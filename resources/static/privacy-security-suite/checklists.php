<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Checklists for protecting your privacy - CreditCards.com';
$metaKeywords = 'privacy, personal information, information sharing';
$metaDescription = 'The following downloadable checklists can help you protect your personal information.';

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
		<li class="active"><a href="/privacy-security-suite/checklists.php">Checklists</a></li>
		<li><a href="/privacy-security-suite/articles.php">Articles</a></li>
	</ul>
</div>
									<!-- /.navbar-collapse --> 
								</div>
						<!-- /.container-fluid --> 
					</nav>
							<br />
							<h2>Checklists</h2>
							<br />
							<p>Download the following checklists to help you protect your personal information and reduce your risk of being a victim of cyber theft.</p>
							<div class="row">
						<div class="col-md-24"> <br />
									<div class="row">
								<div class="col-sm-12">
											<table border="0" cellspacing="0" cellpadding="0" class="table table-striped">
										<tbody>
													<tr>
												<td>Wallet Safety Tips</td>
												<td><a target="_blank" href="/downloads/wallet_safety_tips.pdf">PDF</a></td>
											</tr>
													<tr>
												<td>What was in your wallet</td>
												<td><a target="_blank" href="/downloads/what_was_in_your_wallet.pdf">PDF</a></td>
											</tr>
													<tr>
												<td>What to do if you lost your wallet</td>
												<td><a target="_blank" href="/downloads/what_to_do_if_you_lost_your_wallet.pdf">PDF</a></td>
											</tr>
												</tbody>
									</table>
											<div class="col-sm-12"></div>
										</div>
							</div>
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
			
			
			<!-- Modal -->
			
		</div><!-- End of Other Block -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = 'tools:privacywise:checklists';
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
