<?php
/**
 * 
 * Parser Object
 * UNIT TESTS 
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 * Kyle Putnam
 * <kyle.putnam@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Parser'); 




class TEST_Affiliate_Merchants_Bl_Parser extends TestCase
{
	var $testcase;
	var $nfQuery;
		
	function TEST_Affiliate_Merchants_Bl_Parser( $name = "TEST_Affiliate_Merchants_Bl_Parser" ) 
	{
		$this->TestCase( $name );
		$this->nfQuery = new Affiliate_Scripts_Bl_NFQuery();
	}
	
	function setUp() 
	{
		$this->testTransCccomError = array(
									'transid' 				=> 'skldfj02349fm2309',
									'providerprocessdate' 	=> '2006-12-05 01:05:34',
									'providereventdate' 	=> '2006-12-04 01:01:00',
									'estimatedrevenue' 		=> 35,
									'dateestimated' 		=> '2007-01-05 01:01:00',
									'providerchannel' 		=> 'Linkshare',
									'quantity' 				=> 1,
									'estimateddatafilename' => 'Parser_Unit_Test.csv',
									'providerid'			=> 1
								  );
								  
		$this->testTransCccomClean = array(
									'transid' 				=> '54sf654sdf',
									'providerprocessdate' 	=> '2006-12-05 01:05:34',
									'providereventdate' 	=> '2006-12-04 01:01:00',
									'estimatedrevenue' 		=> 35,
									'dateestimated' 		=> '2007-01-05 01:01:00',
									'providerchannel' 		=> 'Linkshare',
									'quantity' 				=> 1,
									'estimateddatafilename' => 'Parser_Unit_Test.csv',
									'providerid'			=> 2
								  );
								  
		$this->testTrans1 = array(	
									'transid' 				=> '54sf654sdf'
								  );
		
		$this->testTransNFError = array(
									'transid' 				=> '98t799846sfdfsf',
									'providerprocessdate' 	=> '2006-12-05 01:05:34',
									'providereventdate' 	=> '2006-12-04 01:01:00',
									'estimatedrevenue' 		=> 35,
									'dateestimated' 		=> '2007-01-05 01:01:00',
									'providerchannel' 		=> 'Linkshare',
									'quantity' 				=> 1,
									'estimateddatafilename' => 'Parser_Unit_Test.csv',
									'providerid'			=> 3
								  );
								  
		$this->testTransNFClean = array(
									'transid' 				=> '97t11446464sffd',
									'providerprocessdate' 	=> '2006-12-05 01:05:34',
									'providereventdate' 	=> '2006-12-04 01:01:00',
									'estimatedrevenue' 		=> 35,
									'dateestimated' 		=> '2007-01-05 01:01:00',
									'providerchannel' 		=> 'Linkshare',
									'quantity' 				=> 1,
									'estimateddatafilename' => 'Parser_Unit_Test.csv',
									'providerid'			=> 4
								  );
		
		$this->testTrans2 = array(	
									'transid' 				=> '97t11446464sffd'
								  );
								  
	}
	
	function tearDown() 
	{
		$this->_deleteCccomUploadError($this->testTransCccomError['transid']);
		
		TestUtilities::deleteTransCCCOM($this->testTransCccomClean);
		$this->_deleteTransCCCOMUpload($this->testTransCccomClean);
		
		$this->_deleteTransNFUploadError($this->testTransNFError['transid']);
		
		TestUtilities::deleteTransNF($this->testTrans2);
		$this->_deleteTransNFUpload($this->testTransNFClean['transid']);
	}
	
	function _deleteTransCCCOMUpload($trans)
	{
		$sql = 'DELETE FROM '.UPLOAD_TABLE.' WHERE reftrans = ' . _q($trans['transid']);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
	
	function _getCccomUploadError($transid)
	{
		$sql = 'SELECT * FROM '.UPLOAD_ERROR_TABLE.' WHERE reftrans = ' . _q($transid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
		return $rs->fields;
	}
	
	function _getTransNFUpload($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_CCCOM_TABLE.' WHERE reftrans = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);
		return $rs->fields;
	}
	
	function _deleteTransNFUpload($id)
	{
		$sql = 'DELETE FROM '.UPLOAD_CCCOM_TABLE.' WHERE reftrans = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);
		return $rs->fields;
	}
	
	function _getTransNFUploadError($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_ERROR_TABLE.' WHERE reftrans = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);
		return $rs->fields;
	}
	
	function _deleteTransNFUploadError($id)
	{
		$sql = 'DELETE FROM '.UPLOAD_ERROR_TABLE.' WHERE reftrans = ' . _q($id);
		$rs = TestUtilities::_queryNF($sql);
		return $rs->fields;
	}
	
	function _getTransUploadCCCOM($id)
	{
		$sql = 'SELECT * FROM '.UPLOAD_TABLE.' WHERE reftrans = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs->fields;
	}
	
	function _deleteCccomUploadError($transid)
	{
		$sql = 'DELETE FROM '.UPLOAD_ERROR_TABLE.' WHERE reftrans = ' . _q($transid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _loadProviderProps($id)
	{
		$sql = 'SELECT * FROM ' . PROVIDER_TABLE . ' WHERE providerid = ' . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields;
	}
	
	function test_CCCOM_error()
	{
		$provider = $this->_loadProviderProps($this->testTransCccomError['providerid']);
		
		$cleanpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/archive_clean/' . $this->testTransCccomError['estimateddatafilename'];
		$errorpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/errors/' . $this->testTransCccomError['estimateddatafilename'];
		
		$parser = new Affiliate_Merchants_Bl_Parser();
		$parser->addRow($this->testTransCccomError, $cleanpath, $errorpath);
		
		//test that trans hit transactions_upload_errors table
		$newTrans = $this->_getCccomUploadError($this->testTransCccomError['transid']);
		$this->assertEquals($this->testTransCccomError['transid'], $newTrans['reftrans']);
		
		//look for archive file 
		$this->assert(file_exists($cleanpath));
		
		//delete archive file
		$this->assert(unlink($cleanpath));
	}
	
	function test_CCCOM_clean()
	{
		TestUtilities::addTransCCCOM($this->testTrans1);
		
		$provider = $this->_loadProviderProps($this->testTransCccomClean['providerid']);
		
		$cleanpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/archive_clean/' . $this->testTransCccomError['estimateddatafilename'];
		$errorpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/errors/' . $this->testTransCccomError['estimateddatafilename'];
		
		$parser = new Affiliate_Merchants_Bl_Parser();
		$parser->addRow($this->testTransCccomClean, $cleanpath, $errorpath);
		
		//test that trans hit transactions_upload_errors table
		$uploadTrans = $this->_getTransUploadCCCOM($this->testTransCccomClean['transid']);
		$this->assertEquals($this->testTransCccomClean['transid'], $uploadTrans['reftrans']);
		
		//look for archive file 
		$this->assert(file_exists($cleanpath));
		
		//delete archive file
		$this->assert(unlink($cleanpath));
	}
	
	function test_NF_error()
	{
		$provider = $this->_loadProviderProps($this->testTransNFError['providerid']);
		
		$cleanpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/archive_clean/' . $this->testTransNFError['estimateddatafilename'];
		$errorpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/errors/' . $this->testTransNFError['estimateddatafilename'];
		
		$parser = new Affiliate_Merchants_Bl_Parser();
		$parser->addRow($this->testTransNFError, $cleanpath, $errorpath);
		
		//test that trans hit transactions_upload_errors table
		$newTrans = $this->_getTransNFUploadError($this->testTransNFError['transid']);
		$this->assertEquals($this->testTransNFError['transid'], $newTrans['reftrans']);
		
		//look for archive file 
		$this->assert(file_exists($cleanpath));
		
		//delete archive file
		$this->assert(unlink($cleanpath));
	}
	
	function test_NF_clean()
	{
		TestUtilities::addTransNF($this->testTrans2);
		
		$provider = $this->_loadProviderProps($this->testTransNFClean['providerid']);
		
		$cleanpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/archive_clean/' . $this->testTransNFClean['estimateddatafilename'];
		$errorpath = '//tsinside01/ccfinance/revenue/' . $provider['directory'] . '/errors/' . $this->testTransNFClean['estimateddatafilename'];
		
		$parser = new Affiliate_Merchants_Bl_Parser();
		
		$parser->addRow($this->testTransNFClean, $cleanpath, $errorpath);
		
		//test that trans hit transactions_upload_errors table
		$uploadTrans = $this->_getTransNFUpload($this->testTransNFClean['transid']);
		$this->assertEquals($this->testTransNFClean['transid'], $uploadTrans['reftrans']);
	
		//look for archive file 
		$this->assert(file_exists($cleanpath));
		
		//delete archive file
		$this->assert(unlink($cleanpath));
	}			
}
		
?>
