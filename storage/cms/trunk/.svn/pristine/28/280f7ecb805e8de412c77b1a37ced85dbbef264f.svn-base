<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 15, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */

$GLOBALS['IncludesPath'] = $GLOBALS['RootPath'].'/cmsCore/include/'; 

require_once($GLOBALS['RootPath'].'/cmsCore/global/settings.php');
require_once($GLOBALS['RootPath'].'/cmsCore/global/globalFunctions.php');
require_once($GLOBALS['RootPath'].'/cmsCore/global/constants.php');
require_once($GLOBALS['RootPath'].'/cmsCore/global/dictionary_en.inc.php');
require_once($GLOBALS['IncludesPath'].'csCore/import.class.php');
require_once($GLOBALS['IncludesPath'].'adodb/adodb.inc.php');
require_once($GLOBALS['IncludesPath'].'Savant/Savant2.php');
require_once($GLOBALS['IncludesPath'].'php_charts/charts.php');


csCore_import::importClass('csCore_DB_db');
csCore_import::importClass('CMS_libs_History');

set_error_handler ('_errorHandler');