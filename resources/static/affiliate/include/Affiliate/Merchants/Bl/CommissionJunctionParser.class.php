<?php

class Affiliate_Merchants_Bl_CommissionJunctionParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'Date',
		'Event_Date',
		'Action_Name',
		'ID',
		'Type',
		'Status',
		'Corrected',
		'Sale_Amount',
		'Publisher_Commission',
		'Website_ID',
		'Website_Name',
		'Link_ID',
		'Advertiser_ID',
		'Advertiser_Name',
		'SID',
		'Order_ID',
		'Click_Date',
		'Action_ID'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
		$buffer = array();
    	$fd = fopen ($path, "r");
    	
    	$providerchannel = "CJ";
    	
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
				// check for empty row
				if (($buffer[12] != "") || ($buffer[8] != "") || ($buffer[7] != ""))
				{
					//clean fields
					$buffer[8] = $this->cleanFinancial($buffer[8]);
					$buffer[7] = $this->cleanFinancial($buffer[7]);
					
					$rowArr = array();
					$rowArr["merchantname"] = $buffer[13];
					$rowArr["providerwebsiteid"] = $buffer[9];
					$rowArr["providerwebsitename"] = $buffer[10];
					$rowArr["orderid"] = $buffer[15];
					$rowArr["providereventdate"] = $this->_convertDate($buffer[1]);
					$rowArr["providertype"] = $buffer[4];
					$rowArr["transid"] = $buffer[14];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[0]);
					$rowArr["productid"] = $buffer[11];
					$rowArr["merchantsales"] = $buffer[7];
					$rowArr["provideractionname"] = $buffer[2];
					$rowArr["providerorderid"] = $buffer[3];
					$rowArr["providerstatus"] = $buffer[5];
					$rowArr["providercorrected"] = $buffer[6];
					$rowArr["provideractionid"] = $buffer[17];
					$rowArr["estimateddatafilename"] = $filename;
					$rowArr["providerchannel"] = $providerchannel;
					
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
    
    function _convertDate($date)
    {
    	//$date format = "mm/dd/yyyy hh:mm:ss AM"  (ex. 06/27/2007 11:00:00 AM)
    	$dateTimeArr = explode(" ", $date);
		
		$dateArr = explode("/", $dateTimeArr[0]);
		
		$time = $this->_convertTime($dateTimeArr[1], $dateTimeArr[2]);
		
		return ($dateArr[2] ."-". $dateArr[0] ."-". $dateArr[1] ." ". $time);
    }
    
    function _convertTime($time, $f)
    {
    	$timeSplit = explode(":", $time);
    	
    	if((strtolower($f) == "am") && ($timeSplit[0] == "12"))
		{
			//set 12AM to 00
			$timeSplit[0] = "00";
			
		} else if (strtolower($f) == "pm") {
			//add 12 hours if PM
			if($timeSplit[0] != "12")
			{
				$timeSplit[0] += 12;
			}
		}
		
		return ($timeSplit[0] .":". $timeSplit[1] .":". $timeSplit[2]);
    }
}
?>