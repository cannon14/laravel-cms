<?php

require_once "SoapClientHelper.php";

class Cardmatch_Client_Amex_SoapClientTest extends PHPUnit_Framework_TestCase {

	public function testSoap(){

        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		$clientConfig = $config->channels->Amex->params;

		$client = new Cardmatch_Test_Client_Amex_SoapClientHelper($clientConfig);

		try {
			$params = array(
				"transactionId" => '12345',
				"offerAcceptanceCode" => '12345',
				"offerCommTimeStamp" => '2013-08-22T16:14:53',
			);

			$client->acknowledgeOffer($params);
		} catch(SoapFault $s) {
			$msg = "Soap error! " . $s->getMessage();
			$this->fail($msg);
		}


		$expectedPath = FIXTURES_PATH . '/amex/amexSoapRequest.txt';
		$expectedXml = file_get_contents($expectedPath);

		$actualXml = $client->getRequest();

		$this->assertEquals($expectedXml, $actualXml);

	}

}