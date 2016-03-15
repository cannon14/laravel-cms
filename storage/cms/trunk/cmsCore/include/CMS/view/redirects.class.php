<?php
/**
 * 
 * CreditCards.com
 * March 16, 2009
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_View
 */ 
 
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('CMS_libs_Redirect');
csCore_Import::importClass('CMS_libs_Sites');

class CMS_view_redirects extends CMS_pages_cmsList {

	
	function process()
	{
		if(!isset($_REQUEST['action'])) $_REQUEST['action'] = '';
		
		if(!isset($_REQUEST['commited'])){
			switch($_REQUEST['action']){             
				case 'edit':
                    $this->drawFormEditRedirect($_REQUEST['redirect_id']);
			        break;
				case 'create':
			        $this->drawFormCreateRedirect();
			        break;	
				case 'delete':
			        $this->processDeleteRedirect($_REQUEST['redirect_id']);
			        break;
			    default: 
				    $this->showData();
				    break;
			}
		}else{
			switch($_REQUEST['action']){             
				case 'edit':
			        $this->processEditRedirect($_REQUEST['redirect_id']);
			        break;
					   
				case 'create':
			        $this->processCreateRedirect();
			        break;
			        
				default: 
				    $this->showData();
				    break;	
			}		         			
		}
	}
	
    
	function getRequiredPermissions()
    {
    	return array('CMS_pages');	
    }  	
	
	function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = 
<<<SQL
SELECT $columns
FROM redirects as r
JOIN rt_sites as s ON (s.siteId = r.site_id)
SQL;
    	
    	$search = $this->filter->getValue('searchRedirects');
   		
   		if($search != ''){
   			$this->where .= ' AND (filename LIKE ' . _q('%'.$search.'%') .' OR destination_url LIKE ' . _q('%'.$search.'%') . ')';
   		}
   		
   		$this->where = ' WHERE r.deleted != 1';
    }	
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM redirects as r';
    }      
    
    function setFilter()
    {
    	
    	$this->filter->setTitle("User Filter");									
    	
    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchRedirects', 
															'value' => isset($_REQUEST['searchRedirects']) ? $_REQUEST['searchRedirects'] : '',
															'label' => 'Search (by filename or destination url): ')));
    }   
    
    function getColumns()
    {
		// db Column name => array(Label, sortable)
		return array(
			"redirect_id"	 	=> array("Id", true),
			"siteName"			=> array("Site", true),			
			"filename" 			=> array("File Name", true),
			"destination_url" 	=> array("Destination URL", true)
		);
    }  
    
    function getKey()
    {
    	return "redirect_id";
    }	

    function setSelectActions()
    {
    	
    	$label 		= "Edit Redirect";
    	$action		= "edit";
    	$vars 		= array("redirect_id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
 		
 		$label 		= "Delete Redirect";
    	$action		= "delete";
    	$vars 		= array("redirect_id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
  
    }	         
    
    function setTextActions()
    {
    	$label 		= "Create New Redirect";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    } 
    
    function drawFormCreateRedirect()
    {
        $this->assignValue('sites', CMS_libs_Sites::getAllSites());
    	
        $this->assignValue('site_id', '');
    	$this->assignValue('filename', '');
    	$this->assignValue('destination_url', '');
    	$this->assignValue('redirect_id', '');
    	
        isset($_REQUEST['embed']) ? $this->addContent('redirect_edit_ajax') : $this->addContent('redirect_edit');	
    	
        return true;
    }   
    
    function processCreateRedirect()
    {
    	$params['site_id'] = $_REQUEST['site_id'];
    	$params['filename'] = $_REQUEST['filename'];
    	$params['destination_url'] = $_REQUEST['destination_url'];
    	
    	CMS_libs_Redirect::insert($params);
    	$this->showData();
    }
    
    
    function drawFormEditRedirect($id)
    {
        $redirect = CMS_libs_Redirect::getById($id);
    	
    	$this->assignValue('sites', CMS_libs_Sites::getAllSites());
    	
    	$this->assignValue('site_id', $redirect->fields['site_id']);
    	$this->assignValue('filename', $redirect->fields['filename']);
    	$this->assignValue('destination_url', $redirect->fields['destination_url']);
    	$this->assignValue('redirect_id', $redirect->fields['redirect_id']);
    	
    	$this->addContent('redirect_edit');
    }
    
    
    function processEditRedirect($id)
    {
		$params['site_id'] = $_REQUEST['site_id'];
    	$params['filename'] = $_REQUEST['filename'];
    	$params['destination_url'] = $_REQUEST['destination_url'];
    	$params['redirect_id'] = $_REQUEST['redirect_id'];
    	
    	CMS_libs_Redirect::update($id, $params);
    	$this->showData();	
    }
    
    
    function processDeleteRedirect($id)
    {
    	CMS_libs_Redirect::delete($id);
    	$this->showData();		
    }   
}
?>