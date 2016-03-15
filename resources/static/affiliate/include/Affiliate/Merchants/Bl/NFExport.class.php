<?php

QUnit_Global::includeClass('Affiliate_Scripts_Bl_NFQuery');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Validator');

class Affiliate_Merchants_Bl_NFExport {
	
	function payout($transids)
	{
		$transactions = array();
		
		if(!is_array($transids))
			$transids = array($transids);
		
		foreach($transids as $transid){
			
			Affiliate_Merchants_Bl_NFExport::_setPaid($transid);
			$transactions[] = Affiliate_Merchants_Bl_NFExport::_getMappedTrans($transid);	
			
		}
		
		Affiliate_Merchants_Bl_NFExport::_transferTransactions($transactions);
	}
	
	function _transferTransactions($transactions)
	{
		//process transactions
		foreach($transactions as $transaction)
		{
			Affiliate_Merchants_Bl_NFExport::_insert($transaction);
		}	
	}
	
	function _getTrans($transid)
	{
		
		$sql = 'SELECT * FROM '.TABLE_TRANS_RECENT.' WHERE transid = ' ._q($transid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields;
	}
	
	function _getMappedTrans($transid)
	{
		$orig = Affiliate_Merchants_Bl_NFExport::_getTrans($transid);
		
		$transid = $orig['data1'];
		$estrev = $orig['commission'];
		$processdate = date('Y-m-d h:i:s');
		$orderid = $orig['transid'];
		
		$orig['data1'] = $orig['commission'] = null;
		
		$orig['transid'] = $transid;
		$orig['estimatedrevenue'] = $estrev;
		$orig['providerprocessdate'] = $processdate;
		$orig['providerorderid'] = $orderid;
		$orig['affiliateid'] = null;
		$orig['campcategoryid'] = null;
		$orig['exit'] = null;
		
		return $orig;
	}
	
	function _insert($trans)
	{
		$cols = array(	'transid', 
						'providerid', 
						'merchantname', 
						'providerwebsiteid', 
						'providerwebsitename', 
						'orderid', 
						'providereventdate', 
						'providertype', 
						'providerprocessdate', 
						'estimatedrevenue', 
						'dateestimated', 
						'providerchannel', 
						'productid', 
						'quantity', 
						'merchantsales', 
						'provideractionname', 
						'providerorderid', 
						'providerstatus', 
						'providercorrected', 
						'provideractionid', 
						'dateinserted', 
						'affiliateid', 
						'campcategoryid', 
						'dateinserted',
						'transtype',
						'estimateddatafilename',
						'data1',
						'data2',
						'data3');
						
		$preppedTrans = array();				
		
		foreach($cols as $col)
		{
			$preppedTrans[$col] = $trans[$col];
		}
		
		$validator = new Affiliate_Merchants_Bl_Validator();
		
		$preppedTrans = $validator->validateNetfinitiData($preppedTrans);
				
		if ($preppedTrans['errorcode'] != null){
	    	
	    	$sql = 'INSERT INTO  ' . UPLOAD_ERROR_TABLE . 
					'(`'.implode('`,`', array_keys($preppedTrans)).'`) ' .
					'VALUES ("'.implode('","' ,array_values($preppedTrans)).'")';
	    
	    }else{
	    	
	    	unset($preppedTrans['errorcode']);
			
			$preppedTrans['reftrans'] = $preppedTrans['transid'];
			$preppedTrans['transid'] = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
			$preppedTrans['commission'] = $validator->_computeCommission($preppedTrans, QUERY_NF);			
			$sql = 'INSERT INTO  ' . UPLOAD_CCCOM_TABLE .
					'(`'.implode('`,`', array_keys($preppedTrans)).'`) ' .
					'VALUES ("'.implode('","' ,array_values($preppedTrans)).'")';
		}
	    
		$nfDb = new Affiliate_Scripts_Bl_NFQuery();	
		$nfDb->query($sql);	    

	}
	
	function _setPaid($transid)
	{
		$sql = 'UPDATE '.TABLE_TRANS_RECENT.' SET payoutstatus = ' . _q(2) . ' WHERE transid = ' . _q($transid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
}
?>