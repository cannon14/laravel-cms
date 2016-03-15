<?php
/**
 * 
 * ClickSuccess, L.P.
 * May 16, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */ 
class Tester {
	
	function Tester($c)
	{
		$this->class = $c;
	}
	
	function run()
	{
		
		$class = basename($this->class);
		$tmp = explode(".", $class);
		$class = $tmp[0];
		$suite =& new TestSuite($class);
		$testRunner =& new TestRunner();
		$testRunner->run($suite);
		unset($suite);
		unset($testRunner);
	}
	
	function printCode()
	{
		highlight_string(file_get_contents($this->class));	
	}
}
?>