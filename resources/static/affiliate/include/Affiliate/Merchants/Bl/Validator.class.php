<?php

QUnit_Global::includeClass('Affiliate_Scripts_Bl_NFQuery');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadTransaction');


class Affiliate_Merchants_Bl_Validator {
    
    var $dataTemplate;
    
    function Affiliate_Merchants_Bl_Validator()
    {
    	//grab table structure
        $sql = 'DESCRIBE ' . TRANS_TABLE;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        while(!$rs->EOF){
        	$this->dataTemplate[] = $rs->fields['Field'];
        	$rs->MoveNext();	
        }
    }
    
    function _query($sql, $query = QUERY_CCCOM)
    {
    	switch($query)
    	{
    		case QUERY_NF:
    			$nfDb = new Affiliate_Scripts_Bl_NFQuery();
    			return $nfDb->query($sql);	
    		break;
    		default:
    			return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    		break;
    	}
    }
    
    function _computeCommission($trans, $query = QUERY_CCCOM)
    {
    	if($trans['estimatedrevenue'] < 0)
        	return 0;
              
        $sql = 'SELECT salecommtype, salecommission FROM wd_pa_campaigncategories WHERE campcategoryid = ' . _q($trans['campcategoryid']);

        $rs = $this->_query($sql, $query);
         
        $return_val = 0;
        
        $return_val = ($rs->fields['salecommtype'] == '$' 
        				? $rs->fields['salecommission'] 
        				: ($rs->fields['salecommission'] /100) * $trans['estimatedrevenue']);
        
        return $return_val;
    }
    
    function _processError($row, $error)
    {
 		$row["errorcode"] = $error;
		$row["errordate"] = date('Y-m-d H:i:s');
		
		return $row;   	
    }
    
    function _mergeTransIdClickInfo($clickRs, $saleRs)
    {
    	$trans = $this->dataTemplate;
		
		unset($saleRs["dateinserted"]);
		
		foreach($trans as $col)
		{
			if($saleRs[$col] === null && $clickRs[$col] != null)
				$saleRs[$col] = $clickRs[$col];	
		}
		
		return $saleRs;
	}    
    
    function validateNetfinitiData($row)
    {
    	$row = $this->_validateDataNF($row);
    	
		$row = $this->_createTransid($row);
		
		return $row;
    }
    
    /*
     * Private _validateDataNF
     */
    function _validateDataNF($row)
    {
    	if(!isset($row['estimatedrevenue']))
    	{
    		$rateFlag = true;
    	} else {
    		$rateFlag = false;
    	}
    	
    	if(isset($row['errorcode']))
    		$row = Affiliate_Merchants_Bl_UploadTransaction::errorToTransaction($row);
    	
    	//check for transid
		if (($row["transid"] == "") || ($row["transid"] == " ") || ($row["transid"] == null))
		{
			//error 101 - transid field is empty
			return $this->_processError($row, ERRORCODE_NOTRANSID);
		}
		
		$originalClickRs = array();
		
		//load original click record from trans table
		$sql = "select * from " .TRANS_TABLE. " where transid=" ._q($row["transid"]);
		$originalClickRs = $this->_query($sql, QUERY_NF);
		
		//check that corresponding transid exists in transactions table
		if (strtolower($originalClickRs->fields["transid"]) != strtolower($row["transid"]))
		{
			//error 104 - trans id doesn't exist -> add to errors table
			return $this->_processError($row, ERRORCODE_NOTRANSIDCLICK);
		}

		//merge records to get campcategoryid to be able to look up rate for estimated revenue
		$row = $this->_mergeTransIdClickInfo($originalClickRs->fields, $row);

		//need quantity to get est. revenue
		if (!$row["quantity"])
		{
			//error 105 - missing required fields - quantity
			return $this->_processError($row, ERRORCODE_MISSINGFIELDS);
		}
		
		if($rateFlag)
			unset($row['estimatedrevenue']);
		
		//check that estimated revenue fields exists
		if (!$row["estimatedrevenue"])
		{
			//get est. rev from rate table * quantity
	    	$row["estimatedrevenue"] = $row["quantity"] * Affiliate_Merchants_Bl_Rate::getNFRate($row);
		}
					
		if (($row["estimatedrevenue"] == 0) || ($row["estimatedrevenue"] == "") || ($row["estimatedrevenue"] == null))
		{
			//error 103 - estimatedrevenue is 0
			return $this->_processError($row, ERRORCODE_NOREVENUE);
		}
		
		if ($row["estimatedrevenue"] < 0)
		{
			return $this->_processError($row, ERRORCODE_NEGATIVEREVENUE);
		}
		
		//get commission
	    $row['commission'] = $this->_computeCommission($row, QUERY_NF);
	    	    
		//check that reftrans does NOT exist in transactions table else it's duplicate
		$sql = "SELECT transid FROM " .TRANS_TABLE. " WHERE reftrans=" ._q($row["transid"]);
	   	$rs = $this->_query($sql, QUERY_NF);

	   	if ($rs->_numOfRows > 0)
		{
			//error 102 - duplicate reftrans id -> add to errors table as duplicate record
    		return $this->_processError($row, ERRORCODE_DUPTRANSID);
		}
		
		//check that reftrans does NOT exist in transactions table else it's duplicate
		$sql = "SELECT transid FROM " .UPLOAD_TABLE. " WHERE reftrans=" ._q($row["transid"]);
	   	$rs = $this->_query($sql, QUERY_NF);

	   	if ($rs->_numOfRows > 0)
		{
			//error 102 - duplicate reftrans id -> add to errors table as duplicate record
    		return $this->_processError($row, ERRORCODE_DUPTRANSID);
		}
		
		/**
		 * CHECK FOR DATE ERRORS
		 */
		$today = date('Y-m-d H:i:s');
		
		//must be set, must not be in future, must not be more than 4 months ago 
		if(!isset($row['dateinserted']) || ($row['dateinserted'] > $today) || !$this->isClickDateValid($row['dateinserted']))
		{
			return $this->_processError($row, ERRORCODE_INSERT_DATE);
		}
		
		//must be set, must be <= today, must not be more than one month ago 
		if(!isset($row['providerprocessdate']) || ($row['providerprocessdate'] > $today) || !$this->isProcessDateValid($row['providerprocessdate']))
		{
			return $this->_processError($row, ERRORCODE_PROCESS_DATE);
		}
		
		//if it is set, check that it is not in future
		if(isset($row['dateestimated']) && ($row['dateestimated'] > $today))
		{
			return $this->_processError($row, ERRORCODE_ESTIMATED_DATE);
		}
		
		//if it is set, check that it is not in future
		if(isset($row['providereventdate']) && ($row['providereventdate'] > $today))
		{
			return $this->_processError($row, ERRORCODE_EVENT_DATE);
		}
		
		return $row;
    }
    
