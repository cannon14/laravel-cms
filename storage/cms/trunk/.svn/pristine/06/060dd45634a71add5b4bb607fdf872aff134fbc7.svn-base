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
 
csCore_Import::importClass('csCore_Authentication_authenticator');

class csCore_Authentication_authentication
{
	var $username;
	var $password;
	var $logintime;
	var $valid;
	var $permissions = array();
	var $attempts;
	
    function csCore_Authentication_authentication () 
    {

		/**
		static $valid;
		static $username;
		static $logintime;
		static $permissions;
		static $attempts;
		
		$this->valid =& $valid;
		$this->username =& $username;
		$this->logintime =& $logintime;
		$this->permissions =& $permissions;
		$this->attempts =& $attempts;
		**/
		$this->valid = false;
		$this->attempts = 0;
    }
    
    function login($username, $password, $authObject)
    {
    	
    	if($this->attempts > LOGIN_TRIES){
    		_userAttention("MAXIMUM LOGIN ATTEMPTS REACHED.");
    		return false;
    	}
    	
    	$this->username = $username;
    	$this->password = $password;
    	
    	if(!is_subclass_of($authObject, 'csCore_Authentication_authenticator')){
    		return false;
    	}
    	
    	if($authObject->authenticate($this->username, $this->password)){
    		$this->setModulePermissions($authObject->setPermissions());
    		$this->logintime = time();    	
    		$this->valid = true;
    		
    		return true;
    	}
    	
    	++ $this->attempts;
    	_userAttention("Incorrect login. Attempt # " . $this->getLoginAttempts());
    	return false;
    	
    }
    
    function setUsername($un){
    	$this->username = $un;
    }
    
    function logout ()
    {
    	$this->valid = false;
    }
    
    function setModulePermissions($moduleArray)
    {
    	$this->permissions = array();
    	foreach((array)$moduleArray as $modName){
    		$this->permissions[] = $modName;
    	}
    }
    
    function getLoginTimeElapsed()
    {
    	return time() - $this->logintime;
    }
    
    function getLoginAttempts()
    {
    	return $this->attempts;
    }
    
    function getPermissions()
    {
		return $this->permissions;
    }
    
    function isValid()
    {
    	return $this->valid;
    }
}
?>
