<?php

/**
 * Each provider channel should inherit from this abstract
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
abstract class Cardmatch_Channel_Abstract {

	protected $_channel, $_user, $_visitId, $_client, $_name;


	/**
	 * @param Zend_Config $config Channel-specific configuration, such as API URL, etc.
	 *                            We use a Zend_Config object because we're reading the
	 *                            configuration from an INI file, and this makes it easy
	 *                            to change the adapter to something else if we need to.
	 */
	public function __construct(Zend_Config $config) {
		$this->_config = $config;
		$this->_client = $this->_createApiClient($config);
		$this->_logger = Cardmatch_Logger::getInstance();
	}

	public function getConfig() {
		return $this->_config;
	}

	public function setConfig(Zend_Config $config) {
		$this->_config = $config;
	}

	public function hasErrors() {
		$errors = $this->getErrors();
		return !empty($errors);
	}

	protected function _getApiClient() {
		if (!isset($this->_client)) {
			$this->_client = $this->_createApiClient($this->getConfig());
		}

		return $this->_client;
	}

	public function setApiClient($client) {
		$this->_client = $client;
	}

	public function setName($name) {
		$this->_name = $name;
	}

	public function getName() {
		return $this->_name;
	}


	/**
	 * -----------------------------
	 * Abstract Methods
	 * -----------------------------
	 */

	/**
	 *
	 * @param Cardmatch_User $user
	 * @param $visitId
	 *
	 * @return Cardmatch_Offer[]
	 */
	public abstract function getOffers(Cardmatch_User $user = null, $visitId = '');

	/**
	 * @return boolean
	 */
	public abstract function ackDisplayed();

	/**
	 * @return array Array of Cardmatch_Error objects
	 */
	public abstract function getErrors();
	public abstract function clearErrors();

	protected abstract function _createApiClient(Zend_Config $config);


}
