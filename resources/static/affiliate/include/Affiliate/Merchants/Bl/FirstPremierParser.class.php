<?php

class Affiliate_Merchants_Bl_FirstPremierParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'SourceID',
		'VisitDate',
		'Program',
		'Apps',
		'Visits'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
    	$buffer = array();
    	$fd = fopen ($path, "r");

		$merchantname = "Premier";
		$providerchannel = "Premier";
		
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
				if (($buffer[1] != "") || ($buffer[2] != "") || ($buffer[3] != ""))
				{
					//start inserting data after first row. First row is col headers.
					//apps column must be greater than 0 to qualify
					if ($buffer[3] > 0) {
						
						$buffer[3] = $this->cleanFinancial($buffer[3]);
						
						$date = $this->_convertDate($buffer[1]);
						
						$rowArr = array();
						$rowArr["merchantname"] = $merchantname;
						$rowArr["transid"] = $buffer[0];
						$rowArr["providereventdate"] = $date;
						$rowArr["providerprocessdate"] = $date;
						$rowArr["productid"] = $buffer[2];
						$rowArr["quantity"] = $buffer[3];
						$rowArr["estimateddatafilename"] = $filename;
						$rowArr["providerchannel"] = $providerchannel;
						
						$this->addRow($rowArr, $cleanPath, $sqlErrorPath);
					}
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
		//outgoing format: yyyy-mm-dd
    	return ($dateArr[2] ."-". $dateArr[0] ."-". $dateArr[1]);
    }
}
?>