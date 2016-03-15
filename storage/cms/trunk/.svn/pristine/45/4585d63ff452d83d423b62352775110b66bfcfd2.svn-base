<?php
/**
 * 
 * ClickSuccess, L.P.
 * June 26, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */ 
 
csCore_Import::importClass('CMS_pages_cmsList');

class CMS_view_history extends CMS_pages_cmsList {

	
	function process()
	{
		if($_REQUEST['action'] == 'purge')
		{
			$this->processPurge();	
		}
		$this->showData();    	
	}
	
    function getRequiredPermissions()
    {
    	return array('CMS_history');	
    }     		
	
	function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT " . $columns ." FROM cs_history ";   	
    }	
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM cs_users';
    }      
    
    function setFilter()
    {
    	
    	$this->filter->setTitle("User Filter");									
    	
    }   
    
    function getColumns()
    {
		// db Column name => array(Label, sortable)
		return array(
			"id"	 			=> array("Id", true),
			"dateinserted" 		=> array("Date", true),			
			"user" 				=> array("User", true),
			"action" 			=> array("Action", true),
		);
    }  
    
    function getKey()
    {
    	return "id";
    }	
    
    function setTextActions()
    {
    	$label 		= "Purge History";
    	$action		= "purge";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    } 
    
    function processPurge()
    {
    	CMS_libs_History::purge();	
    	
    	CMS_libs_History::write($this->auth->username, "Purged History");
    }
  
}
?>