    function validateData($row)
    {
    	$row = $this->_validateDataCCCOM($row);

		$row = $this->_createTransid($row);
		
		return $row;
    }
    
    /*
     * Private _validateDataCCCOM
     */
    function _validateDataCCCOM($row)
    {
    	if(!isset($row['estimatedrevenue']))
    	{
    		$rateFlag = true;
    	} else {
    		$rateFlag = false;
    	}
    	
    	
    	if(isset($row['errorcode']))
    		$row = Affiliate_Merchants_Bl_UploadTransaction::errorToTransaction($row);
    	
    	//check for transid
		if (($row["transid"] == "") || ($row["transid"] == " ") || ($row["transid"] == null))
		{
			//error 101 - transid field is empty
			return $this->_processError($row, ERRORCODE_NOTRANSID);
		}
		
		$originalClickRs = array();
		
		//load original click record from trans table
		$sql = "select * from " .TRANS_TABLE. " where transid=" ._q($row["transid"]);
		$originalClickRs = $this->_query($sql, QUERY_CCCOM);

		//check that corresponding transid exists in transactions table
		if (strtolower($originalClickRs->fields["transid"]) != strtolower($row["transid"]))
		{
			//error 104 - trans id doesn't exist -> add to errors table
			return $this->_processError($row, ERRORCODE_NOTRANSIDCLICK);
		}
		
		//merge records to get campcategoryid to be able to look up rate for estimated revenue
		$row = $this->_mergeTransIdClickInfo($originalClickRs->fields, $row);

		//need quantity to get est. revenue
		if (!$row["quantity"])
		{
			//error 105 - missing required fields - quantity
			return $this->_processError($row, ERRORCODE_MISSINGFIELDS);
		}
		
		if($rateFlag)
			unset($row['estimatedrevenue']);
			
		//check that estimated revenue fields exists
		if (!$row["estimatedrevenue"])
		{
			//get est. rev from rate table * quantity
	    	$row["estimatedrevenue"] = $row["quantity"] * Affiliate_Merchants_Bl_Rate::getRate($row);
		}
					
		if (($row["estimatedrevenue"] == 0) || ($row["estimatedrevenue"] == "") || ($row["estimatedrevenue"] == null))
		{
			//error 103 - estimatedrevenue is 0
			return $this->_processError($row, ERRORCODE_NOREVENUE);
		}
		
		if ($row["estimatedrevenue"] < 0)
		{
			return $this->_processError($row, ERRORCODE_NEGATIVEREVENUE);
		}
		
		$row['commission'] = $this->_computeCommission($row, QUERY_CCCOM);
		
		//check that reftrans does NOT exist in transactions table else it's duplicate
		$sql = "SELECT transid FROM " .TRANS_TABLE. " WHERE transtype=" . _q(TRANSTYPE_SALE) . " AND reftrans=" ._q($row["transid"]);
	   	$rs = $this->_query($sql, QUERY_CCCOM);
		
	   	if ($rs->_numOfRows > 0)
		{
			//error 102 - duplicate reftrans id -> add to errors table as duplicate record
    		return $this->_processError($row, ERRORCODE_DUPTRANSID);
		}
		
		//check that reftrans does NOT exist in transactions table else it's duplicate
		/*$sql = "SELECT transid FROM " .UPLOAD_TABLE. " WHERE reftrans=" ._q($row["transid"]);
	   	$rs = $this->_query($sql, QUERY_CCCOM);

	   	if ($rs->_numOfRows > 0)
		{
			//error 102 - duplicate reftrans id -> add to errors table as duplicate record
    		return $this->_processError($row, ERRORCODE_DUPTRANSID);
		}
		*/
		
		
		/**
		 * CHECK FOR DATE ERRORS
		 */
		$today = strtotime(date('Y-m-d H:i:s'));
		
		//must be set, must not be in future, must not be more than 4 months ago 
		if(!isset($row['dateinserted']) || (strtotime($row['dateinserted']) > $today) || !$this->isClickDateValid($row['dateinserted']))
		{
			return $this->_processError($row, ERRORCODE_INSERT_DATE);
		}
		
		//must be set, must be <= today, must not be more than one month ago 
		if(!isset($row['providerprocessdate']) || (strtotime($row['providerprocessdate']) > $today) || !$this->isProcessDateValid($row['providerprocessdate']))
		{
			return $this->_processError($row, ERRORCODE_PROCESS_DATE);
		}
        
		//if it is set, check that it is not in future
		if(isset($row['dateestimated']) && (strtotime($row['dateestimated']) > $today))
		{
			return $this->_processError($row, ERRORCODE_ESTIMATED_DATE);
		}
		
		//if it is set, check that it is not in future
		if(isset($row['providereventdate']) && (strtotime($row['providereventdate']) > $today))
		{
			return $this->_processError($row, ERRORCODE_EVENT_DATE);
		}
		
		return $row;
    }
    
