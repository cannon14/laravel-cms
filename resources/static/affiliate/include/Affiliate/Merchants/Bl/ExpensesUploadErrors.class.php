<?php
QUnit_Global::includeClass('QCore_History');

class Affiliate_Merchants_Bl_ExpensesUploadErrors {
    function Affiliate_Merchants_Bl_ExpensesUploadErrors() {
		
    }
	
	function insert_line($line_array)
	{
		$errorcode = 0;
		
		$temp = $line_array['purchase_time'];
		if(($line_array['purchase_time'] = $this->_standardize_datetime($line_array['purchase_time'])) == null){
			$errorcode = 1;
			$line_array['purchase_time'] = $temp;
			QUnit_Messager::setErrorMessage("Malformed purchase date");
			return 1;
		}
		
		$temp = $line_array['expense_start'];
		if(($line_array['expense_start'] = $this->_standardize_datetime($line_array['expense_start'])) == null){
			$errorcode = 1;
			$line_array['expense_start'] = $temp;
			QUnit_Messager::setErrorMessage("Malformed expense date");
		}
		
		$temp = $line_array['expense_end'];
		if(($line_array['expense_end'] = $this->_standardize_datetime($line_array['expense_end'])) == null){
			$errorcode = 1;
			$line_array['expense_end'] = $temp;
			QUnit_Messager::setErrorMessage("Malformed end expense date");
		}
		
		$temp = $line_array['affiliate_id'];
		if(!$this->_check_affiliate_exists($line_array['affiliate_id'])){
			$errorcode = 1;
			$line_array['affiliate_id'] = $temp;
			QUnit_Messager::setErrorMessage("Affiliate id " . $temp ." does not exist");
		}

		//check format of extcampaign_id and keyword_id fields
		$re = '/(_)|(&)|\s/';
		if(preg_match($re, $line_array['extcampaign_id']))
		{
			$errorcode = 1;
			QUnit_Messager::setErrorMessage("Malformed " . L_G_EXTCAMPAIGN . " value.");
		}
		
		//check format of extcampaign_id and keyword_id fields
		$re = '/(_)|(&)|\s/';
		if(preg_match($re, $line_array['keyword_id']))
		{
			$errorcode = 1;
			QUnit_Messager::setErrorMessage("Malformed " . L_G_EPISODE . " value.");
		}
		
		if((!isset($line_array['extcampaign_id'])) || ($line_array['extcampaign_id'] == ""))
		{
			$errorcode = 1;
			QUnit_Messager::setErrorMessage("Missing " . L_G_EXTCAMPAIGN . " value.");
		}
		
		$begin = explode("-", date($line_array['expense_start']));
		$bYear = $begin[0];
		$bMonth = 0 + $begin[1];
		$bDayArray = explode(" ", $begin[2]);
		$bDay = 0 + $bDayArray[0];
		$bTimeArray = explode(":", $bDayArray[1]);
		$bHour = 0 + $bTimeArray[0];
		$bMinute = 0 + $bTimeArray[1];
		$bSecond = 0 + $bTimeArray[2];
			
		$end = explode("-", date($line_array['expense_end']));
		$eYear = $end[0];
		$eMonth = 0 + $end[1];
		$eDayArray = explode(" ", $end[2]);
		$eDay = 0 + $eDayArray[0];
		$eTimeArray = explode(":", $eDayArray[1]);
		$eHour = 0 + $eTimeArray[0];
		$eMinute = 0 + $eTimeArray[1];	
		$eSecond = 0 + $eTimeArray[2];				
						
		$date1 = mktime($bHour, $bMinute, $bSecond, $begin[1], $begin[2], $begin[0]);
		$date2 = mktime($eHour,$eMinute,$eSecond,$end[1], $end[2], $end[0]); 				
			
		if($date1 > $date2){
			QUnit_Messager::setErrorMessage("End expense date must come after expense date!");
			$errorcode = 1;
		}

		if ($errorcode > 0)
		{
			//update errordate field on existing error
			
			$sql = 'UPDATE ' . EXPENSE_UPLOAD_ERROR_TABLE . ' SET error_time=' . _q(date("Y-m-d H:i:s")) . ' WHERE expense_id=' . _q($line_array['expense_id']);
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			//$this->_insert_error_line($line_array);
		}
		else
		{
			$sql = 'DESCRIBE ' . EXPENSE_UPLOAD_TABLE;
	
	        $rsCheck = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	        
	        if(!$rsCheck) {
	            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
	        	return false;
	        }
	        
	        $cleanTrans = array();
	        
	        while(!$rsCheck->EOF)
	        {
	        	$cleanTrans[$rsCheck->fields['Field']] = $line_array[$rsCheck->fields['Field']];
	        	
	        	$rsCheck->MoveNext();	
	        }
	        
	        $sql = 'INSERT INTO ' . EXPENSE_UPLOAD_TABLE . ' (`'.implode('`,`', array_keys($cleanTrans)).'`) VALUES ("'.implode('","', $cleanTrans).'")';
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			
			if(!$rs)
				$errorcode = 1;
			if($errorcode > 0)
				$this->_insert_error_line($line_array);
		}
		
		return $errorcode;
	}
	
	function _standardize_datetime($string){
		str_replace(" ", "", $string);
		if($string == null)
			return null;
		$timestamp = strtotime($string);
		$formed_date = date("Y-m-d H:i:s", $timestamp);
		return $formed_date;
	}
	
	function _check_affiliate_exists($id){
		$sql = "SELECT userid FROM " . USERS_TABLE . " WHERE userid = " . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return ($rs->fields['userid'] != null);
	}
}
?>