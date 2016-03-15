<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "1323";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Financial calculators, privacy advice, and other credit card tools - CreditCards.com';
$metaKeywords = 'credit card tools, privacy, security, credit card calculators, credit card finder';
$metaDescription = 'CreditCards.com can help you manage your security and privacy and the card offers you receive in the mail, as well as help perform basic financial calculations.';

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
							<li><a href="/">Credit Cards </a> <i class="fa fa-angle-right"></i></li>
							<li>Tools</li>
						</ol>
			</div>
					<h1>Credit Cards Tools</h1>
					<br />
					<p>We have developed a set of free interactive tools and calculators to help you with financial decisions. Our tools help you estimate your credit score for free, give your card a health check, perform financial calculations and pick the card that's right for you based on attributes you specify. We also provide you a reference guide that helps you manage your privacy and security.</p>
					<br />
					See our full list of credit card tools below: <br />
					<br />
					<div class="row">
				<div class="col-md-8">
							<div class="card-tool-hldr">
						<h2><a target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form">CardMatch&#8482;</a></h2>
						<p>Too many inquiries on your credit report may affect your credit score - guard your credit by using this tool. We match you with the cards you are more likely to get approved for.</p>
						<a target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form">Find Card Matches <i class="fa fa-angle-double-right"></i> </a> </div>
						</div>
				<div class="col-md-8">
							<div class="card-tool-hldr">
						<h2><a target="_blank" href="https://my.creditcards.com/?qls=MCC_CCRDTOLS.092215CRED">FREE Credit Score and Report</a></h2>
						<p>Get a FREE credit score and access your FREE credit report. Protect your accounts with Credit Monitoring.</p>
						<a target="_blank" href="https://my.creditcards.com/?qls=MCC_CCRDTOLS.092215CRED">Get your FREE Credit Score <i class="fa fa-angle-double-right"></i> </a> </div>
						</div>
				<div class="col-md-8">
							<div class="card-tool-hldr">
						<h2><a target="_blank" href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=tools_home&utm_campaign=walletup">WalletUp&reg;</a></h2>
						<p>Maximize your rewards, cash back and points earnings. Build your perfect wallet today using this free tool. Let us do the math.</p>
						<a href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=tools_home&utm_campaign=walletup" target="_blank">Maximize your Rewards <i class="fa fa-angle-double-right"></i> </a> </div>
						</div>
			</div>
					<div class="row">
				<div class="col-md-8">
							<div class="card-tool-hldr">
						<h2><a href="/calculators/">Credit Card Calculators</a></h2>
						<p>Too many inquiries on your credit report may affect your credit score - guard your credit by using this tool. We match you with the cards you are more likely to get approved for.</p>
						<a href="/calculators/">Credit Card Calculators <i class="fa fa-angle-double-right"></i> </a> </div>
						</div>
				<div class="col-md-8">
							<div class="card-tool-hldr">
						<h2><a href="/privacy-security-suite/">PrivacyWise&#8482;</a></h2>
						<p>Practical tips to protect your privacy and guard against identity theft. Useful checklists to reduce your risk of being a victim to fraud. Articles that keep you up-to-date on the latest credit card fraud techniques and credit card scams. </p>
						<a href="/privacy-security-suite/">Learn More <i class="fa fa-angle-double-right"></i> </a> </div>
						</div>
				<div class="col-md-8">
							<div class="card-tool-hldr">
						<h2><a href="/best-credit-cards.php">Best Credit Cards by Category</a></h2>
						<p>If you’re undecided about the best type of credit card for your spending habits, see what we consider the best in class for each category. We've made it easier for you to find the best card. </p>
						<a href="/best-credit-cards.php">Find the Best Credit Cards <i class="fa fa-angle-double-right"></i> </a> </div>
						</div>
			</div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card-tool-hldr">
                        <h2><a href="/credit-score-estimator/">Credit Score Estimator</a></h2>
                        <p>Answer a few questions to see your estimated credit score range. Instantly see your results, and tips on improving your credit score. Get a list of credit cards that match your credit score range. </p>
                        <a href="/credit-score-estimator/">Estimate your Credit Score <i class="fa fa-angle-double-right"></i> </a> </div>
                </div>

            </div>
					<br />
					<br />
					<br />
				</div>
	</div>
		</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>

<?
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = 'tools:home:credit-card-tools';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:home';
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
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>
</body>
</html>
