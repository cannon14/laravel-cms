<?php

define('NF_SERVER', 'localhost');
define('NF_USER', 	'csdbuser');
define('NF_PASS', 	'csdbuser');
define('NF_DB', 	'csdb');

class Affiliate_Scripts_Bl_NFQuery 
{

	var $DB;

    function Affiliate_Scripts_Bl_NFQuery() 
    {
		$this->DB = NewADOConnection('mysql');
		$this->DB->Connect(NF_SERVER, NF_USER, NF_PASS, NF_DB);    	
    }
    
	function query($query)
	{
		return $this->DB->Execute($query);	
	}    
}
?>