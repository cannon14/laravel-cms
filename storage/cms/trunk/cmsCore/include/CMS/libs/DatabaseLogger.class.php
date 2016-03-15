<?php

class DatabaseLogger {

	protected $sql;
	protected $referer;
	protected $user;

	/**
	 * @param string $user
	 */
	public function __construct($user = '') {
		$this->sql = '';
		$this->referer = $_SERVER['HTTP_REFERER'];
		$this->user = $user;
	}

	public function log($message, $data) {
		$this->constructSql($message, $data);
		$this->executeSql();
	}

	/**
	 * Takes message and data and constructs the raw sql query
	 *
	 * @param        $data
	 * @param string $message
	 */
	protected function constructSql($data, $message = '') {

		if (is_null($data)) {
			throw new Exception('Data must be instantiated');
		}

		$encodedData = json_encode($data);

		$sql = "INSERT INTO " . CMS_LOGGING_TABLE;
		$sql .= " (log_message, log_data, app_user, app_referer) ";
		$sql .= "VALUES ('{$message}', '{$encodedData}', '{$this->user}', '{$this->referer}')";

		$this->sql = $sql;
	}

	/**
	 * Uses raw sql query that has been constructed and uses global query functions to execute query
	 *
	 * @throws Exception
	 */
	protected function executeSql() {
		if (!$this->sql === '') {
			throw new Exception('No sql statements are defined');
		}

		_sqlQuery($this->sql, __LINE__, __FILE__, DEBUG_MODE);
	}

}