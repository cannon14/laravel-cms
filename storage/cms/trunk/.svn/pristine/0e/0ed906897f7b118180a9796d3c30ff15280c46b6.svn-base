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

csCore_Import::importClass('CMS_pages_cmsLoginPage');
csCore_Import::importClass('CMS_libs_auth');

class CMS_view_login extends CMS_pages_cmsLoginPage
{
	
	function process()
	{
		
		if(isset($_REQUEST['submitted']) && $_REQUEST['submitted'] == 1){
			$this->processLogin();
		}
		if(isset($_REQUEST['logout']) && $_REQUEST['logout'] == 1){
			$this->logout();
		}
		
		if($this->auth->isValid() == true){
			_setMessage("Successfull Login.");
			CMS_libs_History::write($this->auth->username, "Login");
			$this->redirect("CMS_view_splash");
		}else{
			$this->drawLogin();
		}
		
	}
	
	function drawLogin()
	{
		$this->addContent('login', GLOBAL_TEMPLATES);
	}
	
	function processLogin()
	{
		
		$this->auth->login($_REQUEST['username'], 
						$_REQUEST['password'], 
						new CMS_libs_Auth());
	}
	
	function logout()
	{
	
		CMS_libs_History::write($this->auth->username, "Logout");
		//_setMessage("Successfully Logged out.");
		
		$this->auth->logout();	
	}
	
}
?>