<?php
QUnit_Global::includeClass('QCore_History');

class Affiliate_Merchants_Bl_ExpenseParser {
    function Affiliate_Merchants_Bl_ExpenseParser() {
		
    }
	
	function insert_line($line_array){
		
		$col_array = array('purchasedate', 'expensedate', 'endexpensedate', 'totalexpense', 'bannerid', 'affiliateid', 'campcategoryid', 'channel', 'episode', 'timeslot', 'exit', 'quantity');
		$colSQL = "`".implode("`,`", $col_array) ."`";
		
		for($i = 0; $i < count($line_array); ++$i){
			$line_array[$i] = trim(preg_replace('/[\'\"]/', '', $line_array[$i]));
		}
		
		$errorcode = 0;
		
		$temp = $line_array[0];
		if(($line_array[0] = $this->_standardize_datetime($line_array[0])) == null){
			$errorcode = 1;
			$line_array[0] = $temp;
			QUnit_Messager::setErrorMessage("Malformed purchase date");
			return 1;
		}
		
		$temp = $line_array[1];
		if(($line_array[1] = $this->_standardize_datetime($line_array[1])) == null){
			$errorcode = 1;
			$line_array[1] = $temp;
			QUnit_Messager::setErrorMessage("Malformed expense date");
		}
		
		$temp = $line_array[2];
		if(($line_array[2] = $this->_standardize_datetime($line_array[2])) == null){
			$errorcode = 1;
			$line_array[2] = $temp;
			QUnit_Messager::setErrorMessage("Malformed end expense date");
		}
		
		$temp = $line_array[5];
		if(!$this->_check_affiliate_exists($line_array[5])){
			$errorcode = 1;
			$line_array[5] = $temp;
			QUnit_Messager::setErrorMessage("Affiliate id " . $temp ." does not exist");
		}
		
		$temp = $line_array[6];
		if(!$this->_check_campaign_exists($line_array[6])){
			$errorcode = 1;
			$line_array[6] = $temp;
			QUnit_Messager::setErrorMessage("Campaign category id " . $temp . " does not exist");
		}
		
		$begin = explode("-", date($line_array[1]));
		$bYear = $begin[0];
		$bMonth = 0 + $begin[1];
		$bDayArray = explode(" ", $begin[2]);
		$bDay = 0 + $bDayArray[0];
		$bTimeArray = explode(":", $bDayArray[1]);
		$bHour = 0 + $bTimeArray[0];
		$bMinute = 0 + $bTimeArray[1];
		$bSecond = 0 + $bTimeArray[2];
			
		$end = explode("-", date($line_array[2]));
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
		

		if ($errorcode > 0){
			$this->_insert_error_line($line_array);
		}else{
			$dataSQL = implode("','", $line_array);
			$sql = "INSERT INTO wd_pa_expenses ( expenseid, " . $colSQL . ") VALUES (" . _q(QCore_Sql_DBUnit::createUniqueID("wd_pa_expenses", "expenseid")) . ", '" . $dataSQL . "')";
			//QUnit_Messager::setOkMessage($sql);
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if(!$rs)
				$errorcode = 1;
			if($errorcode > 0)
				$this->_insert_error_line($line_array);
		}
		return $errorcode;
	}
	
	function _insert_error_line($line_array){
		$col_array = array('purchasedate', 'expensedate', 'endexpensedate', 'totalexpense', 'bannerid', 'affiliateid', 'campcategoryid', 'channel', 'episode', 'timeslot', 'exit', 'quantity', 'errordate');
		$colSQL = "`".implode("`,`", $col_array)."`";
		$dataSQL = implode("','", $line_array);
		$sql = "INSERT INTO wd_pa_expenses_errors ( expenseid, " . $colSQL . ") VALUES (" . _q(QCore_Sql_DBUnit::createUniqueID("wd_pa_expenses_errors", "expenseid")) . ", '" . $dataSQL . "'," . _q(date("Y-m-d H:i:s")) . ")";
		//QUnit_Messager::setOkMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
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
		$sql = "SELECT userid FROM wd_g_users WHERE userid = " . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return ($rs->fields['userid'] != null);
	}
	
	function _check_campaign_exists($id){
		$sql = "SELECT campcategoryid FROM wd_pa_campaigncategories WHERE campcategoryid = " . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return ($rs->fields['campcategoryid'] != null);
	}
}
?>