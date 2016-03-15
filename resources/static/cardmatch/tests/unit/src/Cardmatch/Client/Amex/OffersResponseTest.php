<?php

require_once dirname(__FILE__)."/../SoapClientHelper.php";
require_once "TestHelper.php";

class Cardmatch_Client_Amex_OffersResponseTest extends PHPUnit_Framework_TestCase {

	public function testResponse() {

        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		$clientConfig = $config->channels->Amex->params;

		$path = TEST_DATA_PATH.'/amex/sampleXmlOffersResponse.txt';
		$response = file_get_contents($path);

		$client = new Cardmatch_Test_Client_SoapClientHelper($clientConfig->wsdl, array(), $response);

		$amexClientMock = $this->getMock('Cardmatch_Client_Amex', array('_getSoapClient'), array($config));
		$amexClientMock->expects($this->any())
			->method('_getSoapClient')
			->will($this->returnValue($client));


		$testHelper = new Cardmatch_Client_Amex_TestHelper();
		$applicantInfo = $testHelper->getValidApplicantInfo();

		$offers = $amexClientMock->getPreScreenOffers($applicantInfo);

		$expectedSkus = array('A00000EALD','A00000EGJE');

		$actualSkus = $offers->getSkus();
		$this->assertEquals($expectedSkus, $actualSkus);

	}

}
