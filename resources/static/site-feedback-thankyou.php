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
			<?php if ($_REQUEST['PRODUCT'] == 'cardmatch'): ?>
				<div class="alert alert-success" role="alert">
					<strong>Thank you!</strong> Your feedback on CARDMATCH has been submitted. It is much appreciated, as we seek to improve the tools we bring to you.
				</div>
                <p>When you submit your information using CARDMATCH, we send the data to a credit bureau which matches your profile against criteria provided by card issuers. CARDMATCH then displays the matched results to you.</p>
                <p>If you have questions about eligibility for specific cards, or are trying to follow-up on an application you have already submitted online, <a href="/bank-partner-contact-information.php">contact the credit card issuer directly</a>.</p>
                <p>By law, you are entitled to receive a free copy of your credit report annually. Get yours from <a href="http://www.annualcreditreport.com" target="_blank">http://www.annualcreditreport.com</a>.</p>
			<?php else: ?>
				<div class="alert alert-success" role="alert">
					<strong>Thank you!</strong> Your feedback  has been received. We are constantly seeking to improve CreditCards.com and bring you tools that help you make financial decisions. Your feedback is appreciated.
				</div>
				<p>If you are trying to follow-up on an application that you have already submitted online, <a href="/bank-partner-contact-information.php">contact the credit card issuer directly</a>.</p>
			<?php endif; ?>
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
$prop2 = 'contact us:thank you';
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
