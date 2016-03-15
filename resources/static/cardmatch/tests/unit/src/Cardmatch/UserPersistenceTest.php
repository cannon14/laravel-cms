<?php


class Cardmatch_UserPersistenceTest extends PHPUnit_Framework_TestCase {

	public function testScrubUserNameData() {

		$config = new Zend_Config_Ini(CARDMATCH_PATH . '/config/channels.ini', APPLICATION_ENV);

		$persistenceMock = $this->getMock('Cardmatch_UserPersistence', ['setCookie'], [$config->cache->cookie]);
		$persistenceMock->expects($this->any())->method('setCookie')->will($this->returnValue(true));

		$user = $this->getTestUser();
		$persistenceMock->persist($user);

		$savedUser = $persistenceMock->getCurrentUser();

		$this->assertNotEmpty($savedUser->getFirstName());
		$this->assertNotEmpty($savedUser->getLastName());

		$this->assertNotEmpty($savedUser->getStreetAddress());
		$this->assertNotEmpty($savedUser->getCity());
		$this->assertNotEmpty($savedUser->getState());
		$this->assertNotEmpty($savedUser->getZipCode());
		$this->assertNotEmpty($savedUser->getSSN());

		$persistenceMock->clearUserName();
		$savedUser = $persistenceMock->getCurrentUser();

		/**
		 * The name should be empty now, but
		 * everything else should still be there
		 */
		$this->assertEmpty($savedUser->getFirstName());
		$this->assertEmpty($savedUser->getLastName());

		$this->assertNotEmpty($savedUser->getStreetAddress());
		$this->assertNotEmpty($savedUser->getCity());
		$this->assertNotEmpty($savedUser->getState());
		$this->assertNotEmpty($savedUser->getZipCode());
		$this->assertNotEmpty($savedUser->getSSN());

		$persistenceMock->clearUserData();
		$savedUser = $persistenceMock->getCurrentUser();

		/**
		 * Everything should be cleared out now
		 */
		$this->assertEmpty($savedUser->getMiddleInitial());
		$this->assertEmpty($savedUser->getStreetAddress());
		$this->assertEmpty($savedUser->getCity());
		$this->assertEmpty($savedUser->getState());
		$this->assertEmpty($savedUser->getZipCode());
		$this->assertEmpty($savedUser->getSSN());

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
