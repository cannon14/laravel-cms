<?php


class Cardmatch_RowIteratorTest extends Cardmatch_DbTestCase {

	/** @var Cardmatch_RowIterator */
	private $_iterator;

	public function getDataSet() {


		$dataset = $this->createMySQLXMLDataSet(FIXTURES_PATH.'/ccdata_test.rt_cardpagemap.xml');

		return $dataset;
	}

	public function setUp() {

		$db = Cardmatch_Database::getInstance();
		$resultSet = $db->query('SELECT * FROM ccdata_test.rt_cardpagemap', array());

		$this->_iterator = $this->getMockForAbstractClass('Cardmatch_RowIterator', array($resultSet));

		$this->_iterator->expects($this->any())
				->method('_buildFromRow')
				->will($this->returnValue(array()));

	}

	public function testGetLength() {
		$this->assertEquals(5, $this->_iterator->length());
	}

	public function testHasNext() {

		for($i = 0; $i<5; $i++) {
			$this->assertTrue($this->_iterator->hasNext());
			$this->_iterator->getNext();
		}

		$this->assertFalse($this->_iterator->hasNext());

		$this->_iterator->rewind();
		$this->assertTrue($this->_iterator->hasNext());

	}

}
