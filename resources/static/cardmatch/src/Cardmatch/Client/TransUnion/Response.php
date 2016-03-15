<?php

class Cardmatch_Client_TransUnion_Response {

    protected  $_responseId;
	protected $_externalVisitId;
	protected $_approvedBuckets;
	protected $_errorCode;


	/**
	 * @return string
	 */
	public function getResponseId() {
        return $this->_responseId;
    }

	/**
	 * @param $_responseId
	 */
	public function setResponseId($_responseId) {
        $this->_responseId = $_responseId;
    }

	/**
	 * @return string
	 */
	public function getExternalVisitId() {
        return $this->_externalVisitId;
    }

	/**
	 * @param $_externalVisitId
	 */
	public function setExternalVisitId($_externalVisitId) {
        $this->_externalVisitId = $_externalVisitId;
    }

	/**
	 * @return array
	 */
	public function getApprovedBuckets() {
        return $this->_approvedBuckets;
    }

	/**
	 * @param array $_approvedBuckets
	 */
	public function setApprovedBuckets(Array $_approvedBuckets) {
        $this->_approvedBuckets = $_approvedBuckets;
    }


	/**
	 * @return int
	 */
	public function getErrorCode() {
        return $this->_errorCode;
    }

	/**
	 * @param $_errorCode
	 */
	public function setErrorCode($_errorCode) {
        $this->_errorCode = $_errorCode;
    }



}

