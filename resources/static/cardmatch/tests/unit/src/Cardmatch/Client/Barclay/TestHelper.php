<?php


class Cardmatch_Client_Barclay_TestHelper extends PHPUnit_Framework_TestCase {

	public function getMockWebservice($apiResponse) {

		$wsdl = 'file://'.CARDMATCH_PATH.'/config/barclay/PrescreenWebService.wsdl';
		//echo $wsdl; exit;

		$webservice = $this->getMockFromWsdl($wsdl);
		
		$webservice->expects($this->any())
				->method('getProactivePrescreenProducts')
				->will($this->returnValue($apiResponse));


		$ackResponse = $this->getApiResponseAckReceived();
		$webservice->expects($this->any())
				->method('offerCapture')
				->will($this->returnValue($ackResponse));

		return $webservice;
	}

	/**
	 * @return Cardmatch_Client_Barclay_ApplicantInfo
	 */
	public function getValidApplicantInfo() {

		$info = new Cardmatch_Client_Barclay_ApplicantInfo();

		$info->setLast4SSN('7695');

		$name = new Cardmatch_Client_Barclay_Name('Test', '', 'Test');
		$info->setName($name);

		$address = new Cardmatch_Client_Barclay_Address();
		$address->setAddressLine1('125 South West Stsad asdgfg');
		$address->setAddressLine2('');
		$address->setCity('Newark');
		$address->setState('DE');
		$address->setZip('198010001');
		$info->setAddress($address);

		return $info;

	}

	
		/**
	 * @return Cardmatch_Client_Barclay_ApplicantInfo
	 */
	public function getEmptyApplicantInfo() {

		$info = $this->getValidApplicantInfo();

		$info->setLast4SSN('7695');

		$name = new Cardmatch_Client_Barclay_Name('Test', '', 'Test');
		$info->setName($name);

		$address = $info->getAddress();
		$address->setZip('198010000');
		$info->setAddress($address);

		return $info;

	}

	
	public function getApiResponse() {

		$response =  new stdClass();
		$offers = $this->_getOffers();
		$response->prescreenProducts = $offers;

		return $response;

	}

	public function getApiResponseNoOffers() {

		$response = new stdClass();
		$response->proactivePrescreenResponse = new stdClass();
		return $response;

	}

	public function getApiResponseError() {
		$response = $this->getApiResponseNoOffers();
		
		$response = new stdClass;

		$response->prescreenProducts = array();
		$response->prescreenProducts[0] = new stdClass();
		$response->prescreenProducts[0]->errorcodes = array('1001','1003');
		
		return $response;
	}

	public function getApiResponseAckReceived() {

		$response = new stdClass();
		$response->statusInfo = new stdClass();
		$response->statusInfo->statusCode = "SUCCESS";

		return $response;

	}

	/**
	 * @return stdClass
	 */
	private function _getOffers(){

		$offers = array();

		$offer1 = new stdClass();
		$offer1->productId = '22034980';
		$offer1->applyURL = 'https://www.barclaycardus.com/apply/Landing.action?campaignId=1655&cellId=7&prescreenId=22034980&referrerid=123123';
		$offer1->campaignId = '1730' ;
		$offer1->cellId = '2720';
		$offer1->prescreenId = 'prescreen1';
		
		$offers[] = $offer1;

		$offer2 = new stdClass();
		$offer2->productId = '22034979';
		$offer2->applyURL = 'https://www.barclaycardus.com/apply/Landing.action?campaignId=1655&cellId=7&prescreenId=22034979&referrerid=123123';
		$offer2->campaignId = '1665' ;
		$offer2->cellId = '4024';
		$offer2->prescreenId = 'prescreeen2';

		$offers[] = $offer2;



		return $offers;
	}

	/**
	 * @param string $code
	 * @param string $description
	 *
	 * @return stdClass
	 */
	private function _getError($errorcodes = array())
	{
		$errorArr = new Cardmatch_Client_Barclay_Error($errorcodes);

		return $errorArr;
	}



}
