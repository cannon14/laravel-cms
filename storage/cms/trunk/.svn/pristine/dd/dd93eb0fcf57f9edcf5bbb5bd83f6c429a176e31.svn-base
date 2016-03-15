<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 25, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */
class csCore_Util_shExecuter {

	var $script;
	var $timeout;
	var $output;
	
    function csCore_Util_shExecuter($script) 
    {
    	$this->script = $script;
    }
    
    function setTimeout($to)
    {
    	$this->timeout = $to;
    }
    
    function scriptExists()
    {
    	return @is_file($this->script);
    }
    
    function canExecute() 
    {
    	return @is_executable($this->script);	
    }
    
    function execute() 
    {
    	$this->output = shell_exec('sh ' . $this->script);
    	
    }
    
    function getOutput($lineBreak='<br>')
    {
		return str_replace("\n", $lineBreak, $this->output);
    }
}
?>