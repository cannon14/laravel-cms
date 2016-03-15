<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1395';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$cse_credit_type = "fair";
$cse_image_tag = "fair";
$cse_credit_label = "Fair";
$category_page_url = "/fair-credit.php";
$category_page_image = "/images/fair-credit-credit-cards.gif";
$cse_type_toplimit = 659; // Top Score for this credit type
$cse_type_botlimit = 620; // Bottom Score for this credit type
$cse_default_score = 635; 

// Set base score, if it is inappropriate for this credit type page, adjust it
$cse_base_score = ($_SESSION['es_score'] ? $_SESSION['es_score'] : $cse_default_score);

if (($cse_base_score > $cse_type_toplimit) || ($cse_base_score < $cse_type_botlimit)) {
	$cse_base_score = $cse_default_score;
}

$cse_bottom_range =  $cse_base_score - 20;
$cse_top_range = $cse_base_score + 20;
$cse_cat_id = "23";
$cse_icon_image = "/images/fair-credit-credit-cards.gif";

$cse_body_text = <<< END_CSE_TEXT
<p align="left">
		It means that you don't have much margin for error when it comes to credit. You've struggled to pay bills on time, or you're in danger of maxing out your credit cards. In short, you're one misstep away from the dreaded "bad credit" label.
		</p>
		
		<p align="left">
		So what should you do next? Issuers are always looking for reasons to crack down on consumers, so it's your job not to give them any more than you already have. Avoid any other missteps for as long as you can. Pay that credit card bill the day it comes in, and pay more than the <a href="/glossary/term-minimum-payment.php">minimum payment</a> when you do. Carefully consider whether or not to apply for a new credit card. And be sure not to accrue any new debt as you pay down your current ones.
		</p>
END_CSE_TEXT;

$cse_disclaimer_text = <<< END_DISCLAIMER_TEXT
See the online Fair Credit card applications for details about terms and conditions of offers. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty. When you click on the "Apply Now" button you can review the credit card terms and conditions on the credit card issuer's web site.
END_DISCLAIMER_TEXT;
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Estimated Credit Score is Fair';
$metaKeywords = 'fair credit score, credit score estimator';
$metaDescription = 'Your estimated credit score is Fair; 620-659.  Get the credit card that best fits your estimated credit score.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
	<link rel="stylesheet" type="text/css" href="/css/cc-card-category.css">
</head>

<?php include('cse_common.php'); ?>
