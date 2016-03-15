<?php

// Patrick J. Mizer
// Rapido Technologies
// Transactions.class
// Methods with a leading underscore are intended to be private

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactionsrev1');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapModel');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapAccess');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_TransactionModel');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ChangeLog');

class Affiliate_Merchants_Bl_Transactions extends Affiliate_Merchants_Bl_Transactionsrev1 {
	
	function insert_sale($trans, $filename="MANUAL ENTRY", $provider = null){
		
		$sql = "SELECT transid, campcategoryid, affiliateid FROM wd_pa_transactions WHERE transid = " . _q(trim($trans->data_set['transid']));
		if(strlen($trans->data_set['transid']) == 8)
			$sql = "SELECT transid, campcategoryid, affiliateid FROM wd_pa_transactions WHERE transid = " . _q(trim($trans->data_set['transid']) . "!") . " OR transid = " . _q(trim($trans->data_set['transid']) . "$") . " OR transid = " . _q(trim($trans->data_set['transid'])) ;
		//QUnit_Messager::setOkMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$reftrans = $rs->fields['transid'];
		
		if($rs->fields['transid'] == null){
			//QUnit_Messager::setErrorMessage($rs->fields['transid'] . " != " . $trans->data_set['transid']);
			QUnit_Messager::setErrorMessage("Transaction " . $trans->data_set['transid'] . " - ID does not exist.");
			$this->_insert_error_transaction($trans, 1);
			return 1;	
		}
		$trans->data_set['affiliateid'] = $rs->fields['affiliateid'];
		$sql = "SELECT estimatedrevenue, transid, reversed FROM wd_pa_transactions WHERE transtype='4' AND reftrans=" . _q(trim($trans->data_set['transid']) );
		if(strlen($trans->data_set['transid']) == 8)
			$sql = "SELECT estimatedrevenue, transid, reversed FROM wd_pa_transactions WHERE transtype = '4' AND (reftrans = " . _q(trim($trans->data_set['transid']) . "!") . " OR reftrans = " . _q(trim($trans->data_set['transid']) ."$") . " OR reftrans = " . _q(trim($trans->data_set['transid'])) . ")";
			
		$checkrs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if($checkrs->fields['transid'] != null && $checkrs->fields['reversed'] == 0){
			QUnit_Messager::setErrorMessage("Transaction " . $trans->data_set['transid'] . " - Duplicate estimate.");
			$this->_insert_error_transaction($trans, 3);
			return 1;		
		}
			
		$trans->data_set['accountid'] = $GLOBALS['Auth']->accountID;
		$trans->data_set['payoutstatus'] = 1;
		$trans->data_set['transtype'] = 4;
		$trans->data_set['rstatus'] = 2;
		if($provider != null)
			$trans->data_set['providerchannel'] = $provider;
		if($trans->data_set['quantity'] == null)
			$trans->data_set['quantity'] = 1;
		$trans->data_set['affiliateid'] = $rs->fields['affiliateid'];
		$trans->data_set['campcategoryid'] = $rs->fields['campcategoryid'];
		$trans->data_set['dateinserted'] = $rs->fields['dateinserted'];
		$trans->data_set['dateestimated'] = date("Y-m-d H:i:s");
		$trans->data_set['reftrans'] = $reftrans;
		
		$trans->data_set['commission'] = $this->_calculate_commission($trans->data_set['reftrans'], $trans->data_set['estimatedrevenue']);
		$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
		$trans->data_set['estimateddatafilename'] = $filename;
		$trans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
		$trans->data_set['reversed'] = 0;
		$trans = $this->_merge_transaction_data($trans, $rs->fields['transid']);
		
		if($checkrs->fields['reversed'] == 1){
			$sql = "UPDATE wd_pa_transactions set transtype = 102 WHERE transid = " . _q($checkrs->fields['transid']);
			//QUnit_Messager::setOkMessage($sql);
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		
		$this->_insert_valid_transaction($trans);
		
		$this->_update_reftrans_on_click($trans->data_set['reftrans']);
		
		return 0;
	}
	
	function insert_non_click_sale($trans, $filename="MANUAL ENTRY"){
		$trans->data_set['accountid'] = $GLOBALS['Auth']->accountID;
		$trans->data_set['payoutstatus'] = 1;
		$trans->data_set['transtype'] = 4;
		$trans->data_set['rstatus'] = 2;
		
		if($trans->data_set['dateinserted'] == "")
			$trans->data_set['dateinserted'] =date("Y-m-d H:i:s");
		if($trans->data_set['estimatedrevenue'] != "")
			$trans->data_set['dateestimated'] = date("Y-m-d H:i:s");
		if($trans->data_set['totalcost'] != "")
			$trans->data_set['dateactual'] = date("Y-m-d H:i:s");
		if($trans->data_set['quantity'] == "")
			$trans->data_set['quantity'] = 1;
			
		$trans->data_set['commission'] = $this->_calculate_commission($trans->data_set['transid'], $trans->data_set['estimatedrevenue']);
		$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
		$trans->data_set['estimateddatafilename'] = $filename;
		$trans->data_set['actualdatafilename'] = $filename;
		$trans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
		
		$sql = "SELECT * FROM wd_pa_campaigncategories WHERE campaignid = " . _q($trans->data_set['campcategoryid']);
		//QUnit_Messager::setOkMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);				
		$trans->data_set['campcategoryid'] = $rs->fields['campcategoryid'];
		
		$trans->data_set['reftrans'] = $trans->data_set['transid'];
		$this->_insert_valid_transaction($trans);
		
		return 0;
	}
	
	function update_actual($trans, $filename="MANUAL ENTRY"){
		$sql = "SELECT * FROM wd_pa_transactions WHERE  transtype = '4' AND reftrans=" . _q(trim($trans->data_set['transid']));
	    
		if(strlen($trans->data_set['transid']) == 8)
			$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = '4' AND (reftrans = " . _q(trim($trans->data_set['transid']) . "!") . " OR reftrans = " ._q(trim($trans->data_set['transid']) . "$") . " OR reftrans = " . _q(trim($trans->data_set['transid'])) . ")";
		//QUnit_Messager::setErrorMessage($sql);
	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	    if($rs->fields['transid'] == null){
	    	QUnit_Messager::setErrorMessage("No sale exists with trans ref " . $trans->data_set['transid']);
	    	$this->_insert_error_transaction($trans, 1);
	    	return 1;	
	    }
		if($this->get_adjusted_estimated_revenue($rs->fields['reftrans']) > $trans->data_set['totalcost']){
			QUnit_Messager::setErrorMessage("Transaction " . $trans->data_set['transid'] . " - Estimated revenue ". $this->get_adjusted_estimated_revenue($rs->fields['transid']) ." greater than actual revenue " . $trans->data_set['totalcost'] . ".");	
			$this->_insert_error_transaction($trans, -2);
			return 1;
		}
		if($this->get_adjusted_estimated_revenue($rs->fields['reftrans']) < $trans->data_set['totalcost']){
			QUnit_Messager::setErrorMessage("Transaction " . $trans->data_set['transid'] . " - Estimated revenue ". $this->get_adjusted_estimated_revenue($rs->fields['transid']) ." less than actual revenue " . $trans->data_set['totalcost'] . ".");	
			$this->_insert_error_transaction($trans, -3);
			return 1;
		}
		if(!($rs->fields['totalcost'] == 0 || $rs->fields['totalcost'] == null)){
			QUnit_Messager::setErrorMessage("Transaction " . $trans->data_set['transid'] . " - Duplicate Actual Value.");		
			$this->_insert_error_transaction($trans, 5);
			return 1;
		}
		
		$sql = "UPDATE wd_pa_transactions SET dateactual=" . _q(date("Y-m-d H:i:s")) . ", totalcost = " . _q($trans->data_set['totalcost']) . ", dateapproved = " . _q($trans->data_sety['dateapproved']) . ", actualdatafilename = " . _q($filename) . " WHERE transtype='4' AND reftrans=" . _q(trim($trans->data_set['transid']));
		
		
		if(strlen($trans->data_set['transid']) == 8){
			$sql = "UPDATE wd_pa_transactions SET dateactual=" . _q(date("Y-m-d H:i:s")) . ", totalcost = " . _q($trans->data_set['totalcost']) . ", dateapproved = " . _q($trans->data_sety['dateapproved']) . ", actualdatafilename = " . _q($filename) . " WHERE transtype='4' AND reftrans like " . _q(trim($trans->data_set['transid']) . "%");
			//$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = '4' AND (reftrans = " . _q(trim($trans->data_set['transid']) . "!") . " OR reftrans = " . _q(trim($trans->data_set['transid']) . "$") . " OR reftrans = " . _q(trim($trans->data_set['transid'])) . ")";
		}
		QUnit_Messager::setErrorMessage($sql);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo $sql;
		return 0;		
	}
	
	function insert_sales_from_errored_transactions($params) 
    {
        $deleteids = array();
        $IDs = $params['ids'];
        if(!is_array($IDs) || count($IDs) < 1){
           	return false;
        }        
        foreach($IDs as $IDsArray)
        {
        	$sql = "SELECT * FROM " . $this->error_trans_table . " WHERE id = " . $IDsArray;
        	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        	
        	if($this->_transid_exists($rs->fields['transid'])){
        			QUnit_Messager::setErrorMessage("Can not create a new transaction " . $rs->fields['transid'] . " click already exists with this transid.");	
        	}else{
        		
        	
        		$trans = new Affiliate_Merchants_Bl_TransactionModel();
        		$trans->data_set['transid'] = $rs->fields['transid'];
        		
        		foreach($rs->fields as $column=>$data){
    				if (array_search($column, $this->db_array) > -1  && $data != "" && $column != '0')
    					$trans->data_set[$column] = $data;
    			}
    		
    			if($trans->data_set['affiliateid'] == null){
    				$sql = "SELECT * FROM wd_g_users WHERE refid = '997'";
					$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
					$trans->data_set['affiliateid'] = $rs->fields['userid'];
    			}
    		
    			if($trans->data_set['transid'] == null){
    				//QUnit_Messager::setOkMessage("Transid is null, generating new ID");
    				$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");	
    			}
    			
    			if($this->insert_non_click_sale($trans) < 1){
    				QUnit_Messager::setOkMessage("Transaction " . $trans->data_set['transid'] . " successfully added.");
    				$deleteids[] = $IDsArray;
    				
    			}else
    				QUnit_Messager::setErrorMessage("Transaction " . $trans->data_set['transid'] . " already exists.");
        	}
        }
        
        $delete['ids'] = $deleteids;
        $this->delete_invalid($delete);
        
        return true;
    }
	
	function insert_estimate_adjustment($trans){
		
		$trans->data_set['accountid'] = $GLOBALS['Auth']->accountID;
		$trans->data_set['transtype'] = 95;
		$trans->data_set['rstatus'] = 2;
		$trans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
		$trans->data_set['dateestimated'] = date("Y-m-d H:i:s");
		$trans->data_set['dateadjusted'] = date("Y-m-d H:i:s");
		$trans = $this->_merge_transaction_data($trans, $trans->data_set['reftrans']);
		
		$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
		
		if($trans->data_set['estimatedrevenue'] != 0){
			$this->_insert_valid_transaction($trans);
			QUnit_Messager::setOkMessage("Inserted revenue adjustment of $" . $trans->data_set['estimatedrevenue']);
		}
	}
	
	function populate_transaction_from_csv_line($arr_current_line = array()){

		$trans = new Affiliate_Merchants_Bl_TransactionModel();
 		$trans->transid = $arr_current_line[$this->get_mapped_location('transid')];

 		foreach($trans->data_set as $col=>$data){
 			if(($index = $this->get_mapped_location($col)) >= 0){
 				$trans->data_set[$col] = $arr_current_line[$index];
 				if(substr_count($col, "date") && $trans->data_set[$col] != ""){	
 					$trans->data_set[$col] = $this->standardize_datetime($trans->data_set[$col]);		
 				}
 			}
 		}
 		$trans->data_set['transid'] = $this->_prepare_transid(trim($trans->transid)); 
 		$trans->data_set['transid'] = trim($trans->data_set['transid']);
 		$trans->transid = $trans->data_set['transid'];

 		return $trans;
	}
	
	function get_type($trans){
		
		// 1 = actual, 2 = estimate, 
		// 3 = notransid, 4 = notransid or affiliate 
		// ,0 = invalid
		$type = 0;
		$missing_actual = 0;
		$missing_estimate = 0;

		if($trans->data_set['transid'] == ""){
			if($trans->data_set['affiliateid'] == "")
				return 4;
			return 3;	
		}

		foreach($this->actual_required as $field){
 			if($trans->data_set[$field] == null){
 				$missing_fields .= $field . " ";
 				$this->update_log( "[get_type] =: missing actual required field " . $field); 
 				++ $missing_actual;
 			}
 		}
 		if($missing_actual == 0)
 			$type += 1;
 		
 		foreach($this->estimate_required as $field){
 			if($trans->data_set[$field] == null){
 				$missing_fields .= $field . " ";
 				++ $missing_estimate;
 			}
 		}
 		if($missing_estimate == 0)
 			$type += 2;

 		return $type;
	}
	
    function is_empty($trans){
		
		foreach($trans->data_set as $col=>$data){
			if(trim($data) != "" && $col != "accountid" && $col != "transtype" && $col != "reversed"){
				//QUnit_Messager::setErrorMessage($col . " " . $data);
				return false;
			}	
		}
		return true;
	}
    
    function resubmit_errored_transaction($id){
    	
    	$trans = $this->_select_invalid_transaction($id);
    	
    	$sql = "DELETE FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    		
    		
    		$status = $this->get_type($trans);
    		
    		$errors = 0;
				switch($status){
					case 0 : 
						 QUnit_Messager::setErrorMessage($this->_insert_error_transaction($trans, 2));
						 $errors ++;
					break;
					case 1 : $errors += $this->update_actual($trans, "resubmit");
					break;
					case 2 : $errors += $this->insert_sale($trans, "resubmit");						
					break;
					case 3 : $errors += $this->insert_non_click_sale($trans, "resubmit");
					break;
					case 4 : QUnit_Messager::setErrorMessage($this->_insert_error_transaction($trans, -1));
							 $errors ++;
					break;
					default : 		 
					break;
					}
			
			if($errors == 0){
    			QUnit_Messager::setOkMessage("Successfully resubmitted transaction");
    			return true;
			}	
    	
     		QUnit_Messager::setErrorMessage("Error resubmitting transaction.  See error log.");
    		return false;	   			 		
    }
    
    function override_transaction($id){

		$not_overridable = array('', 'commission', 'transid', 'transtype', 'rstatus', 'payoutstatus', 'accountid', 'transkind');
    	$error_trans = $this->_select_invalid_transaction($id);
    	$transid = $error_trans->data_set['transid'];
    	
		if(trim($transid) == ""){
    		QUnit_Messager::setErrorMessage("Can not override transaction with no transaction id.  Create as a new sale.");	
    		return;
    	}
    	$valid_trans = $this->_select_sale($transid);
    	
		if($valid_trans->data_set['transid'] == null){
    		QUnit_Messager::setErrorMessage("Can not override " . $transid . " - No sale associated with transaction.");	
    		return;				
		}
		
		if($valid_trans->data_set['reversed'] == 1){
    		QUnit_Messager::setErrorMessage("Can not override " . $transid . " - Can not override reversed sale.");	
    		return;			
		}
    	
    	if($error_trans->errorcode == -2 && $error_trans->data_set['totalcost'] == 0 ){
    		
    		$adjustment = 0 - $valid_trans->data_set['commission'];
    		$this->insert_commission_adjustment($adjustment, $id);
    		$sql = "DELETE FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    		QUnit_Messager::setOkMessage("Successfuly overrode transaction!");
    		return;
    	}
    	
    	foreach($error_trans->data_set as $col=>$data){
    		
    		
    		if($data != null && $data != $valid_trans->data_set[$col] &&  array_search($col, $not_overridable) == null){
    			if($col == "estimatedrevenue"){
					$difference = $data - $this->get_adjusted_estimated_revenue($valid_trans->data_set['reftrans']);
					$adjustment_trans = new Affiliate_Merchants_Bl_TransactionModel();
    				$adjustment_trans->data_set['estimatedrevenue'] = $difference;
    				$adjustment_trans->data_set['dateestimated'] = date("Y-m-d H:i:s)");
    				$adjustment_trans->data_set['reftrans'] = $valid_trans->data_set['reftrans'];
    				QUnit_Messager::setOkMessage("Created a revenue adjustment of $" . $difference);
    				$this->insert_estimate_adjustment($adjustment_trans);
    				if($this->get_adjusted_estimated_revenue($valid_trans->data_set['reftrans']) < 1){
    					$commadjust = (-1 * $valid_trans->data_set['commission']);
    					QUnit_Messager::setOkMessage("Created a commission adjustment of $" . $commadjust);
    					$this->insert_commission_adjustment($commadjust, $id);
    				}	
    				
    			}
    			else if($col == "totalcost"){
    				$difference = $data - $this->get_adjusted_estimated_revenue($valid_trans->data_set['reftrans']);
    				$adjustment_trans = new Affiliate_Merchants_Bl_TransactionModel();
    				$adjustment_trans->data_set['estimatedrevenue'] = $difference;
    				$adjustment_trans->data_set['dateestimated'] = date("Y-m-d H:i:s)");
    				$adjustment_trans->data_set['reftrans'] = $valid_trans->data_set['reftrans'];
    				//QUnit_Messager::setOkMessage("Created a revenue adjustment of $" . $difference);
    				$this->insert_estimate_adjustment($adjustment_trans);
    				
    				
    				$sql = "UPDATE wd_pa_transactions set totalcost = " . _q($data) . ", dateactual = " . _q(date('Y-m-d H:i:s')) . ", actualdatafilename = 'OVERRIDE' WHERE transtype = '4' AND reftrans = " . _q($valid_trans->data_set['reftrans']);
    				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    				QUnit_Messager::setOkMessage("Adjusted actual revenue of transaction " . $transid . "  by $" . $difference);
    				
    			}
    			else{
    				//QUnit_Messager::setOkMessage($col . " old " . $valid_trans->data_set[$col] . " new " . $data);
    				$valid_trans->data_set[$col] = $data;
    			}
    		}
    	}
    	$sql = "DELETE FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	QUnit_Messager::setOkMessage("Successfuly overrode transaction");
    }
    
    
    function delete_sales($params)
    {
    	
        $adjustments = array();
        $transactions = $this->_select_sales($params);   
        foreach($transactions as $trans){
     
        	if($trans->data_set['transtype'] == 4 && $trans->data_set['reversed'] == 0){
        		$adjustedEstimatedRev = $this->get_adjusted_estimated_revenue($trans->data_set['reftrans']);
        		$adjustedCommission = $this->get_adjusted_commission($trans->data_set['reftrans']);
        		$adjtrans = new Affiliate_Merchants_Bl_TransactionModel();
        		$adjtrans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
        		$adjtrans->data_set['estimatedrevenue'] = 0 - $adjustedEstimatedRev;
        		$adjtrans->data_set['commission'] = 0 - $adjustedCommission;
        		//$adjtrans->data_set['dateinserted'] = date("Y-m-d H:i:s");
        		$adjtrans->data_set['reftrans'] = $trans->data_set['reftrans'];
        		$adjtrans->data_set['totalcost'] = 0;
        		$adjtrans->data_set['transtype'] = 100;
        		//$adjtrans->data_set['dateadjusted'] = date("Y-m-d H:i:s");
        		$adjtrans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
        		$adjtrans = $this->_merge_transaction_data($adjtrans, $adjtrans->data_set['reftrans']);
        		
        		$this->_insert_valid_transaction($adjtrans);
        		
        		$sql = "UPDATE wd_pa_transactions set reversed = 1 WHERE transtype != 1 AND reftrans = " . _q($trans->data_set['reftrans']); 
    			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        		
        		$sql = "UPDATE wd_pa_transactions set totalcost = '0', dateactual = " . _q(date('Y-m-d H:i:s')) . ", actualdatafilename = 'MANUALLY ENTERED' WHERE transtype = '4' AND reftrans = " . _q($adjtrans->data_set['reftrans']);
    			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        		
        		
        		QUnit_Messager::setOkMessage($trans->data_set['transid'] . " has been cancelled");
        	}else{
        		$adjustments[] = $trans;
        		//QUnit_Messager::setErrorMessage($trans->data_set['transid'] . " is not a Sale and can not be cancelled");	
        	}
        }
        $this->delete_adjustments($adjustments);
        return true;
    }
    
    function delete_adjustments($transactions)
    {
        if(count($transactions) < 1)
        	return;
        
        
        foreach($transactions as $trans){
        	if($trans->data_set['transtype'] > 89 && $trans->data_set['transtype'] < 100 && $trans->data_set['reversed'] == 0){

        		$adjtrans = new Affiliate_Merchants_Bl_TransactionModel();
        		$adjtrans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
        		$adjtrans->data_set['estimatedrevenue'] = 0 - $trans->data_set['estimatedrevenue'];
        		$adjtrans->data_set['commission'] = 0 - $trans->data_set['commission'];
        		$adjtrans->data_set['dateinserted'] = date("Y-m-d H:i:s");
        		$adjtrans->data_set['reftrans'] = $trans->data_set['reftrans'];
        		$adjtrans->data_set['transtype'] = 101;
        		$adjtrans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
        		$adjtrans->data_set['dateadjusted'] = date("Y-m-d H:i:s");
        		$adjtrans = $this->_merge_transaction_data($adjtrans, $adjtrans->data_set['reftrans']);
        		
        		$sql = "SELECT totalcost FROM wd_pa_transactions WHERE transid = " . _q($trans->data_set['reftrans']);
        		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        		
        		$totalcostadjustment = 0;
        		if($rs->fields['totalcost'] > 0)
        			$totalcostadjustment = 0 - $adjtrans->data_set['estimatedrevenue'];
        		
        		$this->_insert_valid_transaction($adjtrans);
        		
        		$sql = "UPDATE wd_pa_transactions set reversed = 1 WHERE transid = " . _q($trans->data_set['transid']);
    			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        		
        		$sql = "UPDATE wd_pa_transactions set totalcost = " . _q($totalcostadjustment) . ", dateactual = " . _q(date('Y-m-d H:i:s')) . ", actualdatafilename = 'MANUALLY ENTERED' WHERE transtype = '4' AND reftrans = " . _q($adjtrans->data_set['reftrans']);
    			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        		
        		QUnit_Messager::setOkMessage("Adjusmtent " . $trans->data_set['transid'] . " has been reversed");
        	}else
        		QUnit_Messager::setErrorMessage($trans->data_set['transid'] . " can not be reversed");	
        }
        return true;
    }
    
    function delete_invalid($params)
    {
        $IDs = $params['ids'];
        if(!is_array($IDs) || count($IDs) < 1){
            return false;
        }

        $chunkedIDs = array_chunk($IDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedIDs as $IDsArray)
        {
            $IDSql = "('".implode("','", $IDsArray)."')";
            $sql = 'delete from wd_pa_transactions_errors'.
                   ' where id in '.$IDSql;         
            $this->update_log("[delete_invalid] =: " . $sql);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }		
        }
        return true;
    }
    
