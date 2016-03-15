<?php

require_once dirname(__FILE__)."/../Client/SoapClientHelper.php";

class Cardmatch_Channel_AmexTest extends Cardmatch_DbTestCase {

	public function testHasErrors() {
		$channel = new Cardmatch_Channel_Amex(new Zend_Config(array()));

		$this->assertFalse($channel->hasErrors());
		$this->assertEmpty($channel->getErrors());

		$error = new Cardmatch_Error(1, 1, 'unit testing');
		$channel->addError($error);

		$this->assertTrue($channel->hasErrors());

		$expectedErrors = array($error);
		$this->assertEquals($channel->getErrors(), $expectedErrors);

		$channel->clearErrors();
		$this->assertFalse($channel->hasErrors());

	}

	public function testAckReceived() {


		$client = $this->getMock(
			'Cardmatch_Client_Amex',
			array('acknowledgeOffer'),
			array(),
			'',
			false
		);

		$expectedResponse = new Cardmatch_Client_Amex_AckResponse(0, 'SUCCESS', 0);

		$client->expects($this->any())
			->method('acknowledgeOffer')
			->will($this->returnValue($expectedResponse));


		$channel = new Cardmatch_Channel_Amex(new Zend_Config(array()));
		$channel->setApiClient($client);

		$actualResponse = $channel->ackReceived('123');

		$this->assertEquals($expectedResponse->getStatusCode(), $actualResponse->getStatusCode());
		$this->assertEquals($expectedResponse->getStatusDescription(), $actualResponse->getStatusDescription());

	}


	/**
	 * @dataProvider samplePersonProvider
	 */
	public function testGetOffers(Cardmatch_User $user) {

		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		$clientConfig = $config->channels->Amex->params;

		$path = TEST_DATA_PATH.'/amex/sampleXmlOffersResponse.txt';
		$response = file_get_contents($path);

		$client = new Cardmatch_Test_Client_SoapClientHelper($clientConfig->wsdl, array(), $response);

		$amexClientMock = $this->getMock('Cardmatch_Client_Amex', array('_getSoapClient','acknowledgeOffer'), array($clientConfig));
		$amexClientMock->expects($this->any())
				->method('_getSoapClient')
				->will($this->returnValue($client));

		$ackResponse = new Cardmatch_Client_Amex_AckResponse(0, 'SUCCESS', 0);
		$amexClientMock->expects($this->any())
			->method('acknowledgeOffer')
			->will($this->returnValue($ackResponse));

		$channel = new Cardmatch_Channel_Amex($clientConfig);
		$channel->setApiClient($amexClientMock);

		$offers = $channel->getOffers($user, '1');

		$products = array();
		foreach($offers as $offer) {
			$products[] = $offer->getCardId();
		}

		$expectedProducts = array(
			'22034980',
			'22034979',
		);

		$this->assertEquals($expectedProducts, $products);

	}


	public function samplePersonProvider(){

		$path = TEST_DATA_PATH.'/amex/sampleApplicants.json';

		$contents = file_get_contents($path);
		$applicants = json_decode($contents);

		$applicant = $applicants[0]; // Mack Tints

		$user = new Cardmatch_User();

		$user->setFirstName($applicant->first);
		$user->setLastName($applicant->last);
		$user->setStreetAddress($applicant->street);
		$user->setCity($applicant->city);
		$user->setState($applicant->state);
		$user->setZipCode($applicant->zip);
		$user->setSSN($applicant->ssn);

		$users[] = array($user);


		return $users;

	}


	public function getDataSet() {

		$datasets = array(
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/amex/card_data.xml"),
		);

		$dataset = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);

		return $dataset;
	}
}
