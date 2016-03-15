<?
/**
 * 
 * ClickSuccess, L.P.
 * August 7, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */ 

csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('csCore_UI_filter');
csCore_Import::importClass('csCore_UI_formItem');
csCore_Import::importClass('CMS_libs_Amenities');

class CMS_view_amenities extends CMS_pages_cmsList
{
	var $filter;
    function process()
    {
		if(!empty($_REQUEST['action'])){
			switch($_REQUEST['action']){
				case 'deleteAmenity':
                    if($this->processDeleteAmenity())
                        return;
                    break;     
				case 'createAmenity':
                    if($this->drawFormCreateAmenity())
                        return;
                    break;   
				case 'processCreateAmenity':
                    if($this->processCreateAmenity())
                        return;
                    break; 
				case 'updateAmenity':
                    if($this->drawFormUpdateAmenity())
                        return;
                    break;   
				case 'processUpdateAmenity':
                    if($this->processUpdateAmenity())
                        return;
                    break;                                                                 	
			}			
		}
		$this->showData();      
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_cards');	
    }
	
	function setSql()
    {
    	
    	$columns =  implode(", ", $this->keys);
    	$this->sql = "SELECT ". $columns ." FROM cs_amenities ";

   		$this->where = " WHERE deleted != 1 ";
    }
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM cs_amenities';
		
    }
    
    function setFilter()
    {
    	$this->filter->setTitle("Amenity Filter");		
    }
    
	function getColumns()
    {
		// db Column name => array(Label, sortable, table, callback function)
		return array(
			"label"					=> array("Amenity Label", true),			
			"amenityid"		 		=> array("Amenity ID", true),
		);    
		
    }
    
    function getKey()
    {
    	return "amenityid";
    }
    
    function setSelectActions()
    {
    	
    	$label 		= "Update Amenity";
    	$action		= "updateAmenity";
    	$vars 		= array("amenityid" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);     	
    	
    	$label 		= "Delete Amenity";
    	$action		= "deleteAmenity";
    	$vars 		= array("amenityid" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);   
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Amenity";
    	$action		= "createAmenity";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }
    
    function processDeleteAmenity()
    {
    	CMS_libs_Amenities::deleteAmenity($_REQUEST['amenityid']);
    }
    
    function drawFormCreateAmenity()
    {
    	
    	$this->addContent('amenity_create');
    	
    	return true;
    }
    
    function processCreateAmenity()
    {
    	$data = array(	"label" => $_REQUEST['label'],
    					"description" => $_REQUEST['description']);
    	CMS_libs_Amenities::addAmenity($data);
    }
    
    function drawFormUpdateAmenity()
    {
    	$this->assignValue('amenityid', $_REQUEST['amenityid']);
    	
    	$this->assignValue('data', CMS_libs_Amenities::getAmenityById($_REQUEST['amenityid']));
    	
    	
    	$this->addContent('amenity_edit');
    	
    	return true;    		
    }
    
    function processUpdateAmenity()
    {
    	$data = array(	"label" => $_REQUEST['label'],
    					"description" => $_REQUEST['description']);
    	CMS_libs_Amenities::updateAmenity($_REQUEST['amenityid'], $data);
    }
}
?>
