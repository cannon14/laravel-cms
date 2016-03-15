<?php

/**
 * Barclay pre-screened offers applicant info
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */
class Cardmatch_Client_Barclay_ApplicantInfo {

	protected $_last4SSN,
		$_referrerId;

	const CLIENT_PRODUCT_CODE = "APB";

	protected $_errors = array();

	/**
	 * @var Cardmatch_Client_Barclay_Name
	 */
	protected $_name;

	/**
	 * @var Cardmatch_Client_Barclay_Address
	 */
	protected $_address;

	/**
	 * @param Cardmatch_Client_Barclay_Address $address
	 */
	public function setAddress(Cardmatch_Client_Barclay_Address $address = null) {
		$this->_address = $address;
	}

	/**
	 * @return Cardmatch_Client_Barclay_Address
	 */
	public function getAddress() {
		return $this->_address;
	}

	/**
	 * @param mixed $last4SSN
	 */
	public function setLast4SSN($last4SSN) {
		$this->_last4SSN = $last4SSN;
	}

	/**
	 * @return mixed
	 */
	public function getLast4SSN() {
		return $this->_last4SSN;
	}

	/**
	 * @param Cardmatch_Client_Barclay_Name $name
	 */
	public function setName(Cardmatch_Client_Barclay_Name $name) {
		$this->_name = $name;
	}

	/**
	 * @return Cardmatch_Client_Barclay_Name
	 */
	public function getName() {
		return $this->_name;
	}

	public function getSoapParams() {

		$params = array(
			'clientProductCode' => self::CLIENT_PRODUCT_CODE,
			'firstName' => $this->getName()->getFirst(),
			'lastName' => $this->getName()->getLast(),
			'ssn' => $this->_last4SSN,
			'addressline1' => $this->_address->getAddressLine1(),
			'city' => $this->_address->getCity(),
			'state' => $this->_address->getState(),
			'zip' => $this->_address->getZip(),
			'referrerId' => $this->_referrerId
		);

		return $params;
	}

	/**
	 * @param mixed $referrerId
	 */
	public function setReferrerId($referrerId) {
		$this->_referrerId = $referrerId;
	}

	/**
	 * @return mixed
	 */
	public function getReferrerId() {
		return $this->_referrerId;
	}

	/**
	 * @return bool
	 */
	public function isValid() {
		$this->_clearErrors();

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

		if(!$this->isAddressValid()) {
			$error = 'Address is invalid';
			$this->_addError($error);
			return false;
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function isSSNValid() {
		if(!empty($this->_last4SSN) && strlen($this->_last4SSN) != 4) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public function isAddressValid() {
		$address = $this->getAddress();
		if(!$address instanceof Cardmatch_Client_Barclay_Address) {
			return false;
		}

		return $address->isValid();
	}

	/**
	 * @return array
	 */
	public function getErrors() {
		return $this->_errors;
	}

	/**
	 * @param $msg
	 */
	protected function _addError($msg) {
		$this->_errors[] = $msg;
	}

	/**
	 *
	 */
	protected function _clearErrors() {
		$this->_errors = array();
	}

	/**
	 * @return bool
	 */
	public function hasErrors() {
		return count($this->_errors) > 0;
	}
}
