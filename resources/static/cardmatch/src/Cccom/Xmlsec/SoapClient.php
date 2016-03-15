<?php

/**
 * WS-Security related functions
 *
 * Handle WSSE security headers with digest
 *
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cccom_Xmlsec_SoapClient extends SoapClient {

	protected $_signatureCert, $_signaturePass;

	/**
	 * @param string $wsdl
	 * @param string $client_cert Path to client cert file (should include public/private keys)
	 * @param string $client_pass Password for client cert
	 * @param string $ssl_cert Path to SSL cert
	 */
	public function __construct($wsdl, $client_cert, $client_pass, $ssl_cert) {

		$options = array(
			"trace" => 1,
			'cache_wsdl' => WSDL_CACHE_NONE,
			'soap_version' => SOAP_1_1,
			'local_cert' => $ssl_cert
		);

		$this->_signatureCert = $client_cert;
		$this->_signaturePass = $client_pass;


		parent::SoapClient($wsdl, $options);

	}

	public function __doRequest($request, $location, $action, $version, $one_way = 0) {

		$securedRequest = $this->_secureRequest($request);

		return parent::__doRequest($securedRequest, $location, $action, $version, $one_way);

	}

	protected function _secureRequest($request) {


		$request = str_replace("SOAP-ENV", 'soapenv', $request);

		$xml = new Cccom_Xmlsec_XmlRequest($request);
		$security = new Cccom_Xmlsec_Security($this->_signatureCert, $this->_signaturePass);

		$securedRequest = $security->insertSecurityHeader($xml);

		return $securedRequest;
	}





}