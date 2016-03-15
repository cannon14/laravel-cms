<?php

if (empty($pagefid)) $pagefid = "1581";
$_SESSION['fid'] = $pagefid;
?>
	<title><?= $htmlTitle ?></title>
	<meta name="description" content="<?= $metaDescription ?>" />
	<meta name="keywords" content="<?= isset($metaKeyword) ? $metaKeyword : ''; ?>" />
	<meta name="Robots" content="ALL">
	<meta name="revisit-after" content="10 days">
	<meta name="resource-type" content="document">
	<meta name="distribution" content="global">
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="author" content="CreditCards.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="copyright" content="&reg; <?= date('Y') ?> CreditCards.com">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/cm-override.css" rel="stylesheet">
	<link href="css/cm-global.css" rel="stylesheet">
	<link href="css/cm-match.css" rel="stylesheet">
