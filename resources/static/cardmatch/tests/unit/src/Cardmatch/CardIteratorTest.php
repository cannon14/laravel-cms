<?php

class Cardmatch_CardIteratorTest extends Cardmatch_DbTestCase {


	public function getDataSet() {


		$datasets = array(
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.rt_cards.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.rt_carddetails.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.cs_carddata.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.cs_merchants.xml"),
		);

		$dataset = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);

		return $dataset;
	}

	public function testBuildFromRow() {

		$cardDao = new Cardmatch_CardDao();

		$cards = array(
			'1',
			'2',
			'3', // inactive
			'4', // deleted
		);

		$results = $cardDao->getCards($cards);
		$this->assertCount(2, $results);


	}

}
