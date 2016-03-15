<?
/**
 * 
 * ClickSuccess, L.P.
 * March 23, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */ 
 
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('CMS_libs_Categories');

class CMS_view_categories extends CMS_pages_cmsList
{

    function process()
    {
        if(!empty($_POST['commited']))
        {
			switch($_POST['massaction'])
            {    
                case 'delete':
                    if($this->processDelete())
                        return;
                break;
			}			
            switch($_POST['postaction'])
            {

               case 'update':
                    if($this->processUpdateCategory())
                        return;
                    break;
					
				case 'create':
                    if($this->processCreateCategory())
                        return;
                    break;				
            }
        }
        else if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                case 'edit':
                    if($this->drawFormUpdateCategory())
                        return;
                    break;
				case 'create':
                    if($this->drawFormCreateCategory())
                        return;
                    break;					
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;
				case 'activate':
				    if($this->processActivate($_REQUEST['active']))
                        return;
                    break;					
            }
        }        

        $this->showData();      
    }
    
    function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT ". $columns ." FROM rt_categories ";
    }
    
    
    function getColumns()
    {
		// db Column name => array(Label, sortable)
		return array(
			"categoryId" 			=> array("Category ID", true),
			"categoryName" 			=> array("Category Name", true),
			"shortName" 			=> array("Short Name", true),
			"categoryDescription" 	=> array("Category Description", true),
			"dateCreated" 			=> array("Date Created", true),
			"dateUpdated" 			=> array("Date Updated", true),
		);
    }
    
    function getKey()
    {
    	return "categoryId";
    }
    

   
    function setSelectActions()
    {
    	
    	$label 		= "Edit Category";
    	$action		= "edit";
    	$vars 		= array("categoryId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
 		
 		$label 		= "Delete Category";
    	$action		= "delete";
    	$vars 		= array("categoryId" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    	
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Category";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    	
    }
    
  
	
	function drawFormUpdateCategory(){
		$this->loadObjectInfo($_REQUEST[$this->getKey()]);
		$this->addContent('category_edit');
		return true;
	}
	
	function processUpdateCategory()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		
		$_REQUEST['categoryName'] = preg_replace('/[\'\"]/', '', $_REQUEST['categoryName']);
		$_REQUEST['shortName'] = preg_replace('/[\'\"]/', '', $_REQUEST['shortName']);			
		
		if($rs->fields['shortName'] == $_REQUEST['shortName']){
			_setMessage("The shortname " . $_REQUEST['shortName'] . " already exists.", true);
			return false;	
		}
				
		$params = array(
			'categoryName' 			=> $_REQUEST['categoryName'],
			'shortName' 			=> $_REQUEST['shortName'],
			'categoryDescription' 	=> $_REQUEST['categoryDescription'],
			'active' 				=> $_REQUEST['active'],
		);		
		
        // save changes of user to db
        CMS_libs_Categories::updateCategory($_REQUEST['categoryId'], $params);
                
		_setMessage("Page Successfully Updated");
		
        return false;
    }  
	
	
	
	function drawFormCreateCategory(){
		$this->addContent('category_create');
		return true;
	}	
    
    function processCreateCategory()
    {   
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$_REQUEST['categoryName'] = preg_replace('/[\'\"]/', '', $_REQUEST['categoryName']);
		$_REQUEST['shortName'] = preg_replace('/[\'\"]/', '', $_REQUEST['shortName']);
		
		$sql = "SELECT shortName FROM rt_categories WHERE shortName = " . _q($_REQUEST['shortName']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE); 
		
		if($rs->fields['shortName'] == $_REQUEST['shortName']){
			QUnit_Messager::setErrorMessage("The shortname " . $_REQUEST['shortName'] . " already exists.");
			return false;	
		}
		
		$params = array(
			'categoryName' => $_REQUEST['categoryName'],
			'shortName' => $_REQUEST['shortName'],
			'categoryDescription' => $_REQUEST['categoryDescription'],
			'active' => $_REQUEST['active'],
			'type' => $_REQUEST['type'],
		);	
		
        // save changes of user to db
        CMS_libs_Categories::addCategory($params);
                
		_setMessage("Site Successfully Created");
              
        return false;
    } 	  
    
    
    function processDelete()
    {
		if(($IDs = $this->returnIds()) == false)
            return false;
			
		$sqlIDs = "('" . implode("','", $IDs) . "')";
    
		CMS_libs_Categories::deleteCategories($sqlIDs);
      	_setMessage("Category Deleted");
        return false;
    }
     
    function loadObjectInfo($id)
    {
        $id = preg_replace('/[\'\"]/', '', $id);

		$rs = CMS_libs_Categories::getCategory($id);

        if (!$rs || $rs->EOF) {
          _setMessage("Query Failed!", true);
          return false;
        }

		$this->assignValue('categoryId',$rs->fields['categoryId']);
		$this->assignValue('shortName',$rs->fields['shortName']);
		$this->assignValue('categoryDescription',$rs->fields['categoryDescription']);
		$this->assignValue('categoryName',$rs->fields['categoryName']);
		$this->assignValue('dateInserted',$rs->fields['dateInserted']);
		$this->assignValue('active',$rs->fields['active']);
    }
    	  
}
?>
