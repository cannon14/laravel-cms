<?php
/**
 * 
 * NFEXport Object
 * UNIT TESTS 
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_NFExport'); 

class TEST_Affiliate_Merchants_Bl_NFExport extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_NFExport( $name = "TEST_Affiliate_Merchants_Bl_NFEXport" ) 
	{
		$this->TestCase( $name );
	}
	
	function setUp() 
	{	
		$this->cccomTrans1 = array(
									'transid' 		=> 'abcdef',
									'data1' 		=> '123456',
									'commission' 	=> 100,
									'payoutstatus' 	=> 1,
									'transtype'		=> TRANSTYPE_SALE
									);
									
		$this->cccomTrans2 = array(
									'transid' 		=> 'dfgfdgf',
									'data1' 		=> 'zyxwvut',
									'commission' 	=> 100,
									'payoutstatus' 	=> 1,
									'transtype'		=> TRANSTYPE_SALE
									);
											
		$this->nfTrans1 	= array(
									'transid' 		=> '123456',
									'transtype'		=> TRANSTYPE_CLICK,
									'accountid'		=> 'Default1'
									);
														
		TestUtilities::addTransCCCOM($this->cccomTrans1);
		TestUtilities::addTransCCCOM($this->cccomTrans2);
		TestUtilities::addTransNF($this->nfTrans1);
	}
	
	function tearDown() 
	{
		TestUtilities::deleteTransCCCOM($this->cccomTrans1);
		TestUtilities::deleteTransCCCOM($this->cccomTrans2);
		TestUtilities::deleteTransNF($this->nfTrans1);
	}	
	
	
	function test_Valid_Sale()
	{
		Affiliate_Merchants_Bl_NFExport::payout('abcdef');
		$valid = TestUtilities::getTransNFUploadByProvider('abcdef');
		$this->assertEquals($valid['reftrans'], '123456');
	}
	
	function test_Invalid_Sale()
	{
		Affiliate_Merchants_Bl_NFExport::payout('dfgfdgf');
		$valid = TestUtilities::getTransNFUploadError('zyxwvut');
		$this->assertEquals($valid['transid'], 'zyxwvut');		
	}
		
}

			
?>
