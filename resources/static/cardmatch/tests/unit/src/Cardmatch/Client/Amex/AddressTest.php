<?php

class Cardmatch_Client_Amex_AddressTest extends PHPUnit_Framework_TestCase {

	public function testIsValid() {
		$address = new Cardmatch_Client_Amex_Address();
		$this->assertFalse($address->isValid());

		$address->setAddressLine1('8920 Business Park Dr');
		$address->setAddressLine2('Suite 350');
		$this->assertFalse($address->isValid());

		$address->setCity('Austin');
		$this->assertFalse($address->isValid());

		$address->setState('TX');
		$this->assertFalse($address->isValid());

		$address->setZip('78759');
		$this->assertTrue($address->isValid());


	}

	public function testAddressToString() {

		$address = new Cardmatch_Client_Amex_Address();

		$address->setAddressLine1('8920 Business Park Dr');
		$address->setAddressLine2('Suite 350');
		$address->setCity('Austin');
		$address->setState('TX');
		$address->setZip('78759');

		$fullAddress = "8920 Business Park Dr\nSuite 350\nAustin TX 78759";
		$this->assertEquals($fullAddress, $address->__toString());
	}

}
