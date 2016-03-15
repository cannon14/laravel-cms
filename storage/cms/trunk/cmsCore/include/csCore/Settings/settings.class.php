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
 */

csCore_import::importClass('csCore_Registry_Registry');

class CsCore_Settings_settings 
{
 	var $settingsRegistry;
 	
 	function CsCore_Settings_settings ()
 	{
 		$this->settingRegistry = new csCore_Registry_Registry();
 	}   
    
    function loadSettings()
    {
    	
    }
    
    function saveSettings()
    {
   
    }
    
    function getSetting($key)
    {
    	 return $this->settingRegistry->getEntry($key); 
    }
    
    function setSetting($key, &$value)
    {
    	$this->settingRegistry->setEntry($key, $value);
    }
    
    function settingExists($key)
    {
    	return ($this->isEntry($key));
    }
    
    function clearSettingsCache()
    {
    	unset($this->settingRegistry);
    	$this->settingRegistry = new csCore_Registry_Registry();
    }
    
    function getSettingsArray()
    {
    	return $this->settingRegistry->getCacheAsArray();
    }
}