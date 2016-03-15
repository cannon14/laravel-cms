<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1394';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$cse_credit_type = "good";
$cse_image_tag = "good";
$cse_credit_label = "Good";
$category_page_url = "/good-credit.php";
$category_page_image = "/images/good-credit-credit-cards.gif";
$cse_type_toplimit = 749; // Top Score for this credit type
$cse_type_botlimit = 660; // Bottom Score for this credit type
$cse_default_score = 700; 

// Set base score, if it is inappropriate for this credit type page, adjust it
$cse_base_score = ($_SESSION['es_score'] ? $_SESSION['es_score'] : $cse_default_score);

if (($cse_base_score > $cse_type_toplimit) || ($cse_base_score < $cse_type_botlimit)) {
	$cse_base_score = $cse_default_score;
}

$cse_bottom_range = $cse_base_score - 20;
$cse_top_range = $cse_base_score + 20;
$cse_cat_id = "22";
$cse_icon_image = "/images/good-credit-credit-cards.gif";

$cse_body_text = <<< END_CSE_TEXT
<p align="left">
		It means that you've got a couple chinks in your armor but have done a mostly admirable job with your credit. Maybe you've had a late payment or two. Maybe you've applied for a few new cards recently. Perhaps you've gotten just a little bit too close to that <a href="/glossary/term-credit-limit.php">credit limit</a> lately. Or maybe you're just fairly new to credit and haven't had time to build up to "excellent" status. The trouble is that those little imperfections could lead to higher interest rates, lower credit limits or even rejection.
		</p>
		
		<p align="left">
		Issuers are always looking for reasons to crack down on consumers, so it's your job not to give them one. Be extra careful to pay your bills on time, every time. Keep working to get that balance down by paying more than the <a href="/glossary/term-minimum-payment.php">minimum payment</a> each month. Be cautious about applying for that new credit card. In short, stay on the straight and narrow. 
		</p>
END_CSE_TEXT;

$cse_disclaimer_text = <<< END_DISCLAIMER_TEXT
See the online Good Credit card applications for details about terms and conditions of offers. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty. When you click on the "Apply Now" button you can review the credit card terms and conditions on the credit card issuer's web site.
END_DISCLAIMER_TEXT;
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Estimated Credit Score is Good';
$metaKeywords = 'good credit score, credit score estimator';
$metaDescription = 'Your estimated credit score is Good; 660-749.  Get the credit card that best fits your estimated credit score.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
	<link rel="stylesheet" type="text/css" href="/css/cc-card-category.css">
</head>

<?php include('cse_common.php'); ?>
