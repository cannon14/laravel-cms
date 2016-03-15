<?php

class Cardmatch_Client_Barclay_NameTest extends PHPUnit_Framework_TestCase {

	public function testSettersAndGetters() {
		$name = new Cardmatch_Client_Barclay_Name('Kenneth', 'K', 'Skertchly');
		$this->assertEquals('Kenneth', $name->getFirst());
		$this->assertEquals('K', $name->getMiddle());
		$this->assertEquals('Skertchly', $name->getLast());
	}

	public function testIsValid() {
		$name = new Cardmatch_Client_Barclay_Name();
		$this->assertFalse($name->isValid());

		$name->setMiddle('K');
		$this->assertFalse($name->isValid());

		$name->setFirst('Kenneth');
		$this->assertFalse($name->isValid());

		$name->setLast('Skertchly');
		$this->assertTrue($name->isValid());

		$name->setFirst('');
		$this->assertFalse($name->isValid());

	}

}
