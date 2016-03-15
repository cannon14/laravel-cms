<?php
/**
 * 
 * CreditCards.com L.P.
 * Parser Class
 * 
 * Patrick J. Mizer
 * Kyle Putnam
 * 
 **/
QUnit_Global::includeClass('QUnit_UI_ListPage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_NFQuery');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadError');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadTransaction');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Validator');

class Affiliate_Merchants_Bl_Parser extends QUnit_UI_ListPage
{
	var $dataTemplate;
	var $errorDataTemplate;
	var $cleanDataTemplate;
	var $validator;
	var $errorCsvHeaderFlag = false;
	var $cleanCsvHeaderFlag = false;
	var $providerprops = array();
	//errorflag, fileValidated, skipHeaderRow used in each individual subclass
	var $errorFlag = false;
	var $fileValidated = false;
	var $skipHeaderRow = false;
	
    function Affiliate_Merchants_Bl_Parser($providerprops = null) 
    {
    	$this->providerprops = $providerprops;
    	
    	$this->validator = new Affiliate_Merchants_Bl_Validator();
    	
    	
    	//grab table structure
        $sql = 'DESCRIBE ' . TRANS_TABLE;
        $rsCheck = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rsCheck) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        while(!$rsCheck->EOF){
        	$this->cleanDataTemplate[] = $rsCheck->fields['Field'];
        	$rsCheck->MoveNext();	
        }
    								
		$this->errorDataTemplate = $this->cleanDataTemplate;
		array_unshift($this->errorDataTemplate, "errordate", "errorcode");
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
     * Private _validateFileFormat
     * 
     * This method takes in an array of header names and an array of columns that should be present
     * correpsonding to the first row of a raw file.
     * 
     */
    function _validateFileFormat($rawFileHeader, $validColumns)
    {
    	for ($i=0; $i<count($validColumns); $i++)
    	{
    		$raw = trim(strtolower($rawFileHeader[$i]));
    		$valid = trim(strtolower($validColumns[$i]));
    		
    		if ($raw != $valid)
	    	{
				return false;
	    	}
    	}
    	
    	return true;
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
    	$row['transid'] = $this->validator->_cleanTransid($row['transid']);
    	$row['dateadjusted'] = date('Y-m-d H:i:s');
    	$row['dateestimated'] = date('Y-m-d H:i:s');
    	
    	if($this->providerprops["rate"])
    		unset($row['estimatedrevenue']);
    	
    	$row["providerid"] = $this->providerprops["provider_id"];
    	
    	//check for netfiniti records and dump them into netfiniti upload holding table
    	if (isNF($row["transid"]))
    	{
    		$row = $this->_validateNetfinitiData($row);
    		
    		if (!$row["errorcode"])
	    	{
				$dataTemplate = $this->cleanDataTemplate;
	    		$tbl = UPLOAD_CCCOM_TABLE;
	    	}
	    	else
	    	{
	    		$dataTemplate = $this->errorDataTemplate;
	    		$tbl = UPLOAD_ERROR_TABLE;
	    	}
	    	
	    	$netfiniti = true;
    	}
    	else
    	{
    		$row = $this->_validateData($row);
	    	
	    	if (!$row["errorcode"])
	    	{
				$dataTemplate = $this->cleanDataTemplate;
	    		$tbl = UPLOAD_TABLE;
	    	}
	    	else
	    	{
	    		$dataTemplate = $this->errorDataTemplate;
	    		$tbl = UPLOAD_ERROR_TABLE;
	    	}
	    	
	    	$netfiniti = false;
    	}
    	
    	//verify valid column and strip quotes
    	foreach($row as $col => $data)
    	{
    		if(in_array($col, array_keys($dataTemplate)))
    		{
    			$sqldata[$col] = trim(str_replace('"', "", $data));
    		}
    	}
    	
    	if ($netfiniti)
    	{
    		$rs = $this->_insertNetfinitiData($sqldata, $tbl);
    	}
    	else
    	{
    		$rs = $this->_insertData($sqldata, $tbl);
    	}
    	
    	//if sql error on data insert
    	if ($rs == null)
		{
			// add header row to error CSV
			if (!$this->errorCsvHeaderFlag)
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
			if (!$this->cleanCsvHeaderFlag)
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
     * Private _validateNetfinitiData
     * 
     * Accepts transaction as associative array and returns the same with or without error data fields. 
     */
    
    function _validateNetfinitiData($row)
    {		
		return $this->validator->validateNetfinitiData($row);
    }
    
    /*
     * Private _validateData
     * 
     * Accepts transaction as associative array and returns the same with or without error data fields. 
     */
    
    function _validateData($row)
    {		
		return $this->validator->validateData($row);
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
     * Private _insertNetfinitiData
     * 
     */
    function _insertNetfinitiData($data, $tbl)
    {
    	//$data["dateinserted"] = $this->getDate();
    	//set transtype
    	$data["transtype"] = TRANSTYPE_SALE;
    	// scrub productid
    	$data["productid"] = $this->_scrub($data["productid"]);
    	
    	$sql = 'INSERT INTO ' . 
	    		$tbl . 
				' (`'.implode('`,`', array_keys($data)) .
				'`) VALUES ("'.implode('","', $data).'")';
	    $rs = $this->_queryNF($sql);
		
		if (!$rs)
			QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
		
	    return $rs;
    }
    
    /**
     * 
     * Private _insertData
     * 
     */
    function _insertData($data, $tbl)
    {
    	//$data["dateinserted"] = $this->getDate();
    	//set transtype
    	$data["transtype"] = TRANSTYPE_SALE;
    	// scrub productid
    	$data['productid'] = $this->_scrub($data['productid']);
    	
    	switch($tbl){
    		case UPLOAD_TABLE :
    			$ret = Affiliate_Merchants_Bl_UploadTransaction::insertTransaction($data);
    		break;
    		default :
    			$ret = Affiliate_Merchants_Bl_UploadError::insertError($data);
    		break;
    	}
    	
    	return $ret;
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
     * Public getDate - returns current date/time
     * 
     */
    function getDate()
    {
    	return date("Y-m-d H:i:s");
    }
    
    /**
     * 
     * Private _scrub
     * 
     * scrubs text and removes any instance contained in the $badStrings array
     * from the param string and returns the resulting string.
     * 
     */
	
	function _scrub($str)
	{
			// Add anything you want 'scrubbed' to this array
			$badStrings = array('�', '�');
			
			foreach($badStrings as $badString){
				$str = str_replace($badString, '', $str);
			}
			
			return $str;
	}
	
	function _queryNF($sql)
	{
		$nfDb = new Affiliate_Scripts_Bl_NFQuery();
		
    	return $nfDb->query($sql);
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