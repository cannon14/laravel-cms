<?php

class Cardmatch_Channel_Barclay extends Cardmatch_Channel_Abstract {

	/**
	 * @var Cardmatch_Client_Barclay
	 */
	protected $_client;
	protected $_errors = array();
	protected $_statusCode;

	protected $_rawOffers;

	const MERCHANT_ID = 46;
	const CONTEXT_ID = 1111;

	/**
	 * @param Cardmatch_User $user
	 * @param string $visitId
	 * @return array|Cardmatch_Offer[]
	 */
	public function getOffers(Cardmatch_User $user = null, $visitId = '') {
		$info = $this->_getApplicantInfo($user);
		$response = $this->_getOffersResponse($info);
		$offers = array();
		if($response) {
			$providerOffers = $response->getOffers();
			$this->_rawOffers = $providerOffers;
			$offers = $this->_getOffersFromResponse($providerOffers);
			$this->_sendAcknowledgmentsFromResponse($providerOffers);
		}

		return $offers;
	}

	/**
	 * Returns array of Cardmatch_Offer objects
	 * 
	 * @param array $providerOffers
	 * @return array
	 */
	protected function _getOffersFromResponse($providerOffers){
		$offers = array();
		
		foreach($providerOffers as $offer) {
			$offerObj = $this->_createOfferObject($offer);
			if($offerObj){
				$offers []= $offerObj;
			}
		}
		return $offers;
	}

	/**
	 * Creates Cardmatch offer object from response product
	 * 
	 * @param object $offer
	 * @return \Cardmatch_Offer
	 */
	protected function _createOfferObject($offer){
		$offerObj = null;
		
		//get card Id
		$productId = $offer->campaignId . '-' . $offer->cellId;
		$cardId = $this->_getCardIdBySku($productId);
		
		//get all ptv variables from applyUrl
		$ptvArray = $this->_urlToPtvArray($offer->applyURL);

		if(!empty($cardId)) {	
			$offerObj = new Cardmatch_Offer($cardId, $ptvArray);
		}
		return $offerObj;
	}
	
	/**
	 * Convert URL GET Params into an associative array for PTV var
	 * Array will be converted back into a ptv var in the controller
	 * 
	 * @param string $applyURL
	 * @return array
	 */
	protected function _urlToPtvArray($applyURL){
		$ptvArray = null;
		$urlFragments = parse_url($applyURL);
		$queryString = $urlFragments['query'];
		
		parse_str($queryString,$ptvArray);
		return $ptvArray;
	}
	
	/**
	 * Sends Acknowledgment to Barclay for each product ID
	 * 
	 * @param array $providerOffers
	 */
	protected function _sendAcknowledgmentsFromResponse($providerOffers){
		//you can only send 6 records per acknowledgment
		$ackLimit = 6;

		foreach ($providerOffers as $offerKey => $offer){
			$acknowledgment = new stdClass();
			$acknowledgment->contextId = self::CONTEXT_ID;
			$acknowledgment->prescreenId =  $offer->prescreenId;
			$acknowledgments []= $acknowledgment;

			//check if amount of acknowledgments is same as limit
			//or if last record in set
			//$offerKey starts at 0 so you have to add 1
			if(($offerKey+1) % $ackLimit === 0 || $offerKey+1 === count($providerOffers)){
				//send fully populated acknowledgment
				$this->ackReceived($acknowledgments);
				//empty acknowledgment array
				$acknowledgments = array();
			}
		}
	}
	
	public function getRawOffers() {
		return $this->_rawOffers;
	}

	protected function _getOffersResponse(Cardmatch_Client_Barclay_ApplicantInfo $info) {
		try {
			$response = $this->_client->getPreScreenOffers($info);
		} catch(Exception $e) {

			$msg = "Barclay API Error: ".$e->getMessage();
			$error = new Cardmatch_Error(0,	1,$msg);
			$this->_errors[] = $error;

			$this->_logger->err($msg);
			return false;
		}

		return $response;
	}

	public function ackDisplayed() {
		$response = $this->_client->acknowledgeOfferDisplayed();
		$success = $response->getStatusCode() == 200;

		return $success;
	}

	public function ackReceived($ackObjects) {
		$response = $this->_client->acknowledgeOffer($ackObjects);
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
		$client = new Cardmatch_Client_Barclay($config);
		return $client;
	}

	/**
	 * @param Cardmatch_User $user
	 *
	 * @return Cardmatch_Client_Barclay_ApplicantInfo
	 */
	protected function _getApplicantInfo(Cardmatch_User $user) {

		$name = new Cardmatch_Client_Barclay_Name();
		$name->setFirst($user->getFirstName());
		$name->setLast($user->getLastName());
		$address = new Cardmatch_Client_Barclay_Address();
		$address->setAddressLine1($user->getStreetAddress());
		$address->setCity($user->getCity());
		$address->setState($user->getState());
		$address->setZip($user->getZipCode());
		$info = new Cardmatch_Client_Barclay_ApplicantInfo();
		$info->setName($name);
		$info->setAddress($address);
		$info->setLast4SSN(substr($user->getSSN(), -4));

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
}

