<?php

/**
 * Barclay Address
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Barclay_Address {
	protected $_addressLine1, $_addressLine2, $_city, $_state, $_zip;

	/**
	 * @param mixed $addressLine1
	 */
	public function setAddressLine1($addressLine1)
	{
		$this->_addressLine1 = $addressLine1;
	}

	/**
	 * @return mixed
	 */
	public function getAddressLine1()
	{
		return $this->_addressLine1;
	}

	/**
	 * @param mixed $addressLine2
	 */
	public function setAddressLine2($addressLine2)
	{
		$this->_addressLine2 = $addressLine2;
	}

	/**
	 * @return mixed
	 */
	public function getAddressLine2()
	{
		return $this->_addressLine2;
	}

	/**
	 * @param mixed $city
	 */
	public function setCity($city)
	{
		$this->_city = $city;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->_city;
	}

	/**
	 * @param mixed $state
	 */
	public function setState($state)
	{
		$this->_state = $state;
	}

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return $this->_state;
	}

	/**
	 * @param mixed $zip
	 */
	public function setZip($zip)
	{
		$this->_zip = $zip;
	}

	/**
	 * @return mixed
	 */
	public function getZip()
	{
		return $this->_zip;
	}

	public function isValid() {

		$shouldNotBeEmpty = array(
			$this->_addressLine1,
			$this->_city,
			$this->_state,
			$this->_zip
		);

		foreach($shouldNotBeEmpty as $field) {
			if(empty($field)) {
				return false;
			}

		}

		return true;

	}

	public function __toString() {

		$string = $this->getAddressLine1()."\n".$this->getAddressLine2()."\n";
		$string .= $this->getCity().' '.$this->getState() . ' ' . $this->getZip();

		return $string;

	}
}
