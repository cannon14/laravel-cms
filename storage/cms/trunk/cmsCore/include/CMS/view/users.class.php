<?php
/**
 * 
 * ClickSuccess, L.P.
 * June 23, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */ 
 
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('CMS_libs_User');
csCore_Import::importClass('CMS_libs_Rights');

class CMS_view_users extends CMS_pages_cmsList {

	
	function process()
	{
		if(!isset($_REQUEST['action'])) $_REQUEST['action'] = '';
		
		if(!isset($_REQUEST['commited'])){
			switch($_REQUEST['action']){             
				case 'edit':
			    	
			        if($this->drawFormEditUser($_REQUEST['userid']))
			                        return;
			           break;
				case 'create':
			        if($this->drawFormCreateUser())
			                        return;
			           break;	
				case 'delete':
			        if($this->processDeleteUser($_REQUEST['userid']))
			                        return;		
			        	break;
				case 'setRights':
			        if($this->drawSetRights($_REQUEST['userid']))
			                        return;		
			        	break;				        		           			           		
		         }
		}else{
			switch($_REQUEST['action']){             
				case 'edit':
			        if($this->processEditUser($_REQUEST['userid']))
			                        return;
			           break;
					   
				case 'create':
			        if($this->processCreateUser())
			                        return;
			           break;				           		
		         
				case 'setRights':
			        if($this->processSetRights($_REQUEST['userid']))
			                        return;		
			        	break;	
			}		         			
		}
		
		$this->showData();    	
	}
	
    function getRequiredPermissions()
    {
    	return array('CMS_users');	
    }  	
	
	function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT " . $columns ." FROM cs_users ";   	
    	
    	$search = $this->filter->getValue('searchUsers');
   		
   		if($search != ''){
   			$this->where .= ' AND (userName LIKE ' . _q('%'.$search.'%') .')';
   		}
    }	
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM cs_users';
    }      
    
    function setFilter()
    {
    	
    	$this->filter->setTitle("User Filter");									
    	
    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchUsers', 
															'value' => isset($_REQUEST['searchUsers']) ? $_REQUEST['searchUsers'] : '',
															'label' => 'Search (by Name or ID): ')));
    }   
    
    function getColumns()
    {
		// db Column name => array(Label, sortable)
		return array(
			"userid"	 			=> array("Id", true),
			"username" 				=> array("Username", true),			
			"lastName" 				=> array("Last Name", true),
			"firstName" 			=> array("First Name", true),
			//"userGroup"				=> array("User Group", true),
		);
    }  
    
    function getKey()
    {
    	return "userid";
    }	

   function setSelectActions()
    {
    	
    	$label 		= "Edit User";
    	$action		= "edit";
    	$vars 		= array("userid" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
 		
 		$label 		= "Set User's Rights";
    	$action		= "setRights";
    	$vars 		= array("userid" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
 		
 		$label 		= "Delete User";
    	$action		= "delete";
    	$vars 		= array("userid" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
  
    }	         
    
    function setTextActions()
    {
    	$label 		= "Create New User";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= true;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    } 
    
    function drawFormCreateUser()
    {
    	$this->addContent('user_create');	
    	return true;
    }   
    
    function processCreateUser()
    {
    	if($_REQUEST['password'] != $_REQUEST['password2'] || $_REQUEST['password'] == ''){
    		_userAttention("Passwords must match!");
    		
    		$this->addContent('user_create');	
    		return true;
    	}
    	
    	if(CMS_libs_User::usernameExists($_REQUEST['username'])){
    		_userAttention("Username " . $_REQUEST['username'] . " already exists!");
    		
    		$this->addContent('user_create');	
    		return true;
    	}    	
    	
    	
    	
    	$params['username'] = $_REQUEST['username'];
    	$params['password'] = $_REQUEST['password'];
    	$params['firstName'] = $_REQUEST['firstName'];
    	$params['lastName'] = $_REQUEST['lastName'];
    	
    	CMS_libs_User::insertUser($params);
		    	
    	return false;	
    }
    
    function drawFormEditUser($id)
    {
    	$user = CMS_libs_User::getUserById($id);
    	
    	$this->assignValue('username', $user->fields['username']);
    	$this->assignValue('firstName', $user->fields['firstName']);
    	$this->assignValue('lastName', $user->fields['lastName']);
    	$this->assignValue('userid', $user->fields['userid']);
    	
    	$this->addContent('user_edit');	
    	return true;
    }
    
    function processEditUser($id)
    {
    	if($_REQUEST['password'] != $_REQUEST['password2']){
    		_userAttention("Passwords must match!");
    		
    		$this->drawFormEditUser($id);	
    		return true;
    	}
		
		if($_REQUEST['password'] != '')
    		$params['password'] = $_REQUEST['password'];
    	$params['firstName'] = $_REQUEST['firstName'];
    	$params['lastName'] = $_REQUEST['lastName'];
    	$params['userId']	= $_REQUEST['userid'];
    	
    	CMS_libs_User::updateUser($id, $params);

    	return false;    	
    }
    
    
    function processDeleteUser($id)
    {
    	CMS_libs_User::deleteUser($id);   	
    	
    	return false;    	
    } 
    
    function drawSetRights($id)
    {
    	$rightsArray = CMS_libs_Rights::getUsersRightsAsArray($id);
    	$allRightsArray = CMS_libs_Rights::getAllRightsAsArray();
    	
    	$user = CMS_libs_User::getUserById($id);
    	$username = $user->fields['username'];
    	
    	$this->assignValue('username', $username);
    	
    	$this->assignValue('usersRights', $rightsArray);
    	$this->assignValue('allRights', $allRightsArray);
    	$this->assignValue('userid', $id);
    	
    	$this->addContent('rights_edit');
    	return true;
    } 
    
    function processSetRights($id)
    {
    	$allRightsArray = CMS_libs_Rights::getAllRightsAsArray();
    	
    	$ids = array_keys($allRightsArray);
    	
    	$rights = array();
    	
    	foreach($ids as $rightid){
    		if($_REQUEST[$rightid] != null){
    			$rights[] = $rightid;	
    		}	
    	}
    	
    	_setSuccess("User's rights saved");
    	CMS_libs_Rights::setUserRights($id, $rights);
    	$this->drawSetRights($id);    	
    	
    	return true;
    }  
}
?>