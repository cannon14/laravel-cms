<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadTransaction');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadError');

class Affiliate_Merchants_Bl_TransactionSync {
	
	function sync($providerid)
	{
		$sql = 'SELECT * FROM ' . UPLOAD_TABLE . ' WHERE providerid=' ._q($providerid);

		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
		QCore_History::DebugMsg(WLOG_DBERROR, "Running transaction sync from transactions_upload to wd_pa_transactions table for provider: " .$providerid. ". SQL: " . $sql, __FILE__, __LINE__);
		
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QUnit_Messager::setErrorMessage("Not able to begin provider sync.");
            
            QCore_History::DebugMsg(WLOG_DBERROR, "Unable to sync provider id: " .$providerid. ". SQL: " . $sql, __FILE__, __LINE__);
            
        	return false;
        }
        
        //grab table structure
        $sql = 'DESCRIBE ' . TRANS_TABLE;
        $rsCheck = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rsCheck) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
        $fields = array();
        while(!$rsCheck->EOF){
        	$fields[] = $rsCheck->fields['Field'];
        	$rsCheck->MoveNext();	
        }
        
        
        while(!$rs->EOF)
        {
        	if(Affiliate_Merchants_Bl_TransactionSync::_verifyCurrentRate($rs->fields))
        	{
	        	if(!Affiliate_Merchants_Bl_TransactionSync::_insertTransaction($rs->fields, $fields))
	        	{
	        		QUnit_Messager::setErrorMessage("Not able to sync transaction: " . $rs->fields['transid']);
        			return false;
	        	}
	        	else
	        	{
	        		Affiliate_Merchants_Bl_UploadTransaction::deleteUploads($rs->fields['transid']);
	        	}
        	}
        	else
        	{
        		$rs->fields['errorcode'] = ERRORCODE_VERIFYRATE;
				$rs->fields['errordate'] = date("Y-m-d H:i:s");
				
				if(Affiliate_Merchants_Bl_UploadError::insertError($rs->fields))
				{
					/* MOVING TRANS TO DELETED TABLE FOR EFFICIENT FRONTIER ************/
					Affiliate_Merchants_Bl_UploadTransaction::archiveDeleted($rs->fields['transid']);
					
					Affiliate_Merchants_Bl_UploadTransaction::deleteUploads($rs->fields['transid']);
				}
				
				QUnit_Messager::setErrorMessage('Rate discrepancy during sync. Check Upload Error Manager.');
        	}
        	
        	$rs->MoveNext();	
        }

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }
        	
        return true;
	}
	
	function _insertTransaction($trans, $struct)
	{
		$cleanTrans = array();
		foreach($struct as $field){
        	$cleanTrans[$field] = $trans[$field];
        }
		
		$sql = 'INSERT INTO ' .TRANS_TABLE. ' (`'.implode('`,`', array_keys($cleanTrans)).'`) VALUES ("'.implode('","', $cleanTrans).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, "Unable to insert transaction: " .$cleanTrans['transid']. ". SQL: " . $sql, __FILE__, __LINE__);
        	return false;
        }	
        
        return true;
	}
	
	/*
	 * Private function _verifyCurrentRate
	 * 
	 * Accepts associative array and verifies that the rate table hasn't changed for that product since the last
	 * rate calculation.  If it has changed, the transaction gets an error code and is moved back into the 
	 * transactions_upload_errors table and not synched with the live transactions table.
	 */
	function _verifyCurrentRate($trans)
	{
		if(!Affiliate_Merchants_Bl_Rate::hasRateDefined($trans)){
			return true;
		}
		
		$transDateArray = explode(' ', $trans['dateinserted']);
		$transTimeArray = explode(':', $transDateArray[1]);
		$transDateArray = explode('-', $transDateArray[0]);
		
		//???need to check that these are just one call from db
		//$currentRate = Affiliate_Merchants_Bl_Rate::getRate($trans);
		$rateArray = Affiliate_Merchants_Bl_Rate::getRateCreationDate($trans);;
		$rateDateArray = $rateArray['insert_time'];
		$currentRate = $rateArray['rate'];
		
		$rateDateArray = explode(' ', $rateDateArray);
		$rateTimeArray = explode(':', $rateDateArray[1]);
		$rateDateArray = explode('-', $rateDateArray[0]);
		
		$transDate 	= mktime($transTimeArray[0], $transTimeArray[1], $transTimeArray[2], $transDateArray[1] , $transDateArray[2],  $transDateArray[0]);
		$rateDate 	= mktime($rateTimeArray[0], $rateTimeArray[1], $rateTimeArray[2], $rateDateArray[1] , $rateDateArray[2],  $rateDateArray[0]);
		
		if($currentRate != ($trans['estimatedrevenue'] / $trans['quantity']) && $transDate < $rateDate)
		{
			return false;
		}
		
		return true;
	}
	
	function _purgeUploadTable($providerid)
	{
		$sql = 'DELETE FROM ' . UPLOAD_TABLE . ' WHERE providerid=' . _q($providerid);	
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, "Unable to purge upload table for providerid: " .$providerid. ". SQL: " . $sql, __FILE__, __LINE__);
        	return false;
        }
        
        return true;	
	}
}
?>