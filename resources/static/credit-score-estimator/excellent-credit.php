<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1393';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$cse_credit_type = "excellent";
$cse_image_tag = "excellent";
$cse_credit_label = "Excellent";
$category_page_url = "/excellent-credit.php";
$category_page_image = "/images/excellent-credit-credit-cards.gif";
$cse_type_toplimit = 850; // Top Score for this credit type
$cse_type_botlimit = 750; // Bottom Score for this credit type
$cse_default_score = 800;

// Set base score, if it is inappropriate for this credit type page, adjust it
$cse_base_score = ($_SESSION['es_score'] ? $_SESSION['es_score'] : $cse_default_score);

if (($cse_base_score > $cse_type_toplimit) || ($cse_base_score < $cse_type_botlimit)) {
	$cse_base_score = $cse_default_score;
}

$cse_bottom_range = $cse_base_score - 20;
$cse_top_range = $cse_base_score + 20;
$cse_cat_id = "21";
$cse_icon_image = "/images/excellent-credit-credit-cards.gif";

$cse_body_text = <<< END_CSE_TEXT
<p align="left">
		It means that you've paid your bills on time, every time for a long time. You may or may not pay your cards off in full each month, but regardless, you're likely using just a small fraction of your <a href="/glossary/term-credit-limit.php">credit limit</a> and are in little danger of maxing out your cards. 
		</p>
		
		<p align="left">
		So what should you do? Keep up the good work. Pay your bills on time, every time, and pay more than the <a href="/glossary/term-minimum-payment.php">minimum payment</a> when you do. Don't go on any spending sprees that jack up your debt and eat up your available credit. And don't apply for more new credit than you need. Do all of this and you should have little trouble getting that new credit card, mortgage or car loan, and you should also have little to worry about regarding <a href="/glossary/term-annual-percentage-rate-apr.php">interest rate</a> increases. But be careful. It doesn't take much to turn excellent credit into good credit or worse.
		</p>
END_CSE_TEXT;

$cse_disclaimer_text = <<< END_DISCLAIMER_TEXT
See the online Excellent Credit card applications for details about terms and conditions of offers. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty. When you click on the "Apply Now" button you can review the credit card terms and conditions on the credit card issuer's web site.
END_DISCLAIMER_TEXT;
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Estimated Credit Score is Excellent';
$metaKeywords = 'excellent credit score, credit score estimator';
$metaDescription = 'Your estimated credit score is Excellent; 750-850. Get the credit card that best fits your estimated credit score.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
	<link rel="stylesheet" type="text/css" href="/css/cc-card-category.css">
</head>

<?php include('cse_common.php'); ?>
