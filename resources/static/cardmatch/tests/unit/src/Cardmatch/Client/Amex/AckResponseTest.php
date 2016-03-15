<?php

class Cardmatch_Client_Amex_AckResponseTest extends PHPUnit_Framework_TestCase {

	public function testResponseToString() {

		$response = new Cardmatch_Client_Amex_AckResponse(0, 'Unit Testing', '12345');

		$this->expectOutputString('(0) Unit Testing - 12345');

		echo $response;
	}

}
