<?php

class Affiliate_Merchants_Bl_UploadClicks {
	
	function insertClicks($lineArray, $line){
		
		
		
		if(count($lineArray) != 4){
			QUnit_Messager::setErrorMessage("Error parsing CSV line " . $line);
			return;
		}
		$filled = false;
		for($i = 0; $i < 4; ++$i){
			$lineArray[$i] = trim($lineArray[$i]);
			if($lineArray[$i] != "")
				$filled = true;
		}
		
		if(!$filled)
			return;
		
		$sql = "SELECT * FROM wd_g_users WHERE userid = " . _q($lineArray[1]);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if($rs->fields['userid'] != $lineArray[1]){
			QUnit_Messager::setErrorMessage("Affiliate does not exist on line " . $line);
			return;
		}
		

		$sql = "SELECT * FROM wd_pa_campaigncategories WHERE campaignid = " . _q($lineArray[2]);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);				
		$campCategory = $rs->fields['campcategoryid'];
		
		if($campCategory == ""){
			QUnit_Messager::setErrorMessage("Category does not exist on line " . $line);
			return;
		}		
		
		$campCategory = $rs->fields['campcategoryid'];
		
		$timestamp = strtotime($lineArray[0]);
		$lineArray[0] = date("Y-m-d H:i:s", $timestamp);
		$lineArray[] = $campCategory;
		
		$sqlArray[0] = $lineArray[0];
		$sqlArray[1] = $lineArray[1];
		$sqlArray[2] = $lineArray[3];
		$sqlArray[3] = $lineArray[4];
		
		$sqlData = "'" . implode("','", $sqlArray) . "'";
			
		$sql = "INSERT INTO wd_pa_transactions (dateinserted, affiliateid,  quantity, campcategoryid,  accountid, transtype, payoutstatus, rstatus, transid)";
		$sql .= " VALUES (" . $sqlData . ", 'default1', '1', '1', '1', " . _q(QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid")) . ")";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $lineArray[3];
	}
}	

?>