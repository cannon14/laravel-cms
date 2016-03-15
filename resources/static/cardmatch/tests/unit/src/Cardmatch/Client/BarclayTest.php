<?php

require_once("Barclay/TestHelper.php");

class Cardmatch_Client_BarclayTest extends PHPUnit_Framework_TestCase {


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGetOffersWithInvalidInfo() {

		$testHelper = new Cardmatch_Client_Barclay_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponseError());

		/** @var $clientMock Cardmatch_Client_Barclay */
		$clientMock = $this->_getMockClient($webservice);


		$info = new Cardmatch_Client_Barclay_ApplicantInfo();
		$clientMock->getPreScreenOffers($info);

	}


	public function testGetOffers() {

		$testHelper = new Cardmatch_Client_Barclay_TestHelper();
		$apiResponse = $testHelper->getApiResponse();
		$webservice = $testHelper->getMockWebservice($apiResponse);
		
		/** @var $clientMock Cardmatch_Client_Barclay */
		$clientMock = $this->_getMockClient($webservice);

		$info = $testHelper->getValidApplicantInfo();
				
		$response = $clientMock->getPreScreenOffers($info);

		$offers = $response->getOffers();
		$this->assertCount(2, $offers);

		$offer = $offers[0];
		$this->assertEquals('22034980', $offer->productId);

	}


	public function testAckResponse() {

		$testHelper = new Cardmatch_Client_Barclay_TestHelper();
		$webservice = $testHelper->getMockWebservice($testHelper->getApiResponse());

		/** @var $clientMock Cardmatch_Client_Barclay */
		$clientMock = $this->_getMockClient($webservice);

		$info = $testHelper->getValidApplicantInfo();

		$response = $clientMock->getPreScreenOffers($info);
		$offerCaptures = array();
		$offers = $response->getOffers();
		
		
		foreach($offers as $offer){
			$offerCapture = new stdClass();
			$offerCapture->contextId = '1';
			$offerCapture->prescreenId = $offer->prescreenId;
			$offerCapture->customerAcceptanceType = 'DECLINED';
			
			$offerCaptures[] = $offerCapture;

		}
		$ackResponse = $clientMock->acknowledgeOffer($offerCaptures);

		$this->assertEquals('SUCCESS', $ackResponse->getStatusCode());
	}

	private function _getConfig($env = 'development') {
		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', 'unittesting');
		$channelConfig = $config->channels->Barclay->params;
		return $channelConfig;
	}

	private function _getMockClient($webservice) {

		$clientMock = $this->getMock('Cardmatch_Client_Barclay', array('_createSoapClient'), array($this->_getConfig()));
		$clientMock->expects($this->any())
				->method('_createSoapClient')
				->will($this->returnValue($webservice));

		return $clientMock;
	}

}
