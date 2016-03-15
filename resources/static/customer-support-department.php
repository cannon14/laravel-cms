<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '920';
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
	if (!isset($_REQUEST['COMMENTS']) || $_REQUEST['COMMENTS'] == '') {
		$errors['comments'] = 'Please enter your question or comment.';
	}
	if (!verifyCaptcha($_REQUEST)) {
		$errors['captcha'] = 'Verification text does not match. Please re-enter.';
	}

	if (empty($errors)) {
		require_once('customer_support_department_script.php');
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
					<li>Customer Support</li>
		        </ol>
			</div>

			<h1 style="font-weight:bold;">Customer Support Department</h1>

			<p>Thank you for visiting the CreditCards.com Customer Support Department. Please review the information outlined below, which provides answers to commonly asked questions.</p>
                
			<h2 style="font-weight:bold;">Existing Credit</h2>

			<p>Card Accounts Questions regarding payments, disputes, billing, interest rates, lost/stolen cards, suspected fraud or any other topic related to an existing credit card account should be directed to the <a href="http://www.creditcards.com/bank-partner-contact-information.php">credit card issuer</a>. You can also reach your card issuer's customer service department by calling the toll free number listed on the reverse side of your credit card.</p>
				
			<h2 style="font-weight:bold;">Application Status</h2>

			<p>The <a href="http://www.creditcards.com/bank-partner-contact-information.php">issuer</a> for the card you selected determines whether a credit card application gets approved or denied. Response time generally depends on the applicant's credit history. Banks are required to provide written notification of both approvals and denials.</p>

			<p>Once you are approved, delivery of the credit card may take several weeks. Contact the <a href="/bank-partner-contact-information.php">card issuer</a> for more information.</p>

			<h2 style="font-weight:bold;">Credit Card Terms and Conditions</h2> 
			<p>To learn more about any credit card featured on this site, click on the card's "apply here" button. This does not obligate you to apply, but simply redirects you to the card issuer's web site, where you will find specific information on the card's terms and conditions.</p>

			<h2 style="font-weight:bold;">Credit Quality and Bad Credit</h2>
			<p>Banks determine an individual's credit quality based on that applicant's credit score.</p>

			<p>You should use your best judgment in determining your credit quality, based on your individual credit history and credit score. You can get an estimate of your credit score by using the CreditCards.com <a href="/credit-score-estimator/">credit score estimator</a>.</p>

			<p>Consumers with bad credit still have options when it comes to applying for a card. CreditCards.com features a number of products for individuals looking to establish, repair or rebuild their credit at <a href="http://www.creditcards.com/bad-credit.php">http://www.creditcards.com/bad-credit.php</a>.</p>

			<h2 style="font-weight:bold;">Credit Card Recommendations</h2>

			<p>As an objective source of information, we cannot provide individual credit card recommendations. Our goal is to empower consumers in their decision-making process by providing information and tools, including <a href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=csfeedback&utm_campaign=walletup" target="_blank">WalletUp&reg;</a> - a tool that helps consumers maximize their rewards.</p>

			<h2 style="font-weight:bold;">Credit Reports</h2>
			<p>Incorrect items on your credit report should be directed to the <a href="http://www.creditcards.com/bank-partner-contact-information.php">card issuer</a>. Other questions related to credit scores, credit report orders, contents of recent credit reports, and suspected fraud or identity theft should be directed to one of the three major credit bureaus listed below:</p>

			<p><b>Equifax</b>, P.O. Box 740241, Atlanta, GA 30374-0241; (800) 685-1111.<br><a href="http://www.equifax.com" target="_blank">http://www.equifax.com</a></p>

			<p><b>Experian</b>, P.O. Box 2002, Allen, TX 75013; (888) EXPERIAN (397-3742).<br><a href="http://www.experian.com" target="_blank">http://www.experian.com</a></p>

			<p><b>TransUnion</b>, P.O. Box 1000, Chester, PA 19022; (800) 916-8800.<br><a href="http://www.transunion.com" target="_blank">http://www.transunion.com</a></p>

			<br>

			<h2 style="font-weight:bold;">Online Application Privacy and Security</h2>

			<p>We only partner with card issuers whose online credit application forms are secured by 128-bit SSL encryption. SSL technology encodes information as it is being sent over the Internet, helping to ensure that the information transmitted remains confidential. Please review our <a href="http://www.creditcards.com/SSL-Security.php">Site Security Policy</a>.</p>

			<p><b>We do not require you to create an account or share any personally identifiable information in order to use our site.</b> When you choose to apply for a credit card offer presented at CreditCards.com, you are taken directly to the credit card issuer's website and you provide your information directly to the issuer. For more information, review our <a href="http://www.creditcards.com/privacy.php">Privacy Policy</a>.</p>

			<p><b>We do not currently offer applications by mail or phone.</b></p>
				
			<h2 style="font-weight:bold;">Information For Application</h2>

			<p>Credit card applicants will need to provide basic personal information, such as social security number, driver's license number, date of birth, and home address. Primary applicants must be at least 18 years of age.</p>

			<p><a href="http://www.creditcards.com/prepaid.php">Prepaid cards</a> may require less information on their application forms.</p>
				
			<h2 style="font-weight:bold;">Citizenship Requirement</h2>

			<p>All credit card offers featured on our site require applicants to be citizens of the United States and must reside within this country.</p>

			<h2 style="font-weight:bold;">Where to find us</h2>

			<p>For the physical addresses, phone numbers and maps to our Austin and Palm Beach Gardens locations, go to our <a href="/where-to-find-us.php">CreditCards.com Office Locations page.</a></p>
            
            <br>
         
			<p>Still have questions? <a id="show-customer-support-form">Contact Customer Support.</a></p>

			<br>

			<div id="form-items" <?php if (empty($errors)) { echo 'style="display: none;"'; } ?>>
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

					<div class="form-group <?php if (isset($errors['comments'])) { echo $error_class; } ?>">
						<br>
						<div class="col-sm-14">
							<label for="comments" class="control-label">Enter your question or comment*</label>
							<textarea class="form-control" name="COMMENTS" rows="3"><?= $_REQUEST['COMMENTS'] ?></textarea>
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
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'contact-us';
$pageName = $channel.':customer-support';
$analyticsServer = '';
$pageType = '';
$prop1 = '';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = 'customer support contact form';
$prop7 = '';
$prop8 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = '';
$analyticsProducts = '';
$purchaseId = '';
$eVar1 = '';
$eVar2 = 'send email';
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
	$pageName = 'customer support';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

<script>
$(document).ready(function () {
	$('#show-customer-support-form').click(function (){
		$('#form-items').slideToggle();
	});
});
</script>

</body>
</html>
