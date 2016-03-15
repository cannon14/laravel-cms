<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '877';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Thank You - CreditCards.com';
$metaKeywords = '';
$metaDescription = '';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
<link href="/css/cc-misc.css" rel="stylesheet">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->

<div id="skeleton" class="other-block">
	<div class="container">
		<div class="row">
			<div class="alert alert-success" role="alert">
				<strong>Thank you!</strong> Your inquiry has been submitted.
			</div>
			<p>For answers to commonly asked questions, please visit the <a href="/customer-support-department.php">Customer Support Page</a>.</p>
	        <p>If you have questions or issues related to a recent online application made through our site or about an existing credit card account, please contact the <a href="/bank-partner-contact-information.php">customer service department of the issuing bank</a>.</p>
			<p>To search, compare and apply for credit card offers, please use the top menu.</p>
		</div>
	</div>
</div>

  <?php

  echo '<img src="'.$GLOBALS['RootPath'].'sb.php?a_aid='.$_SESSION['aid'].'&a_bid='.$_SESSION['hid'].'" width=1 height=1 style="border: 0;">';
  echo '<img src="'.$GLOBALS['RootPath'].'xtrack.php?'.$_SERVER['QUERY_STRING'].'" width=1 height=1 style="border: 0;">';
  ?>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>
<?php

$channel = 'contact-us';
$pageName = $channel.':thank-you';
$analyticsServer = '';
$pageType = '';
$prop1 = 'contact us:customer support';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = '';
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
if (SITE_CATALYST_ENABLED) {
	$channel = 'contact us';
	$pageName = $channel.':customer support:thank you';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
