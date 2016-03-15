<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1596';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'actions/geoip.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Credit Cards - Compare Credit Card Offers at CreditCards.com';
$metaKeywords = 'credit cards, credit card, credit, creditcards, visa, offers, search, compare, apply, mastercard, low interest, student, instant approval, balance transfer, reward, business, student, cash back';
$metaDescription = 'Compare Credit Cards &amp; Credit Card Offers at CreditCards.com. Search credit cards and reviews about the best low interest, 0% balance transfer, reward, cash back, prepaid, student, airline, business and instant approval credit cards. Apply for Credit Cards Online.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
<link href="/css/cc-misc.css" rel="stylesheet">
	<meta name="credit-card" content="Credit card offers: low interest, balance transfer, cash back, reward, prepaid, college students, business, bad credit, airline and instant approval credit cards.">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
			<div class="container">
		<div class="row"> <br />
					<h1>Select the Type of Credit Card You are Interested in....</h1>
					<br />
					<div class="row">
				<div class="col-md-24"> <br />
							<div class="media"> <a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank" class="media-left"> <img width="35" height="35" border="0" alt="Low Interest Credit Card Offers" src="/images/credit-card-match_sm.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank">CARDMATCH&#8482;</a></strong></h3>
									Find the credit cards you are more likely to qualify for </div>
					</div>
							<br />
							<div class="media"> <a href="/low-interest.php" target="_blank" class="media-left"> <img width="35" height="35" border="0" alt="Low Interest Credit Card Offers" src="/images/Low-Interest-Credit-Cards-Applications.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/low-interest.php" target="_blank">Low Interest Credit Cards</a></strong></h3>
									Credit cards with 0% intro APRs & low fixed rate offers </div>
					</div>
							<br />
							<div class="media"> <a href="/balance-transfer.php" class="media-left"> <img width="35" height="35" border="0" alt="Balance Transfer Credit Card Offers" src="/images/Balance-Transfer-Credit-Card-Specials.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/balance-transfer.php" target="_blank">Balance Transfer Cards</a></strong></h3>
									Transfer a high interest balance onto a low APR credit card </div>
					</div>
							<br />
							<div class="media"> <a href="/reward.php" class="media-left"> <img width="35" height="35" border="0" alt="Rewards Credit Card Offers" src="/images/Rewards-Credit-Card-Specials.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/reward.php" target="_blank">Rewards Credit Cards</a></strong></h3>
									Credit cards that "reward" you for your purchases</div>
					</div>
							<br />
							<div class="media"> <a href="/cash-back.php" class="media-left"> <img width="35" height="35" border="0" alt="Cash Back Credit Card Offers" src="/images/cash-back-credit-card-offers.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/cash-back.php" target="_blank">Cash Back Credit Cards</a></strong></h3>
									Credit cards that allow you to earn cash back on purchases </div>
					</div>
							<br />
							<div class="media"> <a href="/airline-miles.php" class="media-left"> <img width="35" height="35" border="0" alt="Airline Credit Card Offers" src="/images/Airline-Credit-Cards-with-Frequent-Flyer-Miles-Offers.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/airline-miles.php" target="_blank">Airline Credit Cards</a></strong></h3>
									Earn frequent flyer miles with an airline credit card </div>
					</div>
							<br />
							<div class="media"> <a href="/instant-approval.php" class="media-left"> <img width="35" height="35" border="0" alt="Instant Approval Credit Cards" src="/images/Credit-Cards-Instant-Approval-Offer.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/instant-approval.php" target="_blank">Instant Approval Cards</a></strong></h3>
									Get approved instantly on select credit cards from specific banks </div>
					</div>
							<br />
							<div class="media"> <a href="/prepaid.php" class="media-left"> <img width="35" height="35" border="0" alt="Prepaid Credit Card Offers" src="/images/Prepaid-Debit-Card-Specials.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/prepaid.php" target="_blank">Prepaid & Debit Cards</a></strong></h3>
									Control your spending with debit cards, prepaid debit cards, & prepaid credit cards </div>
					</div>
							<br />
							<div class="media"> <a href="/bad-credit.php" class="media-left"> <img width="35" height="35" border="0" alt="Credit Cards for Bad Credit" src="/images/bad-credit-deals.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/bad-credit.php" target="_blank">Credit Cards for Bad Credit</a></strong></h3>
									Cards for people with bad credit or less than perfect credit </div>
					</div>
							<br />
							<div class="media"> <a href="/college-students.php" class="media-left"> <img width="35" height="35" border="0" alt="Student Credit Card Offers" src="/images/student-credit-card-deals.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/college-students.php" target="_blank">Student Credit Cards</a></strong></h3>
									Credit cards for high school & college students </div>
					</div>
							<br />
							<div class="media"> <a href="/business.php" class="media-left"> <img width="35" height="35" border="0" alt="Corporate &amp;amp; Business Credit Card Offers" src="/images/Business-Credit-Card-Deals.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/business.php" target="_blank">Business Credit Cards</a></strong></h3>
									Cards for corporate & small-business owners </div>
					</div>
							<br />
							<div class="media"> <a href="/business.php" class="media-left"> <img width="35" height="31" border="0" alt="0% APR Credit Card Offers" src="/images/0-percent-small.gif"> </a>
						<div class="media-body">
									<h3 class="media-heading"><strong><a href="/business.php" target="_blank">0% APR Credit Cards</a></strong></h3>
									Credit cards with 0% APR for 6 - 12 months on purchases or balance transfers </div>
					</div>
							<br />
							<br />
							<br />
							<p>At CreditCards.com we continuously monitor the credit card market in order to bring you the best credit cards, reviews and credit card offers available online. Credit card offers are displayed side by side so you can easily compare key factors such as interest rates, annual fees as well as other key features.</p>
							<p>Once you have found the card that is best for you, you can fill out an online credit card application and in some cases even get a credit decision within 60 seconds.</p>
							<p>At CreditCards.com our goal is to provide a resource where consumers can search, compare and apply for the best credit card offers online.</p>
							<p><strong>To begin searching for your credit cards, choose the "Type" of credit card you are looking for from the menu at the top.</strong></p>
						</div>
			</div>
					<br />
				</div>
	</div>
		</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'home-ppc-generic';
$pageName = 'home_ppc_generic';
$analyticsServer = '';
$pageType = '';
$prop1 = 'home_ppc_generic';
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
$eVar27 = $_GET['adsrc'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) {
	$channel = 'home_ppc_generic';
	$pageName = 'home_ppc_generic';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