    function insert_commission_adjustment($amount, $id){
    	$sql = "SELECT * FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	  	
    	if(!$rs){
    		QUnit_Messager::setErrorMessage("SQL Error");
    		return;
    	}
    	
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = '4' AND reftrans = " . _q($rs->fields['transid']);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$date = $rs->fields['dateinserted'];
    	$transid = $rs->fields['reftrans'];
    	
    	if(!$rs){
    		QUnit_Messager::setErrorMessage("SQL Error");
    		return;
    	}
    	
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
    	$trans->data_set['accountid'] = $GLOBALS['Auth']->accountID;
    	$trans->data_set['reftrans'] = $rs->fields['reftrans'];
    	$trans->data_set['affiliateid'] = $rs->fields['affiliateid'];
    	$trans->data_set['campcategoryid'] = $rs->fields['campcategoryid'];
    	$trans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
    	$trans->data_set['transtype'] = 99;
    	$trans->data_set['commission'] = $amount;
    	$trans->data_set['dateadjusted'] = date("Y-m-d H:i:s");
    	$trans->data_set['dateinserted'] = date("Y-m-d H:i:s");

    	$trans = $this->_merge_transaction_data($trans, $trans->data_set['reftrans']);
    	
    	//create commission adjusment
    	$this->_insert_valid_transaction($trans);
    	
    	$trans->data_set['commission'] = null;
    	$trans->data_set['estimatedrevenue'] = -1 * $this->get_adjusted_estimated_revenue($rs->fields['reftrans']);
    	$trans->data_set['dateinserted'] = $date;
    	//fire off diff estimate
    	$this->insert_estimate_adjustment($trans);
    	
    	$sql = "DELETE FROM wd_pa_transactions_errors WHERE id =" . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	//adjust actual revenue
    	//$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	//$trans->data_set['totalcost'] = 0;
    	//$trans->data_set['dateactual'] = date("Y-m-d H:i:s"); 
    	//$trans->data_set['transid'] = $transid;
    	
    	$sql = "UPDATE wd_pa_transactions set totalcost = '0', dateactual = " . _q(date('Y-m-d H:i:s')) . ", actualdatafilename = 'MANUALLY ENTERED' WHERE transtype = '4' AND reftrans = " . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	
    	QUnit_Messager::setOkMessage("Commission adjustment created for the amount $" . $amount);
    }
    
