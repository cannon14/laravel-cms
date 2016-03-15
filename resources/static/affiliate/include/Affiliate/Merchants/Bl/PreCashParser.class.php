<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExcelReader');

class Affiliate_Merchants_Bl_PreCashParser extends Affiliate_Merchants_Bl_Parser {
	
	var $validColumns = array(
		'DateSubmitted',
		'camefrom',
		'camefromid'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
		$data = new Affiliate_Merchants_Bl_ExcelReader();
		$data->setOutputEncoding('CP1251');
		error_reporting(E_ALL ^ E_NOTICE);
		
		$data->read($path);
		$errorCsvHeaderFlag = false;
		
		$providerchannel = "PreCash";
		$merchantname = "PreCash";
		
		for ($i=1; $i <= $data->sheets[0]['numRows']; $i++)
		{
			$buffer = array();
			
			for ($j=1; $j <= $data->sheets[0]['numCols']; $j++)
			{
				array_push($buffer, $data->sheets[0]['cells'][$i][$j]);
			}

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
			if (($i > 5) && (!$this->fileValidated))
			{
				$this->copyFile($path, $fileErrorPath);
				
				QUnit_Messager::setErrorMessage(L_G_REVENUE_FILE_ERROR .$path);
				$this->errorFlag = true;
				break;
			}
			
			if (($this->fileValidated) && ($this->skipHeaderRow))
			{
				// check for empty row
				if (($buffer[0] != "") && ($buffer[1] != ""))
				{
					
					//check if transid is double
					if(strstr($buffer[2], ","))
					{
						$transArr = explode(",", $buffer[2]);
						//only take the first transid
						$buffer[2] = trim($transArr[0]);
					}
					
					$providerDate = $this->_convertDate($buffer[0]);
					
					$rowArr = array();
					$rowArr["merchantname"] = $merchantname;
					$rowArr["transid"] = $buffer[2];
					$rowArr["providerprocessdate"] = $providerDate;
					$rowArr["providereventdate"] = $providerDate;
					
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
    
    //incoming format: dd/mm/yyyy
    function _convertDate($date)
    {
    	$dateArr = explode("/", $date);
    	
    	//mktime format: h, m, s, month, day, year
    	return (date("Y-m-d H:i:s", mktime(0, 0, 0, $dateArr[1], $dateArr[0], $dateArr[2])));
	}
}
?>