<?php
/**
 * Patrick J. Mizer
 * Rapido Tecnologies
 */

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactionsold');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapModel');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_MapAccess');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_TransactionModel');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_ChangeLog');

class Affiliate_Merchants_Bl_Transactionsrev1 extends Affiliate_Merchants_Bl_Transactionsold {
	
	var $trans_table;
	var $error_trans_table;
	var $log;
	var $estimate_required = array();
	var $actual_required = array();
	var $db_array = array();
	var $trans_mapping;
	var $provider;
	
	function Affiliate_Merchants_Bl_Transactionsrev1($provider = null, $mapping = null){
		
		$this->provider = $provider;
		$this->trans_table = "wd_pa_transactions";
		$this->error_trans_table = "wd_pa_transactions_errors";
		$this->update_log("[transaction_access] =: new transaction_access instance created.");
		$this->estimate_required = array("providerprocessdate",  
										"estimatedrevenue");
										
		$this->actual_required = array(	"dateapproved",
										"totalcost");
		
		$this->db_array = array( 			'transid',
											'dateapproved',
											'totalcost',
											'providerprocessdate',
											'estimatedrevenue',
											'accountid',
											'rstatus',
											'dateinserted',
											'transtype',
											'payoutstatus',
											'datepayout',
											'cookiestatus',
											'orderid',
											'bannerid', 
											'transkind',
											'refererurl',
											'affiliateid',
											'campcategoryid',
											'parenttransid',
											'commission',
											'ip',
											'recurringcommid',
											'accountingid',
											'productid',
											'data1',
											'data2',
											'data3',
											'provideractionname',
											'providerorderid',
											'providertype',
											'providerstatus',
											'providercorrected',
											'providerwebsiteid',
											'providerwebsitename',
											'provideractionid',
											'channel',
											'episode',
											'timeslot',
											'exit',
											'sid',
											'providereventdate',
											'merchantname',
											'providerid',
											'merchantsales',
											'quantity',
											'providerchannel',
											'dateestimated',
											'estimateddatafilename',
											'actualdatafilename');
		
		if($mapping == null){	
			$this->trans_mapping = new Affiliate_Merchants_Bl_MapModel($this->db_array, "default");		
		}else{
			$macc = new Affiliate_Merchants_Bl_MapAccess();
			$map = $macc->get_custom_map($mapping);
			$this->trans_mapping = $map;
		}
		
	}
	function update_log($entry, $error = false){

	}
	
	function get_mapped_location($key){
		foreach($this->trans_mapping->mapping as $index=>$value){
			if(trim($value) == trim($key)){
				//$this->update_log( "[get_mapped_location] =: found " . $key . " at index " . $index);
				return $index;
			}
		}
		$this->update_log( "[get_mapped_location] =: did not find " . $key);
		return -99;	
	}
	

	function populate_transaction_from_csv_line($arr_current_line = array()){

		$trans = new Affiliate_Merchants_Bl_TransactionModel();
 		$trans->transid = trim(rtrim($arr_current_line[$this->get_mapped_location('transid')], "?"));

 		$this->update_log( "[populate_transaction_from_csv_line] =: transid " . $trans->transid);
 	
 		foreach($trans->data_set as $col=>$data){
 				if(($index = $this->get_mapped_location($col)) >= 0){
 					$trans->data_set[$col] = $arr_current_line[$index];
 					if(substr_count($col, "date") && $trans->data_set[$col] != ""){
 					
 						$trans->data_set[$col] = $this->standardize_datetime($trans->data_set[$col]);
 					
 					}
 					if($trans->data_set[$col] != null){
 					
 						$this->update_log( "[populate_transaction_from_csv_line] =: " . $col . " " . $trans->data_set[$col]);
 						
 					}
 				}
 		}
 		 
 		if($trans->transid == null){
 		 	$this->update_log( "[populate_transaction_from_csv_line] =: No Transid found looking up affiliate id" );
 			if($this->affiliate_id_exists($trans->data_set['affiliateid']))
 				$trans->transid = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
 		}
 		//$this->get_type($trans);
 		return $trans;
	}
	
	function populate_transaction_from_db($rs, $error = false){

		$trans = new Affiliate_Merchants_Bl_TransactionModel();

		$trans->transid = $rs->fields['transid'];
		$this->log .= "[populate_transaction] =: transid " . $this->transid . "<br>";
		if($error){
			$trans->errorcode = $rs->fields['errorcode'];
			$this->log .= "[populate_transaction] =: errorcode" . $this->errorcode . "<br>";
		}
		if($rs->fields == null)
			return false;
			
		foreach($rs->fields as $col=>$data ){
			if($data != "" && $col){
				$trans->data_set[$col] = $data;
			}
		}

		foreach($trans->data_set as $col=>$data ){
			if($data != null)
				$this->log .= "[populate_transaction] =: " . $col . " " . $data . "<br>";
		}
		$this->get_type($trans);

		return $trans;
	}
	
