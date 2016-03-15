<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$errors = array();
$error_class = 'has-error';
//validate form
if(isset($_REQUEST['validate'])) {
	if (!isset($_REQUEST['NAME']) || $_REQUEST['NAME'] == '') {
		$errors['name'] = "Please specify your name";
	}
	if (!preg_match('/^[A-Z, a-z, ]*$/',$_REQUEST['NAME'])) {
		$errors['name'] = "Name must be alphabetic characters";
	}
	if(!isset($_REQUEST['EMAIL']) || $_REQUEST['EMAIL'] == '') {
		$errors['email'] = "Please specify your email address";
	}
	if(!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_REQUEST['EMAIL'])) {
		$errors['email'] = "Email must be in the form yourname@yourdomain.com";
	}
	if(!isset($_REQUEST['PHONE']) || $_REQUEST['PHONE'] == '') {
		$errors['phone'] = "Please specify your phone number";
	}
	// regex from http://stackoverflow.com/questions/123559/a-comprehensive-regex-for-phone-number-validation
	if(!preg_match('/^(?:(?:\+?1\s*(?:[.-]\s*)?)?(?:\(\s*([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9])\s*\)|([2-9]1[02-9]|[2-9][02-8]1|[2-9][02-8][02-9]))\s*(?:[.-]\s*)?)?([2-9]1[02-9]|[2-9][02-9]1|[2-9][02-9]{2})\s*(?:[.-]\s*)?([0-9]{4})(?:\s*(?:#|x\.?|ext\.?|extension)\s*(\d+))?$/', $_REQUEST['PHONE']) || strlen($_REQUEST['PHONE']) < 8) {
		$errors['phone'] = "Please provide a valid phone number with area code first.";
	}
	if (!verifyCaptcha($_REQUEST)) {
		$errors['captcha'] = "Verification code does not match. Please re-enter.";
	}
	if(empty($errors)) {
		include("interview_invitation_script.php");
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

$htmlTitle = 'Interview - CreditCards.com';
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

			<!-- breadcrumbs -->
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/contact.php">Contact Us</a> <i class="fa fa-angle-right"></i></li>
					<li>Interview</li>
				</ol>
			</div><!-- End of breadcrumbs -->

			<h1>Earn $100 by completing an interview</h1>

			<p>From time to time, we solicit feedback from our site visitors in order to improve our products and services.</p>
			<p>Earn $100 by participating and completing a telephone interview about your site experience. This will take approximately one hour of your time. Complete the form below, and if selected, one of our interviewers will contact you to schedule a time that is most convenient for you.</p>

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

			<form class="form-horizontal" role="form" method="POST">
				<div class="form-group <?php if (isset($errors['name'])) { echo $error_class; } ?>">
					<label for="name" class="col-sm-4 control-label">Your name*</label>
					<div class="col-sm-10">
						<input type="text" name="NAME"  class="form-control" value="<?=$_REQUEST['NAME']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Your e-mail address*</label>
					<div class="col-sm-10">
						<input type="text" name="EMAIL"  class="form-control" value="<?=$_REQUEST['EMAIL']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['phone'])) { echo $error_class; } ?>">
					<label for="phone" class="col-sm-4 control-label">Phone number*</label>
					<div class="col-sm-10">
						<input type="tel" name="PHONE"  class="form-control" value="<?=$_REQUEST['PHONE']?>">
					</div>
				</div>
				
				
				<div class="form-group <?php if (isset($errors['captcha'])) { echo $error_class; } ?>">
					<label for="captcha" class="col-sm-4 control-label">Verification Code*</label>
					<div class="col-sm-3">
						<input type="text" name="captcha_entry" class="form-control" id="" placeholder="">
					</div>
					<div class="col-sm-5">
						<img style="border:1px solid #A5ACB2" align="middle" src="/lib/captcha/captcha.php">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-5 misce-btn">
						<input class="btn btn-primary btn-lg" type="submit" value="Submit">
						<input type="hidden" name="validate" value="1">
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

$channel = 'about-us';
$pageName = 'about-us:survey:interview-invitation';
$analyticsServer = '';
$pageType = '';
$prop1 = 'about us:survey';
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
	$pageName = 'about us:survey:interview-invitation';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
