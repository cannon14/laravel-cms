<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_ExcelReader');
//QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadScrubber');

class Affiliate_Merchants_Bl_CapitalOneParser extends Affiliate_Merchants_Bl_Parser {
	
	var $validColumns = array(
		'Date',
		'Event_Date',
		'Action_Name',
		'ID',
		'Action_Type',
		'Status',
		'Corrected',
		'Sale_Amount',
		'Commission',
		'Website_ID',
		'Website_Name',
		'Ad_ID',
		'Advertiser_ID',
		'Advertiser_Name',
		'SID',
		'Order_ID',
		'Click_Date',
		'Action_ID'
	);
	
    function parseData($path, $fileErrorPath, $archivePath, $cleanPath, $sqlErrorPath, $filename) {
    	
    	//$uploadScrubber = new Affiliate_Merchants_Bl_UploadScrubber();
    	$data = new Affiliate_Merchants_Bl_ExcelReader();
		$data->setOutputEncoding('CP1251');
		error_reporting(E_ALL ^ E_NOTICE);
		
		$data->read($path);
		
		$errorCsvHeaderFlag = false;
		
		$providerchannel = "CJ-CapitalOne";
		
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
				//clean fields
				$buffer[2] = $this->cleanFinancial($buffer[2]);
				$buffer[8] = $this->cleanFinancial($buffer[8]);
				$buffer[7] = $this->cleanFinancial($buffer[7]);
				
				// check for empty row
				if (($buffer[12] != "") || ($buffer[8] != "") || ($buffer[7] != ""))
				{
					$rowArr = array();
					//$rowArr["merchantid"] = $buffer[12];
					$rowArr["merchantname"] = $buffer[13];
					$rowArr["providerwebsiteid"] = $buffer[9];
					$rowArr["providerwebsitename"] = $buffer[10];
					$rowArr["orderid"] = $buffer[15];
					$rowArr["providereventdate"] = $this->_convertDate($buffer[1]);
					$rowArr["providertype"] = $buffer[4];
					$rowArr["transid"] = $buffer[14];
					$rowArr["providerprocessdate"] = $this->_convertDate($buffer[0]);
					$rowArr["estimatedrevenue"] = $buffer[8];
					$rowArr["productid"] = $buffer[11];
					$rowArr["merchantsales"] = $buffer[7];
					$rowArr["provideractionname"] = $buffer[2];
					$rowArr["providerorderid"] = $buffer[3];
					$rowArr["providerstatus"] = $buffer[5];
					$rowArr["providercorrected"] = $buffer[6];
					$rowArr["provideractionid"] = $buffer[17];
					$rowArr["estimateddatafilename"] = $filename;
					$rowArr["providerchannel"] = $providerchannel;
					
					//$uploadScrubber->add($rowArr);
					$this->addRow($rowArr, $cleanPath, $sqlErrorPath);
				}
			}
		}
		//foreach($uploadScrubber->getRows() as $row)
			//$this->addRow($row, $cleanPath, $sqlErrorPath);
		//create archive of raw file
		$this->moveFile($path, $archivePath);
		
		if(!$this->errorFlag)
			QUnit_Messager::setOkMessage(L_G_REVENUE_FILE_COMPLETE .$path);
    }
    
    function _convertDate($date)
    {
    	$dateTimeArr = explode(" ", $date);
		$dateArr = explode("-", $dateTimeArr[0]);
		return ($dateArr[2] ."-". $this->monthToNumber($dateArr[1]) ."-". $dateArr[0] ." ". $dateTimeArr[1] .":00");
    }
}
?>