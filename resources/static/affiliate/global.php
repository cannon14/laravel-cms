<?
/**
*
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

#$GLOBALS['RootPath'] = "";
define('LANG_PATH', dirname(realpath(__FILE__)).'/langs/');
require_once(dirname(__FILE__) . '/settings/settings.php');
require_once(dirname(__FILE__) . '/settings/globalConst.php');



if(PAP_RELEASE == 1)
{
    $GLOBALS['IncludesPath'] = dirname(__FILE__) . '/include/';
    require_once($GLOBALS['IncludesPath'].'QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}
else
{
    $GLOBALS['IncludesPath'] = dirname(__FILE__) . '/../..';
    require_once($GLOBALS['IncludesPath'].'/QUnit/Global.class.php');
    $GLOBALS['mainTemplatePath'] = '';
}


// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QCore_History');
require_once(dirname(__FILE__) . '/settings/emailTemplates.php');

QUnit_Global::includeClass('Affiliate_Scripts_Bl_Auth');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

defined('AUTH_CLASS') || define('AUTH_CLASS', 'Affiliate_Scripts_Bl_Auth');


// ---------------------------------------------------------------------------
// log in to database
// ---------------------------------------------------------------------------
$dbObj = QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;


// ---------------------------------------------------------------------------
// init authorization object
// ---------------------------------------------------------------------------
begin_page();

/*
QUnit_Global::includeClass('QCore_Auth');
QUnit_Global::includeClass('QCore_Settings');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QUnit_Messager');
QUnit_Global::includeClass('QCore_EmailTemplates');

QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SignupUser');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SignupAcct');
*/

// ---------------------------------------------------------------------------
// set language file
// ---------------------------------------------------------------------------
setLanguage();

