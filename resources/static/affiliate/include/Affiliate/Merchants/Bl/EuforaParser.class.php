<?php

class Affiliate_Merchants_Bl_EuforaParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'client_id',
		'app_status',
		'app_status_text',
		'level',
		'add_date',
		'member_date',
		'referral_tag',
		'payment_type'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
    	$buffer = array();
    	$fd = fopen ($path, "r");

		$merchantname = "Eufora";
		$providerchannel = "Eufora";
		
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
				if (($buffer[0] != "") || ($buffer[1] != "") || ($buffer[4] != "") || ($buffer[5] != ""))
				{
					$rowArr = array();
					$rowArr["orderid"] = $buffer[0];
					$rowArr["providereventdate"] = $this->_convertDate($buffer[4]);
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[5]);
					$rowArr["transid"] = $buffer[6];
					$rowArr["merchantname"] = $merchantname;
					$rowArr["providerchannel"] = $providerchannel;
					$rowArr["quantity"] = 1;
					$rowArr["estimateddatafilename"] = $filename;
					
					$this->addRow($rowArr, $cleanPath, $sqlErrorPath);
				}
			}
		}
		
		//create archive of raw file
		$this->moveFile($path, $archivePath);
		
		if(!$this->errorFlag)
			QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _convertDate($date)
    {
    	$dateArr = explode("/", $date);
		return (date("Y-m-d", mktime(0, 0, 0, $dateArr[0] , $dateArr[1], $dateArr[2])));
    }
}
?>