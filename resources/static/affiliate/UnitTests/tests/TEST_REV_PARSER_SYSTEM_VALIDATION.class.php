<?php
/**
 * 
 * SYSTEM TESTS 
 * 
 * Authors:
 * Kyle Putnam
 * <kyle.putnam@creditcards.com>
 * 
 */ 

class TEST_REV_PARSER_SYSTEM_VALIDATION extends TestCase
{
	var $testcase;
	var $nfQuery;
	var $nfAffiliateId = "8e7a433f";
	var $advantaproviderid = 1;
	var $americanexpressproviderid = 2;
	var $capitaloneproviderid = 3;
	var $chaseproviderid = 4;
	var $citiproviderid = 5;
	var $discoverproviderid = 6;
	var $discoverbizproviderid = 19;
	var $euforaproviderid = 7;
	var $first_premierproviderid = 8;
	var $hsbc_gmproviderid = 9;
	var $hsbc_metrisproviderid = 10;
	var $hsbc_orchardproviderid = 11;
	var $hsbc_platinumproviderid = 12;
	var $hsbc_upproviderid = 13;
	var $icommissionsproviderid = 14;
	var $ncsproviderid = 15;
	var $netspendproviderid = 16;
	
	function TEST_REV_PARSER_SYSTEM_VALIDATION( $name = "TEST_REV_PARSER_SYSTEM_VALIDATION" ) 
	{
		$this->TestCase( $name );
		$this->nfQuery = new Affiliate_Scripts_Bl_NFQuery();
	}
	
	function setUp()
	{
		
	}
	
