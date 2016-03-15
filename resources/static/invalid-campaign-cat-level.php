<?php

include_once('affiliate/settings/settings2.php');
// What is the purpose of this?
$_SESSION['aid'] = '1099';
if ($_SESSION['bid'] == '') {
	Header('Location: '.$GLOBALS['RootPath']);
}
else {
	Header('Location: /oc/?'.$_SESSION['bid']);
}
?>