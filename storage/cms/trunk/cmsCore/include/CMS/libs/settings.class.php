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
 * @package CMS_Lib
 */

csCore_Import::importClass('CsCore_Settings_settings');

class CMS_libs_settings extends CsCore_Settings_settings
{
    /**
     * Read settings from the database and push them into the session
     * @author Patrick Mizer
     * @version 1.0
     */
    function loadSettings()
    {
		$this->clearSettingsCache();
    	$sql = "SELECT * FROM cs_settings";
    	//echo $sql;
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	while($rs && !$rs->EOF){
    		
    		$this->setSetting($rs->fields['key'], $rs->fields['value']);
    		$rs->MoveNext();
    	}
    }
    
    /**
     * Update settings
     * @author Patrick Mizer
     * @version 1.0
     */
    function saveSettings()
    {
    	$settings = $this->getSettingsArray();
    	foreach($settings as $key=>$value){
			if(!isset($_REQUEST[$key])) $_REQUEST[$key] = '';
			$sql = "UPDATE cs_settings set value = " . _q($_REQUEST[$key]) .
			" WHERE `key` = " . _q($key);   
			
			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	}

    	_setSuccess("Setting successfully updated.");
    	
    	$this->loadSettings();
    }
    

}
?>