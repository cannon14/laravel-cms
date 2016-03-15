<?php


class Cardmatch_Client_Barclay_ApplicantInfoTest extends PHPUnit_Framework_TestCase {

	public function testIsSSNValid() {
		$info = new Cardmatch_Client_Barclay_ApplicantInfo();

		$info->setLast4SSN('123');
		$this->assertFalse($info->isSSNValid());

		$info->setLast4SSN('12345');
		$this->assertFalse($info->isSSNValid());

		$info->setLast4SSN('1234');
		$this->assertTrue($info->isSSNValid());

		$this->assertEquals('1234', $info->getLast4SSN());

		$info->setLast4SSN('');
		$this->assertTrue($info->isSSNValid());

	}


	public function testIsValid(){

		$info = new Cardmatch_Client_Barclay_ApplicantInfo();
		$this->assertFalse($info->isValid());

		$info->setLast4SSN('7890');

		$name = new Cardmatch_Client_Barclay_Name('PHP', 'Unit', 'Testing');
		$info->setName($name);

		$address = new Cardmatch_Client_Barclay_Address();
		$address->setAddressLine1('8920 Business Park Dr');
		$address->setAddressLine2('Suite 350');
		$address->setCity('Austin');
		$address->setState('TX');
		$address->setZip('78759');
		$info->setAddress($address);

		$this->assertTrue($info->isValid());


		return $info;

	}


	/**
	 * @depends testIsValid
	 * @param $info
	 */
	public function testInfoIsMissing(Cardmatch_Client_Barclay_ApplicantInfo $info){

		$info->setLast4SSN('123');
		$this->assertFalse($info->isValid(), 'SSN validation failed');
		$info->setLast4SSN('7890');
		$this->assertTrue($info->isValid());

		$name = $info->getName();
		$name->setFirst('');
		$this->assertFalse($info->isValid(), 'Name validation failed');
		$name->setFirst('PHP');
		$this->assertTrue($info->isValid());


	}
}
