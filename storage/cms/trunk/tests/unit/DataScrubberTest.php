<?php

require(CMS_ROOT.'/cmsCore/include/csCore/DB/DataScrubber.class.php');

class DataScrubberTest extends PHPUnit_Framework_TestCase
{

	
	function test_find_primary_key()
	{
		$testScrubber = new csCore_DB_DataScrubber();
		$testKey = $testScrubber->_findPrimaryKey('rt_carddetails');
		$this->assertEquals('id', $testKey);
	}
	
	function test_replace()
	{
		$find = "\'";
		$replace = "'";
		$testScrubber = new csCore_DB_DataScrubber();
		$count = $testScrubber->replace($find, $replace, 'rt_carddetails', 'cardDetailText');
		$this->assertGreaterThanOrEqual(0, $count);
	}
		
}