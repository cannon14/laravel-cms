<?php

/**
 * Map the response of the ackResponse call
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Amex_AckResponse {

	protected $_statusCode, $_statusDescription, $_transactionId;


	public function __construct($statusCode, $statusDescription, $transactionId) {

		$this->setStatusCode($statusCode);
		$this->setStatusDescription($statusDescription);
		$this->setTransactionId($transactionId);
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

	public function __toString() {
		$string = '('.$this->getStatusCode(). ') '. $this->getStatusDescription() . ' - '.$this->getTransactionId();
		return $string;
	}

}
