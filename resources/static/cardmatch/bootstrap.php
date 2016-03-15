<?php

session_start();

// Define application environment
defined('APPLICATION_ENV')
|| define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

if(APPLICATION_ENV == 'development') {
	error_reporting(E_ALL);
}

defined('CARDMATCH_PATH') || define('CARDMATCH_PATH', dirname(__FILE__));
require_once(CARDMATCH_PATH.'/src/Cardmatch/Autoloader.php');
spl_autoload_register('Cardmatch_Autoloader::load');

$includePaths = array(
	CARDMATCH_PATH . '/src',
	CARDMATCH_PATH . '/lib',
	get_include_path()
);

set_include_path(implode(PATH_SEPARATOR, $includePaths));

$_SERVER['SERVER_ADDR'] = '127.0.0.1';

require_once(CARDMATCH_PATH .'/config/config.php');
require_once(CARDMATCH_PATH .'/config/global.php');
require_once(CARDMATCH_PATH . '/lang/dictionary-'.LANGUAGE.'.inc.php');