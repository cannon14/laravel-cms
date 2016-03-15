<?php
/**
 * 
 * CreditCards.com
 * 01/04/08
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('CMS_libs_PageComponents');
csCore_Import::importClass('CMS_libs_Pages');

class CMS_view_content extends CMS_pages_cmsList{
	function process(){
		if($_REQUEST['committed'] !=1 ){
			switch($_REQUEST['action']){
				case 'edit':
					if($this->drawFormEdit($_REQUEST['itemid']))
						return;
					break;
				
				case 'create':
					if($this->drawFormCreate())
						return;
					break;
						
				case 'delete':
					if($this->processDelete($_REQUEST['itemid']))
						return;
					break;
			}
		}
		
		else{
			switch($_REQUEST['action']){
				case 'edit':
					if($this->processEdit())
						return;
					break;
				
				case 'create':
					if($this->processCreate())
						return;
					break;
			}
		}
		$this->showData();    
	}
	
	function getRequiredPermissions()
    {
    	return array('CMS_pageContents');	
    } 
    
    function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT " . $columns ." FROM cs_pagecomponents";   	
    }
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM cs_pagecomponents';
    }
    
    function setFilter()
    {
    	
    	$this->filter->setTitle("Component Filter");									
    	
    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchItems', 
															'value' => $_REQUEST['searchItems'],
															'label' => 'Search (by Name): ')));
    }
    
    function getColumns()
    {
		// db Column name => array(Label, sortable)
		return array(
			"itemid"		 		=> array("Component Id", true),
			"item" 					=> array("Item Name", true),
			//"render"				=> array("Render", true)
		);
    }
    
    function getKey()
    {
    	return "itemid";
    }
    
    function setSelectActions()
    {
    	
    	$label 		= "Edit Component";
    	$action		= "edit";
    	$vars 		= array("itemid" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

 		$label 		= "Delete Component";
    	$action		= "delete";
    	$vars 		= array("itemid" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    } 
    
    function setTextActions()
    {
    	$label 		= "Create New Content Item";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }
    
    function drawFormCreate(){		
    	$this->addContent('component_edit');
    	return true;
    }
    
    function drawFormEdit(){
    	$componentDao = new CMS_libs_PageComponents();
    	$id = $_REQUEST['itemid'];
    	$rs_component = $componentDao->getComponent($id);
    	
    	$_POST['item'] = $rs_component->fields['item'];
    	$_POST['render'] = stripslashes($rs_component->fields['render']);
    	$_POST['itemid'] = $id;
    	    	
    	$this->addContent('component_edit');
    	return true;
    }
    
    function processCreate(){
    	$componentDao = new CMS_libs_PageComponents();
    	if($componentDao->addComponent($_REQUEST['item'], $_REQUEST['render'])){
    		$this->showData();
    		return true;
    	}
    	else{
    		echo "Insert Failed.";
    		return false;
    	}	
    }
    
    function processDelete($id){
    	$componentDao = new CMS_libs_PageComponents();
    	if($componentDao->deleteComponent($id)){
    		$this->showData();
    		return true;
    	}
    }
    
   function processEdit(){
    	$componentDao = new CMS_libs_PageComponents();
    	if($componentDao->updateComponent($_REQUEST['itemid'], $_REQUEST['item'], $_REQUEST['render'])){
    		$this->showData();
    		return true;
    	}
    	else
    		return false;
    }
}
?>