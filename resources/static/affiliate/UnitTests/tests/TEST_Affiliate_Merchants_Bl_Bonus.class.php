<?php
/**
 * 
 * Bonus Object
 * UNIT TESTS 
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Bonus'); 

class TEST_Affiliate_Merchants_Bl_Bonus extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_Bonus( $name = 'TEST_Affiliate_Merchants_Bl_Bonus' ) 
	{
		$this->TestCase( $name );
	}
	function setUp() 
	{	
		$now = mktime(date('H:i:s m/d/Y'));
		$this->dateConditions = array(  'pagination'	=> false,
										'rowsPerPage'	=>	10,
					                    'from'			=>  $now-60,
					                    'to'			=>	$now+60,
					                    'orderby'		=>	'ORDER BY providerprocessdate ASC',
					                    'page'			=>	0);
					                    
		$this->campaignConditions = array(  'pagination'	=> false,
										'rowsPerPage'	=>	10,
					                    'from'			=>  $now-60,
					                    'to'			=>	$now+60,
					                    'orderby'		=>	'ORDER BY providerprocessdate ASC',
					                    'page'			=>	0,
					                    'campcategory'	=> array('1TEST', '2TEST', '4TEST'));
		$this->_insertNewTrans();
	}
	
	function tearDown() 
	{
		$this->_deleteTrans();

	}
	
	function _insertNewTrans(){
		$sql = "INSERT INTO wd_pa_transactions (transid, providerprocessdate, transtype, reftrans, campcategoryid, estimatedrevenue) VALUES ('1TEST', NOW(), 4, '1TEST', 'TESTCASE', 25)";
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "INSERT INTO wd_pa_transactions (transid, providerprocessdate, transtype, reftrans, campcategoryid) VALUES ('2TEST', NOW(), 2, '1TEST', 'TESTCASE')";
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "INSERT INTO wd_pa_campaigncategories (campcategoryid, campaignid) VALUES ('TESTCASE', '1TEST')";
		QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function _deleteTrans(){		
		$sql = 'DELETE FROM wd_pa_campaigncategories WHERE campcategoryid LIKE "%TESTCASE%"';
		$rs=QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = 'DELETE FROM wd_pa_transactions WHERE reftrans LIKE "%TEST%"';
		$rs=QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo '<hr>'.$sql.'<hr>';
	}
	
	function testDateRange(){
		$rs = Affiliate_Merchants_Bl_Bonus::getTransactions($this->dateConditions);
		$outcome = false;
		while($rs && !$rs->EOF){
			if($rs->fields['transid'] == '1TEST')
				$outcome = true;
			$rs->MoveNext();
		}
		$this->AssertEquals($outcome, true);
	}
	
	function testDateRangeAndCampaignSet(){
		$rs = Affiliate_Merchants_Bl_Bonus::getTransactions($this->campaignConditions);
		$outcome = false;
		while($rs && !$rs->EOF){
			if($rs->fields['transid'] == '1TEST')
				$outcome = true;
			$rs->MoveNext();
		}
		$this->AssertEquals($outcome, true);
	}
	
	function testInsertBonus(){
		$rs = Affiliate_Merchants_Bl_Bonus::getTransactions($this->dateConditions);
		//echo'<pre>';print_r($rs);echo'</pre>';
		
		while($rs && !$rs->EOF){
			Affiliate_Merchants_Bl_Bonus::insertBonus(500, $rs->fields);
			$rs->MoveNext();
		}
		
		$rs = Affiliate_Merchants_Bl_Bonus::getTransactions($this->dateConditions);
		$outcome = false;
		
		//echo'<pre>';print_r($rs);echo'</pre>';		
		
		while($rs && !$rs->EOF){
			if($rs->fields['reftrans'] == '1TEST' && $rs->fields['totalestimatedrevenue']==525)
				$outcome = true;
			$rs->MoveNext();
		}		
		$this->AssertEquals($outcome, true);
	}
}