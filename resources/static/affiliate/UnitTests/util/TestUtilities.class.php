<?php

QUnit_Global::includeClass('Affiliate_Scripts_Bl_NFQuery');

class TestUtilities {
	
	function _queryNF($sql)
	{
		$nfQuery = new Affiliate_Scripts_Bl_NFQuery();
		return $nfQuery->query($sql);
	}

	function addTransNF($trans)
	{
		$sql = 'INSERT INTO ' . TRANS_TABLE . ' (`'. implode('`,`', array_keys($trans)) .'`) VALUES ("'.implode('","',array_values($trans)).'")';
		TestUtilities::_queryNF($sql);
	}
	
	function getTransNF($id)
	{
		$sql = 'SELECT * FROM '.TRANS_TABLE.' WHERE transid = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);	
		return $rs->fields;		
	}	
	
	function deleteTransNF($trans)
	{
		$sql = 'DELETE FROM ' . TRANS_TABLE . ' WHERE transid = ' . _q($trans['transid']);
		TestUtilities::_queryNF($sql);
	}

	function getTransNFUpload($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_CCCOM_TABLE.' WHERE transid = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);
		return $rs->fields;
	}
	
	function getTransNFUploadByProvider($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_CCCOM_TABLE.' WHERE providerorderid = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);
		return $rs->fields;
	}	
	
	function getTransNFUploadError($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_ERROR_TABLE.' WHERE transid = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);	
		return $rs->fields;		
	}
	
	function addTransCCCOM($trans)
	{
		$sql = 'INSERT INTO ' . TRANS_TABLE . ' (`'. implode('`,`', array_keys($trans)) .'`) VALUES ("'.implode('","',array_values($trans)).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
	
	function addTransCCCOMUpload($trans)
	{
		$sql = 'INSERT INTO ' . UPLOAD_TABLE . ' (`'. implode('`,`', array_keys($trans)) .'`) VALUES ("'.implode('","',array_values($trans)).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
	
	function getTransCCCOM($id)
	{
		$sql = 'SELECT * FROM '.TRANS_TABLE.' WHERE transid = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields;
	}
	
	function getTransUploadCCCOM($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_TABLE.' WHERE transid = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields;
	}		
	
	function deleteTransCCCOM($trans)
	{
		$sql = 'DELETE FROM ' . TRANS_TABLE . ' WHERE transid = ' . _q($trans['transid']);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
	
	function deleteTransCCCOMUpload($trans)
	{
		$sql = 'DELETE FROM '.UPLOAD_TABLE.' WHERE transid = ' . _q($trans['transid']);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
	
	function getTransCCCOMUpload($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_TABLE.' WHERE transid = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields;
	}
	
	function getTransCCCOMUploadError($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_ERROR_TABLE.' WHERE id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		return $rs->fields;		
	}
	
	function deleteTransCCCOMUploadError($id)
	{
		$sql = 'DELETE FROM '.UPLOAD_ERROR_TABLE.' WHERE id = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		return $rs->fields;		
	}	
	
	function addTransCCCOMUploadError($trans)
	{
		$sql = 'INSERT INTO ' . UPLOAD_ERROR_TABLE . ' (`'. implode('`,`', array_keys($trans)) .'`) VALUES ("'.implode('","',array_values($trans)).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'SELECT id FROM ' . UPLOAD_ERROR_TABLE . ' ORDER BY id DESC LIMIT 1';
		$rs = 	QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		
		return $rs->fields['id'];
	}	
}
?>