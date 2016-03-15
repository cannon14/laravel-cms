<?php

class Cardmatch_Logger {

	private static $_instance = null;

	/**
	 * @param string $path
	 * @return Cardmatch_Log
	 * @throws Zend_Log_Exception
	 */
	public static function getInstance($path = '') {

		if(!self::$_instance) {
			self::$_instance = self::createInstance($path);
		}

		return self::$_instance;
	}

	public static function clearInstance() {
		self::$_instance = null;
	}



	private static function createInstance($path = '') {
		if(empty($path)) $path = self::_getDefaultLogPath();

		$logger = new Cardmatch_Log();

		try {
			$writer = new Zend_Log_Writer_Stream($path);
		} catch(Zend_Log_Exception $e) {
			$msg = "Could not open Cardmatch log file for writing: ". $path;
			throw new Zend_Log_Exception($msg);
		}

		$logger->addWriter($writer);

		$filter = self::_getPriorityFilter();
		$logger->addFilter($filter);

		$logger->addPriority('INSANE', 8);

		return $logger;
	}

	private static function _getDefaultLogPath() {
		$config = self::_getConfig();
		return $config->path;
	}

	private static function _getConfig() {

		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		return $config->logger;
	}

	private static function _getPriorityFilter() {
		$config = self::_getConfig();
		$minPriority = intval($config->filter->priority);
		$filter = new Zend_Log_Filter_Priority($minPriority);
		return $filter;
	}



}