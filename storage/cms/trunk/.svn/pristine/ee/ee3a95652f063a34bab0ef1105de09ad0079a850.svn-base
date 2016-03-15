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
class CMS_libs_User {
    
     /**
     * Get user information by User ID
     * @author Patrick Mizer
     * @version 1.0
     * @param int User ID
     * @return ResultSet User information
     * @static
     */
    function getUserById($id)
    {
    	$sql = "SELECT * FROM cs_users WHERE deleted != 1 AND userid = " . _q($id);
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
     * Get user information by User Username
     * @author Patrick Mizer
     * @version 1.0
     * @param String User Name
     * @return ResultSet User information
     * @static
     */
    function getUserByUsername($username){
    	$sql = "SELECT userid FROM cs_users WHERE username = " ._q(strtolower($username)) . " AND deleted != 1";
		return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
     * Get all users with their information
     * @author Patrick Mizer
     * @version 1.0
     * @return ResultSet All User information
     * @static
     */
    function getAllUsers()
    {
    	$sql = "SELECT * FROM cs_users WHERE deleted != 1";
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
     * Create a new user in the database
     * @author Patrick Mizer
     * @version 1.0
     * @param array Parameters ($field=>$value)
     * @static
     */
    function  insertUser($params)
    {
    	$params['password'] = md5($params['password']);
    	$params['username'] = strtolower($params['username']);
    	$sql = "INSERT INTO cs_users " . _insertAssociative($params);	
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
		//log action
		CMS_libs_History::write($this->auth->username, "Added User: ".$params['username']."<br>$sql");
    }
    
    /**
     * Update a user in the database
     * @author Patrick Mizer
     * @version 1.0
     * @param int User ID
     * @param array Parameters ($field=>$value)
     * @static
     */
    function updateUser($id, $params)
    {
    	if($params['password'] != null){
    		$params['password'] = md5($params['password']);
    	}	
    	
    	$sql = "UPDATE cs_users set " . _updateAssociative($params) . " WHERE userid = " . _q($id);
    	
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Edited User: ".$params['userId']."<br>$sql");
    }
    
    /**
     * Check to see if a username already exists in the database
     * @author Patrick Mizer
     * @version 1.0
     * @param String User Name
     * @return boolean Username exists
     * @static
     */
    function usernameExists($username)
    {
    	$username = strtolower($username);
    	$sql = "SELECT username FROM cs_users WHERE deleted != 1 AND username = " . _q($username);
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
    	return !($username != '' && ($username != $rs->fields['username']));	
    }
    
    /**
     * Check username and password by querying the database by both fields and counting the returned results
     * @author Patrick Mizer
     * @version 1.0
     * @param String User Name
     * @param String Password
     * @return boolean Username and Password match found
     * @static
     */
    function validateUser($username, $password)
    {
    	
    	$sql = "SELECT username FROM cs_users WHERE username = " . _q(strtolower($username)) . " AND password = " . _q(md5($password)). " AND deleted = 0";
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	return ($username != '' && ($username == $rs->fields['username']));	 
    }
    
     /**
     * Remove a user from the database
     * @author Patrick Mizer
     * @version 1.0
     * @param int User ID
     * @static
     */  
    function deleteUser($id)
    {
    	$sql = "UPDATE cs_users set deleted = 1 WHERE userid = " . _q($id);	

    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
		//log action
		CMS_libs_History::write($this->auth->username, "Deleted User: ".$id."<br>$sql");
    }
}
?>