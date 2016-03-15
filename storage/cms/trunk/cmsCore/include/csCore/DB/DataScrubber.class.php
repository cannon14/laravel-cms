<?php

class csCore_DB_DataScrubber {
    function csCore_DB_DataScrubber() {
    	
    }
    
    function replace($pattern, $replace, $table, $col){	
    	$count = 0;
    	$priKey = $this->_findPrimaryKey($table);   	
    	
    	$sql = "SELECT $priKey, $col FROM $table";
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	if(!$rs){
    			$this->_handleError("SQL Error", __LINE__, __FILE__);
    			return -1;
    	}

    	while($rs && !$rs->EOF){
    		$newString = str_replace($pattern, $replace, $rs->fields[$col]);
    		if($rs->fields[$col] != $newString){
    			++ $count;
    			$sql = 'UPDATE ' .$table .' SET ' . $col .'= ' . _q(addslashes($newString)) .' WHERE ' .$priKey .'= ' .$rs->fields[$priKey];
    			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    			if(!$rs){
    				$this->_handleError("SQL Error",  __LINE__, __FILE__);
    				return -1;
    			}
    		}
    		$rs->MoveNext();
    	}
    	return $count;
    }
    
    function _handleError($msg, $line, $file){
    	_setMessage($msg, $line, $file, true);
    }

	function _findPrimaryKey($table)
	{
		//get primary key
    	$sql = "DESCRIBE $table";
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	while($rs && !$rs->EOF && !isset($priKey)){
    		if($rs->fields['Key'] == "PRI"){
    			$priKey = $rs->fields['Field'];
    		}
    	}
    	
    	return $priKey;
	}
}