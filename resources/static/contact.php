<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '872';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Get Credit Card: Contact CreditCards.com to apply today';
$metaKeywords = 'Creditcards.com, contact, email';
$metaDescription = 'Looking to get a credit card? Contact CreditCards.com by email or phone to get started.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link href="/css/cc-misc.css" rel="stylesheet">
</head>

<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Other Block -->

<div class="other-block">
	<div class="container">
		<div class="row">
			
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="http://www.creditcards.com/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li>Contact Us</li>
				</ol>
			</div>

			<h1>Contact Us</h1>
			<br>
			<p><a href="/where-to-find-us.php"><strong>Where to find us</strong></a> &#8212; Physical addresses of our office locations. </p>
			<br>
			<p><strong>For specific inquiries, please contact the  appropriate department:</strong></p>
			<br>
			<p><a href="/advertising.php"><strong>Advertising Department</strong></a> &#8212; Contact us if you are a bank or financial institution interested in advertising your product or service on CreditCards.com.</p>
			<br>
			<p><a href="/business-development.php"><strong>Business Development Departmen</strong>t</a> &#8212; Contact us about business partnership opportunities and to learn about financial tools and solutions we can provide for your organization.</p>
			<br>
			<p><a href="/customer-support-department.php"><strong>Customer Support Department</strong></a> &#8212; Contact us with questions related to credit cards, credit card applications as well as other general consumer inquiries.</p>
			<br>
			<p><a href="/public-relations.php"><strong>Media Relations Department</strong></a> &#8212; Our media relations representatives can answer questions about the company, and help members of the media gather facts about credit and debt issues, on background, or for attribution in print, on the Web or for broadcast. For more information, see the <a href="/about-us/media-center.php">Media Center section</a>.</p>
			<br>
			<p><a href="/publishing-department.php"><strong>Editorial Department</strong></a> &#8212; Contact us if you have questions, comments or corrections or other inquiries regarding news articles found on CreditCards.com. See the <a href="/credit-card-news.php">News and Advice home page</a> for the latest information on credit, debt and other personal finance issues.</p>
			<br>
			<p><a href="/site-feedback.php"><strong>Give us Feedback</strong></a> &#8212; Give us general feedback about the website, tools offered on the site, or let us know what else you'd like to see on CreditCards.com.</p>
			<br>
			<hr>
			<strong>If you have questions or issues related to a recent online application made through our site or about an existing credit card account, please contact the <a href="/bank-partner-contact-information.php">customer service department of the issuing bank</a>. </strong>
			<br>
			<br>
		</div>
	</div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>
<?
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'contact-us';
$pageName = 'contact-us:listing';
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
	$pageName = 'contact us:listing';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>
</body>
</html>
