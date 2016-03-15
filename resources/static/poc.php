<?
require_once('global.php');
require_once('actions/staticProductData.php');

session_start();

$pid = $_REQUEST["pid"];
$purchaseId = ENTITY_ID.date('YmdHis').str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

//404 page if no URL found
if( !empty($pid) && array_key_exists($pid, $productData)) {

	$product = $productData[$pid];
	$appUrl = $product['url'];
	$productUrl = $appUrl; // creating an alias but leaving $appUrl in case a dependency
	$productName = $product['name'];
	$productImage = $product['image'];

	$productFound = true;
}
else {

	$appUrl = "/page-not-found.php";

	$productUrl = $appUrl;
	$productName = 'Please wait as you are being redirected';
	$productImage = '';

	$productFound = false;
}

// if hitting our oc server, add original pid
// so the secondary loading page looks exactly
// the same as first
if (stristr($appUrl, 'creditcards.com')) {
	$appUrl .= '&original_pid=' . $pid;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Just a Moment While We Direct You to Your Offer</title>
<meta name="robots" content="NOFOLLOW,NOINDEX">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<META HTTP-EQUIV="Refresh" CONTENT="2;URL=<?=$appUrl ?>">

<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel="stylesheet" type="text/css">
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="/css/cc-override.css" rel="stylesheet" type="text/css">
<link href="/css/cc-global.css" rel="stylesheet" type="text/css">
<link href="/css/cc-card-category.css" rel="stylesheet" type="text/css">

</head>

<body class="t-bg">

<div class="t-page-block">
	<div class="container">
		<div class="row">
			<div class="load-hldr"> <br>
				<i class="fa fa-lock fa-2x" style="color:#0C4E77;"></i>&nbsp;
				<?= $productName ?>'s secure application will load in this window momentarily
				<br>
				<br>
				<br>
				<img id="spinner" src="/images/load_spinner.gif">
				<div class="tran-hldr">
					<ul class="list-inline">
						<li class="li-none"><img src="/images/cclogo_165x63.png"></li>
						<?php if ($productFound): ?>
							<li class="li-none"><img src="/images/trans_arrow.png"></li>
							<li><img src="<?= $productImage ?>"></li>
						<?php endif; ?>
					</ul>
				</div>
				<img src="/actions/clickBack.php?t=<?= md5(time()); ?>" style="display:none;" width="1px" height="1px"> </div>
		</div>
	</div>
</div>

<img src="/actions/clickBack.php?t=<?=md5(time()); ?>"  style="display:none;" width="1px" height="1px" />
<?
echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."'  style='display:none;' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' style='display:none;' border=0 width=1 height=1>";

$channel = '';
$pageName = 'lead confirmation';
$analyticsServer = '';
$pageType = '';
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
$analyticsEvents = 'purchase,event2';
$analyticsProducts = $_SESSION['fid'].";".$pid.";1;0";
$purchaseId = $purchaseId;
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar25 = $_SESSION['fid'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }

if($_SESSION['aid'] == '1047') { ?>
	<!-- Google Code for offer click Conversion Page -->

	<script language="JavaScript" type="text/javascript">

<!--

var google_conversion_id = 1066278488;

var google_conversion_language = "en_US";

var google_conversion_format = "3";

var google_conversion_color = "ffffff";

var google_conversion_label = "gJ8CCOjodxDYvLj8Aw";

if (2.5) {
	var google_conversion_value = 2.5;

}

//-->

</script>

	<script language="JavaScript" src="http://www.googleadservices.com/pagead/conversion.js">

</script>

	<noscript>

<img height="1" width="1" border="0" src="http://www.googleadservices.com/pagead/conversion/1066278488/?value=2.5&amp;label=gJ8CCOjodxDYvLj8Aw&amp;guid=ON&amp;script=0"/> 

</noscript>
<?php } ?>
<?
/*
<script>
showPostClickField = opener.document.getElementById('showPostClick');
if (showPostClickField && showPostClickField.value == "1") {
    if (opener.location.href.indexOf('/postclick') > -1) {
        opener.location.replace( "/postclick?c=<?=$_SESSION['bid']?>" );
    } else {
        opener.location.href = "/postclick?c=<?=$_SESSION['bid']?>";
    }
}
</script>
*/
?>
</body>
</html>
