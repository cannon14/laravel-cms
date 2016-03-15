<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 30, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
csCore_Import::importClass('CMS_libs_SiteCompiler');
csCore_Import::importClass('CMS_libs_SiteComponents');
csCore_Import::importClass('CMS_libs_SitePublisher');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('csCore_Util_shExecuter');
csCore_Import::importClass('csCore_Util_FTP');
	
class CMS_view_publishSiteToProd extends CMS_pages_cmsRestrictedPage 
{
	var $site;
	var $scripts = array();

	function process()
	{
	    if(!isset($_REQUEST['sites'])){
	        $_REQUEST['sites'] = array();
	    }else if( !is_array($_REQUEST['sites'])){
			$_REQUEST['sites'] = array($_REQUEST['sites']);
		}
		
		foreach($_REQUEST['sites'] as $site)
		{
			$id = $site;
			$rs = CMS_libs_Sites::getSite($id);
			
			$siteData = $rs->fields;
			$this->site = $siteData;	
			
			
			if(isset($_REQUEST['action'])){
    			if($_REQUEST['action'] == 'ftp'){
    				$this->_publishSiteViaFTP($siteData);	
    			}else if($_REQUEST['action'] == 'script'){
    				$this->_publishSiteViaRsync($siteData);
    			}
			}
		}
		
		$this->getSites();
		$this->assignValue('scripts', $this->scripts);
		$this->addContent('publish_to_prod');
	}
	
    function getRequiredPermissions()
    {
    	return array('CMS_prodPublish');	
    }   	
	
	function getSites()
	{
		$sites = CMS_libs_Sites::getAllSites();
		$this->assignValue('sites', $sites);
		
		$ftpSites = array();
		foreach($sites as $site){
			if($site->fields('ftpSite') != ''){
				$ftpSites[] = $site;	
			}else{
				$scriptSites[] = $site;	
			}	
		}
		
		$this->assignValue('ftpsites', $ftpSites);
		$this->assignValue('scriptsites', $scriptSites);
		
	}
	
	function getSite($id)
	{
		$site = CMS_libs_Sites::getSite($id);
		return $site;
	}	
	
	function publishSite()
	{
		$id = $_REQUEST['site'];
		$rs = CMS_libs_Sites::getSite($id);
		
		$siteData = $rs->fields;	
		
		if($siteData['ftpSite'] != '')
		{
			$this->_publishSiteViaFTP($siteData);	
			//$this->	publishSiteViaRsync($siteData);
		}else if($siteData['publishScript'] != '')
		{
			$this->_publishSiteViaFTP($siteData);	
		}else{
			_setMessage("No publish script or FTP data set.", true);	
		}
	}
	
	function _publishSiteViaFTP($siteData)
	{
		
		$console = null;
	
		
		
		$ccbuild = $this->settings->getSetting('CMS_publish');
		
		$ftp_server = $siteData['ftpSite'];
		
		$ftp_user = $_REQUEST['ftp_user'];
		$ftp_passwd = $_REQUEST['ftp_pass'];

		

	    $this->ftp = new csCore_Util_FTP();
	    if ($this->ftp->connect($ftp_server, 21, 10)) {
	        if ($this->ftp->login($ftp_user,$ftp_passwd)) {
	           
	        	$owd = getcwd();
				chdir($ccbuild);
	        	$this->ftp->cwd($siteData['ftpPath']);
	        	$this->_rec_ftp($siteData['publishPath'],$siteData['ftpPath'], $ccbuild);
	        	chdir($owd);

	        } else {
	            $console = "login failed: ";
	        }
	        $this->ftp->disconnect();
	    
	       foreach($this->ftp->lastLines as $msg){
	       		$console .= $msg . "<br>";
	       }
	    } else {
	        $console = "connection failed: ";
	    } 
	    
		//log action
		CMS_libs_History::write($this->auth->username, "Published Site to Production via FTP: ".$siteData['siteName']);

	    $this->assignValue('ftpconsole', $console);

	}
	
	function _rec_ftp($dirsource, $dirdest, $ccbuild)
	{
	  
	  if(is_dir($dirsource))$dir_handle=opendir($dirsource);

	  while($file=readdir($dir_handle))
	  {
	  	set_time_limit(60);
	    if($file != "." && $file != "..")
	    {
	    	
	      if(!is_dir($dirsource."/".$file)){ 
	      		if(file_exists($ccbuild.$dirsource."/".$file)){
	      			$this->ftp->fput($file, fopen($ccbuild.$dirsource."/".$file, "r"));
	      		}
	      }
	      else $this->_rec_ftpSub($dirsource."/".$file, $dirdest, $ccbuild);
	    }
	  }
	  closedir($dir_handle);
	  return true;
	}
	
	function _rec_ftpSub($dirsource, $dirdest, $ccbuild)
	{
	  if(is_dir($dirsource))$dir_handle=opendir($dirsource);
	  
	  $dirArray = explode('/', $dirsource);
	  array_shift($dirArray);
	  $newDir = implode('/', $dirArray);
	  $this->ftp->mkdir($newDir);
			
	  while($file=readdir($dir_handle))
	  {
	  	set_time_limit(60);
	    if($file != "." && $file != "..")
	    {
	    	
	      if(!is_dir($dirsource."/".$file)){ 
	      		if(file_exists($ccbuild.$dirsource."/".$file)){
	      			$this->ftp->fput($newDir."/".$file, fopen($ccbuild.$dirsource."/".$file, "r"));
	      		}
	      }
	      else $this->_rec_ftpSub($dirsource."/".$file, $dirdest, $ccbuild);
	    }
	  }
	  closedir($dir_handle);
	  return true;
	}
	
	function _publishSiteViaRsync($siteData)
	{	
		
		$executer = new csCore_Util_shExecuter($siteData['publishScript']);
		
		if(!$executer->scriptExists()){
			_setMessage('Script does not exist!', true);
			return false;
		}else if(!$executer->canExecute()){
			_setMessage('Script is not executable!', true);
			return false;
		}else{
			$executer->execute();
			$this->scripts[] = $executer;

			//log action
			CMS_libs_History::write($this->auth->username, "Published Site to Production via RSync: ".$siteData['siteName']);

			//_setSuccess("Published Site to Production via RSync: ".$siteData['siteName']);
		}
	}
}
?>