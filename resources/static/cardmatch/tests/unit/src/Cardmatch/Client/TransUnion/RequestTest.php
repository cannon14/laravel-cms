<?php

require_once('TestHelper.php');

class RequestTest extends PHPUnit_Framework_TestCase {

	public function testRequestString() {

		$helper = new TransUnion_TestHelper();

		$testUser = $helper->getTestUser();

		$request = new Cardmatch_Client_TransUnion_Request(
			$testUser,
			$helper->getVisitId(),
			$helper->getConfig()
		);

		$this->assertEquals($helper->getVisitId(), $request->getExternalVisitId());

		$requestString = $request->getRequestString();
		$requestId = $request->getRequestId();

		$expectedString = "TU4I0111". $requestId;
		$expectedString .= "06TRP 01681326YMS11NCD01051234567                         SH011AF01                  NM011SMITH                    MARY                                PI01666523655        000 AD01 0           COMMERCIAL                          FANTASY ISLAND             IL60750     3    RP0109910N     DI01L1123456789               DI01L2                        OD010104001                                                     OD010201001                                                     ENDS013";

		$this->assertEquals($expectedString, $requestString);

	}

}
