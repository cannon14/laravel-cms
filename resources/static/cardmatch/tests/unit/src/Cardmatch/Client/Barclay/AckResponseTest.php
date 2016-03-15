<?php

class Cardmatch_Client_Barclay_AckResponseTest extends PHPUnit_Framework_TestCase {

	public function testResponseToString() {

		$response = new Cardmatch_Client_Barclay_AckResponse('SUCCESS');

		$this->expectOutputString('SUCCESS');

		echo $response;
	}

}
