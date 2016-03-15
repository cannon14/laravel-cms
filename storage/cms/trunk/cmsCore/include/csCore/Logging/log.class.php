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
 
class csCore_Logging_log {

	var $location;
	
	function csCore_Logging_log($location){
		$this->location = $location;
	}
    
    function write($string, $line, $file) {
    	
    	$fileName = LOG_PREFIX."_".date("m-d-Y") . ".log";
    	if(@is_writable($this->location)){
    		$canWrite = true;
    		$handle = @fopen($this->location."/".$fileName, "a");
    	}
    	if($canWrite){
    		$writeString = "[ ".date("H:i:s")." | " .$line . " " . $file . " ] " . $string . "\n";
    		@fwrite($handle, $writeString);
    	}
    }
}
?>