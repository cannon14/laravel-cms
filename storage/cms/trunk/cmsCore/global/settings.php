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
// PROJECT **************************
define("PROJECT_NAME", "Content Management System");
define("PROJECT_VERSION", "2.0");
// **********************************

// DATABASE *************************
defined('DB_HOST') || define("DB_HOST", "localhost");
defined('DB_TYPE') || define("DB_TYPE", "mysql");
defined('DB_NAME') || define("DB_NAME", "cms");
defined('DB_UN') || define("DB_UN", "cccomususer");
defined('DB_PW') || define("DB_PW", "cccomususer");
defined('ENTITY_ID') || define("ENTITY_ID","100");

// ***********************************

// NETFINITI DATABASE ****************
define("NFDB_HOST", "localhost");
define("NFDB_TYPE", "mysql");
define("NFDB_NAME", "csdb");
define("NFDB_UN", "root");
define("NFDB_PW", "");
// ***********************************

// DEBUG *****************************
define("VERBOSE_DEBUG", true);
define("DEBUG_MODE", true);
define("DEBUG_EMAIL", "patrick@clicksuccess.com");
// ***********************************

// LOG *******************************
define("LOG_PREFIX", "csCore");
define("LOG_PATH", "/usr/local/logs");
// ***********************************

// TEMPLATES *************************
define("GLOBAL_TEMPLATES", $GLOBALS['RootPath']."/cmsCore/global/templates");
define("CCCOMUS_CARD_IMAGE_ROOT", "http://images.creditcards.com" );
define("CCCOMUSMOBILE_CARD_IMAGE_ROOT", "http://images.creditcards.com" );
define("IMGSYNERGY_CARD_IMAGE_ROOT","http://imgsynergy.com/cccom");
define("IMGSYNERGY_110X70_CARD_IMAGE_ROOT","http://imgsynergy.com/110x70");
define("IMGSYNERGY_191X120_CARD_IMAGE_ROOT","http://imgsynergy.com/191x120");
// ***********************************

// SECURITY **************************
define("AUTH_SESSION", "auth");
define("NOT_LOGGED", "csCore_view_login");
define("NOT_PERMITTED", "csCore_view_unauthorized");
define("LOGIN_TRIES", 10);
// ***********************************

// Messaging *************************
define("MESSAGE_SESSION", "msg");
// ***********************************

// UI ********************************
define("SORT_SESSION", "sortArray");
define("FILTER_SESSION", "filterArray");
// ***********************************

// SETTINGS **************************
define("SETTING_SESSION", "setsess");
// ***********************************

//SITEPATH **************************
//define("SITE_PATH", "/home/jasonh/cardsdev/cms");
define("SITE_PATH", "/usr/local/apache2/htdocs/dev/cms/");

//SCRIPT PATH ***********************
define("SCRIPT_PATH", "/usr/local/apache2/htdocs/dev/cms/cms/script/");

//An array of FIDs for individual card pages that should show right gutters.
define('RIGHT_GUTTER_INCLUDE_FID_LIST', serialize(array(11, 12, 1477, 14, 77, 79, 78, 15, 16, 2022, 2005, 17, 18, 19, 1768, 13, 2116, 2018, 76, 75, 74, 20, 1077)));

//Dev Credentials
//Dev Credentials
define("REVIEWS_API_URL", "http://review-manager.davidc.in.creditcards.com/api/v1/");
define("REVIEWS_API_USERNAME", "david.cannon");
define("REVIEWS_API_PASSWORD", "Megadeth1");
define('REVIEWS_ENABLED', 1);