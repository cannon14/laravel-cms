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
 */

csCore_Import::importClass('csCore_UI_page');
csCore_Import::importClass('csCore_Authentication_authentication');

class csCore_UI_restrictedPage extends csCore_UI_page {
	
	function checkPermissions()
	{
		$requiredPermissions = $this->getRequiredPermissions();
		$usersPermissions = $this->auth->getPermissions();
		
		foreach((array)$requiredPermissions as $perm){
			if(!in_array($perm, $usersPermissions)){
				return false;	
			}
		}
		
		return true;
	}
	
	function checkLogged($modName)
    {
    	
    	return ($this->auth->isValid());
    	
    }
    
    function getModuleLabel()
    {
    	return "Undefined";
    }
    
    function getRequiredPermissions(){
    	return array();	
    }
    
}