<?php

class Cardmatch_Channel_Amex extends Cardmatch_Channel_Abstract {

	/**
	 * @var Cardmatch_Client_Amex
	 */
	protected $_client;
	protected $_errors;
	protected $_statusCode;

	protected $_rawOffers;

	const MERCHANT_ID = 2;

	/**
	 * @param Cardmatch_User $user
	 * @param $visitId
	 *
	 * @return Cardmatch_Offer[]
	 */
	public function getOffers(Cardmatch_User $user = null, $visitId = '') {

		$info = $this->_getApplicantInfo($user);
		$response = $this->_getOffersResponse($info);

		$offers = array();

		if($response) {

			$providerOffers = $response->getOffers();
			$this->_rawOffers = $providerOffers;
			foreach($providerOffers as $offer) {
				$sku = $offer->sourceCode;
				$cardId = $this->_getCardIdBySku($sku);
				//ptv values now get passed as array
				$offerId = array($offer->offerId);
				if($cardId) {
					$offers[] = new Cardmatch_Offer($cardId, $offerId);
				}
			}

			if(!empty($offers)) {
				$this->ackReceived($this->_client->getTransactionId());
			}
		}

		return $offers;
	}

	public function getRawOffers() {
		return $this->_rawOffers;
	}

	protected function _getOffersResponse(Cardmatch_Client_Amex_ApplicantInfo $info) {

		try {
			$response = $this->_client->getPreScreenOffers($info);
		} catch(Exception $e) {

			$msg = "Amex API Error: ".$e->getMessage();
			$error = new Cardmatch_Error(0,	1,$msg);
			$this->_errors[] = $error;

			$this->_logger->err($msg);
			return false;
		}


		/**
		 * 0 = Success Response
		 * 1 = Failure Response
		 * 2 = No Offer Response
		 */
		if($response->getStatusCode() != 0) {
			$error = new Cardmatch_Client_Amex_Error(
				$response->getStatusCode(),
				"Amex API: " . $response->getStatusDescription()
			);

			$response->setErrorMessages(array($error));
		}

		$errors = $response->getErrorMessages();

		if(!empty($errors)) {
			foreach($errors as $amexError) {
				$code = $amexError->getErrorCode();
				$msg = $amexError->getErrorResponse();
				$error = new Cardmatch_Error(0, $code, $msg);
				$this->_errors[] = $error;
			}

			return false;
		}

		return $response;
	}

	public function ackDisplayed() {
		$response = $this->_client->acknowledgeOfferDisplayed();
		$success = $response->getStatusCode() == 200;

		return $success;
	}

	public function ackReceived($transactionId) {
		$timestamp = $this->_getGmtTimeStamp();
		$response = $this->_client->acknowledgeOffer($transactionId, $timestamp);
		return $response;
	}

	public function getErrors() {
		return $this->_errors;
	}

	public function clearErrors() {
		$this->_errors = array();
	}

	public function addError($error) {
		$this->_errors[] = $error;
	}

	public function getStatusCode() {
		return $this->_client->getStatusCode();
	}



	/* --------------------
	 * Non-public methods
	 * --------------------
	 */

	protected function _createApiClient(Zend_Config $config) {
		$client = new Cardmatch_Client_Amex($config);
		return $client;
	}


	/**
	 * @param Cardmatch_User $user
	 *
	 * @return Cardmatch_Client_Amex_ApplicantInfo
	 */
	protected function _getApplicantInfo(Cardmatch_User $user) {

		$name = new Cardmatch_Client_Amex_Name();
		$name->setFirst($user->getFirstName());
		$name->setMiddle($user->getMiddleInitial());
		$name->setLast($user->getLastName());

		$address = new Cardmatch_Client_Amex_Address();
		$address->setAddressLine1($user->getStreetAddress());
		$address->setCity($user->getCity());
		$address->setState($user->getState());
		$address->setZip($user->getZipCode());

		$info = new Cardmatch_Client_Amex_ApplicantInfo();
		$info->setName($name);
		$info->setHomeAddress($address);
		$info->setLast4SSN(substr($user->getSSN(), -4));

		// These are the values that Amex asked us to use
		$info->setChannelId(1004);
		$info->setGnaVendorCode(60);
		$info->setLeadOfferFlag('C');
		$info->setPmcVendorCode('A1');
		$info->setExperienceId('bas-prscrn');
		$info->setAffId('cccom');

		$info->setRequestTimeStamp($this->_getGmtTimeStamp());


		return $info;
	}

	/**
	 * @param array $skus
	 *
	 * @return array
	 */
	protected function _mapSkusToProductIds(array $skus) {

		$cardDao = new Cardmatch_CardDao();
		$productIds = $cardDao->getCardIdsBySkus($skus, self::MERCHANT_ID);
		return $productIds;
	}

	/**
	 * @param $sku
	 *
	 * @return string
	 */
	protected function _getCardIdBySku($sku) {
		$cardIds = $this->_mapSkusToProductIds(array($sku));

		$cardId = false;
		if(is_array($cardIds) && !empty($cardIds)) {
			$cardId = $cardIds[0];
		}

		return $cardId;
	}

	/**
	 * We need to send the request time stamp relative to GMT,
	 * so we save the current time zone, change it, and then restore
	 * the time zone we had before.
	 */
	protected function _getGmtTimeStamp() {

		$defaultTimezone = date_default_timezone_get();
		date_default_timezone_set('GMT');
		$timestamp = date('c');
		date_default_timezone_set($defaultTimezone);

		return $timestamp;

	}

}

