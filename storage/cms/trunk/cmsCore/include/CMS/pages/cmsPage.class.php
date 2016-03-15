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
 csCore_Import::importClass('csCore_UI_page');
class CMS_pages_cmsPage extends csCore_UI_page
{
	function drawHeader()
	{
		$this->addContent('header',GLOBAL_TEMPLATES);
	}
	
	function drawFooter()
	{
		if(in_array('console', $this->auth->getPermissions()))
			$this->addContent('console',GLOBAL_TEMPLATES);
		$this->addContent('footer',GLOBAL_TEMPLATES);
	}
}
?>