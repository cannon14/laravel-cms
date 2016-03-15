<?php

/**
 * Digest/Signature functions
 *
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cccom_Xmlsec_Security {

	/**
	 * @param string $cert Path to cert
	 * @param string $pass
	 */
	public function __construct($cert = '', $pass = '') {

		$this->_cert = $cert;
		$this->_pass = $pass;

	}



	/**
	 * @param Cccom_Xmlsec_XmlRequest $xml
	 *
	 * @return string
	 */
	public function insertSecurityHeader(Cccom_Xmlsec_XmlRequest $xml) {

		$certificate = $this->getFlatCert($this->_cert, $this->_pass);
		$xml->setCertificate($certificate);

		/*
		 * We need to assign an id to the body element
		 * so that we can later use it to generate the digest
		 */
		$refId = 'request';
		$xml->setRefId($refId);

		$digest = $this->generateDigest($xml->getRefNodeXml());
		$xml->setDigest($digest);

		$signature = $this->generateSignature(
			$xml->getSignedInfoXml(),
			$this->_cert,
			$this->_pass
		);

		$xml->setSignature($signature);

		$request = $xml->getXml();

		return $request;

	}


	/**
	 * @param string $content
	 * @param string $algo Hashing algorithm
	 *
	 * @return string The digest
	 */
	public function generateDigest($content, $algo = 'SHA1') {

		$digest = base64_encode(hash($algo, $content, true));

		return $digest;
	}


	/**
	 * @param string $data
	 * @param string $cert Path to certificate
	 * @param string $pass Certificate password
	 *
	 * @return string
	 * @throws SoapFault
	 */
	public function generateSignature($data, $cert, $pass = '') {

		$key = $this->getPrivateKey($cert, $pass);

		// compute signature with SHA-1
		openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA1);

		if(!$signature) {
			throw new SoapFault("1", 'Could not sign request');
		}

		$encoded = base64_encode($signature);

		$formatted = "\n".wordwrap($encoded, 64, "\n", true)."\n";

		return $formatted;

	}


	/**
	 * @param $path
	 * @param $passphrase
	 *
	 * @return resource
	 * @throws SoapFault
	 */
	public function getPrivateKey($path, $passphrase = '') {

		$cert = $this->_getRawCert($path);

		$key = openssl_pkey_get_private($cert, $passphrase);

		if(!$key) {
			throw new SoapFault("1", 'Could not get private key from certificate');
		}

		return $key;
	}




	public function getCert($path) {
		$raw = $this->_getRawCert($path);
		$cert = openssl_x509_read($raw);
		openssl_x509_export($cert, $output);
		return $output;
	}

	public function getFlatCert($path) {
		$cert = $this->getCert($path);
		$lines = explode("\n", $cert);

		// Remove the first and last line (-----BEGIN/END PUBLIC KEY-----)
		array_shift($lines);
		array_pop($lines);
		array_pop($lines);

		$cert = implode("", $lines);
		return $cert;
	}


	/**
	 * @param Cccom_Xmlsec_XmlRequest $xml
	 *
	 * @return boolean
	 */
	public function verifySignature(Cccom_Xmlsec_XmlRequest $xml) {

		// Get the signature from the signedInfo node
		$signedInfo = $xml->getSignedInfoXml();
		$rawSignature = $xml->getSignature();
		$signature64 = base64_decode($rawSignature);

		// Get the certificate in PEM format
		$rawCert = $xml->getCertificate();
		$formattedCert = $this->_getFormattedCertificate($rawCert);

		$publicKey = openssl_pkey_get_public($formattedCert);
		$verified = openssl_verify($signedInfo, $signature64, $publicKey);

		return $verified == 1;

	}

	public function verifyDigest(Cccom_Xmlsec_XmlRequest $xml) {

		$body = $xml->getRefNodeXml();
		$expectedDigest = $this->generateDigest($body);
		$actualDigest = $xml->getDigest();

		return $expectedDigest == $actualDigest;

	}

	protected function _getFormattedCertificate($rawCert) {

		$formattedCert = "-----BEGIN CERTIFICATE-----\n";

		$formattedCert .= wordwrap($rawCert, 64, "\n", true);

		$formattedCert .= "\n-----END CERTIFICATE-----\n";

		return $formattedCert;
	}



	/**
	 * @param $path
	 *
	 * @return string
	 * @throws SoapFault
	 */
	protected function _getRawCert($path) {

		// fetch private key from file
		$raw = file_get_contents($path);
		if (!$raw) {
			throw new SoapFault("1", 'Could not open certificate file');
		}

		return $raw;
	}
}
