<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1396';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$cse_credit_type = "bad";
$cse_image_tag = "bad";
$cse_credit_label = "Bad";
$category_page_url = "/bad-credit.php";
$category_page_image = "/images/credit-cards-for-bad-credit.gif";
$cse_type_toplimit = 619; // Top Score for this credit type
$cse_type_botlimit = 350; // Bottom Score for this credit type
$cse_default_score = 550; 

// Set base score, if it is inappropriate for this credit type page, adjust it
$cse_base_score = ($_SESSION['es_score'] ? $_SESSION['es_score'] : $cse_default_score);

if (($cse_base_score > $cse_type_toplimit) || ($cse_base_score < $cse_type_botlimit)) {
	$cse_base_score = $cse_default_score;
}

$cse_bottom_range = $cse_base_score - 20; 
$cse_top_range = $cse_base_score + 20;
$cse_cat_id = "24";
$cse_icon_image = "/images/credit-cards-for-bad-credit.gif";

$cse_body_text = <<< END_CSE_TEXT
		<p align="left">
			It means that you're paying the price for mistakes made in the recent past. Rather than focus on what may have already happened, we will -- as you should, too -- focus on what you can do to make things better.
		</p>
		
		<p align="left">
		The first thing you should do is accept that change won't come easily or quickly. Beyond that, you'll need to pay your bills on time, every time for an extended period of time and whittle down your current debt. That means paying that credit card bill the day it comes in and paying more than the <a href="/glossary/term-minimum-payment.php">minimum payment</a> when you do. That means going cold turkey on shopping sprees. That also means that if you're considering getting a new credit card, you'll likely be stuck paying higher-than-average <a href="/glossary/term-annual-percentage-rate-apr.php">APRs</a> and dealing with a low <a href="/glossary/term-credit-limit.php">credit limit</a>. However, used properly, these so-called "subprime" cards -- whose low limits leave little room for extravagant spending -- can help you improve or repair your credit history gradually over time. 
		</p>
END_CSE_TEXT;

$cse_disclaimer_text = <<< END_DISCLAIMER_TEXT
		See the online credit cards for people with bad credit applications for details about terms and conditions of offers. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty. When you click on the " Apply Now " button you can review the credit card terms and conditions on the credit card issuer's web site.
END_DISCLAIMER_TEXT;
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Estimated Credit Score is Bad';
$metaKeywords = 'bad credit score, credit score estimator';
$metaDescription = 'Your estimated credit score is bad; 350-619.  Get the credit card that best fits your estimated credit score.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
	<link rel="stylesheet" type="text/css" href="/css/cc-card-category.css">
</head>

<?php include('cse_common.php'); ?>
