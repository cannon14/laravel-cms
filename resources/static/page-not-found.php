<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Page Not Found - CreditCards.com';
$metaKeywords = '';
$metaDescription = '';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link href="/css/cc-home.css" rel="stylesheet">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24"> <br>
				<h1>Looking for something at CreditCards.com?</h1>
				<p>The page you tried was not found. You may have used an outdated link or may have typed the address (URL) incorrectly. <br>
					However, you might find what you're looking for below:</p>
				<br>
			</div>
			<div class="col-xs-18 col-sm-18 col-md-18">
				<div class="row">
					<div class="col-xs-24 col-sm-12 col-md-6">
						<div class="panel panel-simple">
							<div class="panel-heading"><i class="fa fa-credit-card fa-lg" style="color:#156abd;"></i> Card Types</div>
							<div class="panel-body">
								<ul class="list-unstyled">
									<li><a href="/balance-transfer.php">Balance Transfer</a></li>
									<li><a href="/cash-back.php">Cash Back</a></li>
									<li><a href="/airline-miles.php">Travel & Airlines</a></li>
									<li><a href="/no-annual-fee.php">No Annual Fee</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xs-24 col-sm-12 col-md-6">
						<div class="panel panel-simple">
							<div class="panel-heading"><i class="fa fa-tachometer fa-lg" style="color:#156abd;"></i> Credit Quality</div>
							<div class="panel-body">
								<ul class="list-unstyled">
									<li><a href="/excellent-credit.php">Excellent</a></li>
									<li><a href="/good-credit.php">Good</a></li>
									<li><a href="/fair-credit.php">Fair</a></li>
									<li><a href="/bad-credit.php">Bad</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xs-24 col-sm-12 col-md-6">
						<div class="panel panel-simple">
							<div class="panel-heading"><i class="fa fa-thumbs-up fa-lg" style="color:#156abd;"></i> Cards Offers</div>
							<div class="panel-body">
								<ul class="list-unstyled">
									<li><a href="/top-credit-cards.php">Top Offers</a></li>
									<li><a href="/limited-time-offers.php">Limited Time Offers</a></li>
									<li><a href="/best-credit-cards.php">Best Credit Cards</a></li>
									<li><a href="/reward.php">Rewards Cards</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-xs-24 col-sm-12 col-md-6">
						<div class="panel panel-simple">
							<div class="panel-heading"><i class="fa fa-wrench fa-lg" style="color:#156abd;"></i> Tools</div>
							<div class="panel-body">
								<ul class="list-unstyled">
									<li><a href="/credit-card-tools/">Browse more tools</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-24 col-sm-24 col-md-6">
				<div class="panel panel-blue">
					<div class="panel-heading">We&apos;re Here to Help You</div>
					<div class="panel-body"> 
						<!-- ////////Content Goes Here////////// -->
						<div class="list-group"> <a href="https://www.creditcards.com/cardmatch/?action=show_form" class="list-group-item list-group-item-blue"> <i class="fa fa-angle-right fa-lg pull-right" style=" padding-top:5px;"></i>
							<div class="list-group-item-heading">Better Offers via CardMatch&#8482; </div>
							<p class="list-group-item-text">See offers matched with your credit profile.</p>
							</a> </div>
						<div class="list-group"> <a target="_blank" href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=home_about&utm_campaign=walletup" class="list-group-item list-group-item-blue"> <i class="fa fa-angle-right fa-lg pull-right" style=" padding-top:5px;"></i>
							<div class="list-group-item-heading">Max Rewards with WalletUp&reg; </div>
							<p class="list-group-item-text">Maximize your rewards, cash back, and points earnings.</p>
							</a> </div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<br>
	</div>
</div>
<!-- End of #other-block -->
<!-- End of Main Content -->

<?php

$trackingPixelImagePath = str_replace('http://', '//', $GLOBALS['RootPath']);
echo "<IMG SRC='".$trackingPixelImagePath."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1 style=\"display: none;\">\n";
echo "<IMG SRC='".$trackingPixelImagePath."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1 style=\"display: none;\">";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'tools';
$pageName = $channel.':error';
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
