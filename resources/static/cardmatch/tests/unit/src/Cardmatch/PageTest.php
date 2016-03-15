<?php


class PageTest extends Cardmatch_DbTestCase {

	public function getDataSet() {

		$dataset = $this->createMySQLXMLDataSet(FIXTURES_PATH.'/ccdata_test.rt_cardpagemap.xml');

		return $dataset;
	}


	public function testGetCardOrdering() {

		$page = new Cardmatch_Page();
		$ordering = $page->getCardOrdering(1);

		$expected = array(
			'22034411' => 1,
			'22264552' => 2,
			'22124546' => 3,
			'22144464' => 4,
			'22184477' => 5,
		);

		$this->assertEquals($expected, $ordering);

	}


}
