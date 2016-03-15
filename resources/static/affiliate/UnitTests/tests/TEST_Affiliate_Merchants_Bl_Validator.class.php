<?php
/**
 * 
 * NETFINITI Validator Object
 * UNIT TESTS 
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Validator'); 




class TEST_Affiliate_Merchants_Bl_Validator extends TestCase
{
	var $testcase;
	var $nfQuery;
		
	function TEST_Affiliate_Merchants_Bl_Validator( $name = "TEST_Affiliate_Merchants_Bl_Validator" ) 
	{
		$this->TestCase( $name );
		$this->nfQuery = new Affiliate_Scripts_Bl_NFQuery();
	}
	
	function setUp() 
	{
		$this->trans_101 = array(	
									'transid' 	=> '',
									'accountid' => 'default1'
								  );
								  
		$this->trans_102 = array(	
									'transid' 				=> '654321',
									'accountid' 			=> 'default1',
									'estimatedrevenue' 		=> '3',
									'providerprocessdate' 	=> date('Y-m-d h:i:s'),
									'quantity'				=> 1
								  );
								  
		$this->trans_103 = array(	
									'transid' 				=> '123456',
									'accountid' 			=> 'default1',
									'estimatedrevenue' 		=> '0',
									'providerprocessdate' 	=> date('Y-m-d h:i:s'),
									'quantity'				=> 1
								  );
								  								  								  
		$this->trans_104 = array(	
									'transid' 	=> '111',
									'accountid' => 'default1'
								  );
								  
		$this->trans_105 = array(	
									'transid' 	=> '123456',
									'accountid' => 'default1',
									'estimatedrevenue' => '1',
									'quantity' => '',
								  );
								  
		$this->trans_valid = array(	
									'transid' 				=> '5678910',
									'accountid' 			=> 'default1',
									'estimatedrevenue' 		=> '10',
									'providerprocessdate' 	=> date('Y-m-d h:i:s'),
									'quantity'				=> 1,
									
								  );
								  
		$this->testTrans1 = array(
									'transid' 	=> '123456', 
									'accountid' => 'default1', 
									'rstatus'	=> 1,
									'transtype' => TRANSTYPE_CLICK,
								 );
		$this->testTrans2 = array(
									'transid' 	=> '654321', 
									'accountid' => 'default1', 
									'rstatus'	=> 1,
									'transtype' => TRANSTYPE_CLICK,
									'reftrans'	=> '',
								 );
		
		$this->testTrans3 = array(
									'transid' 	=> '5678910',
									'accountid' => 'default1', 
									'rstatus'	=> 1,
									'transtype' => TRANSTYPE_SALE,
									'reftrans'	=> '654321',
								 );		
		
		
		TestUtilities::addTransNF($this->testTrans1);		
		TestUtilities::addTransNF($this->testTrans2);	
		TestUtilities::addTransNF($this->testTrans3);
		
		TestUtilities::addTransCCCOM($this->testTrans1);		
		TestUtilities::addTransCCCOM($this->testTrans2);	
		TestUtilities::addTransCCCOM($this->testTrans3);												  
	}
	
	function tearDown() 
	{
		TestUtilities::deleteTransNF($this->testTrans1);
		TestUtilities::deleteTransNF($this->testTrans2);
		TestUtilities::deleteTransNF($this->testTrans3);
		
		TestUtilities::deleteTransCCCOM($this->testTrans1);
		TestUtilities::deleteTransCCCOM($this->testTrans2);
		TestUtilities::deleteTransCCCOM($this->testTrans3);		
	}
	
	function test_CCCOM_throw_no_transid_error_101()
	{
		$this->trans_101 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_101);
		$this->assertEquals($this->trans_101['errorcode'], 101);
	}
	
	function test_CCCOM_throw_duplicate_trans_error_102()
	{
		$this->trans_102 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_102);
		$this->assertEquals($this->trans_102['errorcode'], 102);
	}	
	
	function test_CCCOM_throw_estimated_rev_0_error_103()
	{
		$this->trans_103 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_103);
		$this->assertEquals($this->trans_103['errorcode'], 103);
	}		
	
	function test_CCCOM_throw_transid_dne_error_104()
	{
		$this->trans_104 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_104);
		$this->assertEquals($this->trans_104['errorcode'], 104);
	}	
	
	function test_CCCOM_throw_missing_qty_error_105()
	{
		$this->trans_105 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_105);
		$this->assertEquals($this->trans_105['errorcode'], 105);
	}	

	function test_CCCOM_valid_trans()
	{
		$this->trans_valid = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_valid);
		$this->assertEquals($this->trans_valid['errorcode'], null);
	}			
		
	function test_NETFINITI_throw_no_transid_error_101()
	{
		$this->trans_101 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_101);
		$this->assertEquals($this->trans_101['errorcode'], 101);
	}
	
	function test_NETFINITI_throw_duplicate_trans_error_102()
	{
		$this->trans_102 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_102);
		$this->assertEquals($this->trans_102['errorcode'], 102);
	}	
	
	function test_NETFINITI_throw_estimated_rev_0_error_103()
	{
		$this->trans_103 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_103);
		$this->assertEquals($this->trans_103['errorcode'], 103);
	}		
	
	function test_NETFINITI_throw_transid_dne_error_104()
	{
		$this->trans_104 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_104);
		$this->assertEquals($this->trans_104['errorcode'], 104);
	}	
	
	function test_NETFINITI_throw_missing_qty_error_105()
	{
		$this->trans_105 = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_105);
		$this->assertEquals($this->trans_105['errorcode'], 105);
	}	

	function test_NETFINITI_valid_trans()
	{
		$this->trans_valid = Affiliate_Merchants_Bl_Validator::validateNetfinitiData($this->trans_valid);
		$this->assertEquals($this->trans_valid['errorcode'], null);
	}
				
}

			
?>
