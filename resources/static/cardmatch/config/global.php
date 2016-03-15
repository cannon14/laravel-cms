<?php

$GLOBALS['RootPath'] = "http://".$_SERVER['HTTP_HOST']."/";

defined('AFFILIATE_PATH') || define('AFFILIATE_PATH', dirname(realpath(__FILE__)).'/../../affiliate');
require_once(AFFILIATE_PATH.'/settings/settings.php');
require_once(AFFILIATE_PATH.'/settings/globalConst.php');
require_once(AFFILIATE_PATH.'/include/QUnit/Global.class.php');

$GLOBALS['mainTemplatePath'] = '';

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_History');
require_once(AFFILIATE_PATH.'/settings/emailTemplates.php');

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
