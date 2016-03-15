<?php


class Cardmatch_LoggerTest extends PHPUnit_Framework_TestCase {

	public function testsUnwriteablePath() {

		Cardmatch_Logger::clearInstance();

		$this->setExpectedException('Zend_Log_Exception');
		$path = 'ftp://doesnotexist';
		Cardmatch_Logger::getInstance($path);

	}


}
