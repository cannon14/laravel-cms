<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadExpense');

class Affiliate_Merchants_Bl_ExpenseSync {
	
	function sync($affiliate_id)
	{

		$sql = 'SELECT * FROM ' . EXPENSE_UPLOAD_TABLE . ' WHERE affiliate_id=' ._q($affiliate_id);
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        while(!$rs->EOF)
        {
    		if(!Affiliate_Merchants_Bl_ExpenseSync::_insertExpense($rs->fields))
        	{
    			return false;
        	}
        	else
        	{
        		Affiliate_Merchants_Bl_UploadExpense::deleteUploads($rs->fields['expense_id']);
        	}
    		
        	$rs->MoveNext();	
        }

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }
        	
        return true;
	}
	
	/**
	 * Public syncOther
	 * 
	 * Used to sync affiliate expenses from expenses_upload table to expenses table 
	 * where affiliate is not listed in expense_networks table and does not have a parser.
	 * 
	 * These expenses most likely would be added using the Create Expense form.
	 */
	function syncOther()
	{

		$sql = 'SELECT * FROM ' . EXPENSE_UPLOAD_TABLE . ' WHERE affiliate_id NOT in (select affiliate_id from ' . EXPENSE_NETWORK_TABLE . ')';
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        while(!$rs->EOF)
        {
    		if(!Affiliate_Merchants_Bl_ExpenseSync::_insertExpense($rs->fields))
        	{
    			return false;
        	}
        	else
        	{
        		Affiliate_Merchants_Bl_UploadExpense::deleteUploads($rs->fields['expense_id']);
        	}
    		
        	$rs->MoveNext();	
        }

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }
        	
        return true;
	}
	
	function _insertExpense($trans)
	{
        $sql = 'DESCRIBE ' . EXPENSE_TABLE;

        $rsCheck = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rsCheck) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        $cleanTrans = array();
        
        while(!$rsCheck->EOF){
        	$cleanTrans[$rsCheck->fields['Field']] = $trans[$rsCheck->fields['Field']];
        	
        	$rsCheck->MoveNext();	
        }			
		
		
		$sql = 'INSERT INTO ' . EXPENSE_TABLE . ' (`'.implode('`,`', array_keys($cleanTrans)).'`) VALUES ("'.implode('","', $cleanTrans).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }	
        
        return true;
	}
	
	function _purgeUploadTable($affiliate_id)
	{
		$sql = 'DELETE FROM ' . EXPENSE_UPLOAD_TABLE . ' WHERE affiliate_id=' . _q($affiliate_id);	
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        return true;	
	}
}
?>