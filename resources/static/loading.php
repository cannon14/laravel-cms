<?

// array of product data
require_once('actions/staticProductData.php');

$originalPid = $_REQUEST['original_pid'];
$purchaseId = ENTITY_ID.date('YmdHis').str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
$productFound = false;

// setup the product variables such as name and image
if( !empty($originalPid) && array_key_exists($originalPid, $productData)) {

	$product = $productData[$originalPid];
	$productName = $product['name'];
	$productImage = $product['image'];

	$productFound = true;
}

?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Just a Moment While We Direct You to Your Offer</title>

	<meta name="robots" content="NOFOLLOW,NOINDEX">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Pragma" content="no-cache">
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
	<link href="/css/cc-card-category.css" rel="stylesheet" type="text/css">

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
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
			</div>
		</div>
	</div>
</div>


<img src="/actions/clickBack.php?t=<?=md5(time()); ?>" style="display:none;" width="1px" height="1px" />

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' style='display:none;' border=0 width=1 height=1>";
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
$prop16 = $_SESSION['page_pos'];
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = 'purchase';
$analyticsProducts = $_SESSION['fid'].';'.$_SESSION['bid'].';1;0';
$purchaseId = isset($purchaseId) ? $purchaseId : '';
$eVar1 = isset($_GET['catid']) ? $_GET['catid'] : '';
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
$eVar25 = $_SESSION['fid'];
$eVar26 = $_SESSION['page_pos'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }

if($_SESSION['aid'] == 'df209399'):
?>
	<!-- Begin ZEDO -->
	<script>
		var zzp = new Image();
		if (location.protocol == "https:") {
			zzp.src = "https://ss1.zedo.com/ads2/t?o=332223;h=1123594;z=" + Math.random();
		} else {
			zzp.src = "http://xads.zedo.com/ads2/t?o=332223;h=1123594;z=" + Math.random();
		}
	</script>
	<!-- End ZEDO -->
<?php

endif;

if($_SESSION['aid'] == '1047'):
?>
	<!-- Google Code for offer click Conversion Page -->
	<script>
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

	<script src="http://www.googleadservices.com/pagead/conversion.js"></script>
	<noscript>
		<img height="1" width="1" border="0" src="http://www.googleadservices.com/pagead/conversion/1066278488/?value=2.5&amp;label=gJ8CCOjodxDYvLj8Aw&amp;guid=ON&amp;script=0"/>
	</noscript>
<?php endif; ?>

<!-- Google Code for www.creditcards.com/oc Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1065174423;
    var google_conversion_language = "en";
    var google_conversion_format = "3";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "mM3bCLK46V4Ql4v1-wM";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1065174423/?label=mM3bCLK46V4Ql4v1-wM&guid=ON&script=0"/>
    </div>
</noscript>

<!-- Conversion Pixel -->

<img src="//pixel.quantserve.com/pixel/p-KL7thL9yP4QPZ.gif?labels=_fp.event.Conversion" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>
</body>
</html>