    /*DEPRICATED FUNCTION
     * function insert_bonus($amount, $affiliateid){
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
    	$trans->data_set['accountid'] = $GLOBALS['Auth']->accountID;
    	$trans->data_set['affiliateid'] = $affiliateid;
    	$trans->data_set['campcategoryid'] = $rs->fields['campcategoryid'];
    	$trans->data_set['modifiedby'] = $GLOBALS['Auth']->userName;
    	$trans->data_set['transtype'] = 90;
    	$trans->data_set['campcategoryid'] = 99;
    	$trans->data_set['commission'] = $amount;
    	$trans->data_set['dateinserted'] = date("Y-m-d H:i:s");
    	
    	$this->_insert_valid_transction($trans);
		return;
    }*/

    
    function get_adjusted_estimated_revenue($transid){
    	if(trim($transid) == ""){
    		return 0;
    	}
    	
    	$sql = "select SUM(estimatedrevenue) FROM wd_pa_transactions WHERE transtype in ('95', '100', '101', '102', '4') AND reftrans =" . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(!$rs)
    		return 0;
    	return $rs->fields['SUM(estimatedrevenue)'];
    }
    
    function get_adjusted_commission($transid){
     	if(trim($transid) == ""){
    		return 0;
    	}
     	
     	$sql = "select SUM(commission) FROM wd_pa_transactions WHERE transtype in ('90', '99','100', '101', '102', '4') AND reftrans =" . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(!$rs)
    		return 0;
    	return $rs->fields['SUM(commission)'];   	
    }
    
