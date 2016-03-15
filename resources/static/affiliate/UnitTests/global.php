<?
/**
*
*   @author webradev.com
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

$GLOBALS['RootPath'] = '../';
$GLOBALS['IncludesPath'] = '../include/'; 
$GLOBALS['mainTemplatePath'] = '';

require_once 'Spreadsheet/Excel/Writer.php';
require_once('../settings/settings.php');
require_once('../settings/globalConst.php');
require_once($GLOBALS['IncludesPath'].'QUnit/Global.class.php');
//define('LANG_PATH', dirname(realpath(__FILE__)).'/../csaCore/langs/');
define('LANG_PATH', '../csaCore/langs/');

// ---------------------------------------------------------------------------
// include files
// ---------------------------------------------------------------------------
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QCore_Sql_DBUnit');
QUnit_Global::includeClass('QCore_History');

QUnit_Global::includeClass('Affiliate_Affiliates_Bl_AffiliateDBAuth');
QUnit_Global::includeClass('Affiliate_Merchants_Views_Settings');

QUnit_Global::includeClass('QCore_Constants');
QCore_Constants::initConstants();

QUnit_Global::includeClass('QUnit_Page');
QUnit_Page::init_page();

define('AUTH_CLASS', 'Affiliate_Affiliates_Bl_AffiliateDBAuth');
define('LOGIN_PAGE', 'QCore_Login');
define('TEMPLATES_PATH','./templates/');
define('LIBRARY_PATH','./library/');


// ---------------------------------------------------------------------------
// log in to database
// ---------------------------------------------------------------------------
$dbObj =& QUnit_Global::newObj('QUnit_Sql_DbConnection', DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$GLOBALS['db'] = $dbObj->getConnection();
$GLOBALS['dbrequests'] = 0;
require_once('util/TestUtilities.class.php');
require_once('util/DataFile.class.php');
require_once('util/Clicker.class.php');
require_once('util/TestBrief.class.php');

// Test Constants:

define('SCRIPT_DIR', 'testscripts');
define('UPLOAD_FILE_DIR', REVENUE_PATH);

define('URL', 'http://cc.localhost.com/t.php');

define('CCCOM', 'cccom_tests');
define('NF_CO', 'nf_cobrand_tests');
define('NF_BANNER', 'nf_banner_tests');

define('ERR_101', 'error_101');
define('ERR_102', 'error_102');
define('ERR_103', 'error_103');
define('ERR_104', 'error_104');
define('ERR_105', 'error_105');
define('VALID_TRANS', 'valid');

define('VALID_RATE', '22144458');
define('INVALID_RATE', '22034413');

define ('BASE_URL', 'http://cc.localhost.com/');
define ('COOKIE', 'cookie.txt');



?>
