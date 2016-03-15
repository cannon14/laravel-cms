<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 15, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */

class csCore_DB_db {
	var $DB;
    function csCore_DB_db() {
    	$this->DB = NewADOConnection(DB_TYPE);
		$this->DB->Connect(DB_HOST, DB_UN, DB_PW, DB_NAME);
		$this->DB->SetFetchMode(ADODB_FETCH_ASSOC); //default is ADODB_FETCH_DEFAULT
    }
    
    function query($sql, $line, $file, $errorout = true){
    	
    	$rs = $this->DB->Execute($sql);
    	if ($this->DB->ErrorMsg() != null && $errorout){ 
    		_setMessage($this->DB->ErrorMsg() . " on line " . $line . " of " . $file, true);
    		return null;
    	}
    	
    	return $rs;
    }
    
    function selectLimit($sql, $offset, $limit, $l, $f, $errorout = true)
    {
        $rs = $this->DB->SelectLimit($sql, $limit, $offset);
        
        if ($this->DB->ErrorMsg() != null && $errorout){
	        $msg = $this->DB->ErrorMsg() . " on line " . $l . " of " . $f ." - SQL: ".$sql;
	        _setMessage($msg, true);
    		return null;
    	}

        return $rs;
    }

    function getLastInsertId()
    {
        return $this->DB->Insert_ID();
    }
}