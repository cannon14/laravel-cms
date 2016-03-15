<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '868';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$errors = array();
$error_class = 'has-error';
//validate form
if ($_REQUEST['validate']) {
	if (!isset($_REQUEST['fname']) || $_REQUEST['fname'] == '') {
		$errors['fname'] = "Please specify your first name";
	}
	if (!preg_match('/^[A-Z, a-z, ]*$/',$_REQUEST['fname'])) {
		$errors['fname'] = "First name must be alphabetic characters";
	}
	if (!isset($_REQUEST['lname']) || $_REQUEST['lname'] == '') {
		$errors['lname'] = "Please specify your last name";
	}
	if (!preg_match('/^[A-Z, a-z, ]*$/',$_REQUEST['lname'])) {
		$errors['lname'] = "Last name must be alphabetic characters";
	}
	if (!isset($_REQUEST['email']) || $_REQUEST['email'] == '') {
		$errors['email'] = "Please specify your email address";
	}
	if (!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_REQUEST['email'])) {
		$errors['email'] = "Email must be in the form yourname@yourdomain.com";
	}
	if (!verifyCaptcha( $_REQUEST )) {
		$errors['captcha'] = "Validation Code is incorrect";
	}

	if (empty($errors)) {
		$_POST['name'] = $_REQUEST['fname'] . " " . $_REQUEST['lname'];
		$curlUrl = "http://www.creditcardsmail.com/ec/optin.php";
		$result = sendCurl($curlUrl);

		if ($result == '1') {
			$_POST['state'] = 'thankyou';
			$redirectURL = "ratereport-thankyou.php";
			header("Location: ".$redirectURL);
		} else {
			$_POST['state'] = 'preview';
			$_POST['send_error'] = "Error saving your email. Please try again later.";
		}
	}
}

function verifyCaptcha($params) {

	$captchaText = $_SESSION['CAPTCHAString'];
	$userEntry = $params['captcha_entry'];

	return $userEntry == $captchaText;
}

function sendCurl($curlUrl) {
	$_POST['machine_ip'] = $_SERVER['SERVER_ADDR'];
	$_POST['security_string'] = 'ccc0m' . date('Ymd') . 'n3w5l3tt3r';


	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $curlUrl);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$curl_result = curl_exec($ch);

	curl_close($ch);

	return $curl_result;
}
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Credit Card Newsletter: Sign up to receive valuable information on your finances';
$metaKeywords = '';
$metaDescription = 'Sign up for our credit card newsletter and receive information on credit card deals, tips, and news.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
<link href="/css/cc-misc.css" rel="stylesheet">
	<script src="/javascript/contact_us.js"></script>
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
					<li>Rate Report Newsletter</li>
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

			<h1>CreditCards.com Rate Report Alert</h1>

			<p>For a weekly edition of the Credit Card Rate Report in your inbox, subscribe to the free CreditCards.com Rate Report Alert. Once a week, you will receive a report of average credit card rates in various categories.</p>

			<form class="form-horizontal" role="form" method="POST">
				<div class="form-group <?php if (isset($errors['fname'])) { echo $error_class; } ?>">
					<label for="fname" class="col-sm-4 control-label">First name*</label>
					<div class="col-sm-10">
						<input type="text" name="fname"  class="form-control" value="<?=$_REQUEST['fname']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['lname'])) { echo $error_class; } ?>">
					<label for="lname" class="col-sm-4 control-label">Last name*</label>
					<div class="col-sm-10">
						<input type="text" name="lname"  class="form-control" value="<?=$_REQUEST['lname']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Your e-mail address*</label>
					<div class="col-sm-10">
						<input type="text" name="email"  class="form-control" value="<?=$_REQUEST['email']?>">
						<p>You can see our <a href="/privacy.php#share">privacy policy</a> for the details, but here's the short version: If you sign up for the newsletter, that's all you'll get. This is a spam-free zone; we won't sell or rent out your address to anyone for any reason.</p>
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
					</div>
				</div>
			</form>

			<p>You may also be interested in our <a href="/newsletter.php">weekly newsletter</a>.</p>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'contact-us';
$pageName = 'contact-us:newsletter';
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
	$pageName = 'contact us:newsletter';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
