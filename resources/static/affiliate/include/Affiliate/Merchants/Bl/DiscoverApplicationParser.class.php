<?php

class Affiliate_Merchants_Bl_DiscoverApplicationParser extends Affiliate_Merchants_Bl_Parser {
	
	var $i = 1;
	
	var $validColumns = array(
		'CID',
		'MID',
		'AFFID',
		'UID',
		'DECISION',
		'ACTIVATION'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
		$buffer = array();
		$fd = fopen ($path, "r");
		
		$merchant = "Leapfrog";
		$providerchannel = "Discover";
		
		//parse date from filename
		$pathArr = explode("/", $path);
		
		if (!$this->_validateFilename($filename))
		{
			$this->copyFile($path, $fileErrorPath);
			QUnit_Messager::setErrorMessage("Filename error: " .$path. "<br /><br />Check that filename begins with a date (yyyymmdd_filename.txt) and that there are no spaces.");
			$this->errorFlag = true;
			
			fclose ($fd);
			$this->moveFile($path, $archivePath);
			
			return false;
		}
		
		$filenameSplit = explode('_', $pathArr[count($pathArr)-1]);

		//validate filename has date in it
		if ((!ereg("^[0-9]{8}$", $filenameSplit[0])) || (substr($filenameSplit[0], 0, 2) != "20"))
		{
			$this->copyFile($path, $fileErrorPath);
			
			QUnit_Messager::setErrorMessage("File naming error. Date necessary in filename to calculate revenue. " .$path);
			$this->errorFlag = true;
		}
		else
		{
			$date = substr($filenameSplit[0], 0, 4) ."-". substr($filenameSplit[0], 4, 2) ."-". substr($filenameSplit[0], 6, 2); 
	
			// initialize a loop to go through each line of the file
			while (!feof ($fd)) {
				// declare an array to hold all of the contents of each row, indexed
			    $bufferStr = fgets($fd, 4096);
				
				$buffer = explode("	",$bufferStr);
				
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
					/**
					 * We only get paid on applications so we want to make sure that there is not
					 * a value in the Decision column. A value of 1 means that it probably came through
					 * as an application in an earlier file and now is coming through again as an approval.
					 * 
					 */
					if (($buffer[1] != "") && ($buffer[0] != "") && (($buffer[4] == "") || ($buffer[4] == "0") || ($buffer[4] == 0)) && (($buffer[5] == "") || ($buffer[5] == "0") || ($buffer[5] == 0)))
					{
						$rowArr = array();
						$rowArr["merchantname"] = $merchant;
						$rowArr["transid"] = $buffer[3];
						$rowArr["providerprocessdate"] = $date;
						$rowArr["providereventdate"] = $date;
						$rowArr["providerchannel"] = $providerchannel;
						$rowArr["productid"] = $buffer[0];
						$rowArr["quantity"] = 1;
						$rowArr["estimateddatafilename"] = $filename;
						
						$this->addRow($rowArr, $cleanPath, $sqlErrorPath);
					}
				}
				
				$this->i++;
			}
		}
		
		fclose ($fd);
		
		//create archive of raw file
		$this->moveFile($path, $archivePath);
		
		if(!$this->errorFlag)
			QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _validateFilename($filename)
    {
    	$pattern = '/^\d{8}_/';
    	$subject = substr($filename, 0, 9);
    	
    	if (!strstr($filename, '_') || strstr($filename, ' ') || (!preg_match($pattern, $subject)))
    	{
    		return false;
    	}
    	
    	return true;
    }
}
?>