    function isProcessDateValid($param)
    {
    	//verify that provider process date is not more than 1 month in the past
    	//$oneMonthAgo = date('Y-m-d H:i:s', strtotime("-1 month"));
    	
    	//temporarily changing to 2 months until we get new mass action panel completed
    	$oneMonthAgo = date('Y-m-d H:i:s', strtotime("-2 months"));
    	
    	if(strtotime($param) < strtotime($oneMonthAgo))
    	{
    		return false;
    	}
    	
    	return true;
    }
    
    function isClickDateValid($param)
    {
    	//verify that click date is not more than 4 months in the past
    	$fourMonthsAgo = date('Y-m-d H:i:s', strtotime("-4 months"));
    	
    	if($param < $fourMonthsAgo)
    	{
    		return false;
    	}
    	
    	return true;
    }
    
    /*
     * Private _createTransid
     * 
     * Create new unique transid and set reftrans to current transid
     */
    function _createTransid($trans)
    {
		$original_transid = $trans["transid"];
		$trans["transid"] = QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
		$trans["reftrans"] = $original_transid;

		return $trans;
    }
    
    
    /*
     * Private _cleanTransid
     * 
     * Removes leading underscore charater from transid field
     */
    function _cleanTransid($tid)
    {
    	//for HSBC Orchard Provider
    	//$tid = substr($tid, 0, 1) == "_" ? ltrim($tid,"_") : $tid;
    	
    	//for HSBC Metris Provider
    	//$tid = substr($tid, 0, 8) == "CCCCDOT_" ? ltrim($tid,"CCCCDOT_") : $tid;
    	//changed to catch all transid with 7 characters followed by underscore
    	//$tid = (substr($tid, 7, 1) == "_" ? ltrim($tid,substr($tid, 0, 8)) : $tid);
    	
    	/**
    	 * 
    	 * BEGIN HACK
    	 * Some providers are sending transid's with underscores near the front of the string and others are sending with an underscore at the end.
    	 * The only way we can currently handle this problem is to explode on the underscores and take the string with the longest length
    	 * since transid's are 32 characters in length. I don't expect that any providers will append strings larger than 30 characters.
    	 * 
    	 * We should revisit this in the future and find a more elegant solution.
    	 */
    	 
    	if(strstr($tid, "_"))
    	{
    		$found = false;
    		$longestStr = "";
    		
    		$spt = explode("_", $tid);
    		
    		foreach($spt as $t)
    		{
    			if(strlen($t) == 30)
    			{
    				$tid = $t;
    				$found = true;
    				break;
    			}
    			
    			//track longest string
    			if(strlen($t) > strlen($longestStr))
    				$longestStr = $t;
    		}
    		
    		//if 30 character string is not found in the array, then we should take the longest string
    		if(!$found)
    			$tid = $longestStr;
    	}
    	
    	//for First National Provider
    	$tid = substr($tid, 0, 2) == "CC" ? ltrim($tid,"CC") : $tid;
    	$tid = substr($tid, 0, 7) == "atc2.CC" ? ltrim($tid,"atc2.CC") : $tid;
    	
    	//Amex
    	$tid = substr($tid, 0, 6) == "<none>" ? ltrim($tid,"<none>") : $tid;
    	
    	//HSBC
    	$tid = rtrim($tid,"/");
    	$tid = ltrim($tid,"/");
    	
    	return trim($tid);
    }
    
    function getColumns()
    {
    	return $this->dataTemplate;
    }
}
?>