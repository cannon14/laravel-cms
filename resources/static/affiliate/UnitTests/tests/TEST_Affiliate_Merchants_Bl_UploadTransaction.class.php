<?php
/**
 * 
 * NETFINITI Upload Object
 * UNIT TESTS 
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_UploadTransaction'); 

class TEST_Affiliate_Merchants_Bl_UploadTransaction extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_UploadTransaction( $name = "TEST_Affiliate_Merchants_Bl_UploadTransaction" ) 
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
			
		TestUtilities::deleteTransCCCOMUpload($this->trans_valid);
		TestUtilities::deleteTransCCCOMUpload($this->trans_valid_2);
	}
	
	function tearDown() 
	{
		TestUtilities::deleteTransCCCOMUpload($this->trans_valid);
		TestUtilities::deleteTransCCCOMUpload($this->trans_valid_2);
	}
	
	function test_insert_upload_transaction()
	{
		$id = Affiliate_Merchants_Bl_UploadTransaction::insertTransaction($this->trans_valid);
		$trans = TestUtilities::getTransUploadCCCOM('123456');
		$this->assertEquals($this->trans_valid['transid'], $trans['transid']);
	}
	
	function test_delete_upload_single_transaction()
	{
		TestUtilities::addTransCCCOMUpload($this->trans_valid);
		Affiliate_Merchants_Bl_UploadTransaction::deleteUploads($this->trans_valid['transid']);
		$trans = TestUtilities::getTransCCCOMUpload($this->trans_valid['transid']);
		$this->assertEquals($trans['transid'], null);
	}
	
	function test_delete_upload_multiple_transactions()
	{
		TestUtilities::addTransCCCOMUpload($this->trans_valid);
		TestUtilities::addTransCCCOMUpload($this->trans_valid_2);
		Affiliate_Merchants_Bl_UploadTransaction::deleteUploads(array($this->trans_valid['transid'], $this->trans_valid_2['transid']));
		$trans = TestUtilities::getTransCCCOMUpload($this->trans_valid['transid']);
		$trans2 = TestUtilities::getTransCCCOMUpload($this->trans_valid_2['transid']);
		$this->assert($trans['transid'] == null && $trans2['transid'] == null);		
	}
				
}

			
?>
