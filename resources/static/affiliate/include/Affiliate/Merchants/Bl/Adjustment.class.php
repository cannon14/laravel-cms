<?php

QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadTransaction');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');

class Affiliate_Merchants_Bl_Adjustment
{
	
	function overrideTransaction($id)
	{
		/**
		 * Get the transaction from the upload table
		 */
		$trans = Affiliate_Merchants_Bl_Adjustment::_populateErroredTrans($id);

        if(!$trans){
        	return false;
        }
        
        /**
         * Determine type of override.
         * 
         * Error 105 (Missing Required Fields) cannot be overridden. This is to protect against mass sync of corrupted transactions.
         * Error 103 (No Estimated Revenue) cannot be overridden. User first needs to assign revenue before it can be resubmitted.
         */
         $success = false;
         
         switch($trans['errorcode'])
         {
         	case 101 : 
         		$success = Affiliate_Merchants_Bl_Adjustment::_overrideNewTransId($trans);
         	break;
         	
         	case 102 :
         		$success = Affiliate_Merchants_Bl_Adjustment::_overrideDuplicateTransId($trans);
         	break;
         	
         	case 104 : 
         		$success = Affiliate_Merchants_Bl_Adjustment::_overrideNewTransId($trans);
         	break;         	
         	
         	case 106 :
         		$success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
         	break;
         	
         	case 107 :
         		$success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
         	break;
         	
         	case 109 :
                $success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
            break;
            
            case 110 :
                $success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
            break;
            
            case 111 :
                $success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
            break;
         	
         	case 108 :
         		$success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
         	break;
         	
         	default :
         		$success = QUnit_Messager::setErrorMessage("Could not override transaction transid: " . _q($trans['transid']));         	
         	break;
         }
         
         if ($success){
         	Affiliate_Merchants_Bl_Adjustment::_deleteError($id);
         }
         
         return $success;
	}
	
	function appendTransaction($id)
	{
		/**
		 * Get the transaction from the upload table
		 */
		$trans = Affiliate_Merchants_Bl_Adjustment::_populateErroredTrans($id);
		
        if(!$trans){
        	return false;	
        }
        
        /**
         * Determine type of override.
         */
         $success = false;
         
         if ($trans['errorcode'] == 102){
         	$trans['transtype'] = TRANSTYPE_APPEND;
         	$success = Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);
         }
         else
         	$success = QUnit_Messager::setErrorMessage("Could not append transaction transid: " . _q($trans['transid']) . ". Check that the transaction is a duplicate.");

         if ($success)
         	Affiliate_Merchants_Bl_Adjustment::_deleteError($id);
         
         return $success;
	}
	
	function _deleteError($id)
	{
		$sql = 'DELETE FROM ' . UPLOAD_ERROR_TABLE . ' WHERE id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }
        
        return true;
	} 
	
	function _overrideDuplicateTransId($trans)
	{
        /**
         * Create adjustment trans from copy of overridden trans.
         */
        $adjTrans 	= $trans;	 
		
		/**
		 * Figure out what the current commission and estrev sums are.
		 */
		$sql = 'SELECT SUM(commission) as com, SUM(estimatedrevenue) as est FROM ' .TRANS_TABLE. ' WHERE reftrans = ' ._q($trans['reftrans']);

		$rst = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rst) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }
        
		$sql = 'SELECT SUM(commission) as com, SUM(estimatedrevenue) as est FROM ' . UPLOAD_TABLE . ' WHERE reftrans = ' ._q($trans['reftrans']);
		
		$rsu = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rsu) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }        

        /**
         * Augment transacations.
         */
        $adjTrans['transid'] 			= QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
        $adjTrans['commission'] 		= (0 - ($rst->fields['com'] + $rsu->fields['com']));
        $adjTrans['estimatedrevenue'] 	= (0 - ($rst->fields['est'] + $rsu->fields['est']));
        $adjTrans['transtype']			= TRANSTYPE_REVADJ;
                
        $trans['transid'] 				= QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid"); 
        $trans['transtype']				= TRANSTYPE_REVADJ;


		/**
		 * Insert the adjustment and the override.
		 */
        if(!Affiliate_Merchants_Bl_Adjustment::_insertTransaction($adjTrans))
        	return false;
        	
        return Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);

	}
	
	function _overrideNewTransId($trans)
	{
		$trans['transid']		= QCore_Sql_DBUnit::createUniqueID("wd_pa_transactions", "transid");
		$trans['transtype']		= TRANSTYPE_REVADJ;
		$trans['affiliateid'] 	= Affiliate_Merchants_Bl_Adjustment::_getNonClickAffiliate();
		$trans['dateinserted']	= (isset($trans['providereventdate']) ? $trans['providereventdate'] : (isset($trans['providerprocessdate']) ? $trans['providerprocessdate'] : date("Y-m-d H:i:s")));
		$trans['rstatus'] 		= TRANS_STATUS_APPROVED;
		$trans['transkind'] 	= TRANS_KIND_DEFAULT;
		
		/**
		 * Insert the override.
		 */
		return Affiliate_Merchants_Bl_Adjustment::_insertTransaction($trans);        
	}
	
	function _insertTransaction($trans)
	{
		if(!isset($trans['affiliateid']))
		{
			$trans['affiliateid'] = Affiliate_Merchants_Bl_Affiliate::getAffiliateIdByRef(999); 
		}
		
		
		/**
		 * dateadjusted field should be changed no matter what action is taken.
		 * For Efficient Frontier reports to catch all records that flow through upload table.
		 */
		$trans['dateadjusted']	= date('Y-m-d H:i:s');
		
		
        /**
         *   * Kind of a hack here to get only the keys I want from the error table. 
         */
        $sql = 'DESCRIBE ' . UPLOAD_TABLE;
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
		
		return Affiliate_Merchants_Bl_UploadTransaction::insertTransaction($cleanTrans);		
	}
	
	function _populateErroredTrans($transid)
	{
		$sql = 'SELECT * FROM ' . UPLOAD_ERROR_TABLE . ' WHERE id = ' . _q($transid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }	
        
        return $rs->fields;
	}
	
	function _getNonClickAffiliate()
	{
		$sql = 'SELECT userid FROM ' .USERS_TABLE. ' WHERE refid = ' . _q(997);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
		
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
        	return false;
        }		
		
		return $rs->fields['userid'];
	}
	
}
?>