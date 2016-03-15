<?php

class TEST_REV_PARSER_SYSTEM extends TestCase{
	var $testcase;	

    function TEST_REV_PARSER_SYSTEM( $name = 'TEST_REV_PARSER_SYSTEM' )
	{
		$this->TestCase( $name );
	}
	
	function setUp() 
	{
		$rate = array(
				"rate" => 93.93,
				"campaign_id" => VALID_RATE,
				"rate_start_date" => '2006-01-01',
				"rate_end_date" => '0000-00-00',
				"active" => 1
				);
				
		$sql = 'INSERT INTO ' . RATE_TABLE . ' (`'. implode('`,`', array_keys($rate)) .'`) VALUES ("'.implode('","',array_values($rate)).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$rate = array(
				"rate" => 0,
				"campaign_id" => INVALID_RATE,
				"rate_start_date" => '2006-02-02',
				"rate_end_date" => '0000-00-00',
				"active" => 1
				);
				
		$sql = 'INSERT INTO ' . RATE_TABLE . ' (`'. implode('`,`', array_keys($rate)) .'`) VALUES ("'.implode('","',array_values($rate)).'")';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function tearDown() 
	{

	}
	
	function test_prelim()
	{

		if ($handle = opendir('testscripts')) {
		   while (false !== ($file = readdir($handle))) {
		       if ($file != "." && $file != ".." && $file != "CVS") {
		           $test = new TestBrief($file);
				   $test->compile();
		       }
		   }
		   closedir($handle);
		}	

	
		
	}
}
?>