<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Articles on privacy and identity theft - CreditCards.com';
$metaKeywords = 'privacy, personal information, information sharing';
$metaDescription = 'The following privacy and identity theft articles can keep you up-to-date on the latest credit card fraud techniques and scams.';

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
					<li>PrivacyWise </li>
					<span></span>
				</ol>
				<div ></div>
			</div>
			<br />
			<h1 style="font-weight:bold;">PrivacyWise&#8482;</h1>
			<p class="misce-description">A credit card offers great convenience; however if your personal or account information is lost or stolen, it can also be a source of endless aggravation.
				PrivacyWise&#8482; is a reference guide that helps you:
			<ul>
				<li>Reduce the risk of having your credit card account or your identity stolen</li>
				<li>Quickly respond if you've been a victim</li>
			</ul>
			</p>
			<br />
			<div class="row">
				<div class="col-md-24">
					<nav class="navbar navbar-default" role="navigation">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
							</div>
							
							<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
		<li><a href="/privacy-security-suite/">Online Resources <span class="sr-only">(current)</span></a></li>
		<li class="dropdown"> <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">Protecting Yourself <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li><a href="/privacy-security-suite/protecting-yourself.php">Protecting your account</a></li>
				<li><a href="/privacy-security-suite/protecting-your-identity.php">Protecting your identity</a></li>
				<li><a href="/privacy-security-suite/security-tips.php">Security Tips</a></li>
			</ul>
		</li>
		<li><a href="/privacy-security-suite/if-youre-a-victim.php">If you've been a victim</a></li>
		    <li><a href="/privacy-security-suite/checklists.php">Checklists</a></li>
		<li class="active"><a href="/privacy-security-suite/articles.php">Articles</a></li>
	</ul>
</div>
							<!-- /.navbar-collapse --> 
						</div>
						<!-- /.container-fluid --> 
					</nav>
					<br />
					<h2>Related privacy and identity theft articles</h2>
					<br />
					<p>The following privacy and identity theft articles can keep you up-to-date on the latest credit card fraud techniques and credit card scams.</p>
					<div class="row">
						<div class="col-md-24"> <br />
							<ul>
								<li class="style13"><a href="/credit-card-news/lost-card-cardmember-services-1273.php">Limiting your financial loss</a></li>
								<li class="style13"><a href="/credit-card-news/beware-tax-time-mail-theft-1282.php">Beware of mail theft at tax time</a></li>
								<li class="style13"><a href="/credit-card-news/cancel-a-credit-card-1267.php">Credit card cancellation how to</a></li>
								<li class="style13"><a href="/credit-card-news/identity-theft-on-small-websites-1267.php">Credit card dangers may lurk on smaller Web sites</a></li>
								<li class="style13"><a href="/credit-card-news/phishing-credit-card-scam-fraud-1282.php">Credit card phishing &ndash; what it means and how to avoid it </a></li>
								<li class="style13"><a href="/credit-card-news/credit-card-skimming-scam-1282.php">Skimming 101 -how to spot it, avoid it, deal with it</a></li>
								<li class="style13"><a href="/credit-card-news/identity-protection-tips-when-credit-card-is-lost-1282.php">What to do when credit cards are lost or stolen </a></li>
								<li class="style13"><a href="/credit-card-news/identity-theft-techniques-1282.php">Know the latest credit card fraud techniques</a></li>
								<li class="style13"><a href="/credit-card-news/credit-card-users-protection-steps-identity-theft-1268.php">Credit card users can help prevent identity theft</a></li>
								<li class="style13"><a href="/credit-card-news/credit-card-fraud-and-online-shopping-1282.php">Online shopping options offer credit card safety</a></li>
								<li class="style13"><a href="/credit-card-news/safeguard-personal-information-online-1282.php">4 ways to safeguard personal information online</a></li>
							</ul>
						</div>
					</div>
					<br />
					<div class="cal-fb-other-hldr" style="text-align:right;"> <br/>
						<div style="text-align:right;"> Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a> </div>
					</div>
				</div>
				<br />
			</div>
		</div>
	</div>
</div>
<!-- End of Other Block -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = 'tools:privacywise:articles';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:privacywise';
$prop2 = 'tools:privacywise';
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
