<?php

class Cardmatch_Client_Amex {

	private $_soapClient;
	protected $_statusCode;
	protected $_transactionId;
	protected $_logger;

	public function __construct(Zend_Config $config) {
		$this->_config = $config;
		$this->_logger = Cardmatch_Logger::getInstance();
	}

	/**
	 * @param Cardmatch_Client_Amex_ApplicantInfo $applicantInfo
	 *
	 * @return Cardmatch_Client_Amex_OffersResponse
	 * @throws InvalidArgumentException
	 */
	public function getPreScreenOffers(Cardmatch_Client_Amex_ApplicantInfo $applicantInfo) {

		$this->_transactionId = '';

		if(!$applicantInfo->isValid()) {
			$this->_statusCode = 1;
			throw new InvalidArgumentException("Invalid user info: " . json_encode($applicantInfo->getErrors()));
		}

		$params = array('objaApplicantInfo' => $applicantInfo->getSoapParams());

		$response = $this->_callSoapAction('getPreScreenOffers', $params);

		$offersResponse = new Cardmatch_Client_Amex_OffersResponse($response->offersResponse);

		$this->_statusCode = $offersResponse->getStatusCode();

		$this->_transactionId = $offersResponse->getTransactionId();

		$skus = $offersResponse->getSkus();
		$this->_logSkus($skus);

		return $offersResponse;
	}

	/**
	 * @param String $transactionId The ID returned from a getPreScreenOffers call.
	 * @param int $requestTimeStamp Timestamp in GMT time zone
	 * @return Cardmatch_Client_Amex_AckResponse
	 */
	public function acknowledgeOffer($transactionId, $requestTimeStamp) {

		$params = array(
			"transactionId" => $transactionId,
			"offerCommTimeStamp" => $requestTimeStamp,
			"offerAcceptanceCode" => 'R',
		);

		$response = $this->_callSoapAction('acknowledgeOffer', $params);

		$ackResponse = $response->acknowledgeOfferResponse;

		$statusDescription = $ackResponse->statusDescription;
		$ackResponse = new Cardmatch_Client_Amex_AckResponse(
			$ackResponse->statusCode,
			$statusDescription,
			$ackResponse->transactionId
		);

		$msg = "AMEX - Acknowledged transaction $transactionId - Result: ".$statusDescription;
		$this->_logger->debug($msg);

		return $ackResponse;

	}

	/**
	 * This function is supposed to be used when we actually display
	 * the products to the user. It is not implemented in the Amex API
	 * yet, but I'm leaving this here as a placeholder.
	 *
	 * @return Cardmatch_Client_Amex_AckResponse
	 */
	public function acknowledgeOfferDisplayed() {

		$response = new Cardmatch_Client_Amex_AckResponse(0,'SUCCESS',0);
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
	 * @return Cccom_Xmlsec_SoapClient
	 */
	protected function _createSoapClient(Zend_Config $config) {

		$wsdl = $config->wsdl;
		$client_cert = $config->client_cert;
		$client_pass = $config->client_pass;
		$ssl_cert = $config->ssl_cert;
		$soapClient = new Cccom_Xmlsec_SoapClient($wsdl, $client_cert, $client_pass, $ssl_cert);
		return $soapClient;

	}

	protected function _recordResponseTime($action, $duration) {
		$msg = 'AMEX - API response time for '.$action.': '. $duration.'s';
		$this->_logger->debug($msg);
	}

	protected function _callSoapAction($action, $params) {

		$client = $this->_getSoapClient();
		$startTime = microtime(true);
		$response = $client->$action($params);
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
			$msg = "AMEX - Received skus: " . implode(',', $skus);
		} else {
			$msg = "AMEX - No skus received";
		}
		$this->_logger->debug($msg);
	}
}

