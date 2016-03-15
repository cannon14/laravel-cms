<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Validator');

class Affiliate_Merchants_Bl_TransactionError 
{
	
	function getError($id)
	{	
		$sql = 'SELECT * FROM ' . UPLOAD_ERROR_TABLE . ' WHERE id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
       
        return $rs->fields;
	}
	
	function updateError($id, $params)
	{
		if(count($params) < 1)
			return;
		$sql = 'UPDATE ' . UPLOAD_ERROR_TABLE . ' SET ';
		
		foreach($params as $col=>$val){
			$sql .= $col . '=' . _q($val) . ','; 	
		} 
		
		$sql = substr_replace($sql ,"",-1);
		
		$sql .= ' WHERE id = ' . _q($id);
		
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
         QUnit_Messager::setOkMessage('Error successfully modified.');
	}
	
	function resubmitErrors($ids)
	{
		if (!is_array($ids))
		{
			$ids = array($ids);	
		}
		
		$sql = 'SELECT * FROM ' . UPLOAD_ERROR_TABLE . ' WHERE id IN ('.explode('","', $ids).')';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		print_r($rs);
		
		$count = count($ids);
		
		
		for($i = 0; $i < $count; ++$i){
				
		}
		
	}
	
	function insertError($params)
	{
		$sql = 'INSERT INTO ' . UPLOAD_ERROR_TABLE . 
				' (`'.implode('`,`', array_keys($params)).'`) ' .
				'VALUES ("'.implode('","', $params).'")';
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
		
		if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }		
	}
	
}
?>