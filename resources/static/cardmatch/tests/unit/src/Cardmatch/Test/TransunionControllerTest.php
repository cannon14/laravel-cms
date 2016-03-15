<?php

class TransunionControllerTest extends PHPUnit_Framework_TestCase {
	protected $_controller;

	public function setUp() {
		$this->_controller = new Cardmatch_Test_TransUnionController();
	}


	public function testRun() {
		$controllerMock = $this->getMockBuilder('Cardmatch_Test_TransUnionController')
			->setMethods(array('_showForm', '_processInquiry'))
			->getMock();

		$controllerMock->expects($this->exactly(2))
				->method('_showForm');

		$controllerMock->expects($this->exactly(1))
				->method('_processInquiry');


		$_REQUEST['action'] = 'show_test_form';
		$controllerMock->run();

		$_REQUEST['action'] = 'run_tuna_test';
		$controllerMock->run();

		$_REQUEST['action'] = 'something_default';
		$controllerMock->run();
	}

	public function testSetupChannel() {
		$reflector = new ReflectionMethod($this->_controller, '_getChannel');
		$reflector->setAccessible(true);

		$channel = $reflector->invoke($this->_controller);

		$this->assertEquals('Cardmatch_Channel_TransUnion', get_class($channel));
	}


}
