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
 * @package CMS_Lib
 */
class CMS_libs_Redirect {
    
     /**
     * Get information by ID
     * @author Jason Huie
     * @version 1.0
     * @param int ID
     * @return ResultSet Redirect information
     * @static
     */
    function getById($id)
    {
    	$sql = 
<<<SQL
SELECT 
    * 
FROM 
    redirects 
WHERE
    deleted != 1 
    AND redirect_id = $id
SQL;
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
     * Get all redirects
     * @author Jason Huie
     * @version 1.0
     * @return ResultSet All Redirects
     * @static
     */
    function getAll()
    {
    	$sql = 
<<<SQL
SELECT 
    * 
FROM 
    redirects 
WHERE 
    deleted != 1
SQL;
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
     * Get all redirects for a particular site
     * @author Jason Huie
     * @version 1.0
     * @param int Site Id
     * @return ResultSet All Redirects
     * @static
     */
    function getBySite($id)
    {
    	$sql = 
<<<SQL
SELECT 
    * 
FROM 
    redirects 
WHERE 
    deleted != 1
    AND site_id = $id
SQL;
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
     * Create a redirect in the database
     * @author Jason Huie
     * @version 1.0
     * @param array Parameters ($field=>$value)
     * @static
     */
    function  insert($params)
    {
    	$sql = "INSERT INTO redirects " . _insertAssociative($params);	
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
		//log action
		CMS_libs_History::write($this->auth->username, "Added Redirect: ".$params['filename']."<br>$sql");
    }
    
    /**
     * Update a redirect in the database
     * @author Jason Huie
     * @version 1.0
     * @param int ID
     * @param array Parameters ($field=>$value)
     * @static
     */
    function update($id, $params)
    {
    	$sql = "UPDATE redirects set " . _updateAssociative($params) . " WHERE redirect_id = " . _q($id);
    	
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Edited Redirect: ".$id."<br>$sql");
    }
      
     /**
     * Remove a redirect from the database
     * @author Jason Huie
     * @version 1.0
     * @param int User ID
     * @static
     */  
    function delete($id)
    {
    	$sql = "UPDATE redirects set deleted = 1 WHERE redirect_id = " . _q($id);	

    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	
		//log action
		CMS_libs_History::write($this->auth->username, "Deleted Redirect: ".$id."<br>$sql");
    }
}
?>