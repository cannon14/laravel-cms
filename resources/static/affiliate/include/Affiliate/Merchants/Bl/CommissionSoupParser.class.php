<?php

class Affiliate_Merchants_Bl_CommissionSoupParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'Program Name',
		'Commission Name',
		'Status',
		'SubID',
		'Amount',
		'ReportDate',
		'VisitDate'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
    	$buffer = array();
    	$fd = fopen ($path, "r");

		$merchantname = "Commission Soup";
		$providerchannel = "Commission Soup";
		
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
				if (($buffer[0] != "") || ($buffer[1] != "") || ($buffer[2] != "") || ($buffer[5] != "") || ($buffer[6] != ""))
				{
					$rowArr = array();
					
					$rowArr["transid"] = $buffer[3];
					$rowArr["providereventdate"] = $this->_convertDate($buffer[6]);
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[5]);
					$rowArr["quantity"] = 1;
					
					$rowArr["estimateddatafilename"] = $filename;
					$rowArr["providerchannel"] = $providerchannel;
					$rowArr["merchantname"] = $merchantname;
					
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
    	//incoming format: d/mm/yyyy hh:mm
    	
    	$dateTime = explode(" ", $date);
        $dateArr = explode("/", $dateTime[0]);
        $timeArr = explode(":", $dateTime[1]);
        
        return (date("Y-m-d H:i:s", mktime($timeArr[0], $timeArr[1], 0, $dateArr[0] , $dateArr[1], $dateArr[2])));
    }
}
?>