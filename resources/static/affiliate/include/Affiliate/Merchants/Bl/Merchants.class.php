<?php
#
/**
 * This is the Merchants DAO... umm, that's about it.
 * 
 * @author Patrick J. Mizer
 * 
 */
 
class Affiliate_Merchants_Bl_Merchants 
{
	
	/**
	 * 
	 * returns an array of merchants indexed by merchant_id
	 * 
	 * @access public
	 */	
	function getMerchants()
	{
		$sql = 'SELECT * FROM ' . MERCHANTS_TABLE . ' WHERE deleted != 1 ORDER BY short_name ASC';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
  
        if (!$rs){
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }   
        
        $ret = array();     
        
        while(!$rs->EOF)
        {   
            $ret[$rs->fields['merchant_id']] = $rs->fields;
            $rs->MoveNext();
        }		
        
        return  $ret;
	}

	/**
	 * 
	 * Deletes merchants given an id or an array of ids
	 * 
	 * @access public
	 * @param array $ids array of ids
	 */		
	function deleteMerchants($ids)
	{
		$sql = 'UPDATE ' . MERCHANTS_TABLE . ' SET deleted = 1 WHERE merchant_id IN ("' . implode('","', $ids) . '")';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
  
        if (!$rs){
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }  
    	return true;			
	}
	
	/**
	 * 
	 * Gets merchant by merchant id.
	 * 
	 *  @access public
	 *  @param int $id merchant_id to get 
	 */
	
	function getMerchantByMerchantId($id)
	{ 
		$sql = 'SELECT * FROM ' . MERCHANTS_TABLE . ' WHERE merchant_id = ' . _q($id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
  
        if (!$rs){
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }   
        
		return $rs->fields;	
	}
	
	/**
	 * 
	 * Inserts a merchant.
	 * 
	 * @access public
	 * @param array $params associative array which defines merchant
	 * 
	 */
	function createMerchant($params)
	{

		$params = Affiliate_Merchants_Bl_Merchants::_prepareInsert($params);
		
		$sql = 'INSERT INTO ' . MERCHANTS_TABLE . ' ' . '(`'.implode('`,`', array_keys($params)).'`) VALUES ('.implode(',', array_values($params)).')';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	
		if (!$rs){
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }   
        
        return $params;
	}
	
	/**
	 * 
	 * Updates a merchant.
	 * 
	 * @access public
	 * @params int $id merchant_id to update.
	 * @param array $params associative array which defines merchant
	 * 
	 */	
	function updateMerchant($params)
	{
		$params = Affiliate_Merchants_Bl_Merchants::_prepareUpdate($params);
		
		$sql = 'UPDATE ' . MERCHANTS_TABLE . ' SET ';
		foreach($params as $col => $value){
			$sql .= $col . ' = ' . $value . ', ';
		}
		
		$sql .= ' merchant_id = ' . $params['merchant_id'] . ' WHERE merchant_id = ' . $params['merchant_id'];
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	
		if (!$rs){
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }   
        
        return $params;	
	}
	
	function _getColumns()
	{
		return array(	'merchant_id', 
						'short_name',
						'long_name',
						'description',
						'merchant_type',
						'account_number',
						'address_line_1',
						'address_line_2',
						'city',
						'state',
						'zip_code',
						'phone',
						'contact',
						'notes',
						'bank_rule',
						'insert_date',
						'deleted',
						'active'
						);
	}
	
	function _prepareInsert($params)
	{
		$ret = array();
		$cols = Affiliate_Merchants_Bl_Merchants::_getColumns();
		
		foreach($cols as $col){
			$ret[$col] = _q($params[$col]); 
		}
		
		$ret['active'] = _q(1);
		$ret['insert_date'] = _q(date('Y-m-d h:i:s'));
		
		return $ret;	
	}
	
	function _prepareUpdate($params)
	{
		$ret = array();
		$cols = Affiliate_Merchants_Bl_Merchants::_getColumns();
		
		foreach($cols as $col){
			if($params[$col] !== null)
				$ret[$col] = _q($params[$col]); 
		}
		
		return $ret;	
	}	
}
?>