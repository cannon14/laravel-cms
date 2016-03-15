<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Protecting your identity from fraud - CreditCards.com';
$metaKeywords = 'privacy, personal information, information sharing';
$metaDescription = 'Follow these steps to protect your personal information against identity theft.';

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
		<li class="dropdown active"> <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">Protecting Yourself <span class="caret"></span></a>
	<ul class="dropdown-menu" role="menu">
				<li><a href="/privacy-security-suite/protecting-yourself.php">Protecting your account</a></li>
				<li><a href="/privacy-security-suite/protecting-your-identity.php">Protecting your identity</a></li>
				<li><a href="/privacy-security-suite/security-tips.php">Security Tips</a></li>
			</ul>
</li>
		<li><a href="/privacy-security-suite/if-youre-a-victim.php">If you've been a victim</a></li>
		    <li><a href="/privacy-security-suite/checklists.php">Checklists</a></li>
		<li><a href="/privacy-security-suite/articles.php">Articles</a></li>
	</ul>
</div>
									<!-- /.navbar-collapse --> 
								</div>
						<!-- /.container-fluid --> 
					</nav>
							<br />
							<h2>Protecting Yourself</h2>
							<br />
							<p>Here are steps you can take to protect your personal information against identity theft.</p>
							<div class="row">
						<div class="col-md-24">
									<div><strong>Protecting your identity</strong></div>
									<ul>
								<li>
											<p> <em>Check your credit report regularly</em> <br>
										In many cases, the first indication that your identity has been stolen is when a new account you did not authorize, appears on your credit report. That's why its important that you regularly review your credit report. By law, you are entitled to receive a free copy of your credit report annually. To request yours, visit <a target="_blank" href="http://www.annualcreditreport.com">annualcreditreport.com</a>. </p>
										</li>
								<li>
											<p> <em>Be alert for phishing attacks or spoof sites</em> <br>
										Credit card issuers will never ask you to provide sensitive personal information, including account numbers or passwords, in an email. If you receive an email that requests this information or that directs you to a website that you suspect may not be authentic, do not respond! Additional information on phishing can be found at the <a target="_blank" href="http://www.antiphishing.org">Anti-phishing Working Group</a>. For a list of current phishing reports, visit <a target="_blank" href="http://www.millersmiles.co.uk/archives/current">Millersmiles</a>. </p>
										</li>
								<li>
											<p> <em>More tips</em> <br>
										The Federal Trade Commission offers comprehensive tips on protecting yourself at the <a target="_blank" href="http://www.ftc.gov/bcp/edu/microsites/idtheft">FTC's identity theft website</a>. </p>
										</li>
							</ul>
									<br />
									<div class="row white-link-text">
								<div class="col-xs-12" style="padding-right:10px;"> <a href="/privacy-security-suite/protecting-yourself.php" class="btn btn-primary btn-block pull-left"><i class="fa fa-chevron-left"></i> &nbsp;Protecting Your Account</a> </div>
								<div class="col-xs-12" style="padding-left:10px;"> <a href="/privacy-security-suite/security-tips.php" class="btn btn-primary btn-block pull-right">Security Tips &nbsp;<i class="fa fa-chevron-right"></i></a></div>
							</div>
									<br />
									<div class="cal-fb-other-hldr" style="text-align:right;"> <br/>
								<div style="text-align:right;"> Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a> </div>
							</div>
								</div>
					</div>
						</div>
			</div>
					<br />
				</div>
	</div>
		</div><!-- End of Other Block -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = 'tools:privacywise:identity';
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
