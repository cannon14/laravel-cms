<?php

abstract class Cardmatch_Test_AbstractTestController {

	protected $_user;
	protected $_tpl;
	protected $_messages;
	protected $_errorMessages, $_logger;
	protected $_channel;

    public function __construct() {

        $userPersistence = new Cardmatch_UserPersistence();

        $this->_user = $userPersistence->getCurrentUser();
        $this->_tpl = new Cardmatch_Template();
		$this->_logger = Cardmatch_Logger::getInstance();
		$this->_channel = $this->_getChannel();


	    $config = $this->_getConfig(APPLICATION_ENV);
	    $this->_validateEnabled($config);
    }


	# abstract methods
	abstract public function run();
	abstract protected function _showForm();
	abstract protected function _processInquiry();
	abstract protected function _getChannel();


    protected function _getVisitId() {
        return isset($_SESSION['external_visit_id']) ? $_SESSION['external_visit_id'] : false;
	}

	protected function _getParam($key, $value = null) {

		if(isset($_REQUEST[$key])) {
			$value = $_REQUEST[$key];
		}

		return $value;
	}

	/**
	 * The default for env is "testing" because we always want the testing pages to
	 * point to the provider's testing service.
	 *
	 * @param string $env
	 * @return Zend_Config_Ini
	 */
	protected function _getConfig($env = 'testing') {
		$configFile = CARDMATCH_PATH . '/config/channels.ini';

		$config = new Zend_Config_Ini($configFile, $env);
		return $config;
	}

	/**
	 * @param $config
	 */
	protected function _validateEnabled($config) {
		if (!$config->testing->enabled) {
			header("Location: /cardmatch");
			exit;
		}
	}

}

