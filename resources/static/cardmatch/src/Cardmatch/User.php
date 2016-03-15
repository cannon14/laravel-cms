<?php

class Cardmatch_User
{


	/**
	 * User's first name
	 */
	private $_firstName;

	/**
	 * User's middle initial
	 */
	private $_middleInitial;

	/**
	 * User's last name
	 */
	private $_lastName;

	/**
	 * Street address
	 */
	private $_streetAddress;

	/**
	 * City
	 */
	private $_city;

	/**
	 * State
	 *
	 */
	private $_state;

	/**
	 * Zip code
	 */
	private $_zipCode;

	/**
	 * Social security number
	 */
	private $_ssn;


	public function getFirstName()
	{
		return $this->_firstName;
	}

	public function setFirstName($firstName)
	{
		$this->_firstName = $firstName;
	}

	public function getMiddleInitial()
	{
		return $this->_middleInitial;
	}

	public function setMiddleInitial($middleInitial)
	{
		$this->_middleInitial = $middleInitial;
	}

	public function getLastName()
	{
		return $this->_lastName;
	}

	public function setLastName($lastName)
	{
		$this->_lastName = $lastName;
	}

	public function getStreetAddress()
	{
		return $this->_streetAddress;
	}

	public function setStreetAddress($streetAddress)
	{
		$this->_streetAddress = $streetAddress;
	}

	public function getCity()
	{
		return $this->_city;
	}

	public function setCity($city)
	{
		$this->_city = $city;
	}

	public function getState()
	{
		return $this->_state;
	}

	public function setState($state)
	{
		$this->_state = $state;
	}

	public function getZipCode()
	{
		return $this->_zipCode;
	}

	public function setZipCode($zipCode)
	{
		$this->_zipCode = $zipCode;
	}

	public function getSSN()
	{
		return $this->_ssn;
	}

	public function setSSN($ssn)
	{
		$this->_ssn = $ssn;
	}

	public function isValid() {

		$fields = array(
			'firstName',
			'lastName',
			'streetAddress',
			'city',
			'state',
			'zipCode',
			'ssn'
		);

		foreach($fields as $field) {
			if(empty($this->{'_' . $field})) {
				return false;
			}
		}

		return true;

	}

}
