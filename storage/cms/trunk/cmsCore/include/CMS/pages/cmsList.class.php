<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 22, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Pages
 */  
 csCore_Import::importClass('csCore_UI_restrictedDBList');
class CMS_pages_cmsList extends csCore_UI_restrictedDBList
{	
	function drawHeader()
	{
		$this->addContent('header',GLOBAL_TEMPLATES);
		
	}
	
	function drawFooter()
	{
		if(in_array('console', $this->auth->getPermissions()))
			$this->addContent('floatingconsole',GLOBAL_TEMPLATES);
		$this->addContent('footer',GLOBAL_TEMPLATES);
	}	
		
}
?>
