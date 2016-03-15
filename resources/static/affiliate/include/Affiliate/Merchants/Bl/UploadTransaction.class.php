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
 
class Affiliate_Merchants_Bl_UploadTransaction
{

	function insertTransaction($data)
	{
		if(isset($row['errorcode']))
    		$data = Affiliate_Merchants_Bl_UploadTransaction::errorToTransaction($data);
		
		//check fields
		$sql = 'DESCRIBE ' . UPLOAD_TABLE;
        $rsCheck = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rsCheck) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        $cleanTrans = array();
        
        while(!$rsCheck->EOF){
        	$cleanTrans[$rsCheck->fields['Field']] = $data[$rsCheck->fields['Field']];
        	$rsCheck->MoveNext();	
        }
		
		
		//insert trans
    	$sql = 'INSERT INTO ' . 
	    		UPLOAD_TABLE . 
				' (`'.implode('`,`', array_keys($cleanTrans)) .
				'`) VALUES ("'.implode('","', $cleanTrans).'")';
				
	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	    
		if (!$rs) {
			QCore_History::DebugMsg(WLOG_DBERROR, "Unable to insert transaction: " .$data['transid']. ". SQL: " . $sql, __FILE__, __LINE__);
		}
	    return $rs;
	}
	
	function deleteUploads($ids)
	{
		if(!is_array($ids)){
			$ids = array($ids);
		}
		
		$sql = 'DELETE FROM ' .UPLOAD_TABLE. ' WHERE transid in ("'.implode('","', $ids).'")';
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs){
			QCore_History::DebugMsg(WLOG_DBERROR, "Unable to delete upload transactions. SQL: " . $sql, __FILE__, __LINE__);
		}
	    return $rs;
	}
	
	function getUpload($id)
	{
		$sql = 'SELECT * FROM ' . UPLOAD_TABLE . ' WHERE transid = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        return $rs->fields;
	}
	
	function errorToTransaction($params)
	{
		unset($params['id']);
		unset($params['errorcode']);
		unset($params['errordate']);
		
		return $params;
	}
	
	function archiveDeleted($transid) {
		
		$data = Affiliate_Merchants_Bl_UploadTransaction::getUpload($transid);

		$sql = 'DESCRIBE ' . TRANS_DELETED_TABLE;
        $rsCheck = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rsCheck) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        $cleanTrans = array();
        
        while(!$rsCheck->EOF){
        	$cleanTrans[$rsCheck->fields['Field']] = $data[$rsCheck->fields['Field']];
        	$rsCheck->MoveNext();	
        }

		//insert trans
    	$sql = 'INSERT INTO ' . 
	    		TRANS_DELETED_TABLE . 
				' (`'.implode('`,`', array_keys($cleanTrans)) .
				'`) VALUES ("'.implode('","', $cleanTrans).'")';
		
		
	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	    
		if (!$rs) {
			QCore_History::DebugMsg(WLOG_DBERROR, "Unable to insert transaction into deleted archive: " .$transid. ". SQL: " . $sql, __FILE__, __LINE__);
		}

		return $rs;
	}
}
?>