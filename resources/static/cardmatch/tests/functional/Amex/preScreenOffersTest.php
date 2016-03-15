<?php



class Amex_PreScreenOffersTest extends Cardmatch_DbTestCase {

	/**
	 * @dataProvider samplePeopleProvider
	 */
	public function testGetSkus(Cardmatch_User $user, $expectedStatus, $expectedSkus) {

		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		$apiConfig = $config->channels->Amex->params;


		if($expectedStatus == 1) {
			$this->setExpectedException('InvalidArgumentException');
		}

		$channel = new Cardmatch_Channel_Amex($apiConfig);
		$channel->getOffers($user);

		$rawOffers = $channel->getRawOffers();
		foreach($rawOffers as $offer) {
			$sku = $offer->sourceCode;
			$actualSkus[] = $sku;
		}

		sort($actualSkus);
		sort($expectedSkus);

		echo $user->getFirstName().' '.$user->getLastName()."\n";
		if(empty($actualSkus)) {
			echo "API error:\n";
			print_r($channel->getErrors());
		} else {
			echo "Skus returned by API:\n";
			print_r($actualSkus);
		}


		$this->assertEquals($expectedStatus, $channel->getStatusCode());
		$this->assertEquals($expectedSkus, $actualSkus);
	}

	/**
	 * @dataProvider samplePersonProvider
	 */
	public function testGetOffers(Cardmatch_User $user) {
		$config = new Zend_Config_Ini(CARDMATCH_PATH.'/config/channels.ini', APPLICATION_ENV);
		$apiConfig = $config->channels->Amex->params;

		$channel = new Cardmatch_Channel_Amex($apiConfig);
		$offers = $channel->getOffers($user, '1');

		$expectedProducts = array(
			'22034979',
			'22034980',
		);

		$actualProducts = array();
		foreach($offers as $offer) {
			$actualProducts[] = $offer->getCardId();
		}

		sort($actualProducts);
		sort($expectedProducts);

		$this->assertEquals($expectedProducts, $actualProducts);

	}

	public function samplePeopleProvider(){

		$path = TEST_DATA_PATH.'/amex/sampleApplicants.json';

		$contents = file_get_contents($path);
		$applicants = json_decode($contents);

		$users = array();

		foreach($applicants as $applicant) {

			$user = new Cardmatch_User();

			$user->setFirstName($applicant->first);
			$user->setLastName($applicant->last);
			$user->setStreetAddress($applicant->street);
			$user->setCity($applicant->city);
			$user->setState($applicant->state);
			$user->setZipCode($applicant->zip);
			$user->setSSN($applicant->ssn);

			$users[] = array($user, $applicant->status, $applicant->offers);

		}


//		print_r($users); exit;
//		echo json_encode($users); exit;

		return $users;

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
