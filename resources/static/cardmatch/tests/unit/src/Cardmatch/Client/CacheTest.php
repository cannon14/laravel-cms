<?php

require_once "CacheHelper.php";


class Cardmatch_Client_CacheTest extends PHPUnit_Framework_TestCase {

	public function testAckDisplayed() {
		$config = $this->_getConfig();
		$cache = new Cardmatch_Client_Cache($config);
		$this->assertTrue($cache->ackDisplayed());
	}

	public function testSetAndGetProducts() {
		$config = $this->_getConfig();
		$cache = new Cardmatch_Client_CacheHelper($config);

		$user = new Cardmatch_User();
		$user->setFirstName('Unit');
		$user->setLastName('Testing');

		$expectedProductIds = array(1,2,3,4);

		$cache->saveProducts($expectedProductIds);

		$actualProducts = explode(',', $cache->getProducts());

		$this->assertEquals($expectedProductIds, $actualProducts);
	}

	/**
	 * @depends testSetAndGetProducts
	 */
	public function testClearCache() {

		$config = $this->_getConfig();
		$cache = new Cardmatch_Client_CacheHelper($config);
		$this->assertTrue($cache->hasValidCache());
		$cache->clearCache();
		$this->assertFalse($cache->hasValidCache());

	}

	private function _getConfig() {
        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		return $config->cache->cookie;
	}



}
