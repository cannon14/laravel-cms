<?php

$pagefid = "1583";

include_once('templates/partials/initTracking.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = empty($this->title) ? 'CardMatch - CreditCards.com' : $this->title;
$metaDescription = empty($this->keywords) ? '' : $this->keywords;
$metaKeywords = empty($this->description) ? '' : $this->description;
include_once('templates/partials/htmlHead.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
</head>

<body>

<?php include_once('templates/partials/header.php'); ?>

<!-- Steps Block-->
<div class="steps-block">
	<div class="container">
		<div class="row">
			<div class="col-xs-6 col-sm-5 col-md-6 inactive-step mobile-hide"><i class="fa fa-check-circle green-check"></i> About You</div>
			<div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-6 col-sm-7 col-md-8 inactive-step mobile-hide"><i class="fa fa-check-circle green-check"></i> Term & Conditions</div>
			<div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-24 col-sm-8 col-md-6 active-step">
				<div class="blue-circle">!</div>
				Card Matches</div>
		</div>
	</div>
</div>

<!-- Progress Block-->
<div class="progress-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<div class="searching-hldr">
					<div class="progress-header-text">
						Sorry <?= $this->user->getFirstName() ?>, <span class="progress-header-greentext">we cannot find your credit profile</span>
						at this time.
					</div>
					<div class="progress-header-subtext">
						Based on the information you provided, the credit bureau we use could not locate a file<br>
						in your name. This is not a reflection of your credit quality.
					</div>

					<div class="browse-all-btn-hldr">
						<a href="http://www.creditcards.com" class="btn btn-primary btn-lg">BROWSE ALL CARDS<i class="fa fa-angle-right" style="padding-left:10px;"></i></a>
					</div>

					<br>

					<p><strong>-OR-</strong></p>

					<form class="form-horizontal" role="form" name="modifyInfo" action="./" method="POST" id="modify-info">
						<input type="hidden" name="action" value="show_form">
						<div class="progress-error-btn-hldr">
							<a href="/cardmatch/?action=show_form">Modify your info and try again</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>

<?php

include_once('templates/partials/footer.php');
include_once('templates/partials/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:cardmatch_error';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:cardmatch error';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'cardmatch';
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
	$channel = 'tools';
	$pageName = 'tools:cardmatch error';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>
</body>
</html>
