<?php
require_once('TestHelper.php');

class Cardmatch_Client_TransUnion_ResponseTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var TransUnion_TestHelper
	 */
	protected $_helper;


	public function setUp() {

		$this->_helper = new TransUnion_TestHelper();
	}

	public function testParseSegments() {

		$data = substr(md5('unittesting'),0,23);

		$expectedSegments = array(
			new Cardmatch_Client_TransUnion_Segment('TU4E', 31, $data.'1'),
		);

		$responseString = '';
		foreach($expectedSegments as $segment) {
			$responseString .= $segment->getResponseString();
		}


		$builder = new Cardmatch_Client_TransUnion_ResponseBuilder();
		$response = $builder->parseResponse($responseString);

		$this->assertEquals('cada8d699e7fa9bd567e1', $response->getResponseId());

	}

	public function testIds() {
		$request = $this->_getRequest();
		$response = $this->_getResponse($request);

		$this->assertEquals($request->getRequestId(), $response->getResponseId());
		$this->assertEquals($request->getExternalVisitId(), $response->getExternalVisitId());
	}


	public function testNoCreditBureauHit() {

		$request = $this->_getRequest();
		$response = $this->_getResponse($request, true);
		$errorCode = $response->getErrorCode();

		$this->assertEquals('NCBH', $errorCode);

	}

	public function testErrorCode() {

		$request = $this->_getRequest();
		$errorCode = '123';
		$responseString = $request->format(11, "ERRC" . "011" . 'C'. $errorCode);

		$builder = new Cardmatch_Client_TransUnion_ResponseBuilder();
		$response = $builder->parseResponse($responseString);

		$this->assertEquals($errorCode, $response->getErrorCode());
	}

	protected function _getRequest($userId = 0) {

		$user = $this->_helper->getTestUser($userId);

		$request = new Cardmatch_Client_TransUnion_Request(
			$user,
			$this->_helper->getVisitId(),
			$this->_helper->getConfig()
		);


		return $request;
	}

	protected function _getResponse($request, $ncbh = false) {

		$helper = new TransUnion_TestHelper();
		$user = $helper->getTestUser();

		$responseString = $this->_helper->getTestResponseString($request, $user, $ncbh);
		$builder = new Cardmatch_Client_TransUnion_ResponseBuilder();
		$response = $builder->parseResponse($responseString);
		return $response;

	}


	public function testBucketsApproved() {

		$request = $this->_getRequest();
		$response = $this->_getResponse($request);

		$expectedBuckets = array(
			'AX01',
			'AX02',
			'AX24',
			'CO01',
			'CO02',
		);

		$this->assertEquals($expectedBuckets, $response->getApprovedBuckets());

	}

	public function testNoBucketsApproved() {

		$request = $this->_getRequest();
		$response = $this->_getResponse($request, true);

		$expectedBuckets = array();

		$this->assertEquals($expectedBuckets, $response->getApprovedBuckets());

	}



}
