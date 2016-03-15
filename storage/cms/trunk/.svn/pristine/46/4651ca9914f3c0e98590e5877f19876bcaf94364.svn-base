<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 27, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
 csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
 
class CMS_view_settings extends CMS_pages_cmsRestrictedPage
{

    function process() 
    {
    	if(!isset($_REQUEST['updateSettings'])) $_REQUEST['updateSettings'] = 0;
    	if($_REQUEST['updateSettings'] == 1){
    		$this->saveSettings();
    	}
    
    	$this->loadSettings();
    	$this->addContent("settings");
    }
    
    function loadSettings()
    {
		$settingsArray = $this->settings->getSettingsArray();
    	$this->assignValue('settings', $this->settings);
    }
    
    function saveSettings()
    { 	
    	$this->settings->saveSettings();
    	
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_settings');	
    }   
}
?>