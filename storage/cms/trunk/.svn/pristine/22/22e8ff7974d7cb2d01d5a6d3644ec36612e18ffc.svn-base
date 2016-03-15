<?php

session_start();

// DATABASE *************************
defined('DB_HOST')  || define("DB_HOST", "localhost");
defined('DB_NAME')  || define("DB_NAME", "cms_test");
defined('DB_UN')    || define("DB_UN", "cccomususer");
defined('DB_PW')    || define("DB_PW", "cccomususer");


$GLOBALS['RootPath'] = realpath(dirname(__FILE__).'/..');
define("CMS_ROOT", $GLOBALS['RootPath']);

define("MAIN_TEMPLATE", "main");
define("TEMPLATE_SUFFIX",".tpl.php");
define("DEFAULT_MODULE", "csComparator_view_comparator");
define("TEMPLATES_PATH", "templates/");
define("DYNAMIC_TEMPLATES_PATH", TEMPLATES_PATH."/dynamic/");

// Test Paths
define('FIXTURES_PATH', CMS_ROOT.'/tests/fixtures');



require_once($GLOBALS['RootPath'].'/cmsCore/global/global.php');





