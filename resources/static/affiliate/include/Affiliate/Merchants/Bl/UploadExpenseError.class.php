<?php

/**
 * CreditCards.com
 * Kyle Putnam
 * <kylep@creditcards.com>
 * 
 * UploadExpenseError
 * All SQL pertaining to Upload Errors should be placed here.
 * 
 */
 
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadExpense');
 
class Affiliate_Merchants_Bl_UploadExpenseError {
	
	function deleteUploadErrors($ids)
	{
		if(!is_array($ids))
			$ids = array($ids);
		$sql = 'DELETE FROM ' .EXPENSE_UPLOAD_ERROR_TABLE. ' WHERE expense_id in ("'.implode('","', $ids).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
	}
	
	function getError($id)
	{
		$sql = 'SELECT * FROM ' . EXPENSE_UPLOAD_ERROR_TABLE . ' WHERE expense_id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        return $rs->fields;
	}
	
	function updateError($id, $params)
	{
		if(count($params) < 1)
			return;
		$sql = 'UPDATE ' . EXPENSE_UPLOAD_ERROR_TABLE . ' SET ';
		
		foreach($params as $col=>$val){
			$sql .= $col . '=' . _q($val) . ','; 	
		} 
		
		$sql = substr_replace($sql ,"",-1);
		
		$sql .= ' WHERE expense_id = ' . _q($id);
		
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
		
		$sql = 'SELECT * FROM ' . EXPENSE_UPLOAD_ERROR_TABLE . ' WHERE expense_id IN ("'.implode('","', $ids).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		$sql = 'DELETE FROM ' . EXPENSE_UPLOAD_ERROR_TABLE . ' WHERE expense_id IN ("'.implode('","', $ids).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		$invalid = $valid = 0;
		
		
		while(!$rs->EOF)
		{
			if($record['error_time'] != null)
			{
				Affiliate_Merchants_Bl_UploadExpenseError::insertError($record);
				++ $invalid;
			}
			else
			{
				$record = Affiliate_Merchants_Bl_UploadExpense::errorToExpense($record);
				Affiliate_Merchants_Bl_UploadExpense::insertExpense($record);
				++ $valid;
			}

			$rs->MoveNext();
		}
		
		if($valid > 0) QUnit_Messager::setOkMessage($valid . ' records successfully resubmitted.');
		if($invalid > 0) QUnit_Messager::setErrorMessage($invalid . ' records still contain errors.');
	}
	
	function insertError($params)
	{
		$sql = 'INSERT INTO ' . EXPENSE_UPLOAD_ERROR_TABLE . 
				' (`'.implode('`,`', array_keys($params)).'`) ' .
				'VALUES ("'.implode('","', $params).'")';
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		
		if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
		
		$sql = 'SELECT expense_id FROM ' . EXPENSE_UPLOAD_ERROR_TABLE . ' ORDER BY expense_id DESC LIMIT 1';
		$rs = 	QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		
		if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        return $rs->fields['expense_id'];
	}
	
}
?>