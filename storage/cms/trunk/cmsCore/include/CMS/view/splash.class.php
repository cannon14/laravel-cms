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
 * @package CMS_View
 */
 
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_settings');

class CMS_view_splash extends CMS_pages_cmsRestrictedPage
{
	
	function process()
	{
		if(isset($_REQUEST['submitted'])){
			$this->processLogin();
		}	
		
		$this->settings->loadSettings();
		$this->addContent('splash', GLOBAL_TEMPLATES);
		
	}
}
?>