	function update_valid_transaction($trans, $log = false){
		//QUnit_Messager::setOkMessage($trans->transid . " updated.");
		if($this->check_for_errors($trans) != 0){
			$this->update_log( "[update_valid_transaction] =: Invalid transaction, update aborted.");
			return;	
		}
		if($log){
			$changelog = new Affiliate_Merchants_Bl_ChangeLog($trans->transid);
			$sql = "SELECT * FROM wd_pa_transactions WHERE transid = '" . $trans->transid  . "'";
			$orignal_rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		
		if($this->get_type($trans) == 2){
			$trans->data_set['commission'] = $this->calculate_commission($trans->transid, $trans->data_set['estimatedrevenue']);
		}
		
		$sql = "UPDATE " . $this->trans_table . " SET ";
		foreach($trans->data_set as $col=>$data){
			
			if($data !=  "" ){
				$sql .= $col . " = '" . $data . "',";
				if($log){
					$change = array("action" => $col, 
								"previous_value" => $original_rs->fields[$col], 
								"new_value" => $data);
        			$changelog->add_update($change);
				}
			}
		}
		$sql = substr("$sql", 0, strlen("$sql") - 1);
		$sql .= " WHERE transid = '" . $trans->transid . "'";
		//$this->update_log( "[update_valid_transaction] =: " . $sql);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
		
		if($log)
			$changelog->commit_updates();
	}	
	
	function insert_error_transaction($trans, $error_code){
		$this->update_log("[insert_error_transaction] " . $error_code);
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
			case -1 : $error_message = "Transaction found with no transaction id (-1)!";
			break;
			case -2 : $error_message = "Transaction id '" . $trans->transid . "' Estimated greater than actual(-2)";
					  $trans->data_set['commission'] = $this->get_current_commission($trans->transid);
			break;
			case -3 : $error_message = "Transaction id '" . $trans->transid . "' Estimated less than actual(-3)";
					  $trans->data_set['commission'] = $this->get_current_commission($trans->transid);
			break;
		    case -99 : $error_message = "Blank line found, disregarded!(-99)";
			break;		
			default : $error_message = "Transaction id '" . $trans->transid . "' has encountered an unknown error (99)!";
			break;
		}
		
		$sql = "INSERT INTO " . $this->error_trans_table . " (transid, errorcode, errordate ";
 		
 		foreach($trans->data_set as $column=>$data){
 			if($data != null){
 				$sql .= ",".$column."";
 			}
 		}
 		//$sql = substr("$sql", 0, strlen("$sql") - 1);
 		$sql .= ") VALUES ('" . $trans->transid . "','" . $error_code . "','" . date("Y-m-d H:i:s") . "'";
 		foreach($trans->data_set as $column=>$data){
 			if($data != null){
 				$sql .= ",'".$data."'";
 			}
 		}
 		
 		//$sql = substr("$sql", 0, strlen("$sql") - 1);
 		$sql .= ")";
 		$this->update_log( "[insert_error_transaction] =: " . $sql);
 		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
 
 		return $error_message;
	}
	
