<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '865';
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
	if (!isset($_REQUEST['ADVERTISINGCOMMENTS']) || $_REQUEST['ADVERTISINGCOMMENTS'] == '') {
		$errors['comment'] = 'Please describe the products or services you wish to advertise.';
	}
	if (!verifyCaptcha($_REQUEST)) {
		$errors['captcha'] = 'Verification text does not match. Please re-enter.';
	}

	if (empty($errors)) {
		require_once('advertising_script.php');
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

$htmlTitle = 'Credit Card - Advertise your business with CreditCards.com';
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

			<div class="other-subnav-hldr">
		        <ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="contact.php">Contact Us</a> <i class="fa fa-angle-right"></i></li>
					<li>Advertising</li>
		        </ol>
			</div>

			<h1>Advertising Department</h1>

			<p>Please use the following form to contact us concerning advertising opportunities. We will provide an email response usually within one business day of receipt of your inquiry.</p>

			<p>If you are interested in advertising CreditCards.com services please visit our <a href="http://www.bankratecreditcards.com/" target="_blank">Partnership Opportunity site</a>.</p>

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

				<div class="form-group">
					<label for="organization" class="col-sm-4 control-label">Organization</label>
					<div class="col-sm-10">
						<input type="text" name="ORGANIZATION" class="form-control" id="" value="<?= $_REQUEST['ORGANIZATION'] ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="phone" class="col-sm-4 control-label">Phone number</label>
					<div class="col-sm-10">
						<input type="tel" name="PHONE" class="form-control" id="" value="<?= $_REQUEST['PHONE'] ?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Email address*</label>
					<div class="col-sm-10">
						<input type="email" name="EMAIL" class="form-control" id="" value="<?= $_REQUEST['EMAIL'] ?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['comment'])) { echo $error_class; } ?>">
					<br>
					<div class="col-sm-14">
						<label for="comments" class="control-label">Briefly describe the products or services you wish to advertise*</label>
						<textarea class="form-control" name="ADVERTISINGCOMMENTS" rows="3"><?= $_REQUEST['ADVERTISINGCOMMENTS'] ?></textarea>
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
$pageName = $channel.':advertising';
$analyticsServer = '';
$pageType = '';
$prop1 = 'contact us';
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
	$channel = 'contact us';
	$pageName = $channel.':advertising';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
