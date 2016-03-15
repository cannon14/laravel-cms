<?php
QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadExpenseError');

class Affiliate_Merchants_Bl_ExpenseParserNew extends QUnit_UI_ListPage{
	
	
	var $dataTemplate;
	var $errorDataTemplate;
	var $cleanDataTemplate;
	
	var $errorCsvHeaderFlag = false;
	var $cleanCsvHeaderFlag = false;
	var $providerprops = array();
	
    function Affiliate_Merchants_Bl_ExpenseParserNew($providerprops = null) 
    {
    	$this->providerprops = $providerprops;
    	
 		$this->cleanDataTemplate = array("expense_id",
 											"purchase_time",
 											"expense_start",
 											"expense_end",
 											"total_expense",
 											"affiliate_id",
 											"extcampaign_id",
 											"keyword_id",
 											"quantity");
									
		$this->errorDataTemplate = $this->cleanDataTemplate;
		array_unshift($this->errorDataTemplate, "error_time");
 	}
    
    /**
     * 
     * Public Abstract parseData
     * 
     * This is where the contents are read from the file.
     * This method needs to be implemented within all of
     * the child classes.
     * 
     */
    function parseData($path)
    {
    	$msg = 'Abstract method parseData called. This method must be overridden.';
    	QUnit_Messager::setErrorMessage($msg);
    }
    
    /**
     * 
     * Private Abstract _validateFileFormat
     * 
     * This is where the file is confirmed to be of a certain provider.
     * This method needs to be implemented within all of
     * the child classes.
     * 
     */
    function _validateFileFormat($buffer)
    {
    	$msg = 'Abstract method _validateFileFormat called. This method must be overridden.';
    	QUnit_Messager::setErrorMessage($msg);
    }

    /**
     * 
     * Public addRow
     * 
     * This method takes in an associative array
     * correpsonding to a row, validates the data and inserts it.
     * 
     * $headerRowFields is an array of column headers for the clean and error CSV file.
     * 
     */
     
    function addRow($row, $cleanPath, $sqlErrorPath)
    {
		//set defaults if cid and did values are not set
    	if(!isset($row['extcampaign_id']))
    		$row['extcampaign_id'] = EXPENSE_DEFAULT_CID;
    		
    	if(!isset($row['keyword_id']))
			$row['keyword_id'] = EXPENSE_DEFAULT_DID;
		
		$row = $this->_validateData($row);
    	
    	if(!isset($row["error_time"]))
    	{
			$dataTemplate = $this->cleanDataTemplate;
    		$tbl = EXPENSE_UPLOAD_TABLE;
    	}
    	else
    	{
    		$dataTemplate = $this->errorDataTemplate;
    		$tbl = EXPENSE_UPLOAD_ERROR_TABLE;
    	}
    	
    	$row["expense_id"] = QCore_Sql_DBUnit::createUniqueID(EXPENSE_TABLE, "expense_id");
    	
    	//verify valid column and strip quotes
    	foreach($row as $col => $data)
    	{
    		if(in_array($col, array_keys($dataTemplate)))
    		{
    			$sqldata[$col] = trim(str_replace('"', "", $data));
    		}
    	}
    	
    	$rs = $this->_insertData($sqldata, $tbl);
    	
    	//if sql error on data insert
    	if($rs == null)
		{
			// add header row to error CSV
			if(!$this->errorCsvHeaderFlag)
			{
				$this->addCsvRow($this->errorDataTemplate, $sqlErrorPath, true);
				$this->errorCsvHeaderFlag = true;
			}
			
			$this->addCsvRow($row, $sqlErrorPath);
			return false;
		}
		else
		{
			// add header row to error CSV
			if(!$this->cleanCsvHeaderFlag)
			{
				$this->addCsvRow($this->errorDataTemplate, $cleanPath, true);
				$this->cleanCsvHeaderFlag = true;
			}
			
			//successful add to upload table -> add to cleanCSV file
			$this->addCsvRow($row, $cleanPath);
			return true;
		}
    }
    
    /*
     * Public parseUrl
     * 
     * Accepts string URL value from raw files and returns Array of query string variables. 
     */
    function parseUrl($strUrl)
    {
    	$qrystr = explode("?", $strUrl);
    	$vars = explode("&", $qrystr[1]);

    	$returnData = array();
    	
    	foreach($vars as $data)
    	{
    		$tmpArr = explode("=", $data);
    		$returnData[$tmpArr[0]] = $tmpArr[1];
    	}
    	
    	return $returnData;
    }
    
    /**
     * Private _validateData
     * 
     * Accepts transaction as associative array and returns the same with or without error data fields. 
     */
    
