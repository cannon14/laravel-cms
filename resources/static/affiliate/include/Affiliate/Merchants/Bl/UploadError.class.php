<?php

/**
 * CreditCards.com
 * Kyle Putnam
 * <kylep@creditcards.com>
 * 
 * UploadError DataAccess Object -
 * All SQL pertaining to Upload Errors should be placed here.
 * 
 * 
 */
 
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Validator');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadTransaction');
 
class Affiliate_Merchants_Bl_UploadError {
	
	function deleteUploadErrors($ids)
	{
		if(!is_array($ids))
			$ids = array($ids);
		$sql = 'DELETE FROM ' .UPLOAD_ERROR_TABLE. ' WHERE id in ("'.implode('","', $ids).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
	}
	
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
		
		$sql = 'SELECT * FROM ' . UPLOAD_ERROR_TABLE . ' WHERE id IN ("'.implode('","', $ids).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		$sql = 'DELETE FROM ' . UPLOAD_ERROR_TABLE . ' WHERE id IN ("'.implode('","', $ids).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		$invalid = $valid = 0;
		
		$validator = new Affiliate_Merchants_Bl_Validator();
		
		while(!$rs->EOF){
			
			$rs->fields['transid'] = $rs->fields['reftrans'];
			
			$record = $validator->validateData($rs->fields);

			if($record['errorcode'] != null){
				Affiliate_Merchants_Bl_UploadError::insertError($record);
				++ $invalid;
			}else{
				$record = Affiliate_Merchants_Bl_UploadTransaction::errorToTransaction($record);
				Affiliate_Merchants_Bl_UploadTransaction::insertTransaction($record);
				++ $valid;
			}

			$rs->MoveNext();
		}
		
		if($valid > 0) QUnit_Messager::setOkMessage($valid . ' records successfully resubmitted.');
		if($invalid > 0) QUnit_Messager::setErrorMessage($invalid . ' records still contain errors.');
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
		
		$sql = 'SELECT id FROM ' . UPLOAD_ERROR_TABLE . ' ORDER BY id DESC LIMIT 1';
		$rs = 	QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		
		if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        return $rs->fields['id'];				
	}
	
	function transactionToError($params)
	{
		return $params;
	}
	
}
?>