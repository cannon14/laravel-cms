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
 
define("AMENITY_TABLE", "cs_amenities");
define("AMENITY_MAP_TABLE", "cs_cardamenitymap");
 
class CMS_libs_Amenities {
	
	/**
	 * Returns all amenities
	 *
	 * @return	array	$amenities	Associative array field=>value
	 *
	 * @static
	 */	
	function getAllAmenities()
	{
		$sql = 	"SELECT * FROM " . AMENITY_TABLE . " WHERE deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;
	}
	
	/**
	 * Returns amenity by ID
	 * 
	 * @param	String	$id			Amenity ID.
	 *
	 * @return	array	$amenity	Associative array field=>value
	 *
	 * @static
	 */		
	function getAmenityById($id)
	{
		$sql = 	"SELECT * FROM " . AMENITY_TABLE . " WHERE amenityid = " . _q($id) . " AND deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		return $rs->fields;
	}
	
	
	/**
	 * Returns all amenities assigned to card defined by ID
	 *
	 * @param	string	$cardId		Card ID
	 *
	 * @return	array	$amenities	Associative array field=>value
	 *
	 * @static
	 */		
	function getAmenitiesByCardId($cardId)
	{
		$sql = 	"SELECT a.* FROM " . AMENITY_TABLE . " as a INNER JOIN " . AMENITY_MAP_TABLE . " as amt " .
				"ON (a.amenityid = amt.amenityid) " .
				"WHERE amt.cardid = " . _q($cardId) . " AND a.deleted != 1 " .
				"ORDER BY a.label ASC";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;		
	}
	
	function getUnassignedAmenitiesByCardId($cardId)
	{
		$sql = 	"SELECT * FROM " . AMENITY_TABLE . " WHERE amenityid NOT IN " .
				"(SELECT a.amenityid FROM " . AMENITY_TABLE . " as a INNER JOIN " . AMENITY_MAP_TABLE . " as amt " .
				"ON (a.amenityid = amt.amenityid) " .
				"WHERE amt.cardid = " . _q($cardId) . " AND a.deleted != 1) AND deleted != 1 ORDER BY label ASC";
				
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;				
	}

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
	function assignAmenities($cardId, $amenityIds)
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
	function deleteAmenity($ids)
	{
		if(!is_array($ids)){
			$ids = array($ids);	
		}
		$sql = "UPDATE " . AMENITY_TABLE . " SET deleted = 1 WHERE amenityid in " . _array2paren($ids, "'");
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
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
	function addAmenity($data)
	{
		$sql = "DESCRIBE " . AMENITY_TABLE;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$preparedData = array();
		
		while($rs && !$rs->EOF){
			if($rs->fields['Field'] != 'amenityid')
				$preparedData[$rs->fields['Field']] = $data[$rs->fields['Field']];
			$rs->MoveNext();	
		}
		
		$sql = "INSERT INTO " . AMENITY_TABLE . " " . _insertAssociative($preparedData);
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
	
	function updateAmenity($id, $data)
	{
		$sql = "DESCRIBE " . AMENITY_TABLE;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$preparedData = array();
		
		while($rs && !$rs->EOF){
			if($rs->fields['Field'] != 'amenityid')
				$preparedData[$rs->fields['Field']] = $data[$rs->fields['Field']];
			$rs->MoveNext();	
		}
		
		$sql = "UPDATE " . AMENITY_TABLE . " SET " . _updateAssociative($preparedData) . " WHERE amenityid = " . _q($id);			
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
}
?>