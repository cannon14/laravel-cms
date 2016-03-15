<?php
/**
 * 
 * CCCOM Adjustment Object
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

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Adjustment'); 


class TEST_Affiliate_Merchants_Bl_Adjustment extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_Adjustment( $name = "TEST_Affiliate_Merchants_Bl_Adjustment" ) 
	{
		$this->TestCase( $name );
	}
	
	function setUp() 
	{
		$this->trans_101 = array(	
									'transid' 			=> '',
									'accountid' 		=> 'default1',
									'errorcode' 		=> 101,
									'campcategoryid' 	=> '12344321'
								  );
								  								  								  
		$this->trans_104 = array(	
									'transid' 	=> '654FFFFCCCC',
									'reftrans' 	=> '654FFFFCCCC',
									'errorcode' => 104,
									'campcategoryid' 	=> '12345678'
								  );
								  
		$this->trans_102 = array(	
									'transid' 				=> '9746976134555',
									'reftrans'				=> '9746976134555',
									'errorcode' 			=> 102,
									'estimatedrevenue' 		=> 99.0,
									'commission' 			=> 57.0
								  );
								  
		$this->testTransUpload102 = array(
									'transid' 	=> '654321a', 
									'reftrans'	=> '9746976134555',
									'estimatedrevenue' 		=> '25',
									'commission' 			=> '17'
								 );
								 
		$this->testTransValid102 = array(
									'transid' 	=> '654321b', 
									'reftrans'	=> '9746976134555',
									'estimatedrevenue' 		=> '30',
									'commission' 			=> '13'
								 );
								 
		$this->trans_append = array(	
									'transid' 				=> '4sf64sd54dsf',
									'reftrans'				=> '4sf64sd54dsf',
									'errorcode' 			=> 102,
									'estimatedrevenue' 		=> 104.0,
									'commission' 			=> 72.0
								  );
								  
		$this->testTransUploadAppend = array(
									'transid' 	=> '654321a', 
									'reftrans'	=> '4sf64sd54dsf',
									'estimatedrevenue' 		=> '25',
									'commission' 			=> '17'
								 );
								 
		$this->testTransValidAppend = array(
									'transid' 	=> '654321b', 
									'reftrans'	=> '4sf64sd54dsf',
									'estimatedrevenue' 		=> '30',
									'commission' 			=> '13'
								 );
								 
		
		$this->trans_101["id"] = $this->_addTransCCCOMError($this->trans_101);
		
		$this->trans_104["id"] = $this->_addTransCCCOMError($this->trans_104);
		
		//setup for 102 moved into 102 test function
		
		//setup for append moved into append test function
	}
	
	function tearDown() 
	{
		$this->_deleteTransCCCOM($this->trans_101);
		$this->_deleteError($this->trans_101);
		
		$this->_deleteTransCCCOM($this->trans_104);
		$this->_deleteError($this->trans_104);
		
		$this->_deleteTransCCCOM($this->trans_102);
		TestUtilities::deleteTransCCCOM($this->testTransValid102);
		
		$this->_deleteTransCCCOM($this->trans_append);
		TestUtilities::deleteTransCCCOM($this->testTransValidAppend);
	}	
	
	function _addTransCCCOMError($trans)
	{
		$sql = 'INSERT INTO ' . UPLOAD_ERROR_TABLE . ' (`'. implode('`,`', array_keys($trans)) .'`) VALUES ("'.implode('","',array_values($trans)).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'SELECT id FROM ' . UPLOAD_ERROR_TABLE . ' ORDER BY id DESC LIMIT 1';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 
		
		return $rs->fields['id'];
	}
	
	function _addTransCCCOMUpload($trans)
	{
		$sql = 'INSERT INTO ' . UPLOAD_TABLE . ' (`'. implode('`,`', array_keys($trans)) .'`) VALUES ("'.implode('","',array_values($trans)).'")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _deleteTransCCCOM($trans)
	{
		$sql = 'DELETE FROM ' . UPLOAD_TABLE . ' WHERE ((transid = ' . _q($trans['transid']) . ') OR (campcategoryid = ' . _q($trans['campcategoryid']) . ') OR (reftrans = ' . _q($trans['reftrans']) . '))';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _deleteError($trans)
	{
		$sql = 'DELETE FROM ' . UPLOAD_ERROR_TABLE . ' WHERE campcategoryid = ' . _q($trans['campcategoryid']);
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _getUploadTransByCampCategoryId($trans)
	{
		$sql = 'SELECT * FROM ' . UPLOAD_TABLE . ' WHERE campcategoryid = ' . _q($trans['campcategoryid']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $rs->fields;
	}
	
	function test_override_error_101()
	{
		Affiliate_Merchants_Bl_Adjustment::overrideTransaction($this->trans_101['id']);

		$uploadTrans = $this->_getUploadTransByCampCategoryId($this->trans_101);

		$this->assertEquals($uploadTrans['campcategoryid'], $this->trans_101['campcategoryid']);
		
		//$deletedErrorTrans = TestUtilities::getTransCCCOMUploadError($this->trans_101['transid']);
		//$this->assert($deletedErrorTrans["transid"]==null);
	}
	
	function test_override_error_104()
	{
		Affiliate_Merchants_Bl_Adjustment::overrideTransaction($this->trans_104['id']);
		
		$uploadTrans = $this->_getUploadTransByCampCategoryId($this->trans_104);

		$this->assertEquals($uploadTrans['reftrans'], $this->trans_104['reftrans']);
		
		$deletedErrorTrans = TestUtilities::getTransCCCOMUploadError($this->trans_104['transid']);
		$this->assert($deletedErrorTrans["transid"]==null);
	}
	
	function test_override_error_102()
	{
		$this->trans_102["id"] = $this->_addTransCCCOMError($this->trans_102);
		TestUtilities::addTransCCCOM($this->testTransValid102);
		$this->_addTransCCCOMUpload($this->testTransUpload102);
		
		Affiliate_Merchants_Bl_Adjustment::overrideTransaction($this->trans_102['id']);
		
		$sql = 'SELECT SUM(commission) as com, SUM(estimatedrevenue) as est FROM ' . UPLOAD_TABLE . ' WHERE reftrans = ' ._q($this->trans_102["transid"]);
		$rsu = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql2 = 'SELECT SUM(commission) as com, SUM(estimatedrevenue) as est FROM ' . TRANS_TABLE . ' WHERE reftrans = ' ._q($this->trans_102["transid"]);
		$rst = QCore_Sql_DBUnit::execute($sql2, __FILE__, __LINE__);
		
		$comtotal = $rst->fields['com'] + $rsu->fields['com'];
		$esttotal = $rst->fields['est'] + $rsu->fields['est'];

		$this->assertEquals((double)$comtotal, $this->trans_102['commission']);
		$this->assertEquals((double)$esttotal, $this->trans_102['estimatedrevenue']);
	}
	
	function test_append_errored_transaction()
	{
		$this->trans_append["id"] = $this->_addTransCCCOMError($this->trans_append);
		TestUtilities::addTransCCCOM($this->testTransValidAppend);
		$this->_addTransCCCOMUpload($this->testTransUploadAppend);

		Affiliate_Merchants_Bl_Adjustment::appendTransaction($this->trans_append['id']);
		
		$sql = 'SELECT SUM(commission) as com, SUM(estimatedrevenue) as est FROM ' . UPLOAD_TABLE . ' WHERE reftrans = ' ._q($this->trans_append["transid"]);
		$rsu = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql2 = 'SELECT SUM(commission) as com, SUM(estimatedrevenue) as est FROM ' . TRANS_TABLE . ' WHERE reftrans = ' ._q($this->trans_append["transid"]);
		$rst = QCore_Sql_DBUnit::execute($sql2, __FILE__, __LINE__);
		
		$commtotal = $rst->fields['com'] + $rsu->fields['com'];
		$esttotal = $rst->fields['est'] + $rsu->fields['est'];
		
		$testEstTotal = $this->trans_append['estimatedrevenue'] + $this->testTransValidAppend['estimatedrevenue'] + $this->testTransUploadAppend['estimatedrevenue']; 
		$testCommTotal = $this->trans_append['commission'] + $this->testTransValidAppend['commission'] + $this->testTransUploadAppend['commission'];

		$this->assertEquals((double)$commtotal, $testCommTotal);
		$this->assertEquals((double)$esttotal, $testEstTotal);
	}
}

?>