<?php


class Cardmatch_Client_TransUnion_Request {

    protected $_requestString;
	protected $_requestId;
	protected $_externalVisitId;
	protected $_ipAddress;
	protected $_config;


	/**
	 * @param Cardmatch_User $user
	 * @param $externalVisitId
	 * @param Zend_Config $config
	 */
	public function __construct(Cardmatch_User $user, $externalVisitId, Zend_Config $config) {

		$this->_config = $config;

		$requestId = $this->createRequestId();

        $this->setRequestId( strtoupper($requestId) );
        $this->setExternalVisitId( strtoupper($externalVisitId) );
        //$requestID = "123456789012345678901234"; // 24-bytes

		$segments = $this->_getSegments($user);

		/**
		 * @var $segment Cardmatch_Client_TransUnion_Segment
		 */
		foreach ($segments as $segment) {
			$this->_requestString .= $segment->getRequestString();
		}


    }

	public function createRequestId() {
		$userIp = $_SERVER["REMOTE_ADDR"];
		$this->setIpAddress($userIp);
		$timestamp = time();
		$requestId = substr(md5($userIp . $timestamp . rand(0,999) ), 0, 24);

		return $requestId;
	}

    public function getRequestString() {
        return $this->_requestString;
    }

    public function setRequestString($_requestString) {
        $this->_requestString = $_requestString;
    }

    public function getRequestId() {
        return $this->_requestId;
    }

    public function setRequestId($_requestId) {
        $this->_requestId = $_requestId;
    }

    public function getExternalVisitId() {
        return $this->_externalVisitId;
    }

    public function setExternalVisitId($_externalVisitId) {
        $this->_externalVisitId = $_externalVisitId;
    }

    public function getIpAddress() {
        return $this->_ipAddress;
    }

    public function setIpAddress($_ipAddress) {
        $this->_ipAddress = $_ipAddress;
    }


	public function format($num, $str = "")
	{
		$returnStr = $str;
		if (strlen($returnStr) > $num) $returnStr = substr($returnStr, 0, $num);
		while (strlen($returnStr) < $num) {
			$returnStr .= " ";
		}

		return $returnStr;
	}



	/**
	 * @param $prefix
	 * @param $length
	 * @param $data
	 *
	 * @return Cardmatch_Client_TransUnion_Segment
	 */
	private function _createSegment($prefix, $length, $data = '') {
		$chunk = new Cardmatch_Client_TransUnion_Segment($prefix, $length, $data);
		return $chunk;
	}

	/**
	 * @param Cardmatch_User $user
	 *
	 * @return array
	 */
	private function _getSegments(Cardmatch_User $user)
	{
		$segments = array();

		$streetAddress = $user->getStreetAddress();

		$address = explode(' ', $streetAddress, 2);

		if(!isset($address[1])) {
			$address[1] = '';
		}

		$routingIndicator = $this->_config->routing_indicator;
		$connectionOptions = $this->_config->connection_options;
		$segments[] = $this->_createSegment("TU4I", 52, "0" . $routingIndicator . "11" . $this->getRequestId() . $connectionOptions . "N");
		$segments[] = $this->_createSegment("CD01", 38, "05" . "1234567"); // use customer's internal id
		$segments[] = $this->_createSegment("SH01", 5, "1"); // subject header for subject #1
		$segments[] = $this->_createSegment("AF01", 22, ""); // 8byte access file code to unfreeze report
		$segments[] = $this->_createSegment("NM01", 66, "1" .
				$this->format(25, $user->getLastName()) .
				$this->format(15, $user->getFirstName()) .
				$this->format(15, $user->getMiddleInitial()));
		$segments[] = $this->_createSegment("PI01", 25, // ssn, birthdate, age
				$this->format(9, $user->getSSN()) .
				$this->format(8) .
				"000");
		$segments[] = $this->_createSegment("AD01", 97, " " .
				$this->format(10, $address[0]) .
				$this->format(2, '') .
				$this->format(27, $address[1]) .
				$this->format(2) .
				$this->format(2, '') .
				$this->format(5, '') .
				$this->format(27, $user->getCity()) .
				$this->format(2, $user->getState()) .
				$this->format(10, $user->getZipCode()) .
				$this->format(1, "3")); // 1=own, 2=rent, 3=other

		/*
        $chunkList[] = $this->_createChunk("PN01", 21,                 // phone number
                    $this->_format(2, "01") .
                    $this->_format(3, "555") .
                    $this->_format(7, "5555555"));
		*/

		$segments[] = $this->_createSegment("RP01", 15, "09910" . "N");
		$segments[] = $this->_createSegment("DI01", 30, "L1" . substr($this->getExternalVisitId(), 0, 24)); // first 24-bytes of transid
		$segments[] = $this->_createSegment("DI01", 30, "L2" . substr($this->getExternalVisitId(), 24, 32)); // last 8 bytes
		//$chunkList[] = $this->_createChunk("OR01", 9, "T" );
		$segments[] = $this->_createSegment("OD01", 64, "0104001");
		$segments[] = $this->_createSegment("OD01", 64, "0201001");
		$segments[] = $this->_createSegment("ENDS", 7, "013");

		return $segments;

	}

}

