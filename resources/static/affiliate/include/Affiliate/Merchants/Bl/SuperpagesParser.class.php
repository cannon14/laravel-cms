<?php

class Affiliate_Merchants_Bl_SuperpagesParser extends Affiliate_Merchants_Bl_ExpenseParserNew {

    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
		
		$buffer = array();
		$fd = fopen ($path, "r");
		
		//init counter
		$i = 1;
		
		$filedates = $this->getFileDates($filename);
		
		//validate filename
		if (!$this->_validateFilename($filename))
		{
			$this->copyFile($path, $fileErrorPath);
			QUnit_Messager::setErrorMessage("Filename error: " . $path . ". Filename must contain a start and end date in the format yyyymmdd_yyyymmdd_filename.csv and cannot contain any spaces.");
			
			fclose ($fd);
			$this->moveFile($path, $archivePath);
			
			return false;
		}
		
		// initialize a loop to go through each line of the file
		while (!feof ($fd)) {
			// declare an array to hold all of the contents of each row, indexed
		    $buffer = fgetcsv($fd, 4096);
			
			//concat new fields to header row
			if ($i == 1)
			{
				//validate file format
				if (!$this->_validateFileFormat($buffer))
				{
					$this->copyFile($path, $fileErrorPath);
					
					QUnit_Messager::setErrorMessage("File format error: " .$path);
					
					break;
				}
			}
			
			// check for empty row
			if (($buffer[0] != "") && ($buffer[3] != "") && ($buffer[4] != ""))
			{
				if ($i > 1) {
					
					$rowArr = array();
					$rowArr["purchase_time"] = $filedates["startdate"];
					$rowArr["expense_start"] = $filedates["startdate"];
					$rowArr["expense_end"] = $filedates["enddate"];
					$rowArr["affiliate_id"] = $this->providerprops["affiliate_id"];
					
					$rowArr["total_expense"] = $this->cleanFinancial($buffer[4]);
					$rowArr["quantity"] = $this->cleanFinancial($buffer[3]);
					
					if($this->validateRequiredFields($rowArr))
						$this->addRow($rowArr, $cleanPath, $sqlErrorPath);
				}
			}
			
			$i++;
		}
		
		fclose ($fd);
		
		//create archive of raw file
		$this->moveFile($path, $archivePath);
		
		QUnit_Messager::setOkMessage("Raw expense file processing complete: " .$path);
    }
    
    /**
     * 
     * Private _validateFileFormat
     * 
     * This method takes in an array
     * correpsonding to the first row of a raw file.
     * 
     */
    function _validateFileFormat($buffer)
    {
    	if ((!strstr($buffer[0], 'Keywords')) || (!strstr($buffer[1], 'Max Bid')) || (!strstr($buffer[2], 'Avg Position')) || (!strstr($buffer[3], 'Clicks')) || (!strstr($buffer[4], 'Spend')) || (!strstr($buffer[5], 'Avg Per Click')))
    	{
			return false;
    	} else {
    		return true;
    	}
    }
}
?>