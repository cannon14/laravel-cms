<?php

require_once('bootstrap.php');

$controller = new Cardmatch_Controller($_REQUEST);
$controller->run();
