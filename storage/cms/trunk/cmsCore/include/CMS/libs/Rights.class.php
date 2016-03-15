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
 * @package CMS_Lib
 */
class CMS_libs_Rights {
    
     /**
	 * Get all rights
	 * @author Patrick Mizer
	 * @version 1.0 
	 * @return array All rights in an array
	 * @static
	 */
    function getAllRightsAsArray()
    {
    	$retArray = array();
    	$sql = "SELECT * FROM cs_rights";
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
    	while($rs && !$rs->EOF){
    		$retArray[$rs->fields['id']] = $rs->fields;	
    		$rs->MoveNext();
    	}
    	
    	return $retArray;
    		
    }
    
     /**
	 * Get all rights associated with a user
	 * @author Patrick Mizer
	 * @version 1.0 
	 * @param int User ID
	 * @return array All rights for the user in an array
	 * @static
	 * @deprecated version - Mar 21, 2007
	 */
    function getUsersRightsAsArray($id) 
    {
    	$sql = "SELECT * FROM cs_userrights WHERE userid = " ._q($id);
    	
    	$retArray = array();
    	
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
    	while($rs && !$rs->EOF){
    		$retArray[] = $rs->fields['rightid'];
    		$rs->MoveNext();	
    	}
    	
    	return $retArray;
    }
    
      /**
	 * Get all rights associated with a user
	 * @author Patrick Mizer
	 * @version 1.0 
	 * @param String User Name
	 * @return array All rights for the user in an array
	 * @static
	 */
    function getUsersRightsByUsername($username)
    {
    	$sql = "SELECT userid FROM cs_users WHERE username = " . _q(strtolower($username));
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
    	return CMS_libs_Rights::getUsersRights($rs->fields['userid']);
    } 
    
     /**
	 * Get all rights associated with a user
	 * @author Patrick Mizer
	 * @version 1.0 
	 * @param User ID
	 * @return array All rights for the user in an array
	 * @static
	 */
    function getUsersRights($id){
    	$sql = "SELECT * FROM cs_userrights as ur INNER JOIN cs_rights as r ON (r.id = ur.rightid) WHERE userid = " ._q($id);
    	
    	$retArray = array();
    	
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
    	while($rs && !$rs->EOF){
    		$retArray[] = $rs->fields['code'];
    		$rs->MoveNext();	
    	}
    	
    	return $retArray;    	
    }
    
     /**
	 * Set a user's rights
	 * @author Patrick Mizer
	 * @version 1.0 
	 * @param User ID
	 * @param array Rights
	 * @static
	 */
    function setUserRights($id, $rights)
    {
    	$sql = "DELETE FROM cs_userrights WHERE userid = " . _q($id);
    	
    	_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
    	foreach((array)$rights as $right){
    		$sql = "INSERT INTO cs_userrights (userid, rightid) VALUES ("._q($id).","._q($right).")";	
    		
    		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	}
    	
		//log action
		CMS_libs_History::write($this->auth->username, "Set User Rights For User: ".$id."<br>$sql");
    } 
}
?>