	function tearDown() 
	{
		$sql = 'DELETE FROM product_rates WHERE campaign_id=' . _q(VALID_RATE);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'DELETE FROM product_rates WHERE campaign_id=' . _q(INVALID_RATE);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _getNF($nf)
	{
		switch($nf)
		{
			case 0:	return ' AND affiliateid <> ' . _q($this->nfAffiliateId);
			break;
			
			case 1: return ' AND affiliateid = '. _q($this->nfAffiliateId);
			break;
			
			default: return;
		}	
	}
	
	function _check101($providerid, $db="cccom", $nf=2)
	{
		$sql = 'SELECT count(*) as count FROM '.UPLOAD_ERROR_TABLE .
					' WHERE providerid = ' . _q($providerid) . ' AND errorcode="101" AND (reftrans is null OR reftrans="")';

		if($db == "cccom")
		{
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		else
		{
			$rs = TestUtilities::_queryNF($sql);

		}
		
		return ((int) $rs->fields['count']);
	}
	
	function _check102($providerid, $db="cccom", $nf=2)
	{
		$sql = 'SELECT count(*) as count FROM '.UPLOAD_ERROR_TABLE .
					' WHERE providerid = ' . _q($providerid) . ' AND errorcode="102"' . $this->_getNF($nf);
		
		if($db == "cccom")
		{
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		else
		{
			$rs = TestUtilities::_queryNF($sql);
		}
//println("count: " . $rs->fields['count'] . " - " . $sql);
		return ((int) $rs->fields['count']);
	}
	
	function _check103($providerid, $db="cccom", $nf=2)
	{
		$sql = 'SELECT count(*) as count FROM '.UPLOAD_ERROR_TABLE .
					' WHERE providerid = ' . _q($providerid) . ' AND errorcode="103" AND (estimatedrevenue is null OR estimatedrevenue<=0)' . $this->_getNF($nf);
		
		if($db == "cccom")
		{
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		else
		{
			$rs = TestUtilities::_queryNF($sql);
		}
//println("count: " . $rs->fields['count'] . " - " . $sql);
		return ((int) $rs->fields['count']);
	}
	
	function _check104($providerid, $db="cccom", $nf=2)
	{
		$sql = 'SELECT count(*) as count FROM '.UPLOAD_ERROR_TABLE .
					' WHERE providerid = ' . _q($providerid) . ' AND errorcode="104"';
		
		if($db == "cccom")
		{
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		else
		{
			$rs = TestUtilities::_queryNF($sql);
		}
//println("count: " . $rs->fields['count'] . " - " . $sql);
		return ((int) $rs->fields['count']);
	}
	
	function _check105($providerid, $db="cccom", $nf=2)
	{
		$sql = 'SELECT count(*) as count FROM '.UPLOAD_ERROR_TABLE .
					' WHERE providerid = ' . _q($providerid) . ' AND errorcode=105 AND (quantity is null OR quantity<=0)' . $this->_getNF($nf);
		
		if($db == "cccom")
		{
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		else
		{
			$rs = TestUtilities::_queryNF($sql);
		}
		
		return ((int) $rs->fields['count']);
	}
	
	function _checkValid($providerid, $db="cccom", $nf=2)
	{
		$sql = 'SELECT count(*) as count FROM '.UPLOAD_TABLE . ' WHERE providerid = ' . _q($providerid);

		if($db == "cccom")
		{
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		}
		else
		{
			$rs = TestUtilities::_queryNF($sql);
		}
//println("count: " . $rs->fields['count'] . " - " . $sql);
		return ((int) $rs->fields['count']);
	}

	
	function test_advanta_cccom_valid()
	{
		$count = $this->_checkValid($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_advanta_cccom_101()
	{
		$count = $this->_check101($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_advanta_cccom_102()
	{
		$count = $this->_check102($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_advanta_cccom_103()
	{
		$count = $this->_check103($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_advanta_cccom_104()
	{
		$count = $this->_check104($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_advanta_cccom_105()
	{
		$count = $this->_check105($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_advanta_banner_valid()
	{
		$count = $this->_checkValid($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_advanta_banner_101()
	{
		$count = $this->_check101($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_advanta_banner_102()
	{
		$count = $this->_check102($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_advanta_banner_103()
	{
		$count = $this->_check103($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_advanta_banner_104()
	{
		$count = $this->_check104($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_advanta_banner_105()
	{
		$count = $this->_check105($this->advantaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_advanta_cobrand_valid()
	{
		$this->_check_cobrand($this->advantaproviderid);
	}
	
	function test_advanta_cobrand_101()
	{
		$this->_check_cobrand($this->advantaproviderid);
	}
	
	function test_advanta_cobrand_102()
	{
		$this->_check_cobrand($this->advantaproviderid);
	}
	
	function test_advanta_cobrand_103()
	{
		$this->_check_cobrand($this->advantaproviderid);
	}
	
	function test_advanta_cobrand_104()
	{
		$this->_check_cobrand($this->advantaproviderid);
	}
	
	function test_advanta_cobrand_105()
	{
		$this->_check_cobrand($this->advantaproviderid);
	}*/
//------------------------------------------------------
function test_american_express_cccom_valid()
	{
		$count = $this->_checkValid($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_american_express_cccom_101()
	{
		$count = $this->_check101($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_american_express_cccom_102()
	{
		$count = $this->_check102($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_american_express_cccom_103()
	{
		$count = $this->_check103($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_american_express_cccom_104()
	{
		$count = $this->_check104($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_american_express_cccom_105()
	{
		$count = $this->_check105($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_american_express_banner_valid()
	{
		$count = $this->_checkValid($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_american_express_banner_101()
	{
		$count = $this->_check101($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_american_express_banner_102()
	{
		$count = $this->_check102($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_american_express_banner_103()
	{
		$count = $this->_check103($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_american_express_banner_104()
	{
		$count = $this->_check104($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_american_express_banner_105()
	{
		$count = $this->_check105($this->americanexpressproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_american_express_cobrand_valid()
	{
		$this->_check_cobrand($this->americanexpressproviderid);
	}
	
	function test_american_express_cobrand_101()
	{
		$this->_check_cobrand($this->americanexpressproviderid);
	}
	
	function test_american_express_cobrand_102()
	{
		$this->_check_cobrand($this->americanexpressproviderid);
	}
	
	function test_american_express_cobrand_103()
	{
		$this->_check_cobrand($this->americanexpressproviderid);
	}
	
	function test_american_express_cobrand_104()
	{
		$this->_check_cobrand($this->americanexpressproviderid);
	}
	
	function test_american_express_cobrand_105()
	{
		$this->_check_cobrand($this->americanexpressproviderid);
	}*/
//------------------------------------------------------
function test_capital_one_cccom_valid()
	{
		$count = $this->_checkValid($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_capital_one_cccom_101()
	{
		$count = $this->_check101($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_capital_one_cccom_102()
	{
		$count = $this->_check102($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_capital_one_cccom_103()
	{
		$count = $this->_check103($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_capital_one_cccom_104()
	{
		$count = $this->_check104($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_capital_one_cccom_105()
	{
		$count = $this->_check105($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_capital_one_banner_valid()
	{
		$count = $this->_checkValid($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_capital_one_banner_101()
	{
		$count = $this->_check101($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_capital_one_banner_102()
	{
		$count = $this->_check102($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_capital_one_banner_103()
	{
		$count = $this->_check103($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_capital_one_banner_104()
	{
		$count = $this->_check104($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_capital_one_banner_105()
	{
		$count = $this->_check105($this->capitaloneproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_capital_one_cobrand_valid()
	{
		$this->_check_cobrand($this->capitaloneproviderid);
	}
	
	function test_capital_one_cobrand_101()
	{
		$this->_check_cobrand($this->capitaloneproviderid);
	}
	
	function test_capital_one_cobrand_102()
	{
		$this->_check_cobrand($this->capitaloneproviderid);
	}
	
	function test_capital_one_cobrand_103()
	{
		$this->_check_cobrand($this->capitaloneproviderid);
	}
	
	function test_capital_one_cobrand_104()
	{
		$this->_check_cobrand($this->capitaloneproviderid);
	}
	
	function test_capital_one_cobrand_105()
	{
		$this->_check_cobrand($this->capitaloneproviderid);
	}*/
//------------------------------------------------------
function test_chase_cccom_valid()
	{
		$count = $this->_checkValid($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_chase_cccom_101()
	{
		$count = $this->_check101($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_chase_cccom_102()
	{
		$count = $this->_check102($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_chase_cccom_103()
	{
		$count = $this->_check103($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_chase_cccom_104()
	{
		$count = $this->_check104($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_chase_cccom_105()
	{
		$count = $this->_check105($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_chase_banner_valid()
	{
		$count = $this->_checkValid($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_chase_banner_101()
	{
		$count = $this->_check101($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_chase_banner_102()
	{
		$count = $this->_check102($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_chase_banner_103()
	{
		$count = $this->_check103($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_chase_banner_104()
	{
		$count = $this->_check104($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_chase_banner_105()
	{
		$count = $this->_check105($this->chaseproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_chase_cobrand_valid()
	{
		$this->_check_cobrand($this->chaseproviderid);
	}
	
	function test_chase_cobrand_101()
	{
		$this->_check_cobrand($this->chaseproviderid);
	}
	
	function test_chase_cobrand_102()
	{
		$this->_check_cobrand($this->chaseproviderid);
	}
	
	function test_chase_cobrand_103()
	{
		$this->_check_cobrand($this->chaseproviderid);
	}
	
	function test_chase_cobrand_104()
	{
		$this->_check_cobrand($this->chaseproviderid);
	}
	
	function test_chase_cobrand_105()
	{
		$this->_check_cobrand($this->chaseproviderid);
	}*/
//------------------------------------------------------
function test_citi_cccom_valid()
	{
		$count = $this->_checkValid($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_citi_cccom_101()
	{
		$count = $this->_check101($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_citi_cccom_102()
	{
		$count = $this->_check102($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_citi_cccom_103()
	{
		$count = $this->_check103($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_citi_cccom_104()
	{
		$count = $this->_check104($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_citi_cccom_105()
	{
		$count = $this->_check105($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_citi_banner_valid()
	{
		$count = $this->_checkValid($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_citi_banner_101()
	{
		$count = $this->_check101($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_citi_banner_102()
	{
		$count = $this->_check102($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_citi_banner_103()
	{
		$count = $this->_check103($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_citi_banner_104()
	{
		$count = $this->_check104($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_citi_banner_105()
	{
		$count = $this->_check105($this->citiproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_citi_cobrand_valid()
	{
		$this->_check_cobrand($this->citiproviderid);
	}
	
	function test_citi_cobrand_101()
	{
		$this->_check_cobrand($this->citiproviderid);
	}
	
	function test_citi_cobrand_102()
	{
		$this->_check_cobrand($this->citiproviderid);
	}
	
	function test_citi_cobrand_103()
	{
		$this->_check_cobrand($this->citiproviderid);
	}
	
	function test_citi_cobrand_104()
	{
		$this->_check_cobrand($this->citiproviderid);
	}
	
	function test_citi_cobrand_105()
	{
		$this->_check_cobrand($this->citiproviderid);
	}*/
//------------------------------------------------------
function test_discoverbiz_cccom_valid()
	{
		$count = $this->_checkValid($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_discoverbiz_cccom_101()
	{
		$count = $this->_check101($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_discoverbiz_cccom_102()
	{
		$count = $this->_check102($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_discoverbiz_cccom_103()
	{
		$count = $this->_check103($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_discoverbiz_cccom_104()
	{
		$count = $this->_check104($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_discoverbiz_cccom_105()
	{
		$count = $this->_check105($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_discoverbiz_banner_valid()
	{
		$count = $this->_checkValid($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_discoverbiz_banner_101()
	{
		$count = $this->_check101($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_discoverbiz_banner_102()
	{
		$count = $this->_check102($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_discoverbiz_banner_103()
	{
		$count = $this->_check103($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_discoverbiz_banner_104()
	{
		$count = $this->_check104($this->discoverbizproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
//------------------------------------------------------
function test_discover_cccom_valid()
	{
		$count = $this->_checkValid($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_discover_cccom_101()
	{
		$count = $this->_check101($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_discover_cccom_102()
	{
		$count = $this->_check102($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_discover_cccom_103()
	{
		$count = $this->_check103($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_discover_cccom_104()
	{
		$count = $this->_check104($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_discover_cccom_105()
	{
		$count = $this->_check105($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_discover_banner_valid()
	{
		$count = $this->_checkValid($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_discover_banner_101()
	{
		$count = $this->_check101($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_discover_banner_102()
	{
		$count = $this->_check102($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_discover_banner_103()
	{
		$count = $this->_check103($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_discover_banner_104()
	{
		$count = $this->_check104($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_discover_banner_105()
	{
		$count = $this->_check105($this->discoverproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_discover_cobrand_valid()
	{
		$this->_check_cobrand($this->discoverproviderid);
	}
	
	function test_discover_cobrand_101()
	{
		$this->_check_cobrand($this->discoverproviderid);
	}
	
	function test_discover_cobrand_102()
	{
		$this->_check_cobrand($this->discoverproviderid);
	}
	
	function test_discover_cobrand_103()
	{
		$this->_check_cobrand($this->discoverproviderid);
	}
	
	function test_discover_cobrand_104()
	{
		$this->_check_cobrand($this->discoverproviderid);
	}
	
	function test_discover_cobrand_105()
	{
		$this->_check_cobrand($this->discoverproviderid);
	}*/
//------------------------------------------------------
function test_eufora_cccom_valid()
	{
		$count = $this->_checkValid($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_eufora_cccom_101()
	{
		$count = $this->_check101($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_eufora_cccom_102()
	{
		$count = $this->_check102($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_eufora_cccom_103()
	{
		$count = $this->_check103($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_eufora_cccom_104()
	{
		$count = $this->_check104($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_eufora_cccom_105()
	{
		$count = $this->_check105($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_eufora_banner_valid()
	{
		$count = $this->_checkValid($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_eufora_banner_101()
	{
		$count = $this->_check101($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_eufora_banner_102()
	{
		$count = $this->_check102($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_eufora_banner_103()
	{
		$count = $this->_check103($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_eufora_banner_104()
	{
		$count = $this->_check104($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_eufora_banner_105()
	{
		$count = $this->_check105($this->euforaproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_eufora_cobrand_valid()
	{
		$this->_check_cobrand($this->euforaproviderid);
	}
	
	function test_eufora_cobrand_101()
	{
		$this->_check_cobrand($this->euforaproviderid);
	}
	
	function test_eufora_cobrand_102()
	{
		$this->_check_cobrand($this->euforaproviderid);
	}
	
	function test_eufora_cobrand_103()
	{
		$this->_check_cobrand($this->euforaproviderid);
	}
	
	function test_eufora_cobrand_104()
	{
		$this->_check_cobrand($this->euforaproviderid);
	}
	
	function test_eufora_cobrand_105()
	{
		$this->_check_cobrand($this->euforaproviderid);
	}*/
//------------------------------------------------------
function test_first_premier_cccom_valid()
	{
		$count = $this->_checkValid($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_first_premier_cccom_101()
	{
		$count = $this->_check101($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_first_premier_cccom_102()
	{
		$count = $this->_check102($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_first_premier_cccom_103()
	{
		$count = $this->_check103($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_first_premier_cccom_104()
	{
		$count = $this->_check104($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_first_premier_cccom_105()
	{
		$count = $this->_check105($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_first_premier_banner_valid()
	{
		$count = $this->_checkValid($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_first_premier_banner_101()
	{
		$count = $this->_check101($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_first_premier_banner_102()
	{
		$count = $this->_check102($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_first_premier_banner_103()
	{
		$count = $this->_check103($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_first_premier_banner_104()
	{
		$count = $this->_check104($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_first_premier_banner_105()
	{
		$count = $this->_check105($this->first_premierproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_first_premier_cobrand_valid()
	{
		$this->_check_cobrand($this->first_premierproviderid);
	}
	
	function test_first_premier_cobrand_101()
	{
		$this->_check_cobrand($this->first_premierproviderid);
	}
	
	function test_first_premier_cobrand_102()
	{
		$this->_check_cobrand($this->first_premierproviderid);
	}
	
	function test_first_premier_cobrand_103()
	{
		$this->_check_cobrand($this->first_premierproviderid);
	}
	
	function test_first_premier_cobrand_104()
	{
		$this->_check_cobrand($this->first_premierproviderid);
	}
	
	function test_first_premier_cobrand_105()
	{
		$this->_check_cobrand($this->first_premierproviderid);
	}*/
//------------------------------------------------------
function test_hsbc_gm_cccom_valid()
	{
		$count = $this->_checkValid($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_gm_cccom_101()
	{
		$count = $this->_check101($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_gm_cccom_102()
	{
		$count = $this->_check102($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_gm_cccom_103()
	{
		$count = $this->_check103($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_gm_cccom_104()
	{
		$count = $this->_check104($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_hsbc_gm_cccom_105()
	{
		$count = $this->_check105($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_hsbc_gm_banner_valid()
	{
		$count = $this->_checkValid($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_gm_banner_101()
	{
		$count = $this->_check101($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_gm_banner_102()
	{
		$count = $this->_check102($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_gm_banner_103()
	{
		$count = $this->_check103($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_gm_banner_104()
	{
		$count = $this->_check104($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_hsbc_gm_banner_105()
	{
		$count = $this->_check105($this->hsbc_gmproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_hsbc_gm_cobrand_valid()
	{
		$this->_check_cobrand($this->hsbc_gmproviderid);
	}
	
	function test_hsbc_gm_cobrand_101()
	{
		$this->_check_cobrand($this->hsbc_gmproviderid);
	}
	
	function test_hsbc_gm_cobrand_102()
	{
		$this->_check_cobrand($this->hsbc_gmproviderid);
	}
	
	function test_hsbc_gm_cobrand_103()
	{
		$this->_check_cobrand($this->hsbc_gmproviderid);
	}
	
	function test_hsbc_gm_cobrand_104()
	{
		$this->_check_cobrand($this->hsbc_gmproviderid);
	}
	
	function test_hsbc_gm_cobrand_105()
	{
		$this->_check_cobrand($this->hsbc_gmproviderid);
	}*/
//------------------------------------------------------
function test_hsbc_metris_cccom_valid()
	{
		$count = $this->_checkValid($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_metris_cccom_101()
	{
		$count = $this->_check101($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_metris_cccom_102()
	{
		$count = $this->_check102($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_metris_cccom_103()
	{
		$count = $this->_check103($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_metris_cccom_104()
	{
		$count = $this->_check104($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_hsbc_metris_cccom_105()
	{
		$count = $this->_check105($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_hsbc_metris_banner_valid()
	{
		$count = $this->_checkValid($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_metris_banner_101()
	{
		$count = $this->_check101($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_metris_banner_102()
	{
		$count = $this->_check102($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_metris_banner_103()
	{
		$count = $this->_check103($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_metris_banner_104()
	{
		$count = $this->_check104($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_hsbc_metris_banner_105()
	{
		$count = $this->_check105($this->hsbc_metrisproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_hsbc_metris_cobrand_valid()
	{
		$this->_check_cobrand($this->hsbc_metrisproviderid);
	}
	
	function test_hsbc_metris_cobrand_101()
	{
		$this->_check_cobrand($this->hsbc_metrisproviderid);
	}
	
	function test_hsbc_metris_cobrand_102()
	{
		$this->_check_cobrand($this->hsbc_metrisproviderid);
	}
	
	function test_hsbc_metris_cobrand_103()
	{
		$this->_check_cobrand($this->hsbc_metrisproviderid);
	}
	
	function test_hsbc_metris_cobrand_104()
	{
		$this->_check_cobrand($this->hsbc_metrisproviderid);
	}
	
	function test_hsbc_metris_cobrand_105()
	{
		$this->_check_cobrand($this->hsbc_metrisproviderid);
	}*/
//------------------------------------------------------
function test_hsbc_orchard_cccom_valid()
	{
		$count = $this->_checkValid($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_orchard_cccom_101()
	{
		$count = $this->_check101($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_orchard_cccom_102()
	{
		$count = $this->_check102($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_orchard_cccom_103()
	{
		$count = $this->_check103($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_orchard_cccom_104()
	{
		$count = $this->_check104($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_hsbc_orchard_cccom_105()
	{
		$count = $this->_check105($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_hsbc_orchard_banner_valid()
	{
		$count = $this->_checkValid($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_orchard_banner_101()
	{
		$count = $this->_check101($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_orchard_banner_102()
	{
		$count = $this->_check102($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_orchard_banner_103()
	{
		$count = $this->_check103($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_orchard_banner_104()
	{
		$count = $this->_check104($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_hsbc_orchard_banner_105()
	{
		$count = $this->_check105($this->hsbc_orchardproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_hsbc_orchard_cobrand_valid()
	{
		$this->_check_cobrand($this->hsbc_orchardproviderid);
	}
	
	function test_hsbc_orchard_cobrand_101()
	{
		$this->_check_cobrand($this->hsbc_orchardproviderid);
	}
	
	function test_hsbc_orchard_cobrand_102()
	{
		$this->_check_cobrand($this->hsbc_orchardproviderid);
	}
	
	function test_hsbc_orchard_cobrand_103()
	{
		$this->_check_cobrand($this->hsbc_orchardproviderid);
	}
	
	function test_hsbc_orchard_cobrand_104()
	{
		$this->_check_cobrand($this->hsbc_orchardproviderid);
	}
	
	function test_hsbc_orchard_cobrand_105()
	{
		$this->_check_cobrand($this->hsbc_orchardproviderid);
	}*/
//------------------------------------------------------
function test_hsbc_platinum_cccom_valid()
	{
		$count = $this->_checkValid($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_platinum_cccom_101()
	{
		$count = $this->_check101($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_platinum_cccom_102()
	{
		$count = $this->_check102($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_platinum_cccom_103()
	{
		$count = $this->_check103($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_platinum_cccom_104()
	{
		$count = $this->_check104($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_hsbc_platinum_cccom_105()
	{
		$count = $this->_check105($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_hsbc_platinum_banner_valid()
	{
		$count = $this->_checkValid($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_platinum_banner_101()
	{
		$count = $this->_check101($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_platinum_banner_102()
	{
		$count = $this->_check102($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_platinum_banner_103()
	{
		$count = $this->_check103($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_platinum_banner_104()
	{
		$count = $this->_check104($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_hsbc_platinum_banner_105()
	{
		$count = $this->_check105($this->hsbc_platinumproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_hsbc_platinum_cobrand_valid()
	{
		$this->_check_cobrand($this->hsbc_platinumproviderid);
	}
	
	function test_hsbc_platinum_cobrand_101()
	{
		$this->_check_cobrand($this->hsbc_platinumproviderid);
	}
	
	function test_hsbc_platinum_cobrand_102()
	{
		$this->_check_cobrand($this->hsbc_platinumproviderid);
	}
	
	function test_hsbc_platinum_cobrand_103()
	{
		$this->_check_cobrand($this->hsbc_platinumproviderid);
	}
	
	function test_hsbc_platinum_cobrand_104()
	{
		$this->_check_cobrand($this->hsbc_platinumproviderid);
	}
	
	function test_hsbc_platinum_cobrand_105()
	{
		$this->_check_cobrand($this->hsbc_platinumproviderid);
	}*/
//------------------------------------------------------
function test_hsbc_up_cccom_valid()
	{
		$count = $this->_checkValid($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_up_cccom_101()
	{
		$count = $this->_check101($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_up_cccom_102()
	{
		$count = $this->_check102($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_up_cccom_103()
	{
		$count = $this->_check103($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_hsbc_up_cccom_104()
	{
		$count = $this->_check104($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_hsbc_up_cccom_105()
	{
		$count = $this->_check105($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_hsbc_up_banner_valid()
	{
		$count = $this->_checkValid($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_hsbc_up_banner_101()
	{
		$count = $this->_check101($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_hsbc_up_banner_102()
	{
		$count = $this->_check102($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_up_banner_103()
	{
		$count = $this->_check103($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_hsbc_up_banner_104()
	{
		$count = $this->_check104($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_hsbc_up_banner_105()
	{
		$count = $this->_check105($this->hsbc_upproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_hsbc_up_cobrand_valid()
	{
		$this->_check_cobrand($this->hsbc_upproviderid);
	}
	
	function test_hsbc_up_cobrand_101()
	{
		$this->_check_cobrand($this->hsbc_upproviderid);
	}
	
	function test_hsbc_up_cobrand_102()
	{
		$this->_check_cobrand($this->hsbc_upproviderid);
	}
	
	function test_hsbc_up_cobrand_103()
	{
		$this->_check_cobrand($this->hsbc_upproviderid);
	}
	
	function test_hsbc_up_cobrand_104()
	{
		$this->_check_cobrand($this->hsbc_upproviderid);
	}
	
	function test_hsbc_up_cobrand_105()
	{
		$this->_check_cobrand($this->hsbc_upproviderid);
	}*/
//------------------------------------------------------
function test_icommissions_cccom_valid()
	{
		$count = $this->_checkValid($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_icommissions_cccom_101()
	{
		$count = $this->_check101($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_icommissions_cccom_102()
	{
		$count = $this->_check102($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_icommissions_cccom_103()
	{
		$count = $this->_check103($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_icommissions_cccom_104()
	{
		$count = $this->_check104($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_icommissions_cccom_105()
	{
		$count = $this->_check105($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_icommissions_banner_valid()
	{
		$count = $this->_checkValid($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_icommissions_banner_101()
	{
		$count = $this->_check101($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_icommissions_banner_102()
	{
		$count = $this->_check102($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_icommissions_banner_103()
	{
		$count = $this->_check103($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_icommissions_banner_104()
	{
		$count = $this->_check104($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_icommissions_banner_105()
	{
		$count = $this->_check105($this->icommissionsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_icommissions_cobrand_valid()
	{
		$this->_check_cobrand($this->icommissionsproviderid);
	}
	
	function test_icommissions_cobrand_101()
	{
		$this->_check_cobrand($this->icommissionsproviderid);
	}
	
	function test_icommissions_cobrand_102()
	{
		$this->_check_cobrand($this->icommissionsproviderid);
	}
	
	function test_icommissions_cobrand_103()
	{
		$this->_check_cobrand($this->icommissionsproviderid);
	}
	
	function test_icommissions_cobrand_104()
	{
		$this->_check_cobrand($this->icommissionsproviderid);
	}
	
	function test_icommissions_cobrand_105()
	{
		$this->_check_cobrand($this->icommissionsproviderid);
	}*/
//------------------------------------------------------
function test_ncs_cccom_valid()
	{
		$count = $this->_checkValid($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_ncs_cccom_101()
	{
		$count = $this->_check101($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_ncs_cccom_102()
	{
		$count = $this->_check102($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_ncs_cccom_103()
	{
		$count = $this->_check103($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_ncs_cccom_104()
	{
		$count = $this->_check104($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_ncs_cccom_105()
	{
		$count = $this->_check105($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_ncs_banner_valid()
	{
		$count = $this->_checkValid($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_ncs_banner_101()
	{
		$count = $this->_check101($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_ncs_banner_102()
	{
		$count = $this->_check102($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_ncs_banner_103()
	{
		$count = $this->_check103($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_ncs_banner_104()
	{
		$count = $this->_check104($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_ncs_banner_105()
	{
		$count = $this->_check105($this->ncsproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_ncs_cobrand_valid()
	{
		$this->_check_cobrand($this->ncsproviderid);
	}
	
	function test_ncs_cobrand_101()
	{
		$this->_check_cobrand($this->ncsproviderid);
	}
	
	function test_ncs_cobrand_102()
	{
		$this->_check_cobrand($this->ncsproviderid);
	}
	
	function test_ncs_cobrand_103()
	{
		$this->_check_cobrand($this->ncsproviderid);
	}
	
	function test_ncs_cobrand_104()
	{
		$this->_check_cobrand($this->ncsproviderid);
	}
	
	function test_ncs_cobrand_105()
	{
		$this->_check_cobrand($this->ncsproviderid);
	}*/
//------------------------------------------------------
function test_netspend_cccom_valid()
	{
		$count = $this->_checkValid($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_netspend_cccom_101()
	{
		$count = $this->_check101($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_netspend_cccom_102()
	{
		$count = $this->_check102($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_netspend_cccom_103()
	{
		$count = $this->_check103($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	
	function test_netspend_cccom_104()
	{
		$count = $this->_check104($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	/*function test_netspend_cccom_105()
	{
		$count = $this->_check105($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	function test_netspend_banner_valid()
	{
		$count = $this->_checkValid($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	
	function test_netspend_banner_101()
	{
		$count = $this->_check101($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 3);
	}
	
	function test_netspend_banner_102()
	{
		$count = $this->_check102($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_netspend_banner_103()
	{
		$count = $this->_check103($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 1);
	}
	function test_netspend_banner_104()
	{
		$count = $this->_check104($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}
	/*function test_netspend_banner_105()
	{
		$count = $this->_check105($this->netspendproviderid, 'cccom', 0);
		$this->assertequals($count, 2);
	}*/
	
	/*function test_netspend_cobrand_valid()
	{
		$this->_check_cobrand($this->netspendproviderid);
	}
	
	function test_netspend_cobrand_101()
	{
		$this->_check_cobrand($this->netspendproviderid);
	}
	
	function test_netspend_cobrand_102()
	{
		$this->_check_cobrand($this->netspendproviderid);
	}
	
	function test_netspend_cobrand_103()
	{
		$this->_check_cobrand($this->netspendproviderid);
	}
	
	function test_netspend_cobrand_104()
	{
		$this->_check_cobrand($this->netspendproviderid);
	}
	
	function test_netspend_cobrand_105()
	{
		$this->_check_cobrand($this->netspendproviderid);
	}*/
//------------------------------------------------------
}
		
?>
