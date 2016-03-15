<?php
$pagefid = "1582";

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
			<div class="col-xs-24 col-sm-10 col-md-8 active-step">
				<div class="blue-circle">2</div>
				Term &amp; Conditions </div>
			<div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
			<div class="col-xs-6 col-sm-5 col-md-6 inactive-step mobile-hide">
				<div class="grey-circle">3</div>
				Card Matches</div>
		</div>
	</div>
</div>

<!-- Main Content -->
<div class="maincontent-block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="terms-content"> By clicking "Submit", I authorize CreditCards.com to communicate the personal identifying information I have provided to one or more participating credit card issuers and to a consumer reporting agency. I authorize the consumer reporting agency that receives my personal identifying information from CreditCards.com to use my consumer report information, including my credit score, to determine which credit card products might be available to me based on credit criteria made available to the consumer reporting agency by participating credit card issuers. I authorize a credit card issuer that receives my personal identifying information from CreditCards.com to use it to determine which credit card products might be available to me. </div>
			</div>
			<div class="col-md-12">
				<div class="terms-content-right"> I also acknowledge that even if I receive an indication that I am likely to be approved for a particular credit card product and I apply for that product, there is no guarantee that I will be approved by the credit card issuer or that a card will be issued to me. When my personal identifying information is provided by CreditCards.com to a consumer reporting agency, I understand that my consumer report records will indicate that CreditCards.com and/or the credit card issuer has made a credit inquiry about me. I also understand that CreditCards.com does not retain any of my personal identifying information or my consumer report information, except as a record that I have elected to use this tool. I understand that CreditCards.com will not be able to tell me why I did or did not appear to qualify for any particular credit card product. </div>
				<div class="term-check-box-hlr">
					<div class="row">
						<div class="col-xs-2 col-sm-1">
							<input id="terms-checkbox" name="termsCheckbox" type="checkbox" value=""  style="transform: scale(1.5); -webkit-transform: scale(1.5);">
						</div>
						<div class="col-xs-22 col-sm-23">
							<div class="term-check-box-text"> I understand that this is not an application for credit and that, if I wish to apply for a credit card with any participating credit card issuer, I will need to click through and make application directly with that issuer. </div>
						</div>
					</div>
				</div>
				<form name="userVerifyForm" action="./" method="POST">
					<input type="hidden" name="action" value="confirm_user_info">
					<div class="cm-btn-hldr">
						<button id="terms-button" class="btn btn-success btn-lg" disabled="disabled"><i class="fa fa-lock fa-lg"></i>&nbsp;&nbsp;SUBMIT</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php

include_once('templates/partials/footer.php');
include_once('templates/partials/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:cardmatch_verify';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:cardmatch_verify';
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
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>
<script>
	$termsCheckbox = $('#terms-checkbox');
	$termsButton = $('#terms-button');
	$(document).ready(function() {
		$termsCheckbox.change(function() {
			if ($(this).prop('checked') === true) {
				$termsButton.prop('disabled', false);
			} else {
				$termsButton.prop('disabled', true);
			}
		});
	});
</script>

</body>
</html>
