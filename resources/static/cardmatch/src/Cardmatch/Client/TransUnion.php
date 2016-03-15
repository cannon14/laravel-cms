<?php


class Cardmatch_Client_TransUnion
{

	const ERROR_LEVEL_COMM_FAILURE = 0;
	const ERROR_LEVEL_INQUIRY_FORMAT = 1;
	const ERROR_LEVEL_CB_CONTROL_FIELD = 2; // don't believe these will occur for us
	const ERROR_LEVEL_INVALID_INSTRUCTIONS = 3; // also don't think these will occur
	const ERROR_LEVEL_INVALID_SUBJECT_ID_DATA = 4;

	// TransUnion Level 0 - HW, SW, Telecom errors
	const ERROR_TERMINATED = 1;
	const ERROR_CRONUS_UNAVAIL = 15;
	const ERROR_MARKET_OOS = 21;
	const ERROR_SUBJ_REC_TOO_LONG = 27;
	const ERROR_HW_FAILURE = 29;
	const ERROR_SUBJ_MISFORMAT = 31;
	const ERROR_TOO_MANY_INQUIRIES = 33; // too many inquiries on this file, not from us
	const ERROR_TERM_WATCH_ERROR = 35;
	const ERROR_TERM_DP_ERROR = 41; // DP = DecisionPoint
	const ERROR_DP_MODEL_ERROR = 42;
	const ERROR_INVALID_RESPONSE = 43;
	const ERROR_INVALID_SERVICE_RESPONSE = 50;
	const ERROR_INTERNAL_SERVICE_ERROR = 51;
	const ERROR_UNABLE_TO_CONNECT = 52;
	const ERROR_REQUEST_TIME_OUT = 53;
	const ERROR_INVALID_REQUEST = 55;
	const ERROR_RESPONSE_NOT_CREATED = 56;
	const ERROR_UNABLE_TO_CONNECT_SECONDARY = 57;
	const ERROR_DSBUNDLE_TIME_OUT = 81;
	const ERROR_SERVICE_UNAVAILABLE = 90;
	const ERROR_INTERNAL_SYSTEM_ERROR = 91;
	const ERROR_UNABLE_TO_CONNECT_TO_SERVER = 95;
	const ERROR_FRAUD_DETECT_CONN_FAILURE = 98;
	const ERROR_UNDEFINED_SYSTEM_ERROR = 99;


	// TransUnion user errors
	const ERROR_HOUSE_NUMBER_MISSING = 411;
	const ERROR_CURRENT_ADDRESS_MISSING = 413;
	const ERROR_CURRENT_CITY_MISSING = 415;
	const ERROR_CURRENT_STATE_MISSING = 417;
	const ERROR_CURRENT_ZIP_MISSING = 419;
	const ERROR_INVALID_STATE_OR_ZIP = 420;
	const ERROR_CURRENT_APT_NUM_MISSING = 435;
	const ERROR_MIDDLE_NAME_INVALID = 449;
	const ERROR_CURRENT_STREET_DIR_INVALID = 451;
	const ERROR_CURRENT_STREET_TYPE_INVALID = 453;
	const ERROR_INVALID_CITY_STATE_COMBO = 479;

	// User data is valid, but no buckets found
	const ERROR_NO_BUCKETS_FOUND = 480;

	// Locally defined errors
	const ERROR_CURL = 16;
	const ERROR_NO_RESPONSE_FROM_TUNA = 17;



	protected $_logger;
	protected $_error = null;
	protected $_config;



	public function __construct(Zend_Config $config) {
		$this->_config = $config;
		$this->_logger = Cardmatch_Logger::getInstance();
	}

	/**
	 * @param Cardmatch_User $user
	 * @param $visitId
	 *
	 * @return array
	 */
	public function getApprovedBuckets(Cardmatch_User $user, $visitId) {

		/**
		 * Here we want to verify that the street address starts with a number.
		 * This will keep addresses like PO BOX 117 from returning errors on
		 * TransUnion's side.  We wait until the inquiry time to keep from
		 * confusing the user by changing their input for them.
		 */
		$user->setStreetAddress(
			$this->_formatStreetAddress(
				$user->getStreetAddress()
			)
		);

		$response = $this->sendInquiry($user, $visitId);


		$buckets = array();
		if($response) {
			$buckets = $response->getApprovedBuckets();
		}


		if(empty($buckets) && empty($this->_error)) {
			$this->_error = new Cardmatch_Error(
				self::ERROR_LEVEL_INVALID_SUBJECT_ID_DATA,
				self::ERROR_NO_BUCKETS_FOUND,
				'No buckets found');
		}

		return $buckets;
	}

