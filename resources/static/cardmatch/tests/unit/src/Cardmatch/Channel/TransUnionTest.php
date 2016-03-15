<?php


class Cardmatch_Channel_TransUnionTest extends PHPUnit_Framework_TestCase {

	protected $_channel, $_user;

	public function __construct() {
	}

	public function testAckDisplayed() {
		$channel = $this->_getChannel();
		$this->assertTrue($channel->ackDisplayed());
	}

	public function testConfig() {
		$channel = $this->_getChannel();
		$config = $channel->getConfig();
		$this->assertEquals('https://netaccess-test.transunion.com/', $config->url);


		$prodConfig = $this->_getConfig('production');
		$channel->setConfig($prodConfig);
		$config = $channel->getConfig();
		$this->assertEquals('https://netaccess.transunion.com/', $config->url);

	}

	public function testGetProductsForClientWithNoBuckets() {
		$client = $this->_getApiClientMock();
		$client->expects($this->any())
			->method('getApprovedBuckets')
			->will($this->returnValue(array()));


		$channel = $this->_getChannel();
		$channel->setApiClient($client);

		$offers = $channel->getOffers($this->_getTestUser(), $this->_getVisitId());

		$this->assertEmpty($offers);

	}


	public function testGetProducts() {

		$apiClient = $this->_getApiClientMock();
		$apiClient->expects($this->any())
				  ->method('getApprovedBuckets')
				  ->will($this->returnValue(array(1,2,3)));

		$card = new stdClass();
		$card->cardId = '12345';

		$cards = array($card);

		$cardQuery = $this->getMock('Cardquery', array('getCreditCardsByExpression'));
		$cardQuery->expects($this->any())
				->method('getCreditCardsByExpression')
				->will($this->returnValue($cards));

		$args = array($this->_getConfig());
		$channel = $this->getMock('Cardmatch_Channel_TransUnion', array('_getCardQueryClient'), $args);
		$channel->expects($this->any())
			->method('_getCardQueryClient')
			->will($this->returnValue($cardQuery));


		$channel->setApiClient($apiClient);

		$offers = $channel->getOffers($this->_getTestUser(), $this->_getVisitId());

		$offer = $offers[0];

		$this->assertEquals('12345', $offer->getCardId());

	}

	private function _getApiClientMock() {

		$args = array($this->_getConfig());

		$apiClient = $this->getMock("Cardmatch_Client_TransUnion", array('getApprovedBuckets'), $args);

		return $apiClient;
	}

	private function _getChannel() {

		$channel = new Cardmatch_Channel_TransUnion(
			$this->_getConfig()
		);

		return $channel;
	}

	private function _getConfig($env = 'unittesting') {
        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', $env);
		$channelConfig = $config->channels->TransUnion->params;
		return $channelConfig;
	}

	private function _getTestUser() {
		$testUsers = new Cardmatch_Client_TransUnion_TestUsers();
		$users = $testUsers->getTestUsers();
		return $users[0];
	}

	private function _getVisitId() {
		$visitId = '123456789';
		return $visitId;
	}
}
