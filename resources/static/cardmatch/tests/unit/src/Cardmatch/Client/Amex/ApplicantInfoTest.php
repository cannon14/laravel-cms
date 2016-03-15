<?php


class Cardmatch_Client_Amex_ApplicantInfoTest extends PHPUnit_Framework_TestCase {

	public function testIsSSNValid() {
		$info = new Cardmatch_Client_Amex_ApplicantInfo();

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

	public function testIsLeadOfferValid() {

		$info = new Cardmatch_Client_Amex_ApplicantInfo();

		$this->assertFalse($info->isLeadOfferFlagValid());

		$info->setLeadOfferFlag('I'); // Invalid value
		$this->assertFalse($info->isLeadOfferFlagValid());

		$info->setLeadOfferFlag('C');
		$this->assertTrue($info->isLeadOfferFlagValid());

		$info->setLeadOfferFlag('O');
		$this->assertTrue($info->isLeadOfferFlagValid());

	}

	public function testIsValid(){

		$info = new Cardmatch_Client_Amex_ApplicantInfo();
		$this->assertFalse($info->isValid());

		$info->setRequestTimeStamp(date('c'));
		$info->setLast4SSN('7890');

		$name = new Cardmatch_Client_Amex_Name('PHP', 'Unit', 'Testing');
		$info->setName($name);

		$info->setLeadOfferFlag('C');

		$address = new Cardmatch_Client_Amex_Address();
		$address->setAddressLine1('8920 Business Park Dr');
		$address->setAddressLine2('Suite 350');
		$address->setCity('Austin');
		$address->setState('TX');
		$address->setZip('78759');
		$info->setHomeAddress($address);

		$info->setChannelId(1);
		$info->setPmcVendorCode('cccomus');
		$info->setExperienceId(1);

		$this->assertTrue($info->isValid());

		$info->setLeadOfferFlag('O');
		$this->assertFalse($info->isValid());

		$info->setLeadOfferFlag('invalid');
		$this->assertFalse($info->isValid());

		$info->setLeadOfferFlag('C');
		$this->assertTrue($info->isValid());


		return $info;

	}


	/**
	 * @depends testIsValid
	 * @param $info
	 */
	public function testInfoIsMissing(Cardmatch_Client_Amex_ApplicantInfo $info){

		$info->setRequestTimeStamp('');
		$this->assertFalse($info->isValid(), 'Request timestamp validation failed');

		$info->setRequestTimeStamp('123456');
		$this->assertTrue($info->isValid());

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



	/**
	 * @depends testIsValid
	 * @param $info
	 */
	public function testErrors(Cardmatch_Client_Amex_ApplicantInfo $info){

		$this->assertFalse($info->hasErrors());

		$info->setRequestTimeStamp('');
		$this->assertFalse($info->isValid(), 'Request timestamp validation failed');

		$this->assertTrue($info->hasErrors());
		$errors = $info->getErrors();
		$error = $errors[0];

		$this->assertEquals('requestTimeStamp is required', $error);

		$info->setRequestTimeStamp('123456');
		$this->assertTrue($info->isValid());

		$this->assertFalse($info->hasErrors());


	}

	public function testGetSet() {
		$info = new Cardmatch_Client_Amex_ApplicantInfo();

		$now = date('c');
		$name = 'CreditCards.com';

		$info->setBusinessName($name);
		$info->setRequestTimeStamp($now);

		$this->assertEquals($name, $info->getBusinessName());
		$this->assertEquals($now, $info->getRequestTimeStamp());



	}




}
