<?php

/**
 * Amex Error
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Amex_Error {
	protected $_errorCode, $_errorResponse, $_systemName;

	function __construct($errorCode, $errorResponse, $systemName = '')
	{
		$this->setErrorCode($errorCode);
		$this->setErrorResponse($errorResponse);
		$this->setSystemName($systemName);
	}

	/**
	 * @param mixed $errorCode
	 */
	public function setErrorCode($errorCode)
	{
		$this->_errorCode = $errorCode;
	}

	/**
	 * @return mixed
	 */
	public function getErrorCode()
	{
		return $this->_errorCode;
	}

	/**
	 * @param mixed $errorResponse
	 */
	public function setErrorResponse($errorResponse)
	{
		$this->_errorResponse = $errorResponse;
	}

	/**
	 * @return mixed
	 */
	public function getErrorResponse()
	{
		return $this->_errorResponse;
	}

	/**
	 * @param mixed $systemName
	 */
	public function setSystemName($systemName)
	{
		$this->_systemName = $systemName;
	}

	/**
	 * @return mixed
	 */
	public function getSystemName()
	{
		return $this->_systemName;
	}




}
