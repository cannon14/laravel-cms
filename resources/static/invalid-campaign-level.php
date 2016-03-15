<?php

include_once('affiliate/settings/settings2.php');
// What does this accomplish?
$_SESSION['aid'] = '1099';
//if ($_SESSION['bid'] == '') {
	Header('Location: '.$GLOBALS['RootPath']);
//}
//else {
//	Header('Location: /oc/?'.$_SESSION['bid']);
//}
?>