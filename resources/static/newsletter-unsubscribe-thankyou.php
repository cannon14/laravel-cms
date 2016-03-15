<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '869';
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
<div class="other-block">
	<div class="container">
		<div class="row">

			<div class="newsletter-optout" role="alert">
				<h2><strong>Optout Successful</strong></h2>
				<p>We have recorded your request to unsubscribe from the CreditCards.com newsletters.</p>
				<p>If you opted out unintentionally, you can subscribe to the newsletters <a href="/newsletter.php">here</a>.</p>
			</div>

			<hr id="newletter-pages-divider">

			<div id="credit-card-search-categories"><!-- Credit Card Search Categories -->

				<h2><strong>Interested in a credit card offer? Find the card that's right for you</strong></h2>

				<div class="col-md-12">
					<h3>Credit Card Search Categories</h3>

					<div class="row">
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-bar-chart fa-lg" style="color:#156abd;"></i>
									Rates & Fees
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/balance-transfer.php">Balance Transfer</a></li>
										<li><a href="/0-apr-credit-cards.php">0% APR</a></li>
										<li><a href="/low-interest.php">Low Interest cards</a></li>
										<li><a href="/no-annual-fee.php">No Annual Fee</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-gift fa-lg" style="color:#156abd;"></i> Earn
									Rewards
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/cash-back.php">Cash Back Cards</a></li>
										<li><a href="/reward.php">Rewards Credit Cards</a></li>
										<li><a href="/points-rewards.php">Points Cards</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-plane fa-lg" style="color:#156abd;"></i> Travel
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/airline-miles.php">Airline Credit Cards</a></li>
										<li><a href="/no-foreign-transaction-fee.php">No Foreign Transaction</a></li>
										<li><a href="/gas-cards.php">Gas Credit Cards</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-tachometer fa-lg" style="color:#156abd;"></i>
									Credit Quality
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/excellent-credit.php">Excellent Credit</a></li>
										<li><a href="/good-credit.php">Good Credit</a></li>
										<li><a href="/fair-credit.php">Fair Credit</a></li>
										<li><a href="/bad-credit.php">Bad Credit</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-credit-card fa-lg" style="color:#156abd;"></i>
									Card Type
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/top-credit-cards.php">Top Credit Cards</a></li>
										<li><a href="/business.php">Business</a></li>
										<li><a href="/college-students.php">Student Cards</a></li>
										<li><a href="/prepaid.php">Prepaid / Debit</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-wrench fa-lg" style="color:#156abd;"></i> Tools
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form">CardMATCH &#8482;</a></li>
										<li><a target="_blank" href="https://walletup.creditcards.com/app">WalletUp&reg;</a></li>
										<li><a href="/best-credit-cards.php">Best Credit Cards</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- End of Credit Card Search Categories -->

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'contact-us';
$pageName = 'contact-us:newsletter:unsubscribe-thank-you';
$analyticsServer = '';
$pageType = '';
$prop1 = 'contact us:newsletter';
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
	$pageName = 'contact us:newsletter:unsubscribe thank you';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
