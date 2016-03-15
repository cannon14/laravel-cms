<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$errors = array();
$error_class = 'has-error';
// validate form
if (isset($_REQUEST['validate'])) {
	if (!isset($_REQUEST['NAME']) || $_REQUEST['NAME'] == '') {
		$errors['name'] = 'Please specify your name.';
	}
	if (!preg_match('/^[A-Z, a-z, ]*$/',$_REQUEST['NAME'])) {
		$errors['name'] = 'Name must be alphabetic characters.';
	}
	if (!isset($_REQUEST['EMAIL'])  || $_REQUEST['EMAIL'] == '') {
		$errors['email'] = 'Please specify your email address.';
	}
	if (!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_REQUEST['EMAIL'])) {
		$errors['email'] = 'Email must be in the form yourname@yourdomain.com';
	}
	if (!isset($_REQUEST['PRODUCT']) || $_REQUEST['PRODUCT'] == '') {
		$errors['product'] = 'Please select a product.';
	}
	if (!isset($_REQUEST['MESSAGE']) || $_REQUEST['MESSAGE'] == '') {
		$errors['message'] = 'Please provide your feedback.';
	}
	if (!verifyCaptcha($_REQUEST)) {
		$errors['captcha'] = 'Verification text does not match. Please re-enter.';
	}

	if (empty($errors)) {
		require_once('site-feedback-script.php');
	}
}

function verifyCaptcha($params) {
	$captchaText = $_SESSION['CAPTCHAString'];
	$userEntry = $params['captcha_entry'];

	return $userEntry == $captchaText;
}
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Give us Feedback - CreditCards.com';
$metaKeywords = 'CreditCards.com feedback';
$metaDescription = 'Do you have feedback on some of the tools offered on the site? General comments about the website? Please let us know. We are constantly seeking to improve CreditCards.com and bring you tools that help you make financial decisions.';

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

			<div class="other-subnav-hldr">
		        <ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="contact.php">Contact Us</a> <i class="fa fa-angle-right"></i></li>
					<li>Feeback</li>
		        </ol>
			</div>

			<h1>Give us Feedback!</h1>

			<p>Do you have feedback on some of the tools offered on the site? General comments about the website? Please let us know. We are constantly seeking to improve CreditCards.com and bring you tools that help you make financial decisions.</p>
            <p>Use this form only to submit feedback about the website or tools offered on the site. For answers to commonly asked questions, contact <a href="/customer-support-department.php">Customer Support</a>.</p>
            <p>If you are trying to follow-up on an application that you have already submitted online, <a href="/bank-partner-contact-information.php">contact the credit card issuer directly</a>. </p>

			<br>

			<?php if (!empty($errors)): ?>
				<div class="alert alert-danger" role="alert">
					<strong>Please check the following</strong>
					<ul>
					<?php foreach ($errors as $error): ?>
						<li><?= $error ?></li>
					<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" role="form" method="post">
				<div class="form-group <?php if (isset($errors['name'])) { echo $error_class; } ?>">
					<label for="name" class="col-sm-4 control-label">Name*</label>
					<div class="col-sm-10">
						<input type="text" name="NAME" class="form-control" id="" value="<?= $_REQUEST['NAME'] ?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Email address*</label>
					<div class="col-sm-10">
						<input type="email" name="EMAIL" class="form-control" id="" value="<?= $_REQUEST['EMAIL'] ?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['product'])) { echo $error_class; } ?>">

						<label for="comments" class="control-label col-sm-4">Product*</label>
						<?php

						$selection = isset($_REQUEST['PRODUCT']) ? $_REQUEST['PRODUCT'] : 'default';
						$selected = 'selected="selected"';
						?>
					<div class="col-sm-10">
						<select class="form-control" name="PRODUCT">
							<option value="default" <?php if ($selection == 'default') { echo $selected; } ?>>--Select One--</option>
							<option value="general" <?php if ($selection == 'general') { echo $selected; } ?>>General Feedback</option>
							<option value="cardmatch" <?php if ($selection == 'cardmatch') { echo $selected; } ?>>CardMatch</option>
							<option value="estimator" <?php if ($selection == 'estimator') { echo $selected; } ?>>Credit Score Estimator</option>
							<option value="calculators" <?php if ($selection == 'calculators') { echo $selected; } ?>>Credit Card Calculators</option>
							<option value="walletup" <?php if ($selection == 'walletup') { echo $selected; } ?>>WalletUp</option>
							<option value="mycreditcards" <?php if ($selection == 'mycreditcards') { echo $selected; } ?>>My.CreditCards.com</option>
						</select>
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['message'])) { echo $error_class; } ?>">
					<br>
						<label for="comments" class="control-label col-sm-4">Feedback*</label>
					<div class="col-sm-10">
						<textarea class="form-control" name="MESSAGE" rows="3"><?= $_REQUEST['MESSAGE'] ?></textarea>
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['captcha'])) { echo $error_class; } ?>">
					<br>
					<label for="" class="col-sm-4 control-label">Enter Verification Code*</label>
					<div class="col-sm-3">
						<input type="text" name="captcha_entry" class="form-control" id="" placeholder="">
					</div>
					<div class="col-sm-5">
						<img style="border:1px solid #A5ACB2" align="middle" src="/lib/captcha/captcha.php">
					</div>
				</div>

				<br>

				<div class="form-group">
					<div class="col-sm-5 misce-btn">
						<input class="btn btn-primary btn-lg" type="submit" value="Submit">
						<input type="hidden" name="validate" value=1>
					</div>
					<div class="col-sm-5">
					</div>
				</div>
			</form>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'contact-us';
$pageName = 'contact-us:media';
$analyticsServer = '';
$pageType = '';
$prop1 = 'contact us';
$prop2 = 'contact us';
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
	$pageName = 'contact us:media';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
