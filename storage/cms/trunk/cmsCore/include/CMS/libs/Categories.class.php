<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 23, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Lib
 */ 
class CMS_libs_Categories 
{
	
	/**
	 * Get the data for a category
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Category ID
	 * @return Array all category data
	 * @static
	 */
	function getCategory($id){
		$sql = "SELECT * FROM rt_categories WHERE categoryId = " . _q($id) . " AND deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	/**
	 * Update a cateogy's data from an associative array of parameters
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Category ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateCategory($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_categories set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where categoryId = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE); 
	}
	
	/**
	 * Delete a set of categories defined by an array of ids
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Category ID
	 * @static
	 */
	function deleteCategories($ids){
		$sql = 'UPDATE rt_categories set deleted = 1 where categoryId in ' . $ids;
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	}	
	
	/**
	 * Add a category to the database from an associative array of parameters
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Associative array (fieldName=>value)
	 * @return ResultSet list of all cardpageids
	 * @static
	 */
	function addCategory($params){

		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_categories ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "SELECT cardpageId FROM rt_cardpages ORDER BY cardpageid DESC LIMIT 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$cardpageId = $rs->fields['cardpageId'];
		
		return $cardpageId;
		
	}
	
	/**
	 * Check to see if a category with the defined name exists
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param String Category name
	 * @return boolean does name exist in database
	 * @static
	 */
	function categoryExists($name){
		$sql = "SELECT categoryId FROM rt_categories WHERE shortName = " . _q($name);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		return ($rs->fields['categoryId'] != null);
	}
}
?>