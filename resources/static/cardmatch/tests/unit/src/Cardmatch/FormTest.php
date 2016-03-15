<?php


class FormTest extends PHPUnit_Framework_TestCase {

	public function testFormIsValid() {

		$form = new Cardmatch_Form();

		$data = array();
		$this->assertFalse($form->isValid($data));

		$data = array(
			'firstName' => 'PHP',
			'middleInitial' => 'U',
			'lastName' => 'Testing',
			'streetAddress' => '8920 Business Park Dr',
			'city' => 'Austin',
			'state' => 'TX',
			'zipCode' => '78759',
			'ssn' => '1234',
		);

		$this->assertTrue($form->isValid($data));

		return $data;

	}

	/**
	 * @param $data
	 * @depends testFormIsValid
	 */
	public function testValidateSSN($data) {

		$form = new Cardmatch_Form();

		$data['ssn'] = '123';
		$this->assertFalse($form->isValid($data));

		$data['ssn'] = '12345';
		$this->assertFalse($form->isValid($data));

		$data['ssn'] = '1234';
		$this->assertTrue($form->isValid($data));



	}
}
