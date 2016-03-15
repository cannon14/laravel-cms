<?php


class Cardmatch_Client_Amex_TestHelper extends PHPUnit_Framework_TestCase {

	public function getMockWebservice($apiResponse) {

		$wsdl = 'file://'.CARDMATCH_PATH.'/tests/data/amex/amexE2.wsdl';
		//echo $wsdl; exit;

		$webservice = $this->getMockFromWsdl($wsdl, 'Amex_Webservice');
		$webservice->expects($this->any())
				->method('getPreScreenOffers')
				->will($this->returnValue($apiResponse));


		$response = $this->getApiResponseAckReceived();
		$webservice->expects($this->any())
				->method('acknowledgeOffer')
				->will($this->returnValue($response));

		$webservice->expects($this->any())
				->method('acknowledgeOfferDisplayed')
				->will($this->returnValue($response));

		return $webservice;
	}

	/**
	 * @return Cardmatch_Client_Amex_ApplicantInfo
	 */
	public function getValidApplicantInfo() {

		$info = new Cardmatch_Client_Amex_ApplicantInfo();

		$info->setRequestTimeStamp(date('c'));
		$info->setLast4SSN('7890');

		$name = new Cardmatch_Client_Amex_Name('PHP', 'Unit', 'Testing');
		$info->setName($name);

		$info->setLeadOfferFlag('C');

		$address = new Cardmatch_Client_Amex_Address();
		$address->setAddressLine1('8920 Business Park Dr');
		$address->setAddressLine2('Suite 350');
		$address->setCity('Austin');
		$address->setState('TX');
		$address->setZip('78759');
		$info->setHomeAddress($address);

		$info->setChannelId(1);
		$info->setPmcVendorCode('cccomus');
		$info->setExperienceId(1);

		return $info;

	}

	public function getApiResponse() {

		$response = $this->getApiResponseNoOffers();
		$offersResponse = $response->offersResponse;

		$offers = $this->_getOffers();
		$offersResponse->Offer = new stdClass();
		$offersResponse->Offer->item = $offers;
		$offersResponse->statusCode = '0';

		return $response;

	}

	public function getApiResponseNoOffers() {

		$offersResponse = new stdClass();

		$offersResponse->customerFlag = '';
		$offersResponse->leadOfferFlag = 'C';
		$offersResponse->leadOfferURL = '';
		$offersResponse->offerTypeFlag = 'P';
		$offersResponse->ErrorMessages = '';
		$offersResponse->statusDescription ='SUCCESS';
		$offersResponse->transactionId = '20131016064428014169570TranPMCId';
		$offersResponse->pmcVendorCode = '';

		$offersResponse->Offer = new stdClass();
		$offersResponse->Offer->item = array();
		$offersResponse->statusCode = '2';

		$response = new stdClass();
		$response->offersResponse = $offersResponse;

		return $response;

	}

	public function getApiResponseError() {
		$response = $this->getApiResponseNoOffers();

		$offersResponse = $response->offersResponse;
		$offersResponse->statusCode = 1;

		$error = $this->_getError();
		$errors = array($error);
		$offersResponse->ErrorMessages = $errors;
		$offersResponse->statusDescription = 'System Error';

		return $response;
	}

	public function getApiResponseAckReceived() {

		$response = new stdClass();
		$response->acknowledgeOfferResponse = new stdClass();
		$response->acknowledgeOfferResponse->statusCode = '0';
		$response->acknowledgeOfferResponse->statusDescription = "SUCCESS";
		$response->acknowledgeOfferResponse->transactionId = "12345";

		return $response;

	}

	/**
	 * @return stdClass
	 */
	private function _getOffers()
	{

		$offers = array();

		$offer = new stdClass();
		$offer->sourceCode = 'A00000EALD';
		$offer->iaCode = '2X';
		$offer->rsvpCode = '';
		$offer->bannerInfo = new stdClass();
		$offer->offerExpiry = '2013-12-31 00:00:00.0';
		$offer->offerId = '1720f4d0e7d2f940692daa73117e85a18a214f6b';
		$offers[] = $offer;


		$offer = new stdClass();
		$offer->sourceCode = 'A00000EGJE';
		$offer->iaCode = 'SJH';
		$offer->rsvpCode = '';
		$offer->bannerInfo = new stdClass();
		$offer->offerExpiry = '2015-02-02 00:00:00.0';
		$offer->offerId = 'aac0a46a995e1ab727b4506ee72d6a18db56d9d2';
		$offers[] = $offer;

		return $offers;
	}

	/**
	 * @param string $code
	 * @param string $description
	 *
	 * @return stdClass
	 */
	private function _getError($code = '404', $description = 'Not Found')
	{
		$error = new Cardmatch_Client_Amex_Error($code, $description, 'FAIL');

		return $error;
	}



}
