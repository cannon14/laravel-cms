<?php
error_reporting(E_ALL ^ E_NOTICE);

$GLOBALS['RootPath'] = "http://".$_SERVER['HTTP_HOST']."/";
require_once( dirname(realpath(__FILE__)).'/../affiliate/settings/settings.php');
require_once(dirname(realpath(__FILE__)).'/../affiliate/settings/globalConst.php');
define('LANG_PATH', dirname(realpath(__FILE__)).'langs/');
$GLOBALS['IncludesPath'] = dirname(realpath(__FILE__)).'/../affiliate/include/';
require_once($GLOBALS['IncludesPath'].'/QUnit/Global.class.php');
$GLOBALS['mainTemplatePath'] = '';

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_History');
require_once(dirname(realpath(__FILE__)).'/../affiliate/settings/emailTemplates.php');

define('AUTH_CLASS', 'Affiliate_Scripts_Bl_Auth');
QUnit_Global::includeClass(AUTH_CLASS);
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

// ---------------------------------------------------------------------------
// log in to database
// ---------------------------------------------------------------------------
$dbObj = QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;
?>
