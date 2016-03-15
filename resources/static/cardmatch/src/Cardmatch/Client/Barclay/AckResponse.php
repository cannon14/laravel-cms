<?php

/**
 * Map the response of the ackResponse call
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Barclay_AckResponse {

	protected $_statusCode;


	public function __construct($statusCode) {

		$this->setStatusCode($statusCode);
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

	public function __toString() {
		$string = $this->getStatusCode();
		return $string;
	}

}
