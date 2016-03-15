<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '873';
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
	if (!isset($_REQUEST['PUBLICCOMMENTS']) || $_REQUEST['PUBLICCOMMENTS'] == '') {
		$errors['comments'] = 'Please provide a description of business opportunity you wish to discuss.';
	}
	if (!verifyCaptcha($_REQUEST)) {
		$errors['captcha'] = 'Verification text does not match. Please re-enter.';
	}

	if (empty($errors)) {
		include("public_relations_script.php");
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

$htmlTitle = 'Credit Card Info: Media Relations at CreditCards.com';
$metaKeywords = 'media contact, credit card experts, credit card interviews';
$metaDescription = 'Seeking to republish the credit card info on our site?  Contact our media representative.';

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
					<li>Media Contact</li>
				</ol>
				<ol class="breadcrumb">
					<li><a href="/about-us/media-center.php">Media Center</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/about-us/press-releases.php">Press Releases</a></li>
					<li class="active"><i class="fa fa-envelope-o"></i> Media Contact</li>
				</ol>
				</div>

			<h1>Media Contact</h1>

			<p>Working on a story? Our seasoned team of <a href="/about-us/credit-card-experts.php">journalist and experts</a> are available to support you with facts and quotes on a variety of topics.</p>
			<ul>
				<li>Cards and Payments</li>
				<li>Credit and Debt</li>
				<li>Loyalty and Rewards</li>
				<li>Budgeting and Shopping</li>
				<li>Small business finance</li>
			</ul>
			<p>Check out some of our <a href="/media-recap/">recent interviews and mentions.</a></p>
			<p>To get in touch, complete the inquiry form below and we'll be quick to contact you.</p>
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

				<br>

				<form class="form-horizontal col-sm-16" role="form" method="post">

				<div class="form-group <?php if (isset($errors['name'])) { echo $error_class; } ?>">
					<label for="name" class="col-sm-6 control-label">Name*</label>
					<div class="col-sm-18">
						<input type="text" name="NAME" class="form-control" id="" value="<?= $_REQUEST['NAME'] ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="organization" class="col-sm-6 control-label">Media Organization</label>
					<div class="col-sm-18">
						<input type="text" name="ORGANIZATION" class="form-control" id="" value="<?= $_REQUEST['ORGANIZATION'] ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="phone" class="col-sm-6 control-label">Phone number</label>
					<div class="col-sm-18">
						<input type="tel" name="PHONE" class="form-control" id="" value="<?= $_REQUEST['PHONE'] ?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-6 control-label">Email address*</label>
					<div class="col-sm-18">
						<input type="email" name="EMAIL" class="form-control" id="" value="<?= $_REQUEST['EMAIL'] ?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['comments'])) { echo $error_class; } ?>">
					<div class="col-sm-24">
						<label for="comments" class="control-label">Briefly describe the topic of your inquiry and any deadline you're working under*</label>
						<textarea class="form-control" name="PUBLICCOMMENTS" rows="3"><?= $_REQUEST['PUBLICCOMMENTS'] ?></textarea>
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['captcha'])) { echo $error_class; } ?>">
					<label for="" class="col-sm-4 control-label">Enter Verification Code*</label>
					<div class="col-sm-3">
						<input type="text" name="captcha_entry" class="form-control" id="" placeholder="">
					</div>
					<div class="col-sm-5">
						<img style="border:1px solid #A5ACB2" align="middle" src="/lib/captcha/captcha.php">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-5 misce-btn">
						<input class="btn btn-green btn-lg" type="submit" value="Submit">
						<input type="hidden" name="validate" value=1>
					</div>
					<div class="col-sm-5">
					</div>
				</div>
			</form>
			<div class="row col-sm-7">
				<img class="only-desktop" src="/images/media-contact-logos.png" alt="Media Contact" />
			</div>
			<br>
		</div>
	</div>

	<?php

	echo '<img src="'.$GLOBALS['RootPath'].'sb.php?a_aid='.$_SESSION['aid'].'&a_bid='.$_SESSION['hid'].'" width=1 height=1 style="border: 0;">';
	echo '<img src="'.$GLOBALS['RootPath'].'xtrack.php?'.$_SERVER['QUERY_STRING'].'" width=1 height=1 style="border: 0;">';
	?>
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
