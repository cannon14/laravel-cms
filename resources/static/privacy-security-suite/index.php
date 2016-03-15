<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Privacy Resources - PrivacyWise - CreditCards.com';
$metaKeywords = 'privacy, personal information, information sharing';
$metaDescription = 'Tips to protect your identity, Free annual credit report, opt out and other services that can protect you from identity theft.';

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
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav">
		<li class="active"><a href="/privacy-security-suite/">Online Resources <span class="sr-only">(current)</span></a></li>
		<li class="dropdown"> <a href="#" data-toggle="dropdown" role="button" aria-expanded="false">Protecting Yourself <span class="caret"></span></a>
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
							<h2>Online Privacy Resources</h2>
							<br />
							<div class="row">
						<div class="col-md-24">
									<h3><strong>Free Resources:</strong></h3>
									<br />
									<div class="media"> <a href="http://onguardonline.gov/" target="_blank" class="media-left"><img width="120" height="40" border="0" alt="OnGuard online" src="/images/onguard-online-logo.gif" class="img-responsive"> </a>
								<div class="media-body">
											<div class="media-heading"><strong><a href="http://onguardonline.gov/" target="_blank">Protecting yourself </a></strong></div>
											Great tips from the federal government and the technology industry to help you guard against internet fraud, secure your computer and protect your personal information. <br>
											<a target="_blank" href="http://onguardonline.gov">http://onguardonline.gov</a> </div>
							</div>
									<br />
									<div class="media"> <a href="http://www.ftc.gov/bcp/edu/microsites/idtheft/" target="_blank" class="media-left"><img width="120" height="23" border="0" alt="Federal Trade Commission" src="/images/federal-trade-commission-logo.gif" class="img-responsive"> </a>
								<div class="media-body">
											<div class="media-heading"><strong><a href="http://www.ftc.gov/bcp/edu/microsites/idtheft/" target="_blank">Identity theft</a></strong></div>
											The Federal Trade Commission offers comprehensive tips on protecting yourself from identity theft. <br>
											<a target="_blank" href="http://www.ftc.gov/bcp/edu/microsites/idtheft/">http://www.ftc.gov/bcp/edu/microsites/idtheft/</a> </div>
							</div>
									<br />
									<div class="media"> <a href="http://www.optoutprescreen.com/" target="_blank" class="media-left"><img width="120" height="103" border="0" alt="Experian, Equifax, TransUnion, Innovis" src="/images/optout-prescreen-logo.gif" class="img-responsive"> </a>
								<div class="media-body">
											<div class="media-heading"><strong><a href="http://www.optoutprescreen.com/" target="_blank">Opting out </a></strong></div>
											Opt out of receiving pre-screened solicitations from major credit bureaus by calling or visiting: <br>
											1-888-5-OPTOUT <br>
											<a target="_blank" href="http://www.optoutprescreen.com">http://www.optoutprescreen.com</a> </div>
							</div>
									<br />
									<div class="media"> <a href="http://www.annualcreditreport.com/" target="_blank" class="media-left"><img width="120" height="77" border="0" alt="Experian, Equifax, TransUnion" src="/images/free-annual-credit-report-logo.gif" class="img-responsive"> </a>
								<div class="media-body">
											<div class="media-heading"><strong><a href="http://onguardonline.gov/" target="_blank">Opting out </a></strong></div>
											By law, you are entitled to receive a free copy of your credit report annually. Get yours from <br>
											<a target="_blank" href="http://www.annualcreditreport.com">http://www.annualcreditreport.com</a> </div>
							</div>
                            <br />
                            <div class="media"> <a href="https://my.creditcards.com" target="_blank" class="media-left"><img src="/images/mycreditcards-privacywise.png" alt="My.CreditCards.com" width="120" border="0" class="img-responsive"> </a>
                                <div class="media-body">
                                    <div class="media-heading"><strong><a href="http://www.allclearid.com/" target="_blank">Free Credit Score and Credit Monitoring</a></strong></div>
                                    Get your FREE credit score and credit report. Monitor your credit and protect your identity.<br>
                                    <a target="_blank" href="https://my.creditcards.com">https://my.creditcards.com</a> </div>
                            </div>

									<br />
									<div class="media"> <a href="http://www.antiphishing.org/" target="_blank" class="media-left"><img width="120" height="50" border="0" alt="Anti-Phishing Working Group" src="/images/anti-phishing-working-group-logo.gif" class="img-responsive"> </a>
								<div class="media-body">
											<div class="media-heading"><strong><a href="http://www.antiphishing.org/" target="_blank">Phishing</a></strong></div>
											Information on phishing can be accessed at <br>
											<a target="_blank" href="http://www.antiphishing.org">http://www.antiphishing.org</a> </div>
							</div>
									<br />
									<div class="media"> <a href="http://www.millersmiles.co.uk/" target="_blank" class="media-left"><img width="120" height="27" border="0" alt="millersmiles.co.uk" src="/images/millersmiles-logo.gif" class="img-responsive"> </a>
								<div class="media-body">
											<div class="media-heading"><strong><a href="http://www.millersmiles.co.uk/" target="_blank">MillerSmiles.co.uk</a></strong></div>
											For a current list of phishing reports, visit <br>
											<a target="_blank" href="http://www.millersmiles.co.uk">http://www.millersmiles.co.uk</a> </div>
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
$pageName = 'tools:privacywise';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
$prop2 = 'tools';
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
