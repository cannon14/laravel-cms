<?php


class Cardmatch_CardTest extends PHPUnit_Framework_TestCase {
	
	public function testSettersAndGetters() {

		$dao = new Cardmatch_CardDao();

		$r = new ReflectionClass($dao);
		$method = $r->getMethod('_getMap');
		$method->setAccessible(true);
		$map = $method->invokeArgs($dao, []);

		$fields = array_keys($map);

		$card = new Cardmatch_Card();

		foreach($fields as $field) {
			$setter = 'set'.ucfirst($field);
			$getter = 'get'.ucfirst($field);
			$expected = md5(rand());
			$card->$setter($expected);
			$actual = $card->$getter();
			$this->assertEquals($expected, $actual);
		}
	}

}
