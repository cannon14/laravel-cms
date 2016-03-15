<?php

// database connections moved into global.php
//if ( !defined( 'DB_HOST' ) ) 				define( 'DB_HOST', 'localhost' );
//if ( !defined( 'DB_USER' ) ) 				define( 'DB_USER', 'root' );
//if ( !defined( 'DB_PASS' ) ) 				define( 'DB_PASS', '' );
//if ( !defined( 'DB_NAME' ) )				define( 'DB_NAME', 'cccomus' );

if ( !defined( 'TEMPLATE_BASE_PATH' ) ) 	define( 'TEMPLATE_BASE_PATH', CARDMATCH_PATH.'/templates' );
if ( !defined( 'LANGUAGE' ) ) 			define( 'LANGUAGE', 'en' );

if ( !defined( 'APPLY_LINK' ) ) define( 'APPLY_LINK', '/oc.php?pid=%d&pg=%d&pgpos=%d' );

if ( !defined( 'CARD_LINK' ) )	define( 'CARD_LINK',  'http://www.creditcards.com/credit-cards/%s.php' );

// if results are set and have a timestamp within the seconds defined by RESULTS_TIME_TO_FORWARD, we forward straight to the results
if ( !defined( 'RESULTS_TIME_TO_FORWARD') )	define( 'RESULTS_TIME_TO_FORWARD', 86400 * 7); // 7 days

// if results are set and have a timestamp within the seconds defined by RESULTS_TIME_TO_SHOW_LINK, we show a link offering to take them
// straight back to their previous results
// if set to false will never show link
if ( !defined( 'RESULTS_TIME_TO_SHOW_LINK') )	define( 'RESULTS_TIME_TO_SHOW_LINK', 1 );

if ( !defined( 'CMS_CONTEXT_IFILTERING') )	define( 'CMS_CONTEXT_IFILTERING', 2 );

define("FEEDS_WSDL_SERVER_ADDRESS", "http://feeds.creditcards.com:8535/cardquery/QueryService?wsdl");
//define("FEEDS_WSDL_SERVER_ADDRESS", "http://lindev04.in.creditcards.com:8080/cardquery/QueryService?wsdl");
//define("FEEDS_WSDL_SERVER_ADDRESS", "http://tylerc.in.creditcards.com:8084/cardquery/QueryService?wsdl");

define('TUNA_CONSENT_VERSION', 4); //this must be updated whenever the consent text changes
define('TUNA_LOG_DEBUG_MSGS', true); //should be FALSE. if true, will log raw strings for debugging

define('TRANSUNION_PING_ENABLED', true);
define('TRANSUNION_PING_PATH', '?ping');


define('TRANSUNION_TESTING_ENABLED', true);
define('TRANSUNION_TESTING_VALID_IP', '74.202.43.210'); //local


define('CMS_ORDER_PAGE', 491);
//ini_set('memory_limit','1024M');

define('CCCOMUS_CARD_IMAGE_ROOT', 'https://images.creditcards.com');
