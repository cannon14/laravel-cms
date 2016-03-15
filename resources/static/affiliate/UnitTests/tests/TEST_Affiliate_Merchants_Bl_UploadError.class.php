<?php
/**
 * 
 * NETFINITI Upload Error Object
 * UNIT TESTS 
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadError'); 

class TEST_Affiliate_Merchants_Bl_UploadError extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_UploadError( $name = "TEST_Affiliate_Merchants_Bl_UploadError" ) 
	{
		$this->TestCase( $name );
	}
	
	function setUp() 
	{
			$this->trans_valid = array(	
									'transid' 				=> '123456',
									'accountid' 			=> 'default1',
									'estimatedrevenue' 		=> '10',
									'transtype'				=> TRANSTYPE_SALE,
									'providerprocessdate' 	=> date('Y-m-d h:i:s'),
									'quantity'				=> 1,
								  );
								  
			$this->trans_valid_2 = array(	
									'transid' 				=> '564321',
									'accountid' 			=> 'default1',
									'estimatedrevenue' 		=> '10',
									'transtype'				=> TRANSTYPE_SALE,
									'providerprocessdate' 	=> date('Y-m-d h:i:s'),
									'quantity'				=> 1,
								  );								  
			
		TestUtilities::deleteTransCCCOMUploadError($this->trans_valid);
		TestUtilities::deleteTransCCCOMUploadError($this->trans_valid_2);
	}
	
	function tearDown() 
	{
		TestUtilities::deleteTransCCCOMUploadError($this->trans_valid);
		TestUtilities::deleteTransCCCOMUploadError($this->trans_valid_2);
	}
	
	function test_insert_upload_error()
	{
		$id = Affiliate_Merchants_Bl_UploadError::insertError($this->trans_valid);
		$this->assert($id > 0);
		$trans = TestUtilities::getTransCCCOMUploadError($id);
		$this->assertEquals($this->trans_valid['transid'], $trans['transid']);
	}
	
	function test_get_upload_error()
	{
		$id = TestUtilities::addTransCCCOMUploadError($this->trans_valid);
		$trans = Affiliate_Merchants_Bl_UploadError::getError($id);
		$this->assertEquals($trans['transid'], $this->trans_valid['transid']);
	}
	
	function test_update_upload_error()
	{
		$id = TestUtilities::addTransCCCOMUploadError($this->trans_valid);
		$params = array('estimatedrevenue' => 5);
		Affiliate_Merchants_Bl_UploadError::updateError($id, $params);
		$trans = TestUtilities::getTransCCCOMUploadError($id);
		$this->assertEquals((double)$trans['estimatedrevenue'], (double)$params['estimatedrevenue']);
	}
	
	function test_delete_upload_single_error()
	{
		$id = TestUtilities::addTransCCCOMUploadError($this->trans_valid);
		Affiliate_Merchants_Bl_UploadError::deleteUploadErrors($id);
		$trans = TestUtilities::getTransCCCOMUploadError($id);
		$this->assertEquals($trans['transid'] ,null);
	}
	
	function test_delete_upload_multiple_errors()
	{
		$id1 = TestUtilities::addTransCCCOMUploadError($this->trans_valid);
		$id2 = TestUtilities::addTransCCCOMUploadError($this->trans_valid_2);
		Affiliate_Merchants_Bl_UploadError::deleteUploadErrors(array($id1, $id2));
		$trans = TestUtilities::getTransCCCOMUploadError($id1);
		$this->assertEquals($trans['transid'], null);
		$trans2 = TestUtilities::getTransCCCOMUploadError($id2);
		$this->assertEquals($trans2['transid'], null);
	}
				
}

			
?>