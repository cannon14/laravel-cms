<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExcelReader');

class Affiliate_Merchants_Bl_SimmonsParser extends Affiliate_Merchants_Bl_Parser {
	
	var $validColumns = array(
		'Date',
		'Referral ID',
		'Applications Number',
		'Loan Decision',
		'Commission'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
    	$data = new Affiliate_Merchants_Bl_ExcelReader();
		$data->setOutputEncoding('CP1251');
		error_reporting(E_ALL ^ E_NOTICE);
		
		$data->read($path);
		
		$providerchannel = "Simmons";
		
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
			
			//if file not validated after 10 rows, error out file
			if (($i > 10) && (!$this->fileValidated))
			{
				$this->copyFile($path, $fileErrorPath);
				
				QUnit_Messager::setErrorMessage(L_G_REVENUE_FILE_ERROR .$path);
				$this->errorFlag = true;
				break;
			}
			
			if (($this->fileValidated) && ($this->skipHeaderRow))
			{
				//clean fields
				$date = $this->_convertDate($buffer[0]);
				
				// check for empty row
				if ((($buffer[0] != "") || ($buffer[2] != "")) && ($buffer[3] == "Approved") && ($buffer[0] != "Totals"))
				{
					$rowArr = array();
					$rowArr["transid"] = $buffer[1];
					
					$rowArr["providereventdate"] = $date;
					$rowArr["providerprocessdate"] = $date;
					
					$rowArr["quantity"] = 1;
					$rowArr["providerchannel"] = $providerchannel;
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
    	
    	//echo $date . "-". date("Y-m-d H:i:s", mktime(0, 0, 0, $dateArr[1] , $dateArr[0], $dateArr[2])) . "<br />";
    	
    	//mktime format: h, m, s, m, d, y
		return (date("Y-m-d H:i:s", mktime(0, 0, 0, $dateArr[1] , $dateArr[0], $dateArr[2])));
    }
}
?>