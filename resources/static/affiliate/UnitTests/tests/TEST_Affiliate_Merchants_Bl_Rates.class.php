<?php
/**
 * 
 * Rates Object
 * UNIT TESTS 
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick.mizer@creditcards.com>
 * 
 */ 

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate'); 

class TEST_Affiliate_Merchants_Bl_Rates extends TestCase
{
	var $testcase;
		
	function TEST_Affiliate_Merchants_Bl_Rates( $name = "TEST_Affiliate_Merchants_Bl_Rates" ) 
	{
		$this->TestCase( $name );
	}
	
	function setUp() 
	{
		$this->ids = array();
		$this->rate1 = array(
								'startdate' 	=> '',
								'enddate' 		=> '',
								'rate' 			=> 1,
								'active'		=> 1,
								'campaignid'	=> '123456',
							);
		
		$this->rate2 = array(
								'startdate' 	=> '',
								'enddate' 		=> '',
								'rate' 			=> 2,
								'active'		=> 1,
								'campaignid'	=> '123456',
							);
							
	}
	
	function tearDown() 
	{
		Affiliate_Merchants_Bl_Rate::deleteRates($this->ids);
		Affiliate_Merchants_Bl_Rate::deleteRatesByCampaignId('123456');
	}
	
	function test_adjust_back()
	{
		
		$this->rate1['startdate'] = '2007-01-01';
		$this->rate1['enddate'] = '2007-02-01';
		
		$this->rate2['startdate'] = '2007-01-15';
		$this->rate2['enddate'] = '2007-02-15';
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$origRate1 = Affiliate_Merchants_Bl_Rate::getRateById($this->ids[count($this->ids) - 2]);
		 
		$this->assertEquals($origRate1['enddate'], '2007-01-14');
		
		$this->tearDown();
		
		$this->rate1['startdate'] = '2007-01-01';
		$this->rate1['enddate'] = '0000-00-00';
		
		$this->rate2['startdate'] = '2007-01-15';
		$this->rate2['enddate'] = '0000-00-00';
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$origRate1 = Affiliate_Merchants_Bl_Rate::getRateById($this->ids[count($this->ids) - 2]);
		 
		$this->assertEquals($origRate1['enddate'], '2007-01-14');	
	}
	
	function test_adjust_front()
	{
		$this->rate1['startdate'] = '2007-01-15';
		$this->rate1['enddate'] = '2007-02-15';
		
		$this->rate2['startdate'] = '2007-01-01';
		$this->rate2['enddate'] = '2007-02-01';		
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$origRate1 = Affiliate_Merchants_Bl_Rate::getRateById($this->ids[count($this->ids) - 2]);
		 
		$this->assertEquals($origRate1['startdate'], '2007-02-02');
		
		$this->tearDown();
		
		$this->rate1['startdate'] = '2007-01-15';
		$this->rate1['enddate'] = '0000-00-00';
		
		$this->rate2['startdate'] = '2007-01-01';
		$this->rate2['enddate'] = '2007-02-15';	
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$origRate1 = Affiliate_Merchants_Bl_Rate::getRateById($this->ids[count($this->ids) - 2]);
		 
		$this->assertEquals($origRate1['startdate'], '2007-02-16');		
	}
	
	function test_adjust_obsolete()
	{

		
		$this->rate1['startdate'] = '2007-01-15';
		$this->rate1['enddate'] = '2007-02-15';
		
		$this->rate2['startdate'] = '2007-01-01';
		$this->rate2['enddate'] = '2007-03-01';		
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$origRate1 = Affiliate_Merchants_Bl_Rate::getRateById($this->ids[count($this->ids) - 2]);
		 
		$this->assertEquals($origRate1['active'], '0');
		
		$this->tearDown();
		
		$this->rate1['startdate'] = '2007-01-15';
		$this->rate1['enddate'] = '0000-00-00';
		
		$this->rate2['startdate'] = '2007-01-01';
		$this->rate2['enddate'] = '0000-00-00';	
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$origRate1 = Affiliate_Merchants_Bl_Rate::getRateById($this->ids[count($this->ids) - 2]);
		 
		$this->assertEquals($origRate1['active'], '0');		
	}	
	
	function test_adjust_middle()
	{
		$this->rate1['startdate'] = '2007-01-15';
		$this->rate1['enddate'] = '2007-03-15';
		
		$this->rate2['startdate'] = '2007-02-01';
		$this->rate2['enddate'] = '2007-03-01';		
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$rates = Affiliate_Merchants_Bl_Rate::getActiveRatesByCampaignId('123456');
		
		$begin = $end = $middle = false;
		
		foreach($rates as $rate){
			if($rate['startdate'] == '2007-02-01' && $rate['enddate'] == '2007-03-01'){
				$middle = true;
				continue;
			}
			if($rate['startdate'] == '2007-01-15' && $rate['enddate'] == '2007-01-31'){
				$begin = true;
				continue;
			}
			if($rate['startdate'] == '2007-03-02' && $rate['enddate'] == '2007-03-15'){
				$end = true;
				continue;
			}						
		}
		 
		$this->assert($begin && $end && $middle);
		
		$this->tearDown();
		
		$this->rate1['startdate'] = '2007-01-15';
		$this->rate1['enddate'] = '0000-00-00';
		
		$this->rate2['startdate'] = '2007-02-01';
		$this->rate2['enddate'] = '2007-03-01';		
		
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate1);
		$this->ids[] = Affiliate_Merchants_Bl_Rate::insertRate($this->rate2);
		 
		$rates = Affiliate_Merchants_Bl_Rate::getActiveRatesByCampaignId('123456');
		
		$begin = $end = $middle = false;
		
		foreach($rates as $rate){
			if($rate['startdate'] == '2007-02-01' && $rate['enddate'] == '2007-03-01'){
				$middle = true;
				continue;
			}
			if($rate['startdate'] == '2007-01-15' && $rate['enddate'] == '2007-01-31'){
				$begin = true;
				continue;
			}
			if($rate['startdate'] == '2007-03-02' && $rate['enddate'] == '0000-00-00'){
				$end = true;
				continue;
			}						
		}
		 
		$this->assert($begin && $end && $middle);		
		
	}

				
}

			
?>
