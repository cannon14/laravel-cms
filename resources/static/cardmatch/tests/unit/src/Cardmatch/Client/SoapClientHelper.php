<?php

/**
 * Class used to help capture outgoing SOAP requests
 * and return a predefined response
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */


class Cardmatch_Test_Client_SoapClientHelper extends SoapClient {

	private $_response;

	public function __construct($wsdl, $options = array(), $response = '') {
		$this->_response = $response;
		parent::SoapClient($wsdl, $options);
	}

	public function __doRequest($request, $location, $action, $version, $one_way = 0) {
		return $this->_response;
	}

}
