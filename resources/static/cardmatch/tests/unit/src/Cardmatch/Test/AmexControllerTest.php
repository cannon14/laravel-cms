<?php

class AmexControllerTest extends PHPUnit_Framework_TestCase {
	protected $_controller;

	public function setUp() {
		$this->_controller = new Cardmatch_Test_AmexController();
	}


	public function testRun() {
		$controllerMock = $this->getMockBuilder('Cardmatch_Test_AmexController')
			->setMethods(array('_showForm', '_processInquiry'))
			->getMock();

		$controllerMock->expects($this->exactly(2))
				->method('_showForm');

		$controllerMock->expects($this->exactly(1))
				->method('_processInquiry');


		$_REQUEST['action'] = 'show_test_form';
		$controllerMock->run();

		$_REQUEST['action'] = 'something_default';
		$controllerMock->run();

		$_REQUEST['action'] = 'get-offers';
		$controllerMock->run();
	}

	public function testShowForm() {

		$_REQUEST['action'] = 'show_users_form';
		$this->_controller->run();

		$this->expectOutputRegex('/.*Amex Test Users.*/');

	}


}
