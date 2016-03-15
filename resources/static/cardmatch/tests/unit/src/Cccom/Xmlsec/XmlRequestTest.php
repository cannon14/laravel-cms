<?php

/**
 * Class AmexDigestTest
 *
 * @author kenneth.skertchly@creditcards.com
 *
 */
class XmlRequestTest extends PHPUnit_Framework_TestCase {

	/**
	 * Compare our own generated digest against a known digest.
	 *
	 * @param string $path
	 * @param boolean $valid Whether the digest is expected to be valid or not
	 * @dataProvider digestProvider
	 */
	public function testCreateDigest($path, $valid = true) {

		$xml = file_get_contents($path);

		$request = new Cccom_Xmlsec_XmlRequest($xml, false);

		$content = $request->getRefNodeXml();

		$actualDigest = base64_encode(hash('sha1', $content, true));

		$expectedDigest = $request->getDigest();

		$match = $expectedDigest == $actualDigest;
		$this->assertEquals($valid, $match);

	}


	/**
	 * Verify the signature of an XML document
	 *
	 * @param string $path
	 * @param boolean $valid Whether the signature is expected to be valid or not
	 * @dataProvider signatureProvider
	 */
	public function testCreateSignature($path, $valid = true) {

		$xml = file_get_contents($path);

		$request = new Cccom_Xmlsec_XmlRequest($xml, false);

		$security = new Cccom_Xmlsec_Security();
		$verified = $security->verifySignature($request);

		$this->assertEquals($valid, $verified);

	}


	public function signatureProvider() {

		$data = array();

		$path = FIXTURES_PATH . '/amex/AmexSampleSignedRequest.txt';
		$data[] = array($path);

		$path = FIXTURES_PATH . '/amex/AmexSampleSignedRequestModified.txt';
		$data[] = array($path);

		$path = FIXTURES_PATH . '/amex/CccomGeneratedRequest.txt';
		$data[] = array($path);

		$path = FIXTURES_PATH . '/amex/tamperedSignature.txt';
		$data[] = array($path, false);

		return $data;
	}



	public function digestProvider() {

		$data = array();

		$path = FIXTURES_PATH . '/amex/AmexSampleSignedRequest.txt';
		$data[] = array($path);

		$path = FIXTURES_PATH . '/amex/CccomGeneratedRequest.txt';
		$data[] = array($path);

		$path = FIXTURES_PATH . '/amex/tamperedRequest.txt';
		$data[] = array($path, false);



		return $data;
	}


}