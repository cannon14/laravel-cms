<?php


class SegmentTest extends PHPUnit_Framework_TestCase {

	public function testSettersAndGetters() {

		$segment = new Cardmatch_Client_TransUnion_Segment('unit', 10, 'test');

		$this->assertEquals('unit', $segment->getPrefix());
		$this->assertEquals('10', $segment->getLength());
		$this->assertEquals('test', $segment->getData());

		$segment->setPrefix('phpunit');
		$segment->setLength(15);
		$segment->setData('testing');

		$this->assertEquals('phpunit', $segment->getPrefix());
		$this->assertEquals('15', $segment->getLength());
		$this->assertEquals('testing', $segment->getData());

	}

	public function testSegmentLength() {

		$segment1 = new Cardmatch_Client_TransUnion_Segment('unit', 10, 'test');
		$expected = 'unittest  ';
		$this->assertEquals($expected, $segment1->getRequestString());


		$segment2 = new Cardmatch_Client_TransUnion_Segment('phpunit', 10, 'testing');
		$expected = 'phpunittes';
		$this->assertEquals($expected, $segment2->getRequestString());

	}

}
