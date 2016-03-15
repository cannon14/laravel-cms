<?PHP
/**
 * 
 * ClickSuccess, L.P.
 * August 7, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Lib
 */ 
 
define("CARD_CATEGORY_TABLE", "card_categories");
define("CARD_RANKS_TABLE", "card_ranks");
define("CARD_CATEGORY_RANKS_TABLE", "card_category_ranks");
 
class CMS_libs_CardCategories {
	
	/**
	 * Returns all card categories
	 *
	 * @return	array	$cardCategories	Associative array field=>value
	 *
	 * @static
	 */	
	function getAllCardCategories()
	{
		$sql = 	"SELECT * FROM " . CARD_CATEGORY_TABLE . " WHERE deleted!=1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;
	}
	
	/**
	 * Returns all card categories
	 *
	 * @return	array	$cardCategories	Associative array field=>value
	 *
	 * @static
	 */	
	function getAllCardCategoriesOrderByRank()
	{
		$sql = 	"SELECT c.* FROM " . CARD_CATEGORY_TABLE . " AS c, ".CARD_CATEGORY_RANKS_TABLE." AS cr WHERE c.deleted!=1 AND c.card_category_id=cr.card_category_id ORDER BY cr.card_category_rank";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;
	}
	
	/**
	 * Returns card category by ID
	 * 
	 * @param	String	$id			Card Category ID.
	 *
	 * @return	array	$cardCategory	Associative array field=>value
	 *
	 * @static
	 */		
	function getCardCategoryById($id)
	{
		$sql = 	"SELECT * FROM " . CARD_CATEGORY_TABLE . " WHERE card_category_id = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		return $rs->fields;
	}
	
	
	/**
	 * Returns all amenities assigned to card defined by ID
	 *
	 * @param	string	$cardId		Card ID
	 *
	 * @return	array	$cardCategories	Associative array field=>value
	 *
	 * @static
	 */		
	function getCardCategoriesByCardId($cardId)
	{
		$sql = 	"SELECT a.* FROM " . CARD_CATEGORY_TABLE . " as a INNER JOIN " . CARD_RANKS_TABLE . " as amt " .
				"ON (a.card_category_id = amt.card_category_id) " .
				"WHERE a.deleted!=1 AND amt.card_id = " . _q($cardId) . 
				"ORDER BY a.card_category_name ASC";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;		
	}
	
	function getUnassignedCardCategoriesByCardId($cardId)
	{
		$sql = 	"SELECT * FROM " . CARD_CATEGORY_TABLE . " WHERE amenityid NOT IN " .
				"(SELECT a.card_category_id FROM " . CARD_CATEGORY_TABLE . " as a INNER JOIN " . CARD_RANKS_TABLE . " as amt " .
				"ON (a.card_category_id = amt.card_category_id) " .
				"WHERE amt.card_id = " . _q($cardId) . ") ORDER BY card_category_name ASC";
				
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;				
	}

	// TODO: This needs to change.  Our mapping table is also our Rank table, so we cant delete and repopulate every time.
	/**
	 * Reassigns amenity to card mappings
	 *
	 * @param	string	$cardId			Card ID
	 * @param	array	$amenitiyIds	Array of amenity ids
	 *
	 * @return	void
	 *
	 * @static
	 */			
	function assignCardCategories($cardId, $amenityIds)
	{
		if(!is_array($amenityIds)){
			$amenityIds = array($amenityIds);	
		}	
		
		$sql = "DELETE FROM " . AMENITY_MAP_TABLE . " WHERE cardid = " . _q($cardId);
		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	
		foreach($amenityIds as $id){
			$sqlInsert = "INSERT INTO " . AMENITY_MAP_TABLE . "(cardid, amenityid) VALUES ("._q($cardId).","._q($id).")";	
			_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
		
		
	}
	

	/**
	 * Deletes amenities by array of IDs
	 * 
	 * @param	array	$ids	Array of IDs.
	 *
	 * @return	void
	 *
	 * @static
	 */			
	function deleteCardCategory($ids)
	{
		if(!is_array($ids)){
			$ids = array($ids);	
		}
		//$sql = "DELETE FROM " . CARD_CATEGORY_TABLE . " WHERE card_category_id in " . _array2paren($ids, "'");
		$sql = "UPDATE " . CARD_CATEGORY_TABLE . " SET deleted = 1 WHERE card_category_id in " . _array2paren($ids, "'");
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		/*$sql = "DELETE FROM " . CARD_RANKS_TABLE . " WHERE card_category_id in " . _array2paren($ids, "'");
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "DELETE FROM " . CARD_CATEGORY_RANKS_TABLE . " WHERE card_category_id in " . _array2paren($ids, "'");
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);*/
		
	}

	/**
	 * Adds Amenity
	 * 
	 * @param	array	$data	Associative array field=>value
	 *
	 * @return	void
	 *
	 * @static
	 */			
	function addCardCategory($data)
	{
		$sql = "DESCRIBE " . CARD_CATEGORY_TABLE;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$preparedData = array();
		
		while($rs && !$rs->EOF){
			if($rs->fields['Field'] != 'card_category_id')
				$preparedData[$rs->fields['Field']] = $data[$rs->fields['Field']];
			$rs->MoveNext();	
		}
		
		$sql = "INSERT INTO " . CARD_CATEGORY_TABLE . " " . _insertAssociative($preparedData);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		// get ID of new category
		$sql = "SELECT card_category_id FROM " . CARD_CATEGORY_TABLE . " WHERE card_category_name='".$data['card_category_name']."'";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$catId = $rs->fields['card_category_id'];
		
		// get max rank for context
		$sql = "SELECT MAX(card_category_rank) FROM " . CARD_CATEGORY_RANKS_TABLE . " WHERE card_category_context_id=1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$maxRank = $rs->fields['MAX(card_category_rank)'];
		
		// insert new category rank with default context
		$sql = "INSERT INTO " . CARD_CATEGORY_RANKS_TABLE . " (card_category_rank, card_category_context_id, card_category_id) VALUES (".($maxRank+1).", 1, $catId)";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Updates Amenity
	 * 
	 * @param	string	$id	 	ID of amenity to update.
	 * @param	array	$data	Associative array field=>value
	 *
	 * @return	void
	 *
	 * @static
	 */		
	
	function updateCardCategory($id, $data)
	{
		$sql = "DESCRIBE " . CARD_CATEGORY_TABLE;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$preparedData = array();
		
		while($rs && !$rs->EOF){
			if($rs->fields['Field'] != 'card_category_id')
				$preparedData[$rs->fields['Field']] = $data[$rs->fields['Field']];
			$rs->MoveNext();	
		}
		
		$sql = "UPDATE " . CARD_CATEGORY_TABLE . " SET " . _updateAssociative($preparedData) . " WHERE card_category_id = " . _q($id);			
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
}
?>