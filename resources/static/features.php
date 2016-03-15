<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "2387";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/geoip.php');
?>

<!DOCTYPE HTML>
<html>
<head>
	<?php

	$htmlTitle = 'Featured Articles';

	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
	?>

	<link href="/css/cc-misc.css" rel="stylesheet" type="text/css">
	<style> @media (min-width: 768px) {
			.feature-box div {
				height: 190px
			}
		}
	</style>
</head>

<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<!--
	description paragraphs should be limited to 165 characters with "..." and followed by "Read More" on the second line
	new features should be added to the top of the table
-->
<div class="other-block">
	<div class="container">
		<h1 style="display: inline">Featured Articles</h1>
		<div class="card-category-disclosure-hldr" style="display: inline"><a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img  class="pull-right" src="/images/advertiser_dis_text.png" width="120" height="9" /></a>
			<div class="clearfix"></div>
		</div>
		<hr>
		<div class="feature-box">
			<div class="col-sm-12 col-md-10 col-lg-8">
			<h2>Chase Sapphire Preferred</h2>
			<p>Consistently ranked as one of the best credit cards for travel rewards, the Chase Sapphire Preferred card is a worthy contender for your go-to card ...</p>
			<p><a href="http://www.creditcards.com/features/chase-sapphire-preferred.php">Read More</a></p>
		</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>3 Credit Cards for Holiday Spending</h2>
				<p>As the holiday season approaches, Chase has 3 great credit cards to help you spend smarter. Whether you are looking to earn points towards free ...</p>
				<p><a href="http://www.creditcards.com/features/3-credit-cards-for-everyday-use.php">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>3 Cards to Kick Start Your Rewards Earning Journey</h2>
				<p>So many rewards cards, so little time. With all the offers out there today, it can be a daunting task to figure out which ones are the most ...</p>
				<p><a href="http://www.creditcards.com/features/points-rewards-cards.php">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>USAA Credit Cards &mdash; the Perks of Membership</h2>
				<p>USAA started its roots in 1922, when a small group of Army officers agreed to insure each other's vehicles when no one else would. USAA is constantly receiving ...</p>
				<p><a href="http://www.creditcards.com/features/best-usaa-credit-cards.php">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>Finding the Best Card for You</h2>
				<p>To some, credit cards are perceived as an 'evil'	ploy  that can easily cause someone to spiral into debt. However, recently more personal finance experts are ...</p>
				<p><a href="http://www.creditcards.com/features/finding-the-best-card-for-you.php">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>Balance Transfer Cards for 2015</h2>
				<p>The new year has since come and gone, and unfortunately for many of us, so have our resolutions. According to StatisticsBrain.com, a whopping 34% ...</p>
					<p><a href="http://www.creditcards.com/features/balance-transfer-cards.php ">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>3 Travel Rewards Credit Cards to Add to your wallet in 2015</h2>
				<p>Sometimes a credit card can be your best travel companion. With some cards offering perks like free checked bags, inflight wi-fi, and ...</p>
				<p><a href="http://www.creditcards.com/features/travel-rewards-cards.php">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>3 Credit Cards Money Can't Buy</h2>
				<p>If you believe that money can't buy happiness, then the cards below are for you! These cards come with no annual fee, but don't skimp on other ...</p>
				<p><a href="http://www.creditcards.com/features/no-annual-fee-cards.php">Read More</a></p>
			</div>
			<div class="col-sm-12 col-md-10 col-lg-8">
				<h2>3 Cash Back Cards that Offer Simple Savings</h2>
				<p>There's a reason why the rich keep getting richer. In a recent poll conducted for Creditcards.com, nearly 800 wealthy individuals with ...</p>
				<p><a href="http://www.creditcards.com/features/cash-back-cards.php">Read More</a></p>
			</div>
		</div>
	</div>
</div>

<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'features';
$pageName = $channel.'';
$analyticsServer = '';
$pageType = '';
$prop1 = 'features';
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
	$pageName = '';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>
</body>
</html>
