<?php
/**
 * 
 * Campaign Object
 * UNIT TESTS 
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Campaign'); 

class TEST_Affiliate_Merchants_Bl_Campaign extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_Campaign( $name = 'TEST_Affiliate_Merchants_Bl_Campaign' ) 
	{
		$this->TestCase( $name );
	}
	
	function setUp() 
	{			                    
		$this->_insertNewCampaigns();
	}
	
	function tearDown() 
	{
		$this->_deleteCampaigns($this->trans);

	}
	
	function _insertNewCampaigns(){
		$sql = 'INSERT INTO wd_pa_campaigns (campaignid, name) VALUES ("1TEST", "TESTCASE1")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = 'INSERT INTO wd_pa_campaigns (campaignid, name) VALUES ("2TEST", "TESTCASE2")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = 'INSERT INTO wd_pa_campaigns (campaignid, name) VALUES ("3TEST", "TESTCASE3")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = 'INSERT INTO wd_pa_campaigns (campaignid, name) VALUES ("4TEST", "TESTCASE4")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'INSERT INTO wd_pa_campaigntypemap (campaignid, campaigntypeid) VALUES ("1TEST", "FOO")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = 'INSERT INTO wd_pa_campaigntypemap (campaignid, campaigntypeid) VALUES ("2TEST", "TESTCASE")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = 'INSERT INTO wd_pa_campaigntypemap (campaignid, campaigntypeid) VALUES ("3TEST", "TESTCASE")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = 'INSERT INTO wd_pa_campaigntypemap (campaignid, campaigntypeid) VALUES ("4TEST", "TESTCASE")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'INSERT INTO wd_pa_campaigntypes (typeid, typename) VALUES ("TESTCASE", "TEST")';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	
	function _deleteCampaigns(){
		$sql = 'DELETE FROM wd_pa_campaigns WHERE campaignid LIKE "%TEST%"';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'DELETE FROM wd_pa_campaigntypemap WHERE campaignid LIKE "%TEST%"';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'DELETE FROM wd_pa_campaigntypes WHERE typeid LIKE "%TESTCASE%"';
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);	
	}
	
	function testGetCampaignsInSet(){
		$set= array('1TEST',
					'2TEST',
					'4TEST');
		$rs = Affiliate_Merchants_Bl_Campaign::getCampaignsInSet($set);
		while($rs && !$rs->EOF){
			if(!in_array($rs->fields['campaignid'], $set))
				$failures[] = $rs->fields['campaignid'];
			$rs->MoveNext();
		}
		$this->Assert(sizeof($failures) == 0);
	}

	function testGetAllCampaignsWithExclude(){
		$exclude= array('1TEST',
						'3TEST',
						'4TEST');
		$rs = Affiliate_Merchants_Bl_Campaign::getAllCampaignsWithExclude($exclude);
		while($rs && !$rs->EOF){
			if(in_array($rs->fields['campaignid'], $exclude))
				$failures[] = $rs->fields['campaignid'];
			$rs->MoveNext();
		}
		$this->Assert(sizeof($failures) == 0);
	}

	function testGetCampaignsByCampaignType(){
		$expected = array('2TEST',
						'3TEST',
						'4TEST');
		$rs = Affiliate_Merchants_Bl_Campaign::getCampaignsByCampaignType('TESTCASE');
		while($rs && !$rs->EOF){
			if(!in_array($rs->fields['campaignid'], $expected))
				$failures[] = $rs->fields['campaignid'];
				$returned[] = $rs->fields['campaignid'];
			$rs->MoveNext();
		}
		foreach($expected as $value){
			if(!in_array($value, $returned)){
				$failures[] = $value;
			}
		}
		
		$this->Assert(sizeof($failures)==0);
	}
}