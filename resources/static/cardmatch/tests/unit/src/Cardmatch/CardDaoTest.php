<?php


class Cardmatch_CardDaoTest extends Cardmatch_DbTestCase {


	public function getDataSet() {


		$datasets = array(
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.rt_cards.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.rt_carddetails.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.cs_carddata.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.cs_merchants.xml"),
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/ccdata.card_ranks.xml"),
		);

		$dataset = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);

		return $dataset;
	}


	public function testGetCardById() {

		$id = 1;
		$cardDao = new Cardmatch_CardDao();
		$card = $cardDao->getCardById($id);

		$this->assertEquals('Unit Testing Card 1', $card->getName());
	}

	public function testGetResultCategoryCount() {

		$dao = new Cardmatch_CardDao();

		$ids = array(1,2,3,4,5);

		$counts = $dao->getResultCategoryCount($ids);

		$expectedCounts = array(
			1 => 2,
			2 => 1,
		);

		$this->assertEquals($expectedCounts, $counts);


	}

}
