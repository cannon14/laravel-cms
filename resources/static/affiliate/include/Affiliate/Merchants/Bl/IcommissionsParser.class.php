<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExcelReader');

class Affiliate_Merchants_Bl_IcommissionsParser extends Affiliate_Merchants_Bl_Parser {
	
	var $validColumns = array(
		'Commission Date',
		'Sales',
		'SubAgent',
		'CampaignID',
		'Commision'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
		$data = new Affiliate_Merchants_Bl_ExcelReader();
		$data->setOutputEncoding('CP1251');
		error_reporting(E_ALL ^ E_NOTICE);
		
		$data->read($path);
		$errorCsvHeaderFlag = false;
		
		$providerchannel = "iCommissions";
		$merchantname = "iCommissions";
		
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
				$buffer[4] = $this->cleanFinancial($buffer[4]);
				$buffer[1] = $this->cleanFinancial($buffer[1]);
				
				if (($buffer[0] != "") || ($buffer[4] != "") || ($buffer[1] != ""))
				{
					$rowArr = array();
					$rowArr["transid"] = $buffer[3];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[0]);
					$rowArr["providereventdate"] = $this->_convertDate($buffer[0]);
					$rowArr["estimatedrevenue"] = $buffer[4];
					$rowArr["providerchannel"] = $providerchannel;
					$rowArr["merchantname"] = $merchantname;
					$rowArr["quantity"] = $buffer[1];
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
		return (date("Y-m-d", mktime(0, 0, 0, $dateArr[1] , $dateArr[0], $dateArr[2])));
    }
}
?>