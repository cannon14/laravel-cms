<?php


class Cardmatch_Client_TransUnionTest extends Cardmatch_DbTestCase {

	/**
	 * @param $level
	 * @param $number
	 *
	 * @dataProvider errorProvider
	 */
	public function testErrorTypes($level, $number) {

		$response = new Cardmatch_Client_TransUnion_Response();
		$response->setErrorCode($number);

		$config = $this->_getConfig();

		$client = $this->getMock(
			'Cardmatch_Client_TransUnion',
			array('_sendTunaRequest'),
			array($config));

		$client->expects($this->any())
			->method('_sendTunaRequest')
			->will($this->returnValue($response));

		$user = new Cardmatch_User();
		$visitId = '123';
		$client->getApprovedBuckets($user, $visitId);

		/**
		 * @var $error Cardmatch_Error
		 */
		$error = $client->getError();

		$this->assertEquals($level, $error->getLevel());
		$this->assertEquals($number, $error->getNumber());

	}

	public function testNoResponseError() {

		/**
		 * @var $client Cardmatch_Client_TransUnion
		 */
		$client = $this->getMock(
			'Cardmatch_Client_TransUnion',
			array('_sendCurlRequest'),
			array($this->_getConfig()));

		$client->expects($this->any())
			->method('_sendCurlRequest')
			->will($this->returnValue(false));

		$user = new Cardmatch_User();
		$response = $client->sendInquiry($user, 1);

		$this->assertFalse($response);

		$error = $client->getError();
		$this->assertEquals(Cardmatch_Client_TransUnion::ERROR_NO_RESPONSE_FROM_TUNA, $error->getNumber());

	}

	public function testStoreTunaRequest() {
		$client = $this->_getClient();
		$user = new Cardmatch_User();
		$request = new Cardmatch_Client_TransUnion_Request($user, 12345, $this->_getConfig());
		$client->storeTunaRequest($request);

		$this->assertTableRowCount('tuna_requests', 1);
	}


	public function errorProvider() {

		$errors = array(
			array(Cardmatch_Client_TransUnion::ERROR_LEVEL_COMM_FAILURE, Cardmatch_Client_TransUnion::ERROR_SERVICE_UNAVAILABLE),
			array(Cardmatch_Client_TransUnion::ERROR_LEVEL_COMM_FAILURE, Cardmatch_Client_TransUnion::ERROR_TOO_MANY_INQUIRIES),
			array(Cardmatch_Client_TransUnion::ERROR_LEVEL_INVALID_SUBJECT_ID_DATA, Cardmatch_Client_TransUnion::ERROR_CURRENT_CITY_MISSING)
		);

		return $errors;

	}


	public function getDataSet() {

		$datasets = array(
			$this->createMySQLXMLDataSet(FIXTURES_PATH . "/cccomus.tuna_requests.xml"),
		);

		$dataset = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);

		return $dataset;
	}


	private function _getClient() {

		$client = new Cardmatch_Client_TransUnion(
			$this->_getConfig()
		);

		return $client;
	}

	private function _getConfig($env = 'unittesting') {
        $config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', $env);
		$channelConfig = $config->channels->TransUnion->params;
		return $channelConfig;
	}

}