	function get_type(&$trans){
		// 1 = actual, 2 = estimate, 
		// 3 = complete, 0 = invalid
		$type = 0;
		$missing_actual = 0;
		$missing_estimate = 0;

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
 				$this->update_log( "[get_type] =: missing estimate required field " . $field); 
 				++ $missing_estimate;
 			}
 		}
 		if($missing_estimate == 0)
 			$type += 2;
 		
 		switch($type){
 			case 0 : $val_type = "error";
 			break;
 			case 1 : $val_type = "actual";
 			break;
 			case 2 : $val_type = "estimate";
 			break;
 			case 3 : $val_type = "complete";
 			break;
 			default : $val_type = "error";
 		}
 		$this->update_log( "[get_type] =: returning type " . $type . " " . $val_type); 	
 		return $type;
	}
	
	function isEmpty($trans){
		
		foreach($trans->data_set as $col=>$data){
			if(trim($data) != "" && $col != "accountid" && $col != "transtype"){
				$this->update_log("[isEmpty] =: Not empty " . $col . " = " . $data); 
				return false;
			}	
		}
		return true;
	}
	
	function check_for_errors($trans){
	 	
		
		if($this->isEmpty($trans)){
			$this->update_log( "[check_for_errors] =: Empty or blank line.  Disregarding.", true);
 			return -99;	
		}
		
		$type = $this->get_type($trans);
		
		if($trans->transid == ""){
 			$this->update_log( "[check_for_errors] =: No transaction id (-99).", true);
 			return -1;
 		}
	 	
	 	$sql = "SELECT * FROM  " . $this->trans_table . " WHERE transid = '".$trans->transid."'";
 		if(strlen($trans->transid) < 32){
				$sql = "SELECT * FROM " . $this->trans_table . " WHERE transid LIKE '".$trans->transid."%'";  				
 				// Check to see if transid returns more than one result (Error code 6)
 				$sql_dupes = "select count(*) as count from wd_pa_transactions WHERE transid LIKE '" . $trans->transid."%'";  	
        		$rs_dupes = QCore_Sql_DBUnit::execute($sql_dupes, __FILE__, __LINE__);
 				if($rs_dupes->fields['count'] > 1){
 					$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . "' has " . $rs_dupes->fields['count'] . " possible matches (6).", true);
 					return 6;	
 				}
 		}
 		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$this->update_log( "[check_for_errors] =: " . $sql); 	 
		
 		
 		// Check to see that transid exists. (Error code 1)
 		if($rs->fields['transid'] != $trans->transid){
 			if($this->affiliate_id_exists($trans->data_set['affiliateid']))
 				return -100; // this means we're going to insert it.'
 			$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . "' does not exist (1).", true);
 			return 1;	
 		}
 	
 		//Check all required fields.  (Error code 2)
 		if($type == 0){
 			$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . "' does not have all required fields (2).", true);
 			return 2;
 		}
 	
 		//Check Estimate Dupe. (Error code 3)
 		if($trans->data_set['estimatedrevenue'] != null && ($trans->data_set['estimatedrevenue'] != null && $rs->fields['estimatedrevenue'] != 0)){
 			$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . "' already has an estimated revenue value of $" . $rs->fields['estimatedrevenue'] . " you sent an estimate of $" . $trans->data_set['estimatedrevenue'] . " (3).", true);
 			return 3;
 		}
 	
 		//Check Estimate entry when actual is already assigned. (Error code 4)
 		if($trans->data_set['estimatedrevenue'] != null && ($rs->fields['totalcost'] != null && $rs->fields['totalcost'] != 0) ){
 			
 			$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . "' already has an actual revenue value of $" . $rs->fields['totalcost'] . " you sent an estimate of $" . $trans->data_set['estimatedrevenue'] . " (4).", true);
 			return 4;
 		} 	
 	
 		// Check for Actual Dupes (Error code 5)
 		if($trans->data_set['totalcost'] != null && (trim($rs->fields['totalcost']) != null && $rs->fields['totalcost'] != 0)){
 			$this->update_log("isthis " . ($trans->data_set['totalcost'] != null) . " && ". ($rs->fields['totalcost'] != null). " || " . ($rs->fields['totalcost'] == 0), true);
 			$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . "' already has an actual revenue value of $" . $rs->fields['totalcost'] . " you sent an actual value of $" . $trans->data_set['totalcost'] . " (5).", true);
 			return 5;
 		}
 		
 		// Check that actual == estimate
 		if($type == 1 &&($rs->fields['estimatedrevenue'] > $trans->data_set['totalcost'])){
 				$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . " estimate is greater than actual  (-2)", true);
 				return -2;
 			}
 		if($type == 1 && ($rs->fields['estimatedrevenue'] < $trans->data_set['totalcost'])){
 				$this->update_log( "[check_for_errors] =: Transaction id: '" . $trans->transid . " estimate is less than actual  (-3)", true);
 				return -3;
 			}	
 	
 		return 0;
	}

	function set_autogens($trans, $filename){
		$type = $this->get_type($trans);
			 
		if($type == 1){
			$trans->data_set['actualdatafilename'] = $filename;
			$trans->data_set['dateactual'] = date("Y-m-d H:i:s");
			$trans->data_set['payoutstatus'] = 2;
			$this->update_log( "[set_autogens] =: actual filename " . $filename);
			$this->update_log( "[set_autogens] =: date actual " . $this->data_set['dateactual']);
			$this->update_log( "[set_autogens] =: username modified " . $GLOBALS['Auth']->userName);
		}
		if($type == 2){
			$trans->data_set['estimateddatafilename'] = $filename;
			$trans->data_set['dateestimated'] = date("Y-m-d H:i:s");
			$trans->data_set['providerchannel'] = $this->provider;
			$trans->data_set['transtype'] = 4;
			$this->update_log( "[set_autogens] =: merchantname " . $this->provider);
			$this->update_log( "[set_autogens] =: date estimated  " . $this->data_set['dateestimated']);
			$this->update_log( "[set_autogens] =: estimated filename " . $filename);
			$this->update_log( "[set_autogens] =: provider channel " . $this->provider);
		}
		
		$trans->data_set['transtype'] = 4;
		$trans->data_set['accountid'] = $GLOBALS['Auth']->accountID;
		
		return $trans;
	}
	
	function standardize_datetime($string){
		$timestamp = strtotime($string);
		$formed_date = date("Y-m-d H:i:s", $timestamp);
	 	$this->update_log( "[standardize_date_time_format] =: unformed date " . $string . " formed date " . $formed_date);
		return $formed_date;
	}
	
	function loadTransactionInfo($params = null){ //overwriting this method
        $transid = preg_replace('/[\'\"]/', '', $_REQUEST['tid']);

        $sql = 'select * from wd_pa_transactions '.
               'where transid='._q($transid).
               '  and accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
		
        $_POST['tid'] = $rs->fields['transid'];
        $_POST['rstatus'] = $rs->fields['rstatus'];
        $_POST['transtype'] = $rs->fields['transtype'];
        $_POST['payoutstatus'] = $rs->fields['payoutstatus'];
        $_POST['cookiestatus'] = $rs->fields['cookiestatus'];
        $_POST['orderid'] = $rs->fields['orderid'];
        $_POST['totalcost'] = $rs->fields['totalcost'];
        $_POST['bannerid'] = $rs->fields['bannerid'];
        $_POST['transkind'] = $rs->fields['transkind'];
        $_POST['refererurl'] = $rs->fields['refererurl'];
        $_POST['affiliate'] = $rs->fields['affiliateid'];
        $_POST['campcategoryid'] = $rs->fields['campcategoryid'];
        $_POST['parenttrans'] = $rs->fields['parenttransid'];
        $_POST['commission'] = $rs->fields['commission'];
        $_POST['ip'] = $rs->fields['ip'];
        $_POST['recurringcommid'] = $rs->fields['recurringcommid'];
        $_POST['accountingid'] = $rs->fields['accountingid'];
        $_POST['productid'] = $rs->fields['productid'];
        $_POST['data1'] = $rs->fields['data1'];
        $_POST['data2'] = $rs->fields['data2'];
        $_POST['data3'] = $rs->fields['data3'];
        $_POST['provideractionname'] = $rs->fields['provideractionname'];
		$_POST['providerorderid'] = $rs->fields['providerorderid'];
		$_POST['providerype'] = $rs->fields['provideryped'];
		$_POST['providertatus'] = $rs->fields['providertatus'];
		$_POST['providercorrected'] = $rs->fields['providercorrected'];
		$_POST['providerebsiteid'] = $rs->fields['providerebsiteid'];
		$_POST['providerwebsitename'] = $rs->fields['providerwebsitename'];
		$_POST['provideracionid'] = $rs->fields['provideracionid'];
		$_POST['channel'] = $rs->fields['channel'];
		$_POST['episode'] = $rs->fields['episode'];
		$_POST['timeslot'] = $rs->fields['timeslot'];
		$_POST['exit'] = $rs->fields['exit'];
		$_POST['sid'] = $rs->fields['sid'];
		$_POST['providereventdate'] = $rs->fields['providereventdate'];
		$_POST['providerprocessdate'] = $rs->fields['providerprocessdate'];
		$_POST['merchantname'] = $rs->fields['merchantname'];
		$_POST['providerid'] = $rs->fields['providerid'];
		$_POST['merchantsales'] = $rs->fields['merchantsales'];
		$_POST['quantity'] = $rs->fields['quantity'];
		$_POST['providerchannel'] = $rs->fields['providerchannel'];
		$_POST['estimatedrevenue'] = $rs->fields['estimatedrevenue'];
		$_POST['dateestimated'] = $rs->fields['dateestimated'];
		$_POST['estimateddatafilename'] = $rs->fields['estimateddatafilename'];
		$_POST['dateapproved'] = $rs->fields['dateapproved'];
		$_POST['actualdatafilename'] = $rs->fields['actualdatafilename'];
    }
    
    function loadTransactionInfoError($params = null){ //overwriting this method
        $id = preg_replace('/[\'\"]/', '', $_REQUEST['id']);

        $sql = 'select * from wd_pa_transactions_errors '.
               'where id='._q($id);
               //'  and accountid='._q($params['AccountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$this->update_log("[loadTransactionInfoError] =: ". $sql);
        if (!$rs || $rs->EOF) {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		$_POST['id'] = $rs->fields['id'];
        $_POST['tid'] = $rs->fields['transid'];
        $_POST['errorcode'] = $rs->fields['errorcode'];
        $_POST['errordate'] = $rs->fields['errordate'];
        $_POST['rstatus'] = $rs->fields['rstatus'];
        $_POST['transtype'] = $rs->fields['transtype'];
        $_POST['payoutstatus'] = $rs->fields['payoutstatus'];
        $_POST['cookiestatus'] = $rs->fields['cookiestatus'];
        $_POST['orderid'] = $rs->fields['orderid'];
        $_POST['totalcost'] = $rs->fields['totalcost'];
        $_POST['bannerid'] = $rs->fields['bannerid'];
        $_POST['transkind'] = $rs->fields['transkind'];
        $_POST['refererurl'] = $rs->fields['refererurl'];
        $_POST['affiliateid'] = $rs->fields['affiliate'];
        $_POST['campcategoryid'] = $rs->fields['campcategoryid'];
        $_POST['parenttransid'] = $rs->fields['parenttrans'];
        $_POST['commission'] = $rs->fields['commission'];
        $_POST['ip'] = $rs->fields['ip'];
        $_POST['recurringcommid'] = $rs->fields['recurringcommid'];
        $_POST['accountingid'] = $rs->fields['accountingid'];
        $_POST['productid'] = $rs->fields['productid'];
        $_POST['data1'] = $rs->fields['data1'];
        $_POST['data2'] = $rs->fields['data2'];
        $_POST['data3'] = $rs->fields['data3'];
        $_POST['provideractionname'] = $rs->fields['provideractionname'];
		$_POST['providerorderid'] = $rs->fields['providerorderid'];
		$_POST['providerype'] = $rs->fields['provideryped'];
		$_POST['providertatus'] = $rs->fields['providertatus'];
		$_POST['providercorrected'] = $rs->fields['providercorrected'];
		$_POST['providerebsiteid'] = $rs->fields['providerebsiteid'];
		$_POST['providerwebsitename'] = $rs->fields['providerwebsitename'];
		$_POST['provideracionid'] = $rs->fields['provideracionid'];
		$_POST['channel'] = $rs->fields['channel'];
		$_POST['episode'] = $rs->fields['episode'];
		$_POST['timeslot'] = $rs->fields['timeslot'];
		$_POST['exit'] = $rs->fields['exit'];
		$_POST['sid'] = $rs->fields['sid'];
		$_POST['providereventdate'] = $rs->fields['providereventdate'];
		$_POST['providerprocessdate'] = $rs->fields['providerprocessdate'];
		$_POST['merchantname'] = $rs->fields['merchantname'];
		$_POST['providerid'] = $rs->fields['providerid'];
		$_POST['merchantsales'] = $rs->fields['merchantsales'];
		$_POST['quantity'] = $rs->fields['quantity'];
		$_POST['providerchannel'] = $rs->fields['providerchannel'];
		$_POST['estimatedrevenue'] = $rs->fields['estimatedrevenue'];
		$_POST['dateestimated'] = $rs->fields['dateestimated'];
		$_POST['dateapproved'] = $rs->fields['dateapproved'];
		$_POST['estimateddatafilename'] = $rs->fields['estimateddatafilename'];
		$_POST['actualdatafilename'] = $rs->fields['actualdatafilename'];
    }
   
	function select_invalid_transaction($id){
		$sql = "SELECT * FROM " . $this->error_trans_table . " WHERE id = " . $id;
		$this->update_log("[select_invalid_transaction] =: " . $sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if($rs->fields['id'] == $id){
			$current_trans = $this->populate_transaction_from_db($rs, true);
			$result = $current_trans;
			
			return $result;
		}
		return null;
	}    
    
	function select_all_invalid_transactions(){
		$sql = "SELECT * FROM " . $this->error_trans_table;
		$this->update_log("[select_all_invalid_transactions] =: " . $sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$result = array();
		$i = 0;
		while(!$rs->EOF){
			$current_trans = $this->populate_transaction_from_db($rs);
			$result[$i] = $current_trans;
			$this->update_log("[select_all_invalid_transactions] =: " . $current_trans->transid . " populated ");
			$rs->MoveNext();
			++ $i;
		}
		return $result;
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
            

            // delete also possible recurring commissions
            //$sql = 'update wd_pa_recurringcommissions set deleted=1'.
            //       ' where originaltransid in '.$transIDSql.
            //       ' and rstatus='.AFFSTATUS_NOTAPPROVED;
            //$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            //if (!$rs)
            //{
            //   QUnit_Messager::setErrorMessage(L_G_DBERROR);
            //    return false;
            //}
			
        }
        return true;
    }
    
    
    function override_transactions($params)
    {
        $IDs = $params['ids'];
        if(!is_array($IDs) || count($IDs) < 1){
            
            return false;
        }

        $chunkedIDs = array_chunk($IDs, WD_MAX_PROCESSED_IDS);
        
        $overridden['ids'] = array();
        $overridden = array();
        $i = 0;
        foreach($IDs as $IDsArray)
        {
 			$current_trans = $this->select_invalid_transaction($IDsArray);                       
        	$sql = "SELECT * FROM wd_pa_transactions WHERE transid = " . _q($current_trans->transid);
        	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        	
        	if(!$rs){
        		QUnit_Messager::setOkMessage("Transaction not found");
        		return;	
        	}
        	
        	$old_trans = $this->populate_transaction_from_db($rs);
        	
        	if($current_trans->data_set['estimatedrevenue'] != null)
        		$current_trans->data_set['dateestimated'] = date("Y-m-d H:i:s");
        		
        	if($current_trans->data_set['estimatedrevenue']!= null)
        		$current_trans->data_set['dateactual'] = date("Y-m-d H:i:s");
        	
        	
        	if($current_trans->data_set['totalcost'] != null && $old_trans->data_set['estimatedrevenue']){
        			if($current_trans->data_set['totalcost'] != $old_trans->data_set['estimatedrevenue']){
        				QUnit_Messager::setOkMessage("Transaction ". $current_trans->data_set['transid'] . " - Changed estimated revenue to equal Actual revenue");
        				$current_trans->data_set['estimatedrevenue'] = $current_trans->data_set['totalcost']; 
        			}
        	}
        	
        	if($current_trans->data_set['totalcost'] === 0){
        		QUnit_Messager::setErrorMessage("Transaction " . $current_trans->data_set['transid'] . " is trying to write 0 to actual revenue");
        	}else if($current_trans->data_set['estimatedrevenue'] == 0){
        		QUnit_Messager::setErrorMessage("Transaction " . $current_trans->data_set['transid'] . " is trying to write 0 to estimated revenue");
        	}else if($current_trans->data_set['errorcode'] == 3 || $current_trans->data_set['errorcode'] == 5 || $current_trans->data_set['errorcode'] < -1){
        		
        		$sql = 'SELECT * FROM wd_pa_transactions WHERE transid=' . _q($current_trans->data_set['transid']);
       			$this->update_log("first SQL " . $sql);
        		$original_rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    			$changelog = new Affiliate_Merchants_Bl_ChangeLog($current_trans->data_set['transid']);
        		
        		$sql = "UPDATE " . $this->trans_table . " SET ";
        		
        		
        		
        		$overidablefields = array(
											'dateapproved',
											'totalcost',
											'providerprocessdate',
											'estimatedrevenue',
											'accountid',
											'datepayout',
											'cookiestatus',
											'orderid',
											'bannerid', 
											'transkind',
											'refererurl',
											'affiliateid',
											'campcategoryid',
											'parenttransid',
											'ip',
											'recurringcommid',
											'accountingid',
											'productid',
											'data1',
											'data2',
											'data3',
											'provideractionname',
											'providerorderid',
											'providertype',
											'providerstatus',
											'providercorrected',
											'providerwebsiteid',
											'providerwebsitename',
											'provideractionid',
											'channel',
											'episode',
											'timeslot',
											'exit',
											'sid',
											'providereventdate',
											'merchantname',
											'providerid',
											'merchantsales',
											'quantity',
											'providerchannel',
											'dateestimated',
											'estimateddatafilename',
											'actualdatafilename');
        		
        		if($current_trans->data_set['estimatedrevenue'] != null)
        			$current_trans->data_set['commission'] = $this->calculate_commission($current_trans->transid, $current_trans->data_set['estimatedrevenue']);
        		
        		foreach($overidablefields as $col){
					if($current_trans->data_set[$col] !=  ""){
						if($original_rs->fields[$col] != $current_trans->data_set[$col]){
							$change = array("action" => $col, 
									"previous_value" => $original_rs->fields[$col], 
									"new_value" => $current_trans->data_set[$col]);
        							$changelog->add_update($change);
						}
						$sql .= $col . " = '" . $current_trans->data_set[$col] . "',";
					}
				}
				$sql = substr("$sql", 0, strlen("$sql") - 1);
				$sql .= " WHERE transid = '" . $current_trans->transid . "'";
				
				//$this->update_log( "[update_valid_transaction] =: " . $sql);
				//QUnit_Messager::setOkMessage($sql);
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        		if(!$rs)
        			QUnit_Messager::setErrorMessage($current_trans->data_set['transid'] . " (". $current_trans->data_set['id'] . ") Could not be overridden.");
        		else{
        			$overriddenids[$i] = $current_trans->data_set['id'];
        			QUnit_Messager::setOkMessage($current_trans->data_set['transid'] . " (". $current_trans->data_set['id'] . ") Succesfully overridden");
        			++$i;
        			$changelog->commit_updates();
        		}	
        	}else{
        		QUnit_Messager::setErrorMessage($current_trans->data_set['transid'] . " (". $current_trans->data_set['id'] . ") Could not be overridden.");
        	}
        }
        $overridden['ids'] = $overriddenids;
        $this->delete_invalid($overridden);

        return true;
    }
    
    function _insert_new_transaction($trans){
    	
    	if($trans->transid != null)
    		$trans->data_set['transid'] = $trans->transid;
    	
    	$sql = "SELECT * FROM " . $this->trans_table . " WHERE transid = '" . $trans->data_set['transid'] ."'";
    	$this->update_log("[_insert_new_transaction] =: " . $sql);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if($rs->fields['transid'] == $trans->data_set['transid']){
    		
    		return false;
    	
    	}
    	
    	
    	
    	$trans->data_set['dateinserted'] = date("Y-m-d H:i:s");
    	$trans->data_set['transtype'] = 4;
    	$trans->data_set['accountid'] = 'default1';
    	if($trans->data_set['estimatedrevenue'] != null){
    		$trans->data_set['dateestimated'] = date("Y-m-d H:i:s");	
    		$trans->data_set['commission'] = $this->calculate_commission($trans->transid, $trans->data_set['estimatedrevenue']);
    	}
    	$sql = "INSERT INTO " . $this->trans_table . "(" . implode(",", array_keys($trans->data_set)) . ")";
    	$sql .= " VALUES ('" . implode("','", $trans->data_set) . "')";
    	//echo $sql . "<br>";
    	$this->update_log("[_insert_new_transaction] =: " . $sql);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	$changelog = new Affiliate_Merchants_Bl_ChangeLog($trans->data_set['transid']);
    	foreach($trans as $col=>$value){
    		$change = array("action" => $col, 
					"previous_value" => "",
					"new_value" => $trans->data_set[$col]);
            $changelog->add_update($change);
    	}
    	$changelog->commit_updates();
    	
    	return true;
    }
    
    function create_new_from_errored_transactions($params) 
    {
        $deleteids = array();
        $IDs = $params['ids'];
        if(!is_array($IDs) || count($IDs) < 1){
            return false;
        }        
        foreach($IDs as $IDsArray)
        {
        	$sql = "SELECT * FROM " . $this->error_trans_table . " WHERE id = " . $IDsArray;
        	$this->update_log( "[create_new_from_errored_transactions] =: " . $sql);
        	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        	$trans = new Affiliate_Merchants_Bl_TransactionModel();
        	$trans->data_set['transid'] = $rs->fields['transid'];
        	foreach($rs->fields as $column=>$data){
    			if (array_search($column, $this->db_array) > -1  && $data != "" && $column != '0')
    				$trans->data_set[$column] = $data;
    		}
    		
    		if($trans->data_set['affiliateid'] == null){
    			// this is just until we have an affiliateid for 997'
    			$trans->data_set['affiliateid'] = "14e0f9cf";
    		}
    		
    		if($trans->data_set['transid'] == null){
    			//QUnit_Messager::setOkMessage("Transid is null, generating new ID");
    			$trans->data_set['transid'] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");	
    		}
    			
    		if($this->_insert_new_transaction($trans)){
    			$ok_message .= "Transaction " . $trans->data_set['transid'] . " successfully added<br>";
    			$deleteids[] = $IDsArray;
    			
    		}else
    			$error_message .= "Transaction " . $trans->data_set['transid'] . " already exists<br>";
        
        }
        if($ok_message != "")
        	QUnit_Messager::setOkMessage($ok_message);
        if($error_message != "")
        	QUnit_Messager::setErrorMessage($error_message);
        
        $delete['ids'] = $deleteids;
        $this->delete_invalid($delete);
        
        return true;
    }
    
    function get_current_estimate($transid){
    	$sql = "SELECT estimatedrevenue FROM " . $this->trans_table .
    	" WHERE transid = '" . $transid . "'";
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs->fields['estimatedrevenue'];
    }
    
    function get_current_actual($transid){
    	$sql = "SELECT totalcost FROM " . $this->trans_table .
    	" WHERE transid = '" . $transid . "'";
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs->fields['totalcost'];
    }
    
    function updateTransaction_new($params)
    {
    	$sql = 'SELECT * FROM wd_pa_transactions WHERE transid=' . _q($params['TransID']);
        
        $original_rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$changelog = new Affiliate_Merchants_Bl_ChangeLog($params['TransID']);
        foreach($params as $col=>$data){
        	if($col == "affiliate")
        		$col = "affiliateid";
        	if($data != "" && $data != $original_rs->fields[$col] && $col != "TransID" && $col != "AccountID" ){

        		$this->update_log("*** Sending col " . $col . " original rs " . $original_rs->fields[$col] ." data " . $data );
        		$change = array("action" => $col, 
								"previous_value" => $original_rs->fields[$col], 
								"new_value" => $data);
        		$changelog->add_update($change);
        	}	
        }
        
        $sql = 'update wd_pa_transactions '.
               'set rstatus='._q($params['rstatus']).
               '   ,transtype='._q($params['transtype']).
               '   ,transkind='._q($params['transkind']).
               '   ,payoutstatus='._q($params['payoutstatus']).
               '   ,totalcost='._q($params['totalcost']).
               '   ,refererurl='._q($params['refererurl']).
               '   ,affiliateid='._q($params['affiliate']).
               '   ,parenttransid='._q($params['parenttrans']).
               '   ,commission='._q($params['commission']).
               '   ,ip='._q($params['ip']).
               '   ,productid='._q($params['productid']).
               '   ,data1='._q($params['data1']).
               '   ,data2='._q($params['data2']).
               '   ,data3='._q($params['data3']).
				'   ,productid='._q($params['productid']).
				'   ,orderid='._q($params['orderid']).
				'   ,channel='._q($params['channel']).
				'   ,episode='._q($params['episode']).
				'   ,timeslot='._q($params['timeslot']).
				'   ,provideractionname='._q($params['provideractionname']).
				'   ,providerorderid='._q($params['providerorderid']).
				'   ,providertype='._q($params['providertype']).
				'   ,merchantname='._q($params['merchantname']).
				'   ,providerid='._q($params['providerid']).
				'   ,merchantsales='._q($params['merchantsales']).
				'   ,providerstatus='._q($params['providerstatus']).
				'   ,providercorrected='._q($params['providercorrected']).
				'   ,providerwebsiteid='._q($params['providerwebsiteid']).
				'   ,providerwebsitename='._q($params['providerwebsitename']).
				'   ,provideractionid='._q($params['provideractionid']).
				'   ,providercorrected='._q($params['providercorrected']).
				'   ,providerchannel='._q($params['providerchannel']).
				'   ,estimatedrevenue='._q($params['estimatedrevenue']);
				if($params['actualfilename'] == null && $params['totalcost'] != null){
					$sql .= '   ,actualdatafilename= \'MANUALLY ENTERED\'';																						
					$sql .= '   ,dateactual = ' . _q(date("Y-m-d H:i:s"));
				}
				$sql .= ' where transid='._q($params['TransID']);
        if($params['AccountID'] != '') $sql .= ' and accountid='._q($params['AccountID']);
		$this->update_log("[updateTransaction_new] =: " . $sql);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($params['rstatus'] == AFFSTATUS_APPROVED)
        {
            $params = array('users' => array($params['affiliate']),
                            'AccountID' => $params['AccountID'],
                            'decimal_places' => $params['decimal_places']
                           );

            if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
        }
		$changelog->commit_updates();
        return true;
    }
    
    function updateTransactionError($params)
    {
        
        $sql = 'update wd_pa_transactions_errors set ';
               
        
               
			   if($params['providerprocessdate'])
               		$sql.='providerprocessdate='._q($params['providerprocessdate']) . ",";
               if($params['estimatedrevenue'])
               		$sql.='estimatedrevenue='._q($params['estimatedrevenue']) . ",";
               if($params['totalcost'])
               		$sql.='totalcost='._q($params['totalcost']) . ",";  		   
               if($params['dateapproved'])
               		$sql.='dateapproved='._q($params['dateapproved']) . ",";  																							 
			   
			   
			   $sql .= 'id='. _q($params['id']) . ' where id='._q($params['id']);
       
		$this->update_log("[updateTransactionError] =: " . $sql);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
			
        return true;
    }
    
    function approveTransaction_Payout($params)
    {
    	$sql = 'SELECT * FROM wd_pa_transactions WHERE transid=' . _q($params['TransID']);
        $original_rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$changelog = new Affiliate_Merchants_Bl_ChangeLog($params['TransID']);
    	
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	$totalcost = $params['totalcost'];
    	$estimatedrevenue = $rs->fields['estimatedrevenue'];
    	$providerprocessdate = $this->standardize_datetime($params['providerprocessdate']);
    	
    	$this->update_log("totalcost = " . $totalcost . " estimatedrevenue = " . $estimatedrevenue . " providerprocessdate = " . $providerprocessdate);
    	
    	if($totalcost < $estimatedrevenue){
    		$trans = new Affiliate_Merchants_Bl_TransactionModel();
    		$trans->transid = $params['TransID'];
    		$trans->data_set['totalcost'] = $totalcost;
    		$trans->data_set['estimatedrevenue'] = $estimatedrevenue;
    		$trans->data_set['providerprocessdate'] = $providerprocessdate;
    		$this->insert_error_transaction($trans, -2);
    		QUnit_Messager::setErrorMessage("Transaction " . $params['TransID'] . " estimate greater than actual.  This has been sent to the error log.");
    		return false;
    	}
    	
    	if($totalcost > $estimatedrevenue){
    		$trans = new Affiliate_Merchants_Bl_TransactionModel();
    		$trans->transid = $params['TransID'];
    		$trans->data_set['totalcost'] = $totalcost;
    		$trans->data_set['estimatedrevenue'] = $estimatedrevenue;
    		$trans->data_set['providerprocessdate'] = $providerprocessdate;
    		$this->insert_error_transaction($trans, -3);
    		QUnit_Messager::setErrorMessage("Transaction " . $params['TransID'] . " estimate less than actual.  This has been sent to the error log.");
    		return false;
    	}
    	

        
        $sql = 	'update wd_pa_transactions '.
               	'set totalcost='._q($params['totalcost']).
               	', dateactual='._q(date("Y-m-d H:i:s")).
               	', actualdatafilename='._q("MANUALLY ENTERED").																								
				' where transid='._q($params['TransID']);
        if($params['AccountID'] != '') $sql .= ' and accountid='._q($params['AccountID']);

		$this->update_log("[updateTransaction_Payout] =: " . $sql);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        foreach($params as $col=>$data){
    		$change = array("action" => strtolower($col), 
						"previous_value" => $original_rs->fields[strtolower($col)], 
						"new_value" => $data);
        	$changelog->add_update($change);
    	}
    	
    	$changelog->commit_updates();

        if($params['rstatus'] == AFFSTATUS_APPROVED)
        {
            $params = array('users' => array($params['affiliate']),
                            'AccountID' => $params['AccountID'],
                            'decimal_places' => $params['decimal_places']
                           );

            if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($params)) !== false)
                Affiliate_Merchants_Bl_Rules::checkPerformanceRules($params, $rules);
        }
		
        return true;
    }
    
    function affiliate_id_exists($id){
    	$sql = "SELECT * FROM wd_g_users where userid ="._q($id);
    	$this->update_log( "[affiliateidexists] =: " . $sql);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return (($rs->fields['userid'] == $id) && ($id != null));
    }
    
    function get_affiliate_id($transid){
    	$sql = "SELECT affiliateid FROM wd_pa_transactions WHERE transid=". _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs->fields['affiliateid'];
    }
    
    function calculate_commission($transid, $estimatedrevenue){
    	if($estimatedrevenue <= 0)
    		return 0;
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transid = " . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$trans = $this->populate_transaction_from_db($rs, false);
    	$this->update_log( "[calculate_commision] =: " . $trans->data_set['campcategoryid']);
    	$sql = "SELECT campcategoryid FROM wd_pa_affiliatescampaigns WHERE campaignid = " . _q($trans->data_set['campcategoryid']); // " AND affiliateid = " . _q($trans->data_set['affiliateid']) . " 
    	$this->update_log( "[calculate_commision] =: " . $sql); 
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(!$rs)
    		return;
    	if($trans->data_set['estimatedrevenue'] < 0)
    		return 0;
    	$sql = "SELECT * FROM wd_pa_campaigncategories WHERE campcategoryid = " . _q($rs->fields['campcategoryid']);
    	$this->update_log( "[calculate_commision] =: " . $sql); 
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(!$rs)
    		return;
    	if($rs->fields['salecommtype'] == '$'){
    		$this->update_log( "[calculate_commision] =: returns $" . $rs->fields['salecommission']); 
    		$return_val = $rs->fields['salecommission'];
    	}else{
    		$this->update_log( "[calculate_commision] =: returns %" . (($rs->fields['salecommission'] /100) * $estimatedrevenue)); 
    		$return_val = (($rs->fields['salecommission'] /100) * $estimatedrevenue);
    	}
    	QUnit_Messager::setOkMessage("Commission set for transaction " . $transid . ": $" . $return_val);
    	return $return_val;
    }
    
    function populate_errored_transaction_from_db($rs){
    	$trans = new Affiliate_Merchants_Bl_TransactionModel();
    	$trans->transid = $rs->fields['transid'];
    	foreach($rs->fields as $col=>$data){
    		if($data != "" && strlen($col) > 2 && $col != "transid" && $col != "errorcode" && $col != "errordate"){
    			$trans->data_set[$col] = $data;	
    		}
    	}
    	return $trans;	
    }
    
    function resubmit_errored_transaction($id){
    	$sql = "SELECT * FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	$trans = $this->populate_errored_transaction_from_db($rs, false);
    	$sql = "DELETE FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	if(($errorcode = $this->check_for_errors($trans)) == 0){
    		$trans = $this->set_autogens($trans, "resubmit");
    		$this->update_valid_transaction($trans, true);
    		QUnit_Messager::setOkMessage("Successfully resubmitted transaction");
    		return true;	
    	}
     	QUnit_Messager::setErrorMessage("Error resubmitting transaction.  See error log.");
     	$this->insert_error_transaction($trans, $errorcode);
    	return false;	   			 		
    }
    
    function create_negative_transaction($amount, $id){
    	$sql = "SELECT * FROM wd_pa_transactions_errors WHERE id = " . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	    	
    	if(!$rs){
    		QUnit_Messager::setErrorMessage("SQL Error");
    		return;
    	}
    	$original_transid = $rs->fields['transid'];
    	
    	$sql = "SELECT * FROM wd_pa_transactions WHERE transid = " . _q($rs->fields['transid']);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	$changelog = new Affiliate_Merchants_Bl_ChangeLog($original_transid);
		$orignal_rs = $rs;
    	
    	if(!$rs){
    		QUnit_Messager::setErrorMessage("SQL Error");
    		return;
    	}
    	$sql = "INSERT INTO wd_pa_transactions (transid, accountid, affiliateid, commission, dateinserted, transtype)";
    	$newid = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
    	$sql .= " VALUES (". _q($newid) .", " . _q($GLOBALS['Auth']->accountID) .", " . _q($rs->fields['affiliateid']) . ", " . _q($amount) . ", ". _q(date("Y-m-d H:i:s")).", '99')";
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	if(!$rs){
    		QUnit_Messager::setErrorMessage("SQL Error");
    		return;
    	}
    	$sql = "DELETE FROM wd_pa_transactions_errors WHERE id =" . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	$sql = "UPDATE wd_pa_transactions SET totalcost = '0', estimatedrevenue = '0', dateactual = " . _q(date("Y-m-d H:i:s")) . ", actualdatafilename = 'MANUALLY ZEROED OUT' WHERE transid = " . _q($original_transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	$changes = array ('totalcost'=> '0',
    						'estimatedrevenue' => '0',
    						'dateactual' => date("Y-m-d H:i:s"),
    						'actualfilename' => 'MANUALLY ZEROED OUT');
    	foreach($changes as $col=>$data){					
    		$change = array("action" => $col, 
								"previous_value" => $original_rs->fields[$col], 
								"new_value" => $data);
        	$changelog->add_update($change);
    	}
    	$changelog->commit_updates();
    	
    	//QUnit_Messager::setOkMessage($sql);
    	QUnit_Messager::setOkMessage("Differential transaction successfully created (" . $newid . ") for the amount $" . $amount);
		QUnit_Messager::setOkMessage("Transaction " . $id . " successfully removed from the errorlog");
    }
    
    function get_current_commission($transid){
    	$sql = "SELECT commission FROM wd_pa_transactions WHERE transid = " . _q($transid);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs->fields['commission'];	
    }      	
           	
}
?>