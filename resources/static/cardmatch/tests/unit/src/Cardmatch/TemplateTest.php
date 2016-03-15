<?php


class Cardmatch_TemplateTest extends PHPUnit_Framework_TestCase {

	public function testAssign() {
		$template = new Cardmatch_Template();
		$template->setTemplatePath(CARDMATCH_PATH.'/tests/fixtures');

		$template->assign("title", "unit testing");
		$output = $template->getDisplay("test");

		$this->assertEquals("unit testing", $output);
	}


	public function testErrors() {

		$template = new Cardmatch_Template();
		$error = new Cardmatch_Error(1, 1, "unit testing");
		$template->setError("main", $error);

		$invalidError = $template->getError("thisDoesntExist");
		$this->assertFalse($invalidError);

		$validError = $template->getError("main");

		$this->assertEquals("unit testing", $validError->getMessage());
	}

}
