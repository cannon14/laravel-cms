<?php

include_once('affiliate/settings/settings2.php');
$_SESSION['aid'] = '1099';
Header('Location: /oc/?'.$_SESSION['bid']);
?>