<?php
/**
 * 
 * CreditCards.com
 * 3/15/2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */
csCore_import::importClass('csCore_DB_db');

class CMS_libs_secondaryDbConnection extends csCore_DB_db{
    /**
     * Create an ADODB connection to a database and return the ADODB object
     * @param String Type of database (ex. mysql)
     * @param String Hostname where the database resides
     * @param String Username to connect to the database server
     * @param String Password to connect to the database server
     * @param String Database to connect to
     */
    function CMS_libs_secondaryDbConnection($type, $host, $user, $pass, $db) {
    	$this->DB = NewADOConnection($type);
		$this->DB->PConnect($host, $user, $pass, $db, true);
		$this->DB->SetFetchMode(ADODB_FETCH_ASSOC); //default is ADODB_FETCH_DEFAULT
    }
}
?>