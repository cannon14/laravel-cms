<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Just a Moment While We Direct You to Your Offer';
$metaKeywords = '';
$metaDescription = '';

if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
	<title><?= $htmlTitle ?></title>

    <meta name="keywords" content="<?= $metaKeywords ?>">
    <meta name="description" content="<?= $metaDescription ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="robots" content="NOFOLLOW,NOINDEX">
    <meta name="revisit-after" content="10 days">
    <meta name="resource-type" content="document">
    <meta name="distribution" content="global">
    <meta name="author" content="CreditCards.com">
    <meta name="copyright" content="Copyright <?= date('Y') ?> CreditCards.com">
    <meta name="author" content="CreditCards.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-override.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-global.css" rel="stylesheet" type="text/css">
	<link href="/css/cc-misc.css" rel="stylesheet">
</head>

<body>
<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

		<div align="center"> 
			<h2>Please Wait...</h2>
			<br><br>
			<img src="/images/loading.gif" width="131" height="23">
			<br><br>
			<span class="loading">You are being directed to the Credit Card of your choice</span>
		</div>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'backend';
$pageName = 'backend:loading:wrapper_loading';
$analyticsServer = '';
$pageType = 'backend:loading';
$prop1 = '';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = 'purchase';
$analyticsProducts = '';
$purchaseId = '';
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar9 = '';
$eVar10 = '';
$eVar11 = '';
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

</body>
</html>
