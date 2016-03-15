<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');

$errors = array();
$error_class = 'has-error';
//validate form
if (isset($_REQUEST['validate'])) {
	if (!isset($_REQUEST['NAME']) || $_REQUEST['NAME'] == '') {
		$errors['name'] = "Please specify your name";
	}
	if (!preg_match('/^[A-Z, a-z, ]*$/',$_REQUEST['NAME'])) {
		$errors['name'] = "Name must be alphabetic characters";
	}
	if (!isset($_REQUEST['EMAIL']) || $_REQUEST['EMAIL'] == '') {
		$errors['email'] = "Please specify your email address";
	}
	if (!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_REQUEST['EMAIL'])) {
		$errors['email'] = "Email must be in the form yourname@yourdomain.com";
	}
	if (!isset($_REQUEST['EMAIL2']) || $_REQUEST['EMAIL2'] == '') {
		$errors['email2'] = "Please specify recipients email address";
	}
	if (!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_REQUEST['EMAIL2'])) {
		$errors['email2'] = "Email must be in the form name@domain.com";
	}
	if (!verifyCaptcha( $_REQUEST )) {
		$errors['captcha'] = "Verification code does not match. Please re-enter.";
	}
	if (empty($errors)) {
		include("email_offer_script.php");
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
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="robots" content="noindex, nofollow">
	<meta name="revisit-after" content="10 days">
	<meta name="resource-type" content="document">
	<meta name="distribution" content="global">
	<meta name="author" content="CreditCards.com">
	<meta name="copyright" content="Copyright <?= date('Y') ?> CreditCards.com">
	<meta name="author" content="CreditCards.com">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'/>
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
	<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/cc-override.css" rel="stylesheet" type="text/css"/>
	<link href="css/cc-global.css" rel="stylesheet" type="text/css"/>
        <link href="/css/cc-misc.css" rel="stylesheet">
	
<?php if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); } ?>
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
					<li>Email Offer</li>
				</ol>
			</div><!-- End of breadcrumbs -->

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


			<p>A link to the credit card offer will be sent to the email address you provide below.</p>

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
				
				<div class="form-group <?php if (isset($errors['email2'])) { echo $error_class; } ?>">
					<label for="recipient-email" class="col-sm-4 control-label">Recipient's e-mail Address*</label>
					<div class="col-sm-10">
						<input type="text" name="EMAIL2"  class="form-control" value="<?=$_REQUEST['EMAIL2']?>">
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
						<input class="btn btn-primary btn-lg" type="submit" value="Submit" onclick=" s.linkTrackVars='products,events'; s.linkTrackEvents='event10'; s.events='event10'; s.tl(this,'o','Email me the Offer')">
						<input type="hidden" name="validate" value="1">
					</div>
					<div class="col-sm-5">
						<input type=hidden name="validate" value="1">
						<input type=hidden name="cardLink" value="<?=$_GET["cardLink"]?>">
						<input type=hidden name="cardTitle" value="<?=$_GET["cardTitle"]?>">
						<input type=hidden name="pid" value="<?=$_GET["pid"]?>">
						<input type=hidden name="fid" value="<?=$_SESSION['fid']?>">
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

$channel = 'pop-up';
$pageName = '';
$analyticsServer = '';
$pageType = '';
$prop1 = '';
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
$analyticsProducts = $_REQUEST['fid'].';'.$_REQUEST['pid'].';;';
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
$eVar20 = '';
$eVar27 = '';
$eVar34 = $_REQUEST['fid'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) {
	$channel = 'TYPE';
	$pageName = '';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>
</body>

</html>
