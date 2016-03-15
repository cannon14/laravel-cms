<?

csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('CMS_libs_Versions');
//csCore_Import::importClass('CMS_libs_Pages');
//csCore_Import::importClass('FCKeditor_FCKeditor');
//csCore_Import::importClass('CMS_libs_Sites');
//csCore_Import::importClass('CMS_libs_SiteComponents');

class CMS_view_versions extends CMS_pages_cmsList
{
	/**
	 * Parses incoming variables and exectues proper methods
	 * @author Patrick Mizer
	 * @version 1.0
	 */
    function process()
    {
        
    	if(!empty($_POST['commited']))
        {
        	$_POST['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
    		$_POST['postaction'] = isset($_REQUEST['postaction']) ? $_REQUEST['postaction'] : '';
    		
        	if(!isset($_POST['massaction'])) $_POST['massaction'] = '';
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
                    if($this->processUpdateVersion())
                    	
                        return;
    
                    break;
                case 'create':
                    if($this->processCreateVersion())
                        return;
                    break;	
			
            }
        }
        else if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {                
                
                case 'edit':
					$this->loadVersionInfo();
                    if($this->drawFormEditVersion())
                        return;
                    break;
				case 'create':
                    if($this->drawFormCreateVersion())
                        return;
                    break;					
                case 'delete':
                    if($this->processDelete())
                        return;
                    break;	                  
                                       				
            }
        }        

        $this->showData();      
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_pages');	
    }    
    
    function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT " . $columns ." FROM versions ";
    	
    	$search = $this->filter->getValue('searchPage');
   		
   		if($search != ''){
   			$this->where .= ' AND (version_name=' . _q($search) . ' OR version_description LIKE ' . _q('%'.$search.'%') .')';
   		}
    }
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM versions';
    }
    
    function setFilter()
    {
    	
    	$this->filter->setTitle("Version Filter");									
    	
    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchPage', 
															'value' => isset($_REQUEST['searchPage']) ? $_REQUEST['searchPage'] : '',
															'label' => 'Search (by Name or ID): ')));
															
    }    
    
    function getColumns()
    {
		// db Column name => array(Label, sortable)
		return array(
			"version_id" 			=> array("Version ID", true),
			"version_name" 				=> array("Version Name", true),
			"version_description"		=> array("Version Description", true),
			"insert_time" 			=> array("Date Created", true)
		);
    }
    
    function getKey()
    {
    	return "version_id";
    }
    
    function setSelectActions()
    {
    	
    	$label 		= "Edit Version";
    	$action		= "edit";
    	$vars 		= array("version_id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
 		
 		$label 		= "Delete Version";
    	$action		= "delete";
    	$vars 		= array("version_id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
  
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Version";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }     
    
    function processDelete()
    {
		if(($EIDs = $this->returnIds()) == false)
            return false;
			
		$sqlEIDs = "('" . implode("','", $EIDs) . "')";
    
		CMS_libs_Versions::deleteVersions($sqlEIDs);
      
        return false;
    } 
    
    function loadVersionInfo(){
        $id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);
		$rs = CMS_libs_Versions::getVersion($id);
		//print '<pre>';print_r($rs);print'</pre>';
		
        $_POST['version_id'] 			= $rs->fields['version_id'];
        $_POST['version_name'] 			= $rs->fields['version_name'];
        $_POST['version_description']	= $rs->fields['version_description'];   	
        $_POST['insert_time']			= $rs->fields['date_created'];
    }  

    
	function getVersions($pageId){
		$sql = "SELECT * FROM versions WHERE version_id = " . _q($pageId) . " AND deleted != 1 ORDER BY version_name ASC";
		//echo $sql;
		return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}	      
    
        
    
    //***************************************************************
    //***************************************************************
	

	function drawFormEditVersion(){
		$versionDAO = new CMS_libs_Versions();
		
		$_POST['action'] = "update";
		$_POST['postaction'] = "update";
		
		$_POST['versions'] = $versionDAO->getAllVersions();

		$this->addContent('version_edit');
		return true;
	}
	
	/**
	 * Prepares and loads variables into the template.
	 * @author Jason Huie
	 * @version 1.3
	 */
	function drawFormCreateVersion(){
		
		$_POST['action'] = "create";
		$_POST['postaction'] = "create";
		$this->addContent('version_create');
		return true;
	}	

    //--------------------------------------------------------------------------        
    
    function processUpdateVersion()
    {   
            
        if(!$_REQUEST['itemsOnFirstPage'] || trim(strtolower($_REQUEST['itemsOnFirstPage'])) == 'all')
            $_REQUEST['itemsOnFirstPage'] = 99999;
        if(!$_REQUEST['itemsPerPage'] || trim(strtolower($_REQUEST['itemsPerPage'])) == 'all')
            $_REQUEST['itemsPerPage'] = 99999;
	
		$params = array(
			'version_name' => $_REQUEST['version_name'],
			'version_description' => $_REQUEST['version_description'],
		);

        // save changes of user to db
        CMS_libs_Versions::updateVersion($_REQUEST[$this->getKey()], $params);

		_setMessage("Version Successfully Updated");

        return false;
    }
	
    function processCreateVersion()
    {   

	    if(!$_REQUEST['itemsOnFirstPage'] || trim(strtolower($_REQUEST['itemsOnFirstPage'])) == 'all')
            $_REQUEST['itemsOnFirstPage'] = 99999;
        if(!$_REQUEST['itemsPerPage'] || trim(strtolower($_REQUEST['itemsPerPage'])) == 'all')
            $_REQUEST['itemsPerPage'] = 99999;
            
        if($_REQUEST['showMainCatOnFirstPage'] != 1)
         $_REQUEST['showMainCatOnFirstPage'] = 0;         
			
		$params = array(
			'version_name' => $_REQUEST['version_name'],
			'version_description' => $_REQUEST['version_description'],
		);
		
        $pageid = CMS_libs_Versions::addVersion($params);
		
		_setMessage("Version Successfully Created");
	
        return false;
    }
    
}
?>
