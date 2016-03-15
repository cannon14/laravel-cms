<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExcelReader');

class Affiliate_Merchants_Bl_NcsParser extends Affiliate_Merchants_Bl_Parser {
	
	var $validColumns = array(
		'Account Id',
		'User Variable',
		'Campaign',
		'',
		'Offer',
		'Click Date',
		'Type',
		'Applications',
		'',
		'Approvals',
		'Commission',
		'Posting Date'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
    	$data = new Affiliate_Merchants_Bl_ExcelReader();
		$data->setOutputEncoding('CP1251');
		error_reporting(E_ALL ^ E_NOTICE);
		
		$data->read($path);
		$errorCsvHeaderFlag = false;
		
		$providerchannel = "NCS";
		
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
				//strip out dollar signs and commas
				$buffer[11] = $this->cleanFinancial($buffer[11]);
				$buffer[6] = $this->_scrub($buffer[6]);
					
				if (($buffer[0] != "") || ($buffer[4] != "") || ($buffer[2] != "") || ($buffer[9] != ""))
				{
					$rowArr = array();
					$rowArr["transid"] = $buffer[1];
					$rowArr["merchantname"] = $buffer[2];
					$rowArr["productid"] = $buffer[4];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[11]);
					$rowArr["providereventdate"] = $this->_convertDate($buffer[5]);
					$rowArr["estimatedrevenue"] = $buffer[10];
					
					$rowArr["quantity"] = 1;
					$rowArr["providerchannel"] = $providerchannel;
					$rowArr["estimateddatafilename"] = $filename;
					
					//set static campcategoryid for records without transids
					if ((($buffer[1] == "") || ($buffer[1] == " ") || ($buffer[1] == null)) && ($buffer[4] == "Aspire"))
					{
						$rowArr["campcategoryid"] = CAMPCATID_ASPIRE;
					}
					
					if ((($buffer[1] == "") || ($buffer[1] == " ") || ($buffer[1] == null)) && ($buffer[4] == "Vaya Prepaid MasterCard"))
					{
						$rowArr["campcategoryid"] = CAMPCATID_VAYA;
					}
					
					if ((($buffer[1] == "") || ($buffer[1] == " ") || ($buffer[1] == null)) && ($buffer[4] == "Wired Plastic"))
					{
						$rowArr["campcategoryid"] = CAMPCATID_WIRED;
					}
					
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
    	//incoming format: dd/mm/yyyy
    	
    	$dateArr = explode("/", $date);
		return (date("Y-m-d", mktime(0, 0, 0, $dateArr[1] , $dateArr[0]-1, $dateArr[2])));
    }
}
?>