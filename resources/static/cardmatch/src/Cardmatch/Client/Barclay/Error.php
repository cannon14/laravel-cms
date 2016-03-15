<?php

/**
 * Barclay Error
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Client_Barclay_Error {
	protected $_errorCode;

	public function __construct($errorCode)
	{
		$this->setErrorCode($errorCode);
		
		$errorResponse = $this->_mapErrorCodeToResponse($errorCode);
		$this->setErrorResponse($errorResponse);
		
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

	protected function _mapErrorCodeToResponse($errorCode){
		$errorResponses = array(
			'1000' => 'No Product Found',
			'1001' => 'Invalid First Name',
			'1002' => 'Invalid Last Name',
			'1003' => 'Invalid Address Line 1',
			'1004' => 'Invalid Address Line 2',
			'1005' => 'Invalid City',
			'1006' => 'Invalid State',
			'1007' => 'Invalid Zip',
			'1008' => 'Invalid Zip, State Combination'
		);

		$errorResponse = (!empty($errorResponses[$errorCode])) ? $errorResponses[$errorCode] : 'Unknown Error' ;
		return $errorResponse;
	}

}
