<?php

include_once('affiliate/settings/settings2.php');
$_SESSION['aid'] = '1099';
Header('Location: '.$GLOBALS['RootPath'].'?a_bid='.$_GET['a_bid']);
?>