    function approve_transaction_payout($params)
    {
    	$sql = 'SELECT * FROM wd_pa_transactions WHERE transid=' . _q($params['TransID']);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
   
    	$reftrans = $rs->fields['reftrans'];
    	$totalcost = $params['totalcost'];
    	$estimatedrevenue = $this->get_adjusted_estimated_revenue($rs->fields['reftrans']);
    	$dateapproved = $params['dateapproved'];
    	
    	if($totalcost < $estimatedrevenue){
    		$trans = new Affiliate_Merchants_Bl_TransactionModel();
    		$trans->data_set['transid'] = $reftrans;
    		$trans->data_set['totalcost'] = $totalcost;
    		$trans->data_set['estimatedrevenue'] = $estimatedrevenue;
    		$trans->data_set['dateapproved'] = $providerprocessdate;
    		$this->_insert_error_transaction($trans, -2);
    		QUnit_Messager::setErrorMessage("Transaction " . $params['TransID'] . " estimate greater than actual.  This has been sent to the error log.");
    		return false;
    	}
    	
    	if($totalcost > $estimatedrevenue){
    		$trans = new Affiliate_Merchants_Bl_TransactionModel();
    		$trans->data_set['transid'] = $reftrans;
    		$trans->data_set['totalcost'] = $totalcost;
    		$trans->data_set['estimatedrevenue'] = $estimatedrevenue;
    		$trans->data_set['dateapproved'] = $providerprocessdate;
    		$this->_insert_error_transaction($trans, -3);
    		QUnit_Messager::setErrorMessage("Transaction " . $params['TransID'] . " estimate less than actual.  This has been sent to the error log.");
    		return false;
    	}

		//update actual
		//$trans = new Affiliate_Merchants_Bl_TransactionModel();
		//$trans->data_set['TransID'];
		//$trans->data_set['totalcost'] = $params['totalcost'];
		//$trans->data_set['dateactual'] = date("Y-m-d H:i:s");
		
		$sql = "UPDATE wd_pa_transactions set totalcost = " . _q($totalcost) . ", dateapproved = " . _q($dateapproved) . ", dateactual = " . _q(date('Y-m-d H:i:s')) . ", actualdatafilename = 'MANUALLY ENTERED' WHERE transtype = '4' AND reftrans = " . _q($reftrans);
    	//QUnit_Messager::setOkMessage($sql);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				
        return true;
    }
    
