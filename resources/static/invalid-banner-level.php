<?php

include_once('affiliate/settings/settings2.php');
$_SESSION['aid'] = '999';
unset($_SESSION['bid']);
Header('Location: '.$GLOBALS['RootPath']);
?>