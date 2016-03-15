<?php

class Affiliate_Merchants_Bl_FirstNationalParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'Adjudication Code',
		'Application ID',
		'CreditCards.com Tracking Code',
		'Receive Date',
		'Adjudication Date',
		'Product',
		'Reporting Period'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
		$buffer = array();
    	$fd = fopen ($path, "r");
    	
    	$providerchannel = "Foundry 9";
		$merchantname = "First National Bank";
		
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
				if (($buffer[1] != "") || ($buffer[3] != "") || ($buffer[4] != ""))
				{
					$rowArr = array();
					$rowArr["merchantname"] = $merchantname;
					$rowArr["transid"] = $buffer[2];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[4]);
					$rowArr["providereventdate"] = $this->_convertDate($buffer[3]);
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
    	//incoming format: mm/dd/yyyy
    	
    	$dateArr = explode("/", $date);
    	return (date("Y-m-d H:i:s", mktime(0, 0, 0, $dateArr[0] , $dateArr[1], $dateArr[2])));
	}
}
?>