    function traceTransaction($reftrans){
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transid=" . _q($reftrans);
		$rsClick = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = "SELECT * FROM wd_pa_transactions WHERE transtype > 1 AND reftrans = " . _q($reftrans) ." ORDER by dateadjusted ASC";
    	//QUnit_Messager::setOkMessage($sql);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$spooler = "<center><b>Transaction: " . $reftrans . " <br>Click Inserted: " . $rsClick->fields['dateinserted'] ."</b></center><br>";
    	$spooler .= "<table width='100%'><tr><td><b>Type</td><td><b>Estimated Revenue</td><td><b>Commission</td><td><b>Actual Revenue</td><td><b>Date Adjusted</td><td><b>Adusted By</td></tr><tr>";
    	$sum_rev = 0;
    	$sum_com = 0; 	
    	
    	$types = array(0 => "", 1 => "Click", 2 => "Lead", 4 => "Valid Sale", 95 => "Revenue Adjustment", 99 => "Commission Adjustment", 100 => "Sale Reversal", 101 => "Adjustment Reversal", 102 => "Void Sale");
    	
    	while(!$rs->EOF){
    		if($rs->fields['estimatedrevenue'] <= -0.01)
    			$revfont = "<font color='red'>";
			else
				$revfont = "<font color='black'>";
    		if($rs->fields['commission'] != null && $rs->fields['commission'] <= -0.01)
    			$comfont = "<font color='red'>";
			else
				$comfont = "<font color='black'>";
    		$spooler .= "<tr><td>" . $types[$rs->fields['transtype']] . "</td><td>".$revfont."$" . $rs->fields['estimatedrevenue'] . "</font></td>" . "<td>".$comfont."$" . $rs->fields['commission'] . "</font></td>" . "<td></td><td>" . $rs->fields['dateadjusted'] . "</td>" . "<td>" . $rs->fields['modifiedby'] . "</td></tr>";
    		$sum_rev += $rs->fields['estimatedrevenue'];
    		$sum_com += $rs->fields['commission'];
    		if($rs->fields['transtype'] == 4)
    			$actual_rev = $rs->fields['totalcost'];
    		$rs->MoveNext();	
    	}
    	$spooler .= "<tr><td colspan='6'><hr></tr>";
    	$spooler .= "<tr><td><b>TOTALS:</td><td> <b>$" . $sum_rev ."</td><td> <b>$". $sum_com ."</td><td><b>$".$actual_rev."</td><td></td></tr></table><br><br>";
    	
    	return $spooler;
    }
    
   function _select_sale($transid){
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = '4' AND reftrans = " . _q($transid);
		
		if(strlen($transid) == 8)
			$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = '4' AND (reftrans = " . _q(trim($transid) ."!") . " OR reftrans = " . _q(trim($transid) . "$") . " OR reftrans = " . _q(trim($transid)) . ")";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	
    	foreach($trans->data_set as $col=>$data){
    		$trans->data_set[$col] = $rs->fields[$col];
    	}
    	return $trans;
    }
    
    function _select_click($transid){
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = '1' AND transid = " . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	
    	foreach($trans->data_set as $col=>$data){
    		$trans->data_set[$col] = $rs->fields[$col];
    	}
    	return $trans;
    }
    
    function _select_sales($transid_array){
    	$trans_array = array();
    	$transIDSql = "('".implode("','", $transid_array)."')";
    	
    	$sql = "SELECT * FROM wd_pa_transactions where transid in " . $transIDSql;
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	while(!$rs->EOF){
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    		foreach($trans->data_set as $col=>$data){
    			$trans->data_set[$col] = $rs->fields[$col];	
    		}
    		$trans_array[] = $trans;	
    		$rs->MoveNext();	
    	}
    	return $trans_array;
    }
    
    
    function _select_invalid_transaction($id){
    	$sql = "SELECT * FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	
    	$trans->errorcode = $rs->fields['errorcode'];
    	
    	foreach($trans->data_set as $col=>$data){
    		if(trim($rs->fields[$col]) == "")
    			$trans->data_set[$col] = null;
    		else
    			$trans->data_set[$col] = $rs->fields[$col];
    	}
    	return $trans;	
    }
    
    
    function _merge_transaction_data($trans, $transid){
		$sql = "SELECT * FROM wd_pa_transactions WHERE transid = " . _q($transid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		foreach($trans->data_set as $col=>$data){
			if($trans->data_set[$col] === null && $rs->fields[$col] != null){
				
				$trans->data_set[$col] = $rs->fields[$col];	
				
			}
		}
		return $trans;
	}
	
    
    function _get_current_commission($transid){
    	$sql = "SELECT commission FROM wd_pa_transactions WHERE transid = " . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs->fields['commission'];	
    }        
	
	function _calculate_commission($transid, $estimatedrevenue){
    	if($estimatedrevenue <= 0)
    		return 0;
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transid = " . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$trans = $this->populate_transaction_from_db($rs, false);
    	
    	/**
    	$sql = "SELECT campcategoryid FROM wd_pa_affiliatescampaigns WHERE campaignid = " . _q($trans->data_set['campcategoryid']); // " AND affiliateid = " . _q($trans->data_set['affiliateid']) . " 
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(!$rs)
    		return 0;
    	**/
    	
    	if($trans->data_set['estimatedrevenue'] < 0)
    		return 0;
    	$sql = "SELECT * FROM wd_pa_campaigncategories WHERE campcategoryid = " . _q($rs->fields['campcategoryid']);
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(!$rs)
    		return 0;
    	if($rs->fields['salecommtype'] == '$'){
    		
    		$return_val = $rs->fields['salecommission'];
    	}else{
    		
    		$return_val = (($rs->fields['salecommission'] /100) * $estimatedrevenue);
    	}
    	//QUnit_Messager::setOkMessage("Commission set for transaction " . $transid . ": $" . $return_val);
    	return $return_val;
    }
    
	function _create_clicks($n){
		$i = 0;
		$month = 1;
		$day = 1;
		while ($i < $n){	
				$sql = "INSERT into wd_pa_transactions (transid, accountid, affiliateid, rstatus, transtype, dateinserted, campcategoryid) VALUES ('" . QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid") . "'," . _q("default1") . "," . _q("14e0f9cf") . "," . _q("1") . "," . _q("1") . "," . _q("2005-".$month."-".$day. " 12:00:00") . "," ._q("22184477") .")";
				QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				++$i;
				set_time_limit(100);
				$month ++;
				$day ++;
				if($month > 12)
					$month = 1;
				if($day > 30)
					$day = 1;
		}

		
	}
	
	function _prime_clicks(){
		$sql = "SELECT * FROM wd_pa_transactions WHERE transtype = 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$num = 0;
		while(!$rs->EOF){
			//echo $rs->fields['transid'] . "<br>";
			if(strlen($rs->fields['transid']) == 8){
				$sql = "UPDATE wd_pa_transactions SET transid = " . _q($rs->fields['transid'] . "!") . "WHERE transid = " . _q($rs->fields['transid']);
				QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				++ $num;
			}
			$rs->MoveNext();
			set_time_limit(300);
		}
		echo $num . " clicks successfully primed.";		
	}
	
    function _insert_valid_transaction($trans){
		$trans->data_set['dateadjusted'] = date("Y-m-d H:i:s");
		if($trans->data_set['campcategoryid'] == "")
			$trans->data_set['campcategoryid'] = 99;
		foreach($trans->data_set as $col=>$value){
			$col_array[] = $col;
			$value_array[] = preg_replace('/[\'\"]/', '', $value);
		}
	
		$columns = implode("`,`", $col_array); 
		$values = "'" . implode("','", $value_array) . "'";
		
		$sql = "INSERT INTO wd_pa_transactions (`". $columns ."`) VALUES (" . $values . ")";
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo $sql;
    }
    
    function _insert_error_transaction($trans, $error_code){
		switch ($error_code){
			case 1 : $error_message = "Transaction id '" . $trans->transid . "' does not exist (1)!";
			break;
			case 2 : $error_message = "Transaction id '" . $trans->transid . "' is missing required fields (2)!";
			break;
			case 3 : $error_message = "Transaction id '" . $trans->transid . "' already has an estimate listed (3)!"; 
			break;
			case 4 : $error_message = "Transaction id '" . $trans->transid . "' is attempting to update an estimate when an actual is already listed (4)!"; 
			break;
			case 5 : $error_message = "Transaction id '" . $trans->transid . "' already has an actual listed (5)!";
			break;
			case 6 : $error_message = "Transaction id '" . $trans->transid . "' matches more than one transaction(6)!";
			break;
			case -1 : $error_message = "Transaction found with no transaction id or affiliate (-1)!";
			break;
			case -2 : $error_message = "Transaction id '" . $trans->transid . "' Estimated greater than actual(-2)";
					  $trans->data_set['commission'] = $this->_get_current_commission($trans->transid);
			break;
			case -3 : $error_message = "Transaction id '" . $trans->transid . "' Estimated less than actual(-3)";
					  $trans->data_set['commission'] = $this->_get_current_commission($trans->transid);
			break;
		    case -99 : $error_message = "Blank line found, disregarded!(-99)";
			break;		
			default : $error_message = "Transaction id '" . $trans->transid . "' has encountered an unknown error (99)!";
			break;
		}
		
		$trans->data_set['reftrans'] = $trans->data_set['transid'];
		$trans->data_set['rstatus'] = 2;
		$sql = "INSERT INTO wd_pa_transactions_errors (errorcode, errordate ";
 		
 		foreach($trans->data_set as $column=>$data){
 			if($data != null){
 				$sql .= ",".$column."";
 			}
 		}
 		$sql .= ") VALUES ('" . $error_code . "','" . date("Y-m-d H:i:s") . "'";
 		foreach($trans->data_set as $column=>$data){
 			if($data != null){
 				$sql .= ",'". preg_replace('/[\'\"]/', '', $data) ."'";
 			}
 		}
 		$sql .= ")";
 		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
 		
 		return $error_message;
	}
	
	function _standardize_datetime($string){
		$timestamp = strtotime($string);
		$formed_date = date("Y-m-d H:i:s", $timestamp);
	 	$this->update_log( "[standardize_date_time_format] =: unformed date " . $string . " formed date " . $formed_date);
		return $formed_date;
	}
	
	function _update_reftrans_on_click($transid){
		$sql = "UPDATE wd_pa_transactions set reftrans=" . _q($transid) . " WHERE transid = " . _q($transid); 
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _transid_exists($transid){
		if($transid == "")
			return false;
		$sql = "SELECT transid FROM wd_pa_transactions WHERE transid = " . _q($transid);
		//QUnit_Messager::setOkMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return ($rs->fields['transid'] == $transid);	
	}
	
	function _prepare_transid($transid){	
		$invalid_chars = array ('_', '\\', '/', '?', ' ', ' ', '\n', '\r');
		foreach($invalid_chars as $char){
			$temp = explode($char, $transid);
			if(count($temp) > 1){
				$transid = "";
				foreach($temp as $token)
					$transid .= $token;	
			}
		}
		$transid = ltrim($transid);
		$transid = rtrim($transid);
		$transid = strip_tags($transid);

		
		return $transid;
	}
}
?>