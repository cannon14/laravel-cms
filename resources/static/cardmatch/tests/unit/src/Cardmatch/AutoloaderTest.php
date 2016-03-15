<?php


class Cardmatch_AutoloaderTest extends PHPUnit_Framework_TestCase {

	public function testLoadingInvalidFileReturnsFalse() {
		$result = Cardmatch_Autoloader::load('ThisClassDoesntExist');
		$this->assertFalse($result);
	}
}
