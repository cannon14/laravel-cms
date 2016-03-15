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
 
define("MERCHANT_TABLE", "cs_merchants");
 
class CMS_libs_Merchants {
	
	/**
	 * Returns all merchants
	 *
	 * @return	array	$merchants	Associative array (field=>value)
	 *
	 * @static
	 */	
	function getAllMerchants()
	{
		$sql = 	"SELECT * FROM " . MERCHANT_TABLE . " WHERE deleted != 1";
		//_printR($sql);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}
		
		return $retData;
	}
	
	/**
	 * Returns all merchants
	 *
	 * @return	array	$merchants	Associative array (field=>value)
	 *
	 * @static
	 */	
	function getAllCcxMerchants()
	{
		$sql = 	"SELECT * FROM vw_ccx_issuers WHERE deleted != 1";
		//_printR($sql);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();	
		}

		return $retData;
	}
	
	
	/**
	 * Returns merchant by ID
	 * 
	 * @param	String	$id			Amenity ID.
	 *
	 * @return	array	$amenity	Associative array (field=>value)
	 *
	 * @static
	 */		
	function getMerchantById($id)
	{
		$sql = 	"SELECT * FROM " . MERCHANT_TABLE . " WHERE merchantid = " . _q($id) . " AND deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		return $rs->fields;
	}
	

	/**
	 * Deletes merchants by array of IDs
	 * 
	 * @param	array	$ids	Array of IDs.
	 *
	 * @return	void
	 *
	 * @static
	 */			
	function deleteMerchants($ids)
	{
		if(!is_array($ids)){
			$ids = array($ids);	
		}
		$sql = "UPDATE " . MERCHANT_TABLE . " SET deleted = 1 WHERE merchantid in " . _array2paren($ids, "'");
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
	}

	/**
	 * Adds Merchant
	 * 
	 * @param	array	$data	Associative array (field=>value)
	 *
	 * @return	void
	 *
	 * @static
	 */			
	function addMerchant($data)
	{
		$sql = "DESCRIBE " . MERCHANT_TABLE;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$preparedData = array();
		
		while($rs && !$rs->EOF){
			//if($rs->fields['Field'] != 'merchantid'){
				$preparedData[$rs->fields['Field']] = $data[$rs->fields['Field']];
			//}
			$rs->MoveNext();	
		}
		
		$sql = "INSERT INTO " . MERCHANT_TABLE . " " . _insertAssociative($preparedData);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Updates Amenity
	 * 
	 * @param	string	$id	 	ID of amenity to update.
	 * @param	array	$data	Associative array (field=>value)
	 *
	 * @return	void
	 *
	 * @static
	 */		
	
	function updateMerchant($id, $data)
	{
		$sql = "DESCRIBE " . MERCHANT_TABLE;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$preparedData = array();
		
		while($rs && !$rs->EOF){
			if($rs->fields['Field'] != 'merchantid'){
			    $data[$rs->fields['Field']] = isset($data[$rs->fields['Field']]) ? $data[$rs->fields['Field']] : '';
				$preparedData[$rs->fields['Field']] = $data[$rs->fields['Field']];
			}
			$rs->MoveNext();	
		}
		
		$sql = "UPDATE " . MERCHANT_TABLE . " SET " . _updateAssociative($preparedData) . " WHERE merchantid = " . _q($id);
		//echo $sql.'<br>';			
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
}
?>