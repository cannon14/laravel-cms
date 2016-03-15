<?php

require_once("Amex/TestHelper.php");

class Cardmatch_Client_AmexTest extends PHPUnit_Framework_TestCase {


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGetOffersWithInvalidInfo() {

		$testHelper = new Cardmatch_Client_Amex_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponseError());

		/** @var $clientMock Cardmatch_Client_Amex */
		$clientMock = $this->_getMockClient($webservice);


		$info = new Cardmatch_Client_Amex_ApplicantInfo();
		$clientMock->getPreScreenOffers($info);

	}


	public function testGetOffers() {

		$testHelper = new Cardmatch_Client_Amex_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponse());

		/** @var $clientMock Cardmatch_Client_Amex */
		$clientMock = $this->_getMockClient($webservice);

		$info = $testHelper->getValidApplicantInfo();

		$response = $clientMock->getPreScreenOffers($info);

		$offers = $response->getOffers();
		$this->assertCount(2, $offers);

		$offer = $offers[0];
		$this->assertEquals('A00000EALD', $offer->sourceCode);

	}

	public function testNoOffersResponse() {
		$testHelper = new Cardmatch_Client_Amex_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponseNoOffers());

		/** @var $clientMock Cardmatch_Client_Amex */
		$clientMock = $this->_getMockClient($webservice);

		$info = $testHelper->getValidApplicantInfo();
		$response = $clientMock->getPreScreenOffers($info);

		$this->assertEquals('2', $response->getStatusCode());
		$this->assertEmpty($response->getOffers());

	}

	public function testFailureResponse() {
		$testHelper = new Cardmatch_Client_Amex_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponseError());

		/** @var $clientMock Cardmatch_Client_Amex */
		$clientMock = $this->_getMockClient($webservice);

		$info = $testHelper->getValidApplicantInfo();
		$response = $clientMock->getPreScreenOffers($info);

		$this->assertEquals('1', $response->getStatusCode());
		$this->assertEquals('System Error',$response->getStatusDescription());

		$errors = $response->getErrorMessages();

		$error = $errors[0];
		$this->assertEquals('404', $error->getErrorCode());
		$this->assertEquals('Not Found', $error->getErrorResponse());
		$this->assertEquals('FAIL', $error->getSystemName());

	}

	public function testAckResponse() {

		$testHelper = new Cardmatch_Client_Amex_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponse());

		/** @var $clientMock Cardmatch_Client_Amex */
		$clientMock = $this->_getMockClient($webservice);

		$info = $testHelper->getValidApplicantInfo();
		$response = $clientMock->getPreScreenOffers($info);

		$transactionId = $response->getTransactionId();

		$ackResponse = $clientMock->acknowledgeOffer($transactionId, time());

		$this->assertEquals('0', $ackResponse->getStatusCode());
		$this->assertEquals('SUCCESS', $ackResponse->getStatusDescription());


		$ackResponse = $clientMock->acknowledgeOfferDisplayed($transactionId, time());

		$this->assertEquals('0', $ackResponse->getStatusCode());
		$this->assertEquals('SUCCESS', $ackResponse->getStatusDescription());

	}

	private function _getConfig($env = 'unittesting') {
        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', $env);
		$channelConfig = $config->channels->Amex->params;
		return $channelConfig;
	}

	private function _getMockClient($webservice) {

		$clientMock = $this->getMock('Cardmatch_Client_Amex', array('_createSoapClient'), array($this->_getConfig()));
		$clientMock->expects($this->any())
				->method('_createSoapClient')
				->will($this->returnValue($webservice));

		return $clientMock;
	}

}
