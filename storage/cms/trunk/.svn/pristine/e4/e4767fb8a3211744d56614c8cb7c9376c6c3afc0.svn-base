<?php

/** 
 *  
 * ClickSuccess, L.P. 
 * June 26, 2006
 *  
 * Authors: 
 * Patrick J. Mizer 
 * <patrick@clicksuccess.com> 
 *  
 * @package CMS_View
 **/  


csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
 
class CMS_view_refactorPrime extends CMS_pages_cmsRestrictedPage {

	var $pattern = "/^((?i)prime|p) (\+) ([0-9]|[0-9][0-9]).[0-9][0-9]/";

	function process()
	{
		$this->refactorPrime();	
	}
	
    function getRequiredPermissions()
    {
    	return array('CMS_refactor');	
    }   	
	
	function refactorPrime()
	{
		$sql = "SELECT * FROM rt_cards WHERE deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		echo "<b>Current PRIME = " . $this->settings->getSetting('CMS_prime') . "</b><br><br>";
		
		while(!$rs->EOF){
			if($this->_regExPrime($rs->fields['regularApr'])){
				
				$apr = $this->_fetchApr($rs->fields['regularApr']);
				echo "Refactoring " . $rs->fields['cardTitle'] . " ";
				echo $apr . " + " . $this->settings->getSetting('CMS_prime') . " = " . ($apr + $this->settings->getSetting('CMS_prime')) . "<br>";				
				$sql = "UPDATE cs_carddata SET regularApr = " . _q($apr + $this->settings->getSetting('CMS_prime')) . " WHERE cardId = " ._q($rs->fields['cardId']);
				_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			}
			$rs->MoveNext();	
		}
		CMS_libs_History::write($this->auth->username, "Refactored Prime");
	}
	
	function _regExPrime($haystack)
	{
		return preg_match($this->pattern, $haystack);
	}
	
	function _fetchApr($haystack)
	{
		$strArray = explode(" " , $haystack);
		foreach($strArray as $el){
			if(preg_match("/([0-9]|[0-9][0-9]).[0-9][0-9]/", $el)){
				return str_replace("%", "", $el);
			}	
		}
	}

}
?>