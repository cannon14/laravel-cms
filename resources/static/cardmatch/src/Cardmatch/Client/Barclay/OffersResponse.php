<?php

/**
 * Maps the response from the getPreScreenOffers call
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */
class Cardmatch_Client_Barclay_OffersResponse {
	protected $_errorCodes;
	protected $_errorText;
	protected $_offers;


	/**
	 * @param stdClass $response
	 */
	public function __construct($response) {
		$offers = array();		
		if (empty($response->ErrorDetails)) {
			$offers = $this->_getOffersFromResponse($response);
		} else {
			$this->_setErrorsUsingResponse($response);
		}
		
		$this->setOffers($offers);
	}
	
	protected function _setErrorsUsingResponse($response){
		foreach ($response->ErrorDetails as $error) {
			if(!empty($error->errorCode)) {
				$this->setErrorCodes($error->errorCode);
				$this->setErrorText($error->errorText);
			} else {
				$this->setErrorCodes('1000');
				$this->setErrorText('NO PRODUCTS FOUND');
			}

		}
	}
	
	protected function _getOffersFromResponse($response){
		$offers = array();
		
		if(!empty($response->prescreenProducts)) {
			$offers = $response->prescreenProducts;
			
			if (!is_array($offers)) {
				$offers = array($offers);
			}			
		}
		return $offers;
	}

	public function getSkus() {

		if (is_array($this->_offers)) {
			$skus = array();
			foreach ($this->_offers as $offer) {
				$skus[] = $offer->campaignId."-".$offer->cellId;
			}
		} else {
			$skus = false;
		}

		return $skus;
	}

	/**
	 * @param mixed $errorText
	 */
	public function setErrorText($errorText) {
		$this->_errorText[] = $errorText;
	}

	/**
	 * @return mixed
	 */
	public function getErrorText() {
		return $this->_errorText;
	}

	/**
	 * @param $errorCode
	 */
	public function setErrorCodes($errorCode) {
		$this->_errorCodes[] = $errorCode;
	}

	/**
	 * @return mixed
	 */
	public function getErrorCodes() {
		return $this->_errorCodes;
	}

	/**
	 * @param mixed $offers
	 */
	public function setOffers($offers) {
		$this->_offers = $offers;
	}

	/**
	 * @return mixed
	 */
	public function getOffers() {
		return $this->_offers;
	}

}
