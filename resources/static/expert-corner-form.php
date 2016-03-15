<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1032';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/lib/recaptcha/recaptchalib.php');
$publicKey = RECAPTCHA_PUBLIC_KEY;

$errors = array();
$error_class = 'has-error';
//validate form
if(isset($_POST['validate'])) {
	if (isset($_POST['address']) && !empty($_POST['address'])) {
		$errors['main'] = "Unable to submit form";
	} else {
		if (!isset($_POST['NAME']) || $_POST['NAME'] == '') {
			$errors['name'] = "Please specify your name";
		}
		if (!preg_match('/^[A-Z, a-z, ]*$/', $_POST['NAME'])) {
			$errors['name'] = "Name must be alphabetic characters";
		}
		if (!isset($_POST['EXPERT']) || $_POST['EXPERT'] == '') {
			$errors['expert'] = "Please select an expert";
		}
		if (!isset($_POST['EMAIL']) || $_POST['EMAIL'] == '') {
			$errors['email'] = "Please specify your email address";
		}
		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $_POST['EMAIL'])) {
			$errors['email'] = "Email must be in the form yourname@yourdomain.com";
		}
		if (!isset($_POST['QUESTION']) || $_POST['QUESTION'] == '') {
			$errors['question'] = "Please enter a question";
		}
		if (!verifyCaptcha()) {
			$errors['captcha'] = "Verification code does not match. Please re-enter.";
		}
		if (empty($errors)) {
			include("expert_corner_form_script.php");
		}
	}
}

function verifyCaptcha() {
	$privateKey = RECAPTCHA_PRIVATE_KEY;
	$response = $_POST['recaptcha_response_field'] != '' ? $_POST['recaptcha_response_field'] : null;
	$result = recaptcha_check_answer(
		$privateKey,
		$_SERVER['REMOTE_ADDR'],
		$_POST['recaptcha_challenge_field'],
		$response
	);

	return $result->is_valid;
}
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = '';
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
					<li><a href="/expert-corner.php">Expert Corner</a> <i class="fa fa-angle-right"></i></li>
					<li>Ask an Expert</li>
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

			<h1>Ask our credit and debt experts a question</h1>

			<p>Need an answer to a personal finance question? CreditCards.com's Q&amp;A experts answer questions from readers. Use the form below to ask yours.</p>

			<br>

			<form class="form-horizontal" role="form" method="POST" name="[object]" id="ask_form">
				<div class="form-group <?php if (isset($errors['name'])) { echo $error_class; } ?>">
					<label for="name" class="col-sm-4 control-label">Your name*</label>
					<div class="col-sm-10">
						<input type="text" name="NAME"  class="form-control" value="<?=$_POST['NAME']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Your e-mail address*</label>
					<div class="col-sm-10">
						<input type="text" name="EMAIL"  class="form-control" value="<?=$_POST['EMAIL']?>">
						<p style="font-size: smaller">Your contact information will only be used to seek clarifications to your inquiry, if necessary.</p>
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['expert'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Which expert*</label>
					<div class="col-sm-10">
						<select name="EXPERT" class="form-control">
							<?php $selected = 'selected="selected"'; ?>
							<option value="">Select your expert</option>
							<option value="TM" <?php if($_POST['EXPERT'] == 'TM') { echo $selected; } ?>>Tony Mecia, Cashing In (rewards)</option>
							<option value="EP" <?php if($_POST['EXPERT'] == 'EP') { echo $selected; } ?>>Elaine Pofeldt, Your Business Credit</option>
							<option value="ES" <?php if($_POST['EXPERT'] == 'ES') { echo $selected; } ?>>Erica Sandberg, Opening Credit</option>
							<option value="KW" <?php if($_POST['EXPERT'] == 'KW') { echo $selected; } ?>>Kevin Weeks, Credit Wise</option>
							<option value="BP" <?php if($_POST['EXPERT'] == 'BP') { echo $selected; } ?>>Barry Paperno, Speaking of Credit</option>
							<option value="SH" <?php if($_POST['EXPERT'] == 'SH') { echo $selected; } ?>>Sally Herigstad, To Her Credit</option>
						</select>
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['question'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Your question*</label>
					<div class="col-sm-10">
						<textarea  class="form-control" name="QUESTION" rows="3"><?=$_POST['QUESTION']?></textarea>
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['captcha'])) { echo $error_class; } ?>">
					<br>
					<label for="" class="col-sm-4 control-label">Enter Verification Code*</label>
					<div class="col-sm-5">
						<? if($errors['captcha']) { echo '<span style="color:#F00">'.$errors['captcha'].'</span><br />'; } ?>
						<?= recaptcha_get_html($publicKey);?>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-5 misce-btn">
						<input class="btn btn-block btn-success btn-lg" type="submit" value="Submit">
						<input type="hidden" name="validate" value=1>
					</div>
					<div class="col-sm-5">
					</div>
				</div>

				<h3 class="experts">Our experts:</h3>

				<ul id="experts-list" class="list-inline">
					<li>
						<a href="/credit-card-news/new-frugal-you-stories.php">
							<span class="expert-name">Kevin Weeks</span><br>
							<img border="0" alt="Kevin Weeks" src="/images/experts-kevin-weeks.jpg"><br>
							<span class="expert-column">"Credit Wise"</span>
						</a>
					</li>

					<li>
						<a href="/credit-card-news/authors/sally-herigstad.php">
							<span class="expert-name">Sally Herigstad</span><br>
							<img border="0" alt="Sally Herigstad" src="/images/expert-herigstad.jpg"><br>
							<span class="expert-column">"To Her Credit"</span>
						</a>
					</li>

					<li>
						<a href="/credit-card-news/authors/tony-mecia.php">
							<span class="expert-name">Tony Mecia</span><br>
							<img border="0" alt="Tony Mecia" src="/images/columnist-tony-mecia.jpg"><br>
							<span class="expert-column">"Cashing In"</span>
						</a>
					</li>

					<li>
						<a href="/credit-card-news/authors/barry-paperno.php">
							<span class="expert-name">Barry Paperno</span><br>
							<img border="0" alt="Barry Paperno" src="/images/columnist-barry-paperno.jpg"><br>
							<span class="expert-column">"Speaking of Credit"</span>
						</a>
					</li>

					<li>
						<a href="/credit-card-news/authors/elaine-pofeldt.php">
							<span class="expert-name">Elaine Pofeldt</span><br>
							<img border="0" alt="Elaine Pofeldt" src="/images/elaine-pofeldt.jpg"><br>
							<span class="expert-column">"Your Business Credit"</span>
						</a>
					</li>

					<li>
						<a href="/credit-card-news/authors/erica-sandberg.php">
							<span class="expert-name">Erica Sandberg</span><br>
							<img border="0" alt="Erica Sandberg" src="/images/expert-sandberg.jpg"><br>
							<span class="expert-column">"Opening Credits"</span>
						</a>
					</li>
				</ul>
			</form>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'news';
$pageName = 'news:expert-corner:form';
$analyticsServer = '';
$pageType = '';
$prop1 = 'news';
$prop2 = 'news:expert-corner';
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
