<?php

/**
 * Maps the response from the getPreScreenOffers call
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Amex_OffersResponse {

	protected $_customerFlag,
			$_leadOfferFlag,
			$_leadOfferURL,
			$_offerTypeFlag,
			$_errorMessages,
			$_offers,
			$_statusCode,
			$_statusDescription,
			$_transactionId,
			$_pmcVendorCode;




	/**
	 * @param stdClass $response
	 */
	public function __construct($response) {
		$this->setCustomerFlag($response->customerFlag);
		$this->setLeadOfferFlag($response->leadOfferFlag);
		$this->setLeadOfferURL($response->leadOfferURL);
		$this->setOfferTypeFlag($response->offerTypeFlag);
		$this->setErrorMessages($response->ErrorMessages);
		$this->setStatusCode($response->statusCode);
		$this->setStatusDescription($response->statusDescription);
		$this->setTransactionId($response->transactionId);
		$this->setPmcVendorCode($response->pmcVendorCode);

		if($response->statusCode == 0) {
			$items = $response->Offer->item;
			if(!is_array($items)) {
				$items = array($items);
			}

			$this->setOffers($items);
		}

	}

	public function getSkus() {

		if(is_array($this->_offers)) {
			$skus = array();
			foreach($this->_offers as $offer) {
				$skus[] = $offer->sourceCode;
			}
		} else {
			$skus = false;
		}

		return $skus;
	}


	/**
	 * @param mixed $customerFlag
	 */
	public function setCustomerFlag($customerFlag)
	{
		$this->_customerFlag = $customerFlag;
	}

	/**
	 * @return mixed
	 */
	public function getCustomerFlag()
	{
		return $this->_customerFlag;
	}

	/**
	 * @param Cardmatch_Client_Amex_Error[] $errorMessages
	 */
	public function setErrorMessages($errorMessages = array())
	{
		$this->_errorMessages = $errorMessages;
	}

	/**
	 * @return Cardmatch_Client_Amex_Error[]
	 */
	public function getErrorMessages()
	{
		return $this->_errorMessages;
	}

	/**
	 * @param mixed $leadOfferFlag
	 */
	public function setLeadOfferFlag($leadOfferFlag)
	{
		$this->_leadOfferFlag = $leadOfferFlag;
	}

	/**
	 * @return mixed
	 */
	public function getLeadOfferFlag()
	{
		return $this->_leadOfferFlag;
	}

	/**
	 * @param mixed $leadOfferURL
	 */
	public function setLeadOfferURL($leadOfferURL)
	{
		$this->_leadOfferURL = $leadOfferURL;
	}

	/**
	 * @return mixed
	 */
	public function getLeadOfferURL()
	{
		return $this->_leadOfferURL;
	}

	/**
	 * @param mixed $offerTypeFlag
	 */
	public function setOfferTypeFlag($offerTypeFlag)
	{
		$this->_offerTypeFlag = $offerTypeFlag;
	}

	/**
	 * @return mixed
	 */
	public function getOfferTypeFlag()
	{
		return $this->_offerTypeFlag;
	}

	/**
	 * @param mixed $offers
	 */
	public function setOffers($offers)
	{
		$this->_offers = $offers;
	}

	/**
	 * @return mixed
	 */
	public function getOffers()
	{
		return $this->_offers;
	}

	/**
	 * @param mixed $pmcVendorCode
	 */
	public function setPmcVendorCode($pmcVendorCode)
	{
		$this->_pmcVendorCode = $pmcVendorCode;
	}

	/**
	 * @return mixed
	 */
	public function getPmcVendorCode()
	{
		return $this->_pmcVendorCode;
	}

	/**
	 * @param mixed $statusCode
	 */
	public function setStatusCode($statusCode)
	{
		$this->_statusCode = $statusCode;
	}

	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->_statusCode;
	}

	/**
	 * @param mixed $statusDescription
	 */
	public function setStatusDescription($statusDescription)
	{
		$this->_statusDescription = $statusDescription;
	}

	/**
	 * @return mixed
	 */
	public function getStatusDescription()
	{
		return $this->_statusDescription;
	}

	/**
	 * @param mixed $transactionId
	 */
	public function setTransactionId($transactionId)
	{
		$this->_transactionId = $transactionId;
	}

	/**
	 * @return mixed
	 */
	public function getTransactionId()
	{
		return $this->_transactionId;
	}




}
