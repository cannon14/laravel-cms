<?php
/**
 * 
 * ClickSuccess, L.P.
 * June 22, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */
class csCore_Util_CsvWriter 
{

	var $delim;
	var $newline;
	var $encounteredError;
	var $errors;
    var $csv;
    
    function csCore_Util_CsvWriter($delim = ",", $newline = "\r\n") 
    {
    	$this->delim = $delim;
    	$this->newline = $newline;
    	$this->encounteredError = false;
    	$this->errors = array();
    	$this->csv = "";
    }
    
    function buildFromSql($sql, $cols = false)
    {
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		unset($this->csv);
		
		if(!$cols){
			$cols = array_keys($rs->fields);	
		}
		
		foreach($cols as $col){
			$this->csv .= $col . $this->delim;
		}
		
		$this->csv .= $this->newline;
		
		while($rs && !$rs->EOF){
	
			foreach($cols as $col){
				$this->csv .= $this->_writeNode($rs->fields[$col]) . $this->delim;	
			}
			
			$this->csv .= $this->newline;		
			$rs->MoveNext();	
		}
    }
    
    function writeCsvFile($filename)
    {	
    	$fh =& fopen($filename, "w");
    	
    	fwrite($fh, $this->csv);
    	
    	fclose($fh);	
    	
    	return true;	
    }
    
    function _writeNode($text)
    {
    	if(stristr(",", $text) !== false || stristr('"', $text) !== false){
    		$text = '"' . str_replace('"', '""', $text) . '"';	
    	}	   	
    	return $text;
    }
    
    function _handleError($error)
    {
    	$this->encounteredError = true;
    	$this->errors[] = $error;
    }
    
    
}
?>