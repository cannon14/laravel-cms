<?php

/**
 * Amex Name
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Amex_Name {
	protected $_first, $_middle, $_last;

	public function __construct($first = '', $middle = '', $last = '') {
		$this->setFirst($first);
		$this->setMiddle($middle);
		$this->setLast($last);
	}

	public function isValid() {

		if(empty($this->_first) || empty($this->_last)) {
			return false;
		}

		return true;
	}


	/**
	 * @param mixed $first
	 */
	public function setFirst($first)
	{
		$this->_first = $first;
	}

	/**
	 * @return mixed
	 */
	public function getFirst()
	{
		return $this->_first;
	}

	/**
	 * @param mixed $last
	 */
	public function setLast($last)
	{
		$this->_last = $last;
	}

	/**
	 * @return mixed
	 */
	public function getLast()
	{
		return $this->_last;
	}

	/**
	 * @param mixed $middle
	 */
	public function setMiddle($middle)
	{
		$this->_middle = $middle;
	}

	/**
	 * @return mixed
	 */
	public function getMiddle()
	{
		return $this->_middle;
	}
}
