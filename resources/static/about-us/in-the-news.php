<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "897";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Credit Card News: What people are saying about CreditCards.com';
$metaKeywords = 'creditcards.com, credit cards, credit card, Visa, Mastercard, Discover, American Express, offers, apply online, credit card application, articles';
$metaDescription = 'CreditCards.com is frequently referenced in the media.  See where we\'ve recently been quoted.';

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
					<li><a href="/about-us.php">About Us </a> <i class="fa fa-angle-right"></i></li>
					<li>In the News</li>
				</ol>
				<ol class="breadcrumb">
					<li><a href="/about-us/press-releases.php">Press Releases</a></li>
					<li class="active">In the News</li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php"><i class="fa fa-envelope-o"></i> Media Contact</a></li>
				</ol>
			</div>
			<br />
			<h1>In the News</h1>
			<p>As an industry leader in the credit card marketplace, CreditCards.com is frequently referenced in the media, some highlights are listed below.</p>
			<p>We conduct proprietary public opinion polls, including our most recent "Taking Charge: America's relationship with Credit Cards" which are widely used by the media.</p>
			<p>We have a staff of seasoned experts who are available to comment on credit card issues or support with research and opinions.</p>
			<p> If you need material for a developing story or article, we will be happy to assist you - please <a href="/public-relations.php">contact us</a>. </p>
			<br />
			<h2 style="font-weight:bold;">Broadcast</h2>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"> <img src="/images/broadcast-cbs-marketwatch.gif" width="88" height="60" alt="CBS MarketWatch"/></div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"> <img src="/images/broadcast-businessweek-com.gif" width="202" height="37" alt="BusinessWeek.com"/></div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/cnn.com.logo.gif" width="133" height="60" alt="CNN.com"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-fox-houston.jpg" width="41" height="60" alt="Fox 26 KRIV"/> </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-fox-news.gif" width="45" height="43"  alt="Fox News Channel"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-la-news-radio.gif" width="90" height="31" alt="KNX 1070 News Radio"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-msnbc.gif" width="70" height="47" alt="MSNBC"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/msmoneylogo.jpg" width="100" height="60" alt="msn Money"/> </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-today-show.gif" width="80" height="57" alt="Today"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-wbix-boston.gif" width="80" height="39" alt="WBIX Business 1060 AM"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/yahooFinance-logo.jpg" width="133" height="60" alt="Yahoo! Finance"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"> </div>
				</div>
			</div>
			<br />
			<h2 style="font-weight:bold;">Print</h2>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-boston-globe.gif" width="120" height="45" alt="The Boston Globe"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/businessWeek_logo.gif" width="133" height="60" alt="BusinessWeek"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/chicago_tribune_logo.gif" width="130" height="60" alt="Chicago Tribune"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-dallas-morning-news.gif" width="150" height="45" alt="The Dallas Morning News"/> </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-fed-reserve-bank-of-kansas-city.gif" width="100" height="45" alt="Federal Reserve Bank of Kansas City"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-forbes-magazine.gif" width="86" height="45" alt="Forbes"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-inc-magazine.gif" width="90" height="34" alt="Inc"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/los-angeles-times-logo.gif" width="140" height="60" alt="Los Angeles Times"/> </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-new-york-daily-news.gif" width="130" height="45" alt="Daily News"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/new_york_times_logo.gif" width="130" height="60" alt="The New York Times"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-success-magazine.gif" width="120" height="42" alt="Success"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/wall_street_journal_logo.gif" width="130" height="44" alt="The Wall Street Journal"/></div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/print-washington-post.gif" width="120" height="45" alt="The Washington Post"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"><img src="/images/broadcast-fed-reserve-bank-of-philidelphia.gif" width="150" height="45" alt="Federal Reserve Bank of Philadelphia"/> </div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"></div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="about-img-hldr"></div>
				</div>
			</div>
			<br />
			<br />
			<br />
			<h2>For logos, images and other company information:</h2>
			<p><strong><a href="/about-us/press-kit.php">Download our Press Kit</a></strong> <br />
				<br />
			</p>
		</div>
	</div>
</div>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>

<?
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'about-us';
$pageName = 'about-us:press-room:news';
$analyticsServer = '';
$pageType = '';
$prop1 = 'about us:press room:news';
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
	$channel = 'about us';
	$pageName = 'about us:press room:news';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>
</body>
</html>
