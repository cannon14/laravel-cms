<?php

class Affiliate_Merchants_Bl_MerchantServicesParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'transid',
		'provider_event_date',
		'provider_process_date',
		'revenue',
		'merchant_name',
		'provider_channel'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
		
		$buffer = array();
		$fd = fopen ($path, "r");
		
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
				if (($buffer[2] != "") && ($buffer[3] != ""))
				{
					$rowArr = array();
					
					$rowArr["transid"] = $buffer[0];
					$rowArr["providereventdate"] = $buffer[1];
					$rowArr["providerprocessdate"] = $buffer[2];
					$rowArr["estimatedrevenue"] = $buffer[3];
					$rowArr["merchantname"] = $buffer[4];
					$rowArr["providerchannel"] = $buffer[5];
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
}
?>