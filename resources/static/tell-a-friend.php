<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1333';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$curlUrl = "http://74.55.184.58/tellafriend.php";
$email_subject = "Check out this site for Credit Cards";
$errors = array();
$error_class = 'has-error';
// validate form
if ($_POST['validate'] == '1') {
	if (!isset($_POST['name']) || ($_POST['name'] == "")) {
		$errors['name'] = "Please specify your name";
	}
	if (!preg_match('/^[A-Z, a-z, ]*$/',$_POST['NAME'])) {
		$errors['name'] = "Name must be alphabetic characters";
	}
	if (!isset($_POST['email']) || $_POST['email'] == '') {
		$errors['email'] = "Please specify your email address";
	}
	if (!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_POST['email'])) {
		$errors['email'] = "Email must be in the form yourname@yourdomain.com";
	}
	if (!isset($_POST['friend1']) || $_POST['friend1'] == '') {
		$errors['friend1'] = "Please enter the email address of at least one friend.";
	}
	if (!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_POST['friend1'])) {
		$errors['friend1'] = "Email must be in the form yourname@yourdomain.com. Please retype the first friends email.";
	}
	if ($_POST['friend2'] != '' && !preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_POST['friend2'])) {
		$errors['friend2'] = "Email must be in the form yourname@yourdomain.com. Please retype the second friends email.";
	}
	if ($_POST['friend3'] != '' && !preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_POST['friend3'])) {
		$errors['friend3'] = "Email must be in the form yourname@yourdomain.com. Please retype the third friends email.";
	}
	if (!verifyCaptcha($_POST)) {
		$errors['captcha'] = "Verification code does not match. Please re-enter.";
	}
	
	// if no error, send curl request
	if (empty($errors)) {
		//build html msg content based on user inputs
		$html_message = buildHtmlMessage();
		
		//set and encode vars
		//$_POST['personal_message'] = $_POST['personal_message'];
		$_POST['email_subject'] = $email_subject;
		$_POST['email_message'] = $html_message;
		
		$_POST['state'] = isset($_POST['send']) ? $_POST['state'] = 'send' : $_POST['state'] = 'preview';
	}
}

if ($_POST['state'] == 'send') {
	$result = sendCurl($curlUrl);
	
	if ($result == '1') {
		$_POST['state'] = 'thankyou';
	} else {
		$_POST['state'] = 'preview';
		$_POST['send_error'] = "Error sending your email. Please try again later.";
	}
}


function buildHtmlMessage() {
	$html_message = "";
	
	if ($_POST['personal_message'] != "") {
		//strip out email addresses
		$pattern = '@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,5})';
		$pm = eregi_replace($pattern, "@...", $_POST['personal_message']);
		
		//strip our URLs
		$pattern2 = '(https?|ftp|file)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]';
		$pm = eregi_replace($pattern2, "http://...", $pm);
		
		
		$html_message .= '<b>Personal message:</b><br />' . $pm . '<br /><br /><hr color="#cccccc" size="1" noshade />';
	}
	
	$html_message .= '<br /><br />I thought you would be interested in this website - CreditCards.com is a free online resource where you can compare hundreds of credit card offers.<br /><br /><a target="_blank" href="http://www.creditcards.com/?aid=feff29f4">http://www.CreditCards.com</a>';
		
	if (isset($_POST['add_link_finder'])) {
		$html_message .= '<br /><br />Search, compare and apply for credit cards:<br /><a target="_blank" href="http://www.creditcards.com/credit-card-finder/?aid=feff29f4">http://www.creditcards.com/credit-card-finder/</a>';
	}
	if (isset($_POST['add_link_calculators'])) {
		$html_message .= '<br /><br />Credit card calculators:<br /><a target="_blank" href="http://www.creditcards.com/calculators/?aid=feff29f4">http://www.creditcards.com/calculators/</a>';
	}
	if (isset($_POST['add_link_news'])) {
		$html_message .= '<br /><br />Credit cards news and advice:<br /><a target="_blank" href="http://www.creditcards.com/credit-card-news.php?aid=feff29f4">http://www.creditcards.com/credit-card-news.php</a>';
	}
	
	$html_message .= '<br /><br /><hr color="#cccccc" size="1" noshade />Note: This link was sent to you by using the "Tell-a-Friend" form on CreditCards.com. If you believe you have received this email in error and wish to report abuse, please send an email to <a href="mailto:privacy@creditcards.com&subject=Tell-a-Friend Abuse">privacy@creditcards.com</a>.';
	
	$html_message .= '<br /><br />';
	
	return $html_message;
}


