<?php

class Affiliate_Merchants_Bl_AdvantaParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'Member ID',
		'Merchant ID',
		'Merchant Name',
		'Order ID',
		'Transaction Date',
		'Transaction Time',
		'SKU Number',
		'Sales($)',
		'Quantity',
		'Commissions($)',
		'Process Date',
		'Process Time'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
		$buffer = array();
    	$fd = fopen ($path, "r");
    	
		$providerchannel = "Linkshare";
		
		while (!feof ($fd)) {
			// declare an array to hold all of the contents of each row, indexed
		    $buffer = fgetcsv($fd, 4096);
			
			//if file not validated yet, test validation
			if(!$this->fileValidated)
			{
				$this->fileValidated = $this->_validateFileFormat($buffer, $this->validColumns);
			}
			else
			{
				$this->skipHeaderRow = true;
			}
			
			//if file not validated after 5 rows, error out file
			if (($this->i > 5) && (!$this->fileValidated))
			{
				$this->copyFile($path, $fileErrorPath);
				
				QUnit_Messager::setErrorMessage(L_G_REVENUE_FILE_ERROR .$path);
				$this->errorFlag = true;
				break;
			}
			
			if (($this->fileValidated) && ($this->skipHeaderRow))
			{
				//check for empty row
				if (($buffer[1] != "") || ($buffer[4] != "") || ($buffer[8] != ""))
				{
					$rowArr = array();
					//$rowArr["merchantid"] = $buffer[1];
					$rowArr["merchantname"] = $buffer[2];
					$rowArr["orderid"] = $buffer[3];
					$rowArr["transid"] = $buffer[0];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[10], $buffer[11]);
					$rowArr["providereventdate"] = $this->_convertDate($buffer[4], $buffer[5]);
					//$rowArr["estimatedrevenue"] = $buffer[9];
					$rowArr["providerchannel"] = $providerchannel;
					$rowArr["productid"] = $buffer[6];
					$rowArr["quantity"] = $buffer[8];
					$rowArr["merchantsales"] = $buffer[7];
					$rowArr["estimateddatafilename"] = $filename;
					
					$this->addRow($rowArr, $cleanPath, $sqlErrorPath);
				}
			}
			
			$this->i++;
		}
		
		fclose ($fd);
		
		//create archive of raw file
		$this->moveFile($path, $archivePath);
		
		if(!$this->errorFlag)
			QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _convertDate($date, $time)
    {
    	//incoming date format: mm/dd/yyyy
    	//incoming time format: hh:mm
    	$dateArr = explode("/", $date);
    	$timeArr = explode(":", $time);
		return (date("Y-m-d H:i:s", mktime($timeArr[0], $timeArr[1], 0, $dateArr[0] , $dateArr[1], $dateArr[2])));
    }
}
?>