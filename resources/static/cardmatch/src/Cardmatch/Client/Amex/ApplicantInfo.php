<?php

/**
 * Amex pre-screened offers applicant info
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Amex_ApplicantInfo {

	protected

			$_affId,
			$_channelId, // 1004 for us
			$_custLocationInd,
			$_experienceId, // bas-prscrn
			$_generationCode, // Sr, Jr, etc
			$_gnaVendorCode, // 60 for us
			$_last4SSN,
			$_leadOfferFlag,
			$_pmcVendorCode,
			$_partnerRepId,
			$_paymentInd,
			$_requestTimeStamp,
			$_tenure,
			$_transactionCost,
			$_vendorCustomerId;


	protected $_errors = array();

	/**
	 * @var Cardmatch_Client_Amex_Name
	 */
	protected $_name;

	/**
	 * @var Cardmatch_Client_Amex_Address
	 */
	protected $_homeAddress;

	protected $_businessName;

	/**
	 * @var Cardmatch_Client_Amex_Address
	 */
	protected $_businessAddress;




	/**
	 * @param mixed $affId
	 */
	public function setAffId($affId)
	{
		$this->_affId = $affId;
	}

	/**
	 * @return mixed
	 */
	public function getAffId()
	{
		return $this->_affId;
	}


	/**
	 * @param Cardmatch_Client_Amex_Address $businessAddress
	 */
	public function setBusinessAddress(Cardmatch_Client_Amex_Address $businessAddress)
	{
		$this->_businessAddress = $businessAddress;
	}

	/**
	 * @return Cardmatch_Client_Amex_Address
	 */
	public function getBusinessAddress()
	{
		return $this->_businessAddress;
	}

	/**
	 * @param mixed $businessName
	 */
	public function setBusinessName($businessName)
	{
		$this->_businessName = $businessName;
	}

	/**
	 * @return mixed
	 */
	public function getBusinessName()
	{
		return $this->_businessName;
	}

	/**
	 * @param Cardmatch_Client_Amex_Address $homeAddress
	 */
	public function setHomeAddress(Cardmatch_Client_Amex_Address $homeAddress = null) {
		$this->_homeAddress = $homeAddress;
	}

	/**
	 * @return Cardmatch_Client_Amex_Address
	 */
	public function getHomeAddress()
	{
		return $this->_homeAddress;
	}

	/**
	 * @param mixed $last4SSN
	 */
	public function setLast4SSN($last4SSN)
	{
		$this->_last4SSN = $last4SSN;
	}

	/**
	 * @return mixed
	 */
	public function getLast4SSN()
	{
		return $this->_last4SSN;
	}

	/**
	 * @param string $leadOfferFlag
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
	 * @param Cardmatch_Client_Amex_Name $name
	 */
	public function setName(Cardmatch_Client_Amex_Name $name)
	{
		$this->_name = $name;
	}

	/**
	 * @return Cardmatch_Client_Amex_Name
	 */
	public function getName()
	{
		return $this->_name;
	}


	/**
	 * @param mixed $requestTimeStamp
	 */
	public function setRequestTimeStamp($requestTimeStamp)
	{
		$this->_requestTimeStamp = $requestTimeStamp;
	}

	/**
	 * @return mixed
	 */
	public function getRequestTimeStamp()
	{
		return $this->_requestTimeStamp;
	}

	public function isValid() {

		$this->_clearErrors();

		$shouldNotBeEmpty = array(
			'channelId',
			'leadOfferFlag',
			'requestTimeStamp',
			'pmcVendorCode',
			'experienceId',
		);

		foreach($shouldNotBeEmpty as $field) {
			$property = '_'.$field;
			$value = $this->$property;
			if(empty($value)) {
				$error = $field . ' is required';
				$this->_addError($error);
				return false;
			}
		}

		if(empty($this->_name) || !$this->_name->isValid()) {
			$error = 'Name is invalid';
			$this->_addError($error);
			return false;
		}

		if(!$this->isSSNValid()) {
			$error = 'SSN is invalid';
			$this->_addError($error);
			return false;
		}


		if(!$this->isLeadOfferFlagValid()) {
			$error = 'Lead Offer Flag is invalid';
			$this->_addError($error);
			return false;
		}

		if(!$this->isAddressValid()) {
			$error = 'Address is invalid';
			$this->_addError($error);
			return false;
		}

		return true;

	}


	public function isSSNValid() {
		if(!empty($this->_last4SSN) && strlen($this->_last4SSN) != 4) {
			return false;
		}

		return true;
	}

	public function isLeadOfferFlagValid() {
		$validValues = array(
			'C', // Consumer Products
			'O' // Small Business (OPEN) products
		);

		if(!in_array($this->_leadOfferFlag, $validValues)) {
			return false;
		}

		return true;
	}

	public function isAddressValid() {
		switch($this->getLeadOfferFlag()) {
			case "C": // Consumer cards
				$address = $this->getHomeAddress();
			break;

			case "O": // Small business cards
				$address = $this->getBusinessAddress();
			break;

			default:
				$address = false;

		}

		if(!$address instanceof Cardmatch_Client_Amex_Address) {
			return false;
		}

		return $address->isValid();
	}

	/**
	 * @param mixed $channelId
	 */
	public function setChannelId($channelId)
	{
		$this->_channelId = $channelId;
	}

	/**
	 * @return mixed
	 */
	public function getChannelId()
	{
		return $this->_channelId;
	}

	/**
	 * @param mixed $custLocationInd
	 */
	public function setCustLocationInd($custLocationInd)
	{
		$this->_custLocationInd = $custLocationInd;
	}

	/**
	 * @return mixed
	 */
	public function getCustLocationInd()
	{
		return $this->_custLocationInd;
	}

	/**
	 * @param mixed $experienceId
	 */
	public function setExperienceId($experienceId)
	{
		$this->_experienceId = $experienceId;
	}

	/**
	 * @return mixed
	 */
	public function getExperienceId()
	{
		return $this->_experienceId;
	}

	/**
	 * @param mixed $generationCode
	 */
	public function setGenerationCode($generationCode)
	{
		$this->_generationCode = $generationCode;
	}

	/**
	 * @return mixed
	 */
	public function getGenerationCode()
	{
		return $this->_generationCode;
	}

	/**
	 * @param mixed $gnaVendorCode
	 */
	public function setGnaVendorCode($gnaVendorCode)
	{
		$this->_gnaVendorCode = $gnaVendorCode;
	}

	/**
	 * @return mixed
	 */
	public function getGnaVendorCode()
	{
		return $this->_gnaVendorCode;
	}

	/**
	 * @param mixed $partnerRepId
	 */
	public function setPartnerRepId($partnerRepId)
	{
		$this->_partnerRepId = $partnerRepId;
	}

	/**
	 * @return mixed
	 */
	public function getPartnerRepId()
	{
		return $this->_partnerRepId;
	}

	/**
	 * @param mixed $paymentInd
	 */
	public function setPaymentInd($paymentInd)
	{
		$this->_paymentInd = $paymentInd;
	}

	/**
	 * @return mixed
	 */
	public function getPaymentInd()
	{
		return $this->_paymentInd;
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
	 * @param mixed $tenure
	 */
	public function setTenure($tenure)
	{
		$this->_tenure = $tenure;
	}

	/**
	 * @return mixed
	 */
	public function getTenure()
	{
		return $this->_tenure;
	}

	/**
	 * @param mixed $transactionCost
	 */
	public function setTransactionCost($transactionCost)
	{
		$this->_transactionCost = $transactionCost;
	}

	/**
	 * @return mixed
	 */
	public function getTransactionCost()
	{
		return $this->_transactionCost;
	}

	/**
	 * @param mixed $vendorCustomerId
	 */
	public function setVendorCustomerId($vendorCustomerId)
	{
		$this->_vendorCustomerId = $vendorCustomerId;
	}

	/**
	 * @return mixed
	 */
	public function getVendorCustomerId()
	{
		return $this->_vendorCustomerId;
	}


	protected function _addError($msg) {
		$this->_errors[] = $msg;
	}

	public function getErrors() {
		return $this->_errors;
	}

	protected function _clearErrors() {
		$this->_errors = array();
	}

	public function hasErrors() {
		return count($this->_errors) > 0;
	}


	public function getSoapParams() {

		$params = array(
			'firstName'         => $this->getName()->getFirst(),
			'middleName'        => $this->getName()->getMiddle(),
			'lastName'          => $this->getName()->getLast(),
			'homeAddressLine1'  => $this->_homeAddress->getAddressLine1(),
			'homeAddressLine2'  => $this->_homeAddress->getAddressLine2(),
			'homeCity'          => $this->_homeAddress->getCity(),
			'homeState'         => $this->_homeAddress->getState(),
			'homeZip'           => $this->_homeAddress->getZip(),
			'generationCode'    => $this->_generationCode,
			'channelId'         => $this->_channelId,
			'gnaVendorCode'     => $this->_gnaVendorCode,
			'leadOfferFlag'     => $this->_leadOfferFlag,
			'pmcVendorCode'     => $this->_pmcVendorCode,
			'experienceId'      => $this->_experienceId,
			'affId'             => $this->_affId,
			'last4SSN'          => $this->_last4SSN,
			'requestTimeStamp'  => $this->_requestTimeStamp,
		);


		return $params;
	}


}
