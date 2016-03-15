<?php

class Affiliate_Scripts_Services_ServiceLogger 
{
	var $fileHandle;
	
    function Affiliate_Scripts_Services_ServiceLogger($filename) 
    {
    	$this->fileHandle = fopen($filename, 'a');
    }
    
    function write($msg)
    {
		$line = '['.date('m-d-Y H:i:s').']: ' . $msg . "\n\r";
		fwrite($this->fileHandle, $line);    	
    }
    
    function _throwError($msg)
    {
		    	
    }

}
?>