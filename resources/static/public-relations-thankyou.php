<?
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
<div class="other-block">
	<div class="container">
	    <div class="row">
		    <div class="other-subnav-hldr">
			    <ol class="breadcrumb-other">
				    <li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
				    <li><a href="contact.php">Contact Us</a> <i class="fa fa-angle-right"></i></li>
				    <li>Media Contact</li>
			    </ol>
			    <ol class="breadcrumb">
				    <li><a href="/about-us/media-center.php">Media Center</a></li>
				    <li><a href="/about-us/press-kit.php">Press Kit</a></li>
				    <li><a href="/about-us/press-releases.php">Press Releases</a></li>
				    <li><a href="/public-relations.php"><i class="fa fa-envelope-o"></i> Media Contact</a></li>
			    </ol>
		    </div>
		    <div class="alert alert-success" role="alert"><strong>Thank you!</strong> Your request has been received and someone will contact you shortly. We look forward to speaking with you.</div>
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

$channel = 'contact-us';
$pageName = 'contact-us:customer support:thank you';
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
	$pageName = 'contact us:customer support:thank you';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
