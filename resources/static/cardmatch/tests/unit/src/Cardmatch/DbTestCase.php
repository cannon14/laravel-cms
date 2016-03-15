<?php

abstract class Cardmatch_DbTestCase extends PHPUnit_Extensions_Database_TestCase {

	private $_conn;
	private static $_pdo;


	/**
	 * @return PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection
	 */
	protected function getConnection()	{

		if ($this->_conn === null) {
			if (self::$_pdo == null) {

				$dsn = DB_TYPE.":dbname=".DB_DATABASE.";host=".DB_HOSTNAME;
				self::$_pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

			}
			$this->_conn = $this->createDefaultDBConnection(self::$_pdo);
		}

		return $this->_conn;

	}

	public function loadDataSet($dataSet) {
		// set the new dataset
		$this->getDatabaseTester()->setDataSet($dataSet);
		// call setUp which adds the rows
		$this->getDatabaseTester()->onSetUp();
	}

}