<?php


class SignatureTest extends PHPUnit_Framework_TestCase {


	/**
	 * @param $filePath
	 * @dataProvider filesProvider
	 */
	public function testGeneratedRequestIsValid($filePath) {

		$contents = file_get_contents($filePath);
		$cert = CARDMATCH_PATH . "/tests/data/signature/verizon/amex-full.pem";

		$xmlSec = new Cccom_Xmlsec_Security($cert);
		$xml = new Cccom_Xmlsec_XmlRequest($contents, false);

		$validDigest = $xmlSec->verifyDigest($xml);
		$expectedDigest = $xmlSec->generateDigest($xml->getRefNodeXml());
		$this->assertTrue($validDigest, "Digest is not valid. Expected Digest:\n ". $expectedDigest);

		$validSig = $xmlSec->verifySignature($xml);
		$this->assertTrue($validSig, 'Signature is not valid');


	}


	public function filesProvider() {

		$params = array(
			array(FIXTURES_PATH.'/amex/CccomSignedRequest.txt'),
			array(FIXTURES_PATH.'/amex/CccomGeneratedRequest.txt'),
		);

		return $params;
	}
}
