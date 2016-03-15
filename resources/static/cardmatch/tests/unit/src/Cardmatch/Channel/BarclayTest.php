<?php

require_once dirname(__FILE__)."/../Client/SoapClientHelper.php";

class Cardmatch_Channel_BarclayTest extends Cardmatch_DbTestCase {

	public function testHasErrors() {
		$channel = new Cardmatch_Channel_Barclay(new Zend_Config(array()));

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
			'Cardmatch_Client_Barclay',
			array('acknowledgeOffer'),
			array(),
			'',
			false
		);

		$expectedResponse = new Cardmatch_Client_Barclay_AckResponse(0, 'SUCCESS', 0);

		$client->expects($this->any())
			->method('acknowledgeOffer')
			->will($this->returnValue($expectedResponse));


		$channel = new Cardmatch_Channel_Barclay(new Zend_Config(array()));
		$channel->setApiClient($client);

		$actualResponse = $channel->ackReceived('123');

		$this->assertEquals($expectedResponse->getStatusCode(), $actualResponse->getStatusCode());

	}


	/**
	 * @dataProvider samplePersonProvider
	 */
	public function testGetOffers(Cardmatch_User $user) {

		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', 'unittesting');
		$clientConfig = $config->channels->Barclay->params;

		$path = TEST_DATA_PATH.'/barclay/sampleXmlOffersResponse.txt';
		$response = file_get_contents($path);

		$client = new Cardmatch_Test_Client_SoapClientHelper($clientConfig->wsdl, array(), $response);

		$barclayClientMock = $this->getMock('Cardmatch_Client_Barclay', array('_getSoapClient','acknowledgeOffer'), array($clientConfig));
		$barclayClientMock->expects($this->any())
				->method('_getSoapClient')
				->will($this->returnValue($client));

		$ackResponse = new Cardmatch_Client_Barclay_AckResponse(0, 'SUCCESS', 0);
		$barclayClientMock->expects($this->any())
			->method('acknowledgeOffer')
			->will($this->returnValue($ackResponse));
		
		$barclayChannelMock = $this->getMock('Cardmatch_Channel_Barclay', array('_getCardIdBySku'), array($clientConfig));
		$barclayChannelMock->expects($this->any())
				->method('_getCardIdBySku')
				->will($this->returnArgument(0));

		$barclayChannelMock->setApiClient($barclayClientMock);
		
		$offers = $barclayChannelMock->getOffers($user);
		
		$products = array();
		foreach($offers as $offer) {
			$products[] = $offer->getCardId();
		}
	
		
		$expectedProducts = array(
			'1730-2720',
			'1665-4024',
		);

		$this->assertEquals($expectedProducts, $products);


	}


	public function samplePersonProvider(){

		$path = TEST_DATA_PATH.'/barclay/sampleApplicants.json';

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
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/barclay/card_data.xml"),
		);

		$dataset = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);

		return $dataset;
	}
}
