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
 * @package CMS_Lib
 */
 csCore_Import::importClass('csCore_Authentication_authenticator');
 csCore_Import::importClass('CMS_libs_User');
 csCore_Import::importClass('CMS_libs_Rights');
 
class CMS_libs_auth extends csCore_Authentication_authenticator 
{
	
	var $username;
	
	/**
	 * Validate the user
	 * @author Patrick J. Mizer
	 * @version 1.0
	 * @param String Username
	 * @param String Password
	 * @return boolean Valid User
	 */
	function authenticate($username, $password)
	{
		$userDao = new CMS_libs_User();
		$this->username = $username;
		return $userDao->validateUser($username, $password);
	}
	
	/**
	 * Push the user's permissions into the session
	 * @author Patrick J. Mizer
	 * @version 1.0
	 * @return array User's Rights
	 */
	function setPermissions()
	{
		
		$rightsDao = new CMS_libs_Rights();
		$userDao = new CMS_libs_User();
		$rs = $userDao->getUserByUsername($this->username);
		$retArray = $rightsDao->getUsersRights($rs->fields['userid']);
		
		return $retArray;
		
	}
}
?>