<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "298";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Credit Card Calculators - Answer your financial questions at CreditCards.com';
$metaKeywords = 'current balance, interest, paying the minimum, airlines, low interest, balance transfer';
$metaDescription = 'Use the credit card calculators at CreditCards.com to help figure out how to pay off debt.';

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
					<li><a href="/credit-card-tools/">Tools</a> <i class="fa fa-angle-right"></i></li>
					<li>Calculators</li>
						</ol>
				<div ></div>
			</div>
					<br />
					<h1>Credit Card Calculators</h1>
					<br />
					<p>The following is a set of calculators designed to help you find answers to your financial questions. Enter your values, and the resulting calculations will show the costs and benefits for your scenario. All information on this website is intended only to assist you with financial decisions.</p>
					<h2>Choose a calculator:</h2>
					<br>
					<div class="row">
				<div class="col-md-4">
							<div class="cal-offers-hldr">
						<h3>Minimum Payment Calculator</h3>
						<p>Use this calculator to check how long it will take to pay off your debt, and how much interest you will pay over the life of your debt if you only make minimum monthly payments.</p>
						<div class="cal-bottom"><a href="/calculators/minimum-payment.php">START NOW</a></div>
					</div>
						</div>
				<div class="col-md-4 col-md-offset-1">
							<div class="cal-offers-hldr">
						<h3>Payoff Calculator</h3>
						<p>Enter some basic information and find out how long it would take to pay off your debt. Or, enter desired months to payoff and calculate what your monthly payments should be.</p>
						<div class="cal-bottom"><a href="/calculators/payoff.php">START NOW</a></div>
					</div>
						</div>
				<div class="col-md-4 col-md-offset-1">
							<div class="cal-offers-hldr">
						<h3>Cash Back or Low Interest Card </h3>
						<p>Ever wondered if its better to apply for a cash back card or one that carries a low interest? Find out what's good for your unique situation by entering some basic information in this calculator. </p>
						<div class="cal-bottom"><a href="/calculators/cash-back-or-low-interest.php">START NOW</a></div>
					</div>
						</div>
				<div class="col-md-4 col-md-offset-1">
							<div class="cal-offers-hldr">
						<h3>Airlines or Low Interest Card</h3>
						<p>This calculator compares the value of an Airlines card and a Low Interest credit card to help you determine which card is better for you. Enter your information and find out which card is best for you.</p>
						<div class="cal-bottom"><a href="/calculators/airlines-or-low-interest.php" class="cal-bottom">START NOW</a></div>
					</div>
						</div>
				<div class="col-md-4 col-md-offset-1">
							<div class="cal-offers-hldr">
						<h3>Balance Transfer Calculator</h3>
						<p>You may be able to save money by transferring your balances to a card that carries a lower interest rate. This calculator calculates the amount of interest you'll save by transferring existing balances to a lower rate card.</p>
								<div class="cal-bottom"><a href="/calculators/balance-transfer.php">START NOW</a></div>
					</div>
						</div>
			</div>
					<br />
					<div class="row">
				<div class="col-md-24">
					<div style="text-align:right;">
						<p><iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcalculators%2F&amp;layout=standard&amp;show_faces=false&amp;width=300&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:35px; text-align:right;" allowTransparency="true"></iframe></p>
						<p>Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a>
					</div>
			</div>
					<br />
					<br />
				</div>
	</div>
		</div></div><!-- End of Other Block -->

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>

<?php
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = $channel.':calculators';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
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
