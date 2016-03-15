<?php

class Cardmatch_Client_Barclay {

	private $_soapClient;
	protected $_statusCode;
	protected $_transactionId;
	protected $_logger;
	protected $_errors = array();

	public function __construct(Zend_Config $config) {
		$this->_config = $config;
		$this->_logger = Cardmatch_Logger::getInstance();
	}

	/**
	 * @param Cardmatch_Client_Barclay_ApplicantInfo $applicantInfo
	 *
	 * @return Cardmatch_Client_Barclay_OffersResponse
	 * @throws InvalidArgumentException
	 */
	public function getPreScreenOffers(Cardmatch_Client_Barclay_ApplicantInfo $applicantInfo) {
		$this->_transactionId = '';

		if(!$applicantInfo->isValid()) {
			throw new InvalidArgumentException("Invalid user info: " . json_encode($applicantInfo->getErrors()));
		}

		$params = $applicantInfo->getSoapParams();

		$response = $this->_callSoapAction('getProactivePrescreenProducts', $params);

		$offersResponse = new Cardmatch_Client_Barclay_OffersResponse($response);

		$errors = $offersResponse->getErrorCodes();
		$errorCode = (!empty($errors[0])) ? $errors[0] : NULL;
		//throw exception if there are errors.
		if (!empty($errorCode)) {
			$barclayError = new Cardmatch_Client_Barclay_Error($errorCode);
			$errorText = $barclayError->getErrorResponse();
			throw new InvalidArgumentException($errorText);
		}
		$skus = $offersResponse->getSkus();
		$this->_logSkus($skus);

		return $offersResponse;
	}

	/**
	 * @param array $acknowledgments
	 * @return Cardmatch_Client_Barclay_AckResponse
	 */
	public function acknowledgeOffer($acknowledgments) {

		$params = array();
		$params['PrescreenOfferCaptureRequest'] = array();
		$prescreenId = array();
		foreach($acknowledgments as $acknowledgment){
			$offerCaptures = new stdClass();
			$offerCaptures->contextId = $acknowledgment->contextId;
			$offerCaptures->prescreenId = $acknowledgment->prescreenId;
			$prescreenId[] = $acknowledgment->prescreenId;
			$offerCaptures->customerAcceptanceType = 'DECLINED';
			$params['offerCaptures'][] = $offerCaptures;
		}

		$response = $this->_callSoapAction('offerCapture', $params);
		
		$statusCode = $response->statusInfo->statusCode;

		$ackResponse = new Cardmatch_Client_Barclay_AckResponse($statusCode);


		$msg = "Barclay - Acknowledged transaction(s)". implode(',', $prescreenId)." - Result: ".$ackResponse;
		$this->_logger->debug($msg);

		return $ackResponse;

	}

	/**
	 * This function is supposed to be used when we actually display
	 * the products to the user. It is not implemented in the Barclay API
	 * yet, but I'm leaving this here as a placeholder.
	 *
	 * @return Cardmatch_Client_Barclay_AckResponse
	 */
	public function acknowledgeOfferDisplayed() {

		$response = new Cardmatch_Client_Barclay_AckResponse('SUCCESS');
		return $response;

	}

	public function getStatusCode() {
		return $this->_statusCode;
	}

	public function getTransactionId() {
		return $this->_transactionId;
	}

	protected function _getSoapClient() {

		// Lazy loading
		if($this->_soapClient == null) {
			$this->_soapClient = $this->_createSoapClient($this->_config);
		}

		return $this->_soapClient;
	}

	/**
	 * @param Zend_Config $config
	 *
	 * @return SoapClient
	 */
	protected function _createSoapClient(Zend_Config $config) {
		$options = array(
			"trace" => 1,
			'cache_wsdl' => WSDL_CACHE_NONE,
			'soap_version' => SOAP_1_1,
			'local_cert' => $config->ssl_cert,
			'passphrase' => $config->ssl_pass
		);
		$soapClient = new SoapClient($config->wsdl, $options);
		return $soapClient;

	}

	protected function _recordResponseTime($action, $duration) {
		$msg = 'Barclay API response time for '.$action.': '. $duration.'s';
		$this->_logger->debug($msg);
	}

	protected function _callSoapAction($action, $params) {

		$client = $this->_getSoapClient();
		$startTime = microtime(true);

		try{
			$response = $client->$action($params);
		} catch (Exception $e) {
			$msg = "Barclay API Error: ".$e->getMessage();
			$error = new Cardmatch_Error(0,	1,$msg);
			$this->_errors[] = $error;
			$this->_logger->err($msg);
			return false;
		}

		$endTime = microtime(true);

		$apiResponseTime = $endTime - $startTime;
		$this->_recordResponseTime($action, $apiResponseTime);

		return $response;
	}

	/**
	 * @param $skus
	 */
	protected function _logSkus($skus) {
		if (is_array($skus)) {
			$msg = "Barclay - Received skus: " . implode(',', $skus);
		} else {
			$msg = "Barclay - No skus received";
		}
		$this->_logger->debug($msg);
	}
}

