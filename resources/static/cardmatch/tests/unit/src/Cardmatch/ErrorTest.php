<?php


class Cardmatch_ErrorTest extends PHPUnit_Framework_TestCase {


	public function testSettersAndGetters() {

		$level = 1;
		$number = 2;
		$message = 'Unit Testing';

		$error = new Cardmatch_Error($level, $number, $message);

		$this->assertEquals($level, $error->getLevel());
		$this->assertEquals($number, $error->getNumber());
		$this->assertEquals($message, $error->getMessage());

		return $error;

	}

	/**
	 * @depends testSettersAndGetters
	 */
	public function testErrorOutput($error) {
		$this->expectOutputString('Error - Level: 1 Number: 2 Message: Unit Testing');
		echo $error;
	}

}
