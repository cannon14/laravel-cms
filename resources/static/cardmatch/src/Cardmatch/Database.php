<?php

class Cardmatch_Database {

	private static $instance;
	
	private $connection;

    private function __construct()
    {
    	$this->connection = mysql_connect( DB_HOSTNAME,DB_USERNAME,DB_PASSWORD );
    	mysql_select_db( DB_DATABASE, $this->connection );
    }

	/**
	 * @param $sql
	 * @param $params
	 *
	 * @return resource
	 */
	public function query( $sql, $params )
    {
    	$prepSQL = vsprintf( $sql, $params );

    	return mysql_query( $prepSQL, $this->connection );
    }

	/**
	 * @return Cardmatch_Database
	 */
	public static function getInstance()
    {
    	if ( !isset( self::$instance ) )
    	{
    		self::$instance = new Cardmatch_Database();
    	}
    	
    	return self::$instance;
    }

	public static function getDbAdapter() {

		$config = self::_getDbConfig();
		$adapter = Zend_Db::factory($config);

		return $adapter;
	}

	protected static function _getDbConfig() {
		$path = CARDMATCH_PATH . '/config/db.ini';
		$env = APPLICATION_ENV;
		$config = new Zend_Config_Ini($path, $env);

		return $config->database;
	}
}