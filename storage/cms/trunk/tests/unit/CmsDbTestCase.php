<?php


abstract class CmsDbTestCase extends PHPUnit_Extensions_Database_TestCase {

	private $_conn;
	private static $_pdo;

	protected function getConnection()	{

		if ($this->_conn === null) {
			if (self::$_pdo == null) {

				$dsn = "mysql:dbname=cms_test;host=".DB_HOST;
				self::$_pdo = new PDO($dsn, DB_UN, DB_PW);

			}
			$this->_conn = $this->createDefaultDBConnection(self::$_pdo);
		}

		return $this->_conn;

	}
} 