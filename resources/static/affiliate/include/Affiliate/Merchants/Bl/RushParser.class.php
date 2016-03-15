<?php

class Affiliate_Merchants_Bl_RushParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'ID',
		'Application Date',
		'Activation Date'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
		
		$buffer = array();
		$fd = fopen ($path, "r");
		
		$merchantname = "RushCard";
		$providerchannel = "UniRush Financial";
		
		// initialize a loop to go through each line of the file
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
				if (($buffer[1] != "") && ($buffer[2] != ""))
				{
					$rowArr = array();
					
					$rowArr["providereventdate"] = $this->_convertDate($buffer[1]);
					$rowArr["transid"] = $buffer[0];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[2]);
					$rowArr["merchantname"] = $merchantname;
					$rowArr["providerchannel"] = $providerchannel;
					$rowArr["quantity"] = 1;
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
    
    function _convertDate($date)
    {
    	//accept mm/dd/yyyy hh:mm:ss AM
    	$dateTimeArr = explode(" ", $date);
    	$dateArr = explode("/", $dateTimeArr[0]);
    	$timeArr = explode(":", $dateTimeArr[1]);
    	
    	if(($dateTimeArr[2] == "PM") && ($timeArr[0] != 12))
    	{
    		//add 12 hours
    		$timeArr[0] += 12;
    	} else if(($dateTimeArr[2] == "AM") && ($timeArr[0] == 12))
    	{
    		//set to zero
    		$timeArr[0] = 0;
    	}
    	
    	return (date("Y-m-d H:i:s", mktime($timeArr[0], $timeArr[1], $timeArr[2], $dateArr[0] , $dateArr[1], $dateArr[2])));
    }
}
?>