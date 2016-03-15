<?php

$_SERVER['HTTP_HOST'] = '127.0.0.1';
$_SERVER["REMOTE_ADDR"] = '127.0.0.1';

// Database config
defined('DB_TYPE')     || define('DB_TYPE','mysql');
defined('DB_HOSTNAME') || define('DB_HOSTNAME','localhost');
defined('DB_DATABASE') || define('DB_DATABASE','cccomus_test');
defined('DB_USERNAME') || define('DB_USERNAME','cccomususer');
defined('DB_PASSWORD') || define('DB_PASSWORD','cccomususer');

define('APPLICATION_ENV', 'unittesting');

require_once dirname(__FILE__).'/../bootstrap.php';

defined('FIXTURES_PATH') || define('FIXTURES_PATH', CARDMATCH_PATH.'/tests/fixtures');
defined('TEST_DATA_PATH') || define('TEST_DATA_PATH', CARDMATCH_PATH.'/tests/data');

include 'unit/src/Cardmatch/DbTestCase.php';