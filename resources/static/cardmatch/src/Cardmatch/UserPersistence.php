<?php

class Cardmatch_UserPersistence {

	/**
	 * @var Zend_Config
	 */
	private $_config;

	private $_user;

	public function __construct(Zend_Config $config = null) {

		$this->_config = $config;
		$this->_user = $this->getCurrentUser();
		$this->_logger = Cardmatch_Logger::getInstance();
	}


	public function persist(Cardmatch_User $user) {

		$serializedUser = base64_encode(serialize($user));

		$_SESSION['user'] = $serializedUser;

		$this->_logger->logServer('Stored user info in session');
		$this->_logger->insane(json_encode($_SERVER));

		$cookieName = $this->_config->name->username;
		$ttl = $this->_config->ttl;
		$path = $this->_config->path;
		$domain = $this->_config->domain;

		if ($user->getFirstName() != '' && $user->getLastName() != '') {
			$value = $user->getFirstName().','.$user->getLastName();
			$this->setCookie($cookieName, $value, time() + $ttl, $path, $domain);
		}

		$this->_user = $user;
	}

	public function removeFromPersistence()
	{
		$cookieName = $this->_config->name->username;
		$path = $this->_config->path;
		$domain = $this->_config->domain;
		$this->setCookie($cookieName, "", time() - 3600, $path, $domain);

		$_SESSION['user'] = null;
	}

	public function clearUserName()
	{
		$this->_user->setFirstName('');
		$this->_user->setLastName('');
		$this->persist($this->_user);
	}

	public function clearUserData()
	{
		$this->_user->setMiddleInitial('');
		$this->_user->setStreetAddress('');
		$this->_user->setCity('');
		$this->_user->setState('');
		$this->_user->setZipCode('');
		$this->_user->setSSN('');
		$this->persist($this->_user);
	}

	public function getCurrentUser()
	{
		if (!empty($_SESSION['user'])) {
			$user = unserialize(base64_decode($_SESSION['user']));
		} else {
			$user = new Cardmatch_User();
		}

		if(isset($this->_config)) {

			$cookieName = $this->_config->name->username;

			if (isset($_COOKIE[$cookieName])) {

				$name = explode(',', $_COOKIE[$cookieName]);

				if (count($name) == 2) {
					$user->setFirstName($name[0]);
					$user->setLastName($name[1]);

				}
			}
		}

		return $user;
	}

	protected function setCookie($cookieName, $value, $ttl, $path, $domain) {
		setcookie($cookieName, $value, $ttl, $path, $domain);
	}
}