	public function sendInquiry(Cardmatch_User $user, $externalVisitId)	{

		$request = new Cardmatch_Client_TransUnion_Request($user, $externalVisitId, $this->_config);
		$requestString = $request->getRequestString();

		try {
			$response = $this->_sendTunaRequest($requestString);
		} catch(Exception $e) {
			$this->_logger->err('Transunion - '. $e->getMessage());
			$error = new Cardmatch_Error(0, $e->getCode(), $e->getMessage());
			$this->_error = $error;
			return false;
		}

		if($this->_isCommError($response->getErrorCode())) {
			// Retry the inquiry if we got a communication error
			$response = $this->_sendTunaRequest($requestString);
		}

		$errorCode = $response->getErrorCode();

		if (!empty($errorCode)) {
			$error = $this->_translateErrorCode($errorCode);
			$this->_logger->err('Transunion - '. $error->getMessage());
			$this->_error = $error;
			return false;
		}


		$this->storeTunaRequest($request, $this->_error);

		return $response;

	}

	/**
	 * @param $requestString
	 *
	 * @return Cardmatch_Client_TransUnion_Response
	 * @throws RuntimeException
	 */
	protected function _sendTunaRequest($requestString)	{

		$handle = curl_init();
		$fp = $this->_getTempFile();
		if(!$fp) {
			Throw new RuntimeException('Unable to create tmp log file', self::ERROR_CURL);
		}

		$options = $this->_getCurlOptions($fp, $requestString, $this->_config);
		$this->_logger->insane($requestString);
		curl_setopt_array($handle, $options);
		$rawdata = $this->_sendCurlRequest($handle);


		if($rawdata === false) {
			$this->_logger->err('Transunion - curl failure');
		} else {
			$this->_logger->insane('Transunion - Raw response: ' . $rawdata);
		}


		if (curl_errno($handle)) {
			$msg = 'Curl Error: ' . curl_error($handle);
			Throw new RuntimeException($msg, self::ERROR_CURL);
		}
		curl_close($handle);

		if (!$rawdata) {
			throw new RuntimeException('No Response from TUNA', self::ERROR_NO_RESPONSE_FROM_TUNA);
		}


		$responseBuilder = new Cardmatch_Client_TransUnion_ResponseBuilder();
		$response = $responseBuilder->parseResponse($rawdata);

		return $response;
	}

	protected function _getTempFile() {
		$fp = tmpfile();
		return $fp;
	}

	protected function _sendCurlRequest($handle) {

		$startTime = microtime(true);
		$rawdata = curl_exec($handle);

		$endTime = microtime(true);
		$apiResponseTime = $endTime - $startTime;
		$this->_recordResponseTime('getBuckets', $apiResponseTime);

		return $rawdata;
	}


	protected function _recordResponseTime($action, $duration) {
		$msg = 'Transunion response time for '.$action.': '. $duration.'s';
		$this->_logger->debug($msg);
	}

	/**
	 * @param $tempFile
	 * @param $requestString
	 * @param Zend_Config $config
	 *
	 * @return array
	 */
	protected function _getCurlOptions($tempFile, $requestString, $config) {

		$options = array(
			CURLOPT_STDERR         => $tempFile,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_SSL_VERIFYHOST => '0',
			CURLOPT_SSL_VERIFYPEER => '1',
			CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
			CURLOPT_VERBOSE        => true,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => strtoupper($requestString),
			CURLOPT_SSLCERT        => $config->client_cert,
			CURLOPT_SSLCERTPASSWD  => $config->client_cert_password,
			CURLOPT_CAINFO         => $config->ca_cert,
			CURLOPT_URL            => $config->url,
		);

		return $options;
	}