    function _validateData($row)
    {
		if(!isset($row["total_expense"]) || !isset($row["quantity"]) || ($row["total_expense"] == 0) || ($row["quantity"] == 0))
		{
			$row["error_time"] = date('Y-m-d h:i:s');
			QUnit_Messager::setErrorMessage("Missing required quantity or total_expense field.");
			
			return $row;
		}
		
		if(!isset($row["affiliate_id"]) || !isset($row["purchase_time"]) || !isset($row["expense_start"]) || !isset($row["expense_end"]))
		{
			$row["error_time"] = date('Y-m-d h:i:s');
			QUnit_Messager::setErrorMessage("Missing required affiliate_id or date fields.");
			
			return $row;
		}
		
		if((!$this->_checkDate($row["purchase_time"])) || (!$this->_checkDate($row["expense_start"])) || (!$this->_checkDate($row["expense_end"])))
		{
			$row["error_time"] = date('Y-m-d h:i:s');
			QUnit_Messager::setErrorMessage("Malformed date.");
			
			return $row;
		}
		
		if((!isset($row['extcampaign_id'])) || ($row['extcampaign_id'] == ""))
		{
			$row["error_time"] = date('Y-m-d h:i:s');
			QUnit_Messager::setErrorMessage("Missing " . L_G_EXTCAMPAIGN . " value.");
		}
		
		//check format of extcampaign_id and keyword_id fields
		$re = '/(_)|(&)|\s/';
		if((preg_match($re, $row['extcampaign_id'])) || (preg_match($re, $row['keyword_id'])))
		{
			$row["error_time"] = date('Y-m-d h:i:s');
		}
		
		return $row;
    }
    
    function validateRequiredFields($params)
    {
    	if((($params["quantity"] == 0) || !isset($params["quantity"])) && (($params["total_expense"] == 0) || !isset($params["total_expense"])))
    	{
    		return false;
    	}
    		
    	return true;
    }
    
    /**
     * Public _validateFilename
     * 
     * Accepts filename in format: yyyymmdd_yyyymmdd_filename.csv
     */
    function _validateFilename($filename)
    {
    	$subject = substr($filename, 0, 18);
    	
    	$pattern1 = '/\s+/';
    	$pattern2 = '/^\d{8}_\d{8}_/';
    	
    	if (preg_match($pattern1, $filename))
    		return false;
    	
    	if (!preg_match($pattern2, $subject))
    		return false;
    		
    	return true;
    }
    
    /*
     * Private _checkDate
     * 
     * Accepts date in format: 9/1/2006
     * 
     * Returns boolean. 
     */
    function _checkDate($date)
    {
    	$re = '/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/';
    	
    	return preg_match($re, $date);
    }
    
    /**
     * 
     * Public addCsvRow
     * 
     * This method takes in an associate array
     * correpsonding to a row and inserts it.
     * 
     */
    
    function addCsvRow($row, $filename, $header = false, $sep = ',')
    {
    	$fp = fopen($filename, "a");

    	$ret = '';
    	
    	//write header row only
    	if ($header)
    	{
    		$ret = implode($sep, $row). ",";
    	}
    	else
    	{
    		foreach($this->errorDataTemplate as $col)
	    	{
	    		$ret .= $row[$col]. ",";
	    	}
    	}
    	
		fputs($fp, "$ret\n");
		
		fclose($fp);
    }
    
    /**
     * 
     * Private _insertData
     * 
     */
    function _insertData($data, $tbl)
    {
    	switch($tbl){
    		case EXPENSE_UPLOAD_TABLE :
    			$ret = Affiliate_Merchants_Bl_UploadExpense::insertExpense($data);
    		break;
    		default :
    			$ret = Affiliate_Merchants_Bl_UploadExpenseError::insertError($data);
    		break;
    	}
    	
    	return $ret;
    }
    
    /**
     * Public getFileDates
     */
     
     function getFileDates($filename)
     {
     	//extract dates from filename - format yyyymmdd_yyyymmdd_filename.ext
		$filenameArr = explode('_', $filename);
		
		//convert dates to mm/dd/yyyy
		$file = array();
		$file["startdate"] = substr($filenameArr[0], 0, 4) ."-". substr($filenameArr[0], 4, 2) ."-". substr($filenameArr[0], 6, 2);
		$file["enddate"] = substr($filenameArr[1], 0, 4) ."-". substr($filenameArr[1], 4, 2) ."-". substr($filenameArr[1], 6, 2);
		
		return $file;
     }
    
    /**
     * 
     * Public cleanFinancial
     * 
     */
    function cleanFinancial($field)
    {
    	$field = eregi_replace("\\$","",$field);
		$field = eregi_replace(",","",$field);
		$field = eregi_replace("'","",$field);
    	return $field;
    }
    
    /**
     * 
     * Public moveFile
     * 
     */
    function moveFile($oldpath, $newpath)
    {
    	if (!rename($oldpath, $newpath))
    	{
    		echo "File Move Error: Unable to move file to '$newpath'";
    	}
    }
    
    /**
     * 
     * Public copyFile
     * 
     */
    function copyFile($oldpath, $newpath)
    {
    	if (!copy($oldpath, $newpath)) {
   			echo "File Copy Error: Unable to copy file to '$newpath'";
		}
    }
    
    /**
     * 
     * Public monthToNumber
     * 
     */
    function monthToNumber($month)
    {
    	switch($month)
    	{
    		case "Jan": $num = "01"; 
    		break;
    		case "Feb": $num = "02";
    		break;
    		case "Mar": $num = "03";
    		break;
    		case "Apr": $num = "04";
    		break;
    		case "May": $num = "05";
    		break;
    		case "Jun": $num = "06";
    		break;
    		case "Jul": $num = "07";
    		break;
    		case "Aug": $num = "08";
    		break;
    		case "Sep": $num = "09";
    		break;
    		case "Oct": $num = "10";
    		break;
    		case "Nov": $num = "11";
    		break;
    		case "Dec": $num = "12";
    		break;	
    	}
    	
    	return $num;
    }
}
?>