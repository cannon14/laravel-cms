<?php
/**
 * CreditCards.com
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * Upload DataAccess Object -
 * All SQL pertaining to Uploads should be placed here.
 * 
 * 
 */
 
class Affiliate_Merchants_Bl_UploadExpense
{

	function insertExpense($data)
	{
		if(isset($row['errordate']))
    		$data = Affiliate_Merchants_Bl_UploadExpense::errorToExpense($data);
		
    	$sql = 'INSERT INTO ' . 
	    		EXPENSE_UPLOAD_TABLE . 
				' (`'.implode('`,`', array_keys($data)) .
				'`) VALUES ("'.implode('","', $data).'")';
		
	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs){
			QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
		}
	    return $rs;
	}
	
	function deleteUploads($ids)
	{
		if(!is_array($ids)){
			$ids = array($ids);
		}
		
		$sql = 'DELETE FROM ' .EXPENSE_UPLOAD_TABLE. ' WHERE expense_id in ("'.implode('","', $ids).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		
	}
	
	function getUpload($id)
	{
		$sql = 'SELECT * FROM ' . EXPENSE_UPLOAD_TABLE . ' WHERE expense_id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        return $rs->fields;
	}
	
	function errorToExpense($params)
	{
		unset($params['errordate']);
		
		return $params;
	}
}
?>