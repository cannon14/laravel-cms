<?php


class Cardmatch_UserTest extends PHPUnit_Framework_TestCase {

	public function testSettersAndGetters() {

		$user = $this->getTestUser();

		$this->assertEquals('PHP', $user->getFirstName());
		$this->assertEquals('U', $user->getMiddleInitial());
		$this->assertEquals('Testing', $user->getLastName());
		$this->assertEquals('0123456789', $user->getSSN());
		$this->assertEquals('8920 Business Park Dr', $user->getStreetAddress());
		$this->assertEquals('Austin', $user->getCity());
		$this->assertEquals('TX', $user->getState());
		$this->assertEquals('78759', $user->getZipCode());

	}


	public function testUserIsValid() {

		$user = $this->getTestUser();
		$this->assertTrue($user->isValid());
		$user->setFirstName('');
		$this->assertFalse($user->isValid());

	}


	public function getTestUser() {

		$user = new Cardmatch_User();

		$user->setFirstName('PHP');
		$user->setMiddleInitial('U');
		$user->setLastName('Testing');
		$user->setSSN('0123456789');
		$user->setStreetAddress('8920 Business Park Dr');
		$user->setCity('Austin');
		$user->setState('TX');
		$user->setZipCode('78759');

		return $user;
	}


}