function verifyCaptcha($params) {
	$captchaText = $_SESSION['CAPTCHAString'];
	$userEntry = $params['captcha_entry'];

	return $userEntry == $captchaText;
}


function sendCurl($curlUrl) {
	$_POST['machine_ip'] = $_SERVER['SERVER_ADDR'];
	$_POST['security_string'] = 'ccc0m' . date('Ymd') . 't3llafr13nd';
	
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

$htmlTitle = 'Tell a Friend About CreditCards.com';
$metaKeywords = 'Tell a friend, CreditCards.com, credit cards';
$metaDescription = 'CreditCards.com is a resource for consumers looking to apply for a credit card online.  Visitors can search our directory of credit cards by company or category. Tell someone you know about CreditCards.com.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
<link href="/css/cc-misc.css" rel="stylesheet">
	<script>
	<!--
		function textCounter( field ) {
			var maxLimit = 255;

			if ( field.value.length > maxLimit ) {
				field.value = field.value.substring( 0, maxLimit );
				return false;
			}
		}
	//-->
	</script>
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
					<li>Tell a Friend</li>
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

			<h1>Tell a Friend</h1>

			<p>Inform a friend about CreditCards.com. Fill out the form below, and we'll send an email to your friend(s) letting them know about us.</p>

			<p>Note: Email addresses you provide will only be used for the purposes of sending this email. See our <a href="/privacy.php">Privacy Policy</a>.</p>

			<br>

			<form class="form-horizontal" role="form" method="POST">
				<div class="form-group <?php if (isset($errors['name'])) { echo $error_class; } ?>">
					<label for="name" class="col-sm-4 control-label">Your name*</label>
					<div class="col-sm-10">
						<input type="text" name="name"  class="form-control" value="<?=$_POST['name']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">Your e-mail address*</label>
					<div class="col-sm-10">
						<input type="text" name="email"  class="form-control" value="<?=$_POST['email']?>">
					</div>
				</div>
				
				<div class="form-group <?php if (isset($errors['friend1'])) { echo $error_class; } ?>">
					<label for="friend1-email" class="col-sm-4 control-label">1) Friends e-mail Address*</label>
					<div class="col-sm-10">
						<input type="text" name="friend1"  class="form-control" value="<?=$_POST['friend1']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['friend2'])) { echo $error_class; } ?>">
					<label for="friend2-email" class="col-sm-4 control-label">2) Friends e-mail Address</label>
					<div class="col-sm-10">
						<input type="text" name="friend2"  class="form-control" value="<?=$_POST['friend2']?>">
					</div>
				</div>

				<div class="form-group <?php if (isset($errors['friend3'])) { echo $error_class; } ?>">
					<label for="friend3-email" class="col-sm-4 control-label">3) Friends e-mail Address</label>
					<div class="col-sm-10">
						<input type="text" name="friend3"  class="form-control" value="<?=$_POST['friend3']?>">
					</div>
				</div>

				<div class="form-group">
					<label for="recipient-email" class="col-sm-4 control-label">Additional links to include:</label>
					<div class="col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" name="add_link_finder" value="1" <?=($_POST['add_link_finder'] == 1 ? 'checked' : '') ?>> Credit Card Finder
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="add_link_calculators" value="1" <?=($_POST['add_link_calculators'] == 1 ? 'checked' : '') ?>> Credit Card Calculators
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="add_link_news" value="1" <?=($_POST['add_link_news'] == 1 ? 'checked' : '') ?>> Credit Card News &amp; Advice
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-14">
						<label for="comments" class="control-label">Personal message (optional):</label>
						<textarea class="form-control" name="personal_message" rows="3"><?= $_POST['personal_message'] ?></textarea>
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

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:tell-a-friend';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'Tell A Friend';
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
