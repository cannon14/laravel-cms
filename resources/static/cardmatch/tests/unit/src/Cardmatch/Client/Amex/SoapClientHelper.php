<?php

/**
 * Class used to help capture outgoing SOAP requests
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */


class Cardmatch_Test_Client_Amex_SoapClientHelper extends Cccom_Xmlsec_SoapClient {

	private $_request;
	private $_response;

	public function __construct($config, $response = '') {

		$this->_response = $response;
		parent::__construct($config->wsdl, $config->client_cert, $config->client_pass, $config->ca_cert);

	}

	public function __doRequest($request, $location, $action, $version, $one_way = 0) {

		$securedRequest = $this->_secureRequest($request);
		$this->_request = $securedRequest;
		return $this->_response;
	}

	public function getRequest() {
		return $this->_request;
	}
}