	/**
	 * @param Cardmatch_Client_TransUnion_Request $request
	 * @param Cardmatch_Error $error
	 *
	 * @return mixed
	 */
	public function storeTunaRequest(Cardmatch_Client_TransUnion_Request $request, Cardmatch_Error $error = null)
	{

		$sql = "INSERT INTO tuna_requests
                    (
                        request_id,
                        external_visit_id,
                        insert_time,
                        error_number
                    )
                VALUES
                    (
                        '" . $request->getRequestId() . "',
                        '" . $request->getExternalVisitId() . "',
                        NOW(),
                        " . (empty($error) ? 0 : $error->getNumber()) . "
                    )
                ";

		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);

		return $rs;
	}


	/**
	 * @return Cardmatch_Error
	 */
	public function getError()
	{
		return $this->_error;
	}

	/**
	 * Returns whether an inquiry error is due to a communications error.
	 * We use this to decide whether we retry the inquiry or not
	 *
	 * @param int $errorCode Error to check
	 *
	 * @return boolean true on fatal error, false otherwise
	 */
	protected function _isCommError($errorCode) {
		
		$commErrors = array(
			self::ERROR_TERMINATED,
			self::ERROR_CRONUS_UNAVAIL,
			self::ERROR_MARKET_OOS,
			self::ERROR_TERM_WATCH_ERROR,
			self::ERROR_INVALID_RESPONSE,
			self::ERROR_INVALID_SERVICE_RESPONSE,
			self::ERROR_INTERNAL_SERVICE_ERROR,
			self::ERROR_UNABLE_TO_CONNECT,
			self::ERROR_REQUEST_TIME_OUT,
			self::ERROR_INVALID_REQUEST,
			self::ERROR_RESPONSE_NOT_CREATED,
			self::ERROR_UNABLE_TO_CONNECT_SECONDARY,
			self::ERROR_DSBUNDLE_TIME_OUT,
			self::ERROR_SERVICE_UNAVAILABLE,
			self::ERROR_NO_RESPONSE_FROM_TUNA
		);

		if(in_array($errorCode, $commErrors)) {
			return true;
		}

		return false;

	}

	/**
	 * Returns whether or not the error is one that we should show to users. These are a subset of level 4 errors.
	 *
	 * @param int $errorCode Error to check
	 *
	 * @return boolean true on fatal error, false otherwise
	 */
	protected function _isUserError($errorCode)	{

		$userErrors = array(
			self::ERROR_HOUSE_NUMBER_MISSING,
			self::ERROR_CURRENT_ADDRESS_MISSING,
			self::ERROR_CURRENT_CITY_MISSING,
			self::ERROR_CURRENT_STATE_MISSING,
			self::ERROR_CURRENT_ZIP_MISSING,
			self::ERROR_INVALID_STATE_OR_ZIP,
			self::ERROR_CURRENT_APT_NUM_MISSING,
			self::ERROR_MIDDLE_NAME_INVALID,
			self::ERROR_CURRENT_STREET_DIR_INVALID,
			self::ERROR_CURRENT_STREET_TYPE_INVALID,
			self::ERROR_INVALID_CITY_STATE_COMBO,
		);

		if(in_array($errorCode, $userErrors)) {
			return true;
		}

		return false;

	}

	/**
	 * This function translates a TransUnion error code into a Cardmatch_Error
	 *
	 * @param $errorCode
	 * @return Cardmatch_Error
	 */
	protected function _translateErrorCode($errorCode) {


		if ($errorCode == 'NCBH') {
			$error = new Cardmatch_Error(1, 10, 'Transunion: No Credit Bureau Hit.');
		}


		if($this->_isCommError($errorCode)) {
			$error = new Cardmatch_Error(self::ERROR_LEVEL_COMM_FAILURE, $errorCode, ERR_COMM_ERROR);
		}


		if($this->_isUserError($errorCode)) {
			$error = new Cardmatch_Error(self::ERROR_LEVEL_INVALID_SUBJECT_ID_DATA, $errorCode, sprintf(ERR_CB_DATA_ERROR, ''));
		}


		if(empty($error)) {
			$error = new Cardmatch_Error(self::ERROR_LEVEL_COMM_FAILURE, $errorCode, ERR_UNKNOWN_ERROR);
		}

		return $error;
	}


	protected function _formatStreetAddress($address){
		$address = trim($address);

		if(!preg_match('/^[0-9]+/', $address)){
			$matches = array();
			preg_match('/[0-9]+/', $address, $matches);

			if(!empty($matches)) {
				$address = $matches[0] . ' ' . $address;
			}
		}

		return $address;
	}

}
