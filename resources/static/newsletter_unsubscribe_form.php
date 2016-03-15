<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '868';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$errors = array();
$error_class = 'has-error';
//validate form
if(isset($_REQUEST['validate'])) {
	if(!isset($_REQUEST['ooemail']) || $_REQUEST['ooemail'] == '') {
		$errors['email'] = "Please specify your email address";
	}
	if(!preg_match('/^[A-Za-z0-9._%-]*@([A-Za-z0-9-]*\.)*[A-Z a-z]{2,4}$/', $_REQUEST['ooemail'])) {
		$errors['email'] = "Email must be in the form yourname@yourdomain.com";
	}
	if(empty($errors)) {
		$curlUrl = "http://www.creditcardsmail.com/ec/optout.php";
		$result = sendCurl($curlUrl);
		
		if ($result == '1') {
			$_POST['state'] = 'thankyou';
			
			$redirectURL = "newsletter-unsubscribe-thankyou.php";
			header("Location: ".$redirectURL);
		} else {
			$_POST['state'] = 'preview';
			
			$_POST['send_error'] = "Error saving your email. Please try again later.";
		}
	}	
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

$htmlTitle = '';
$metaKeywords = '';
$metaDescription = '';

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

			<h1>Newsletter Optout</h1>

			<p>Please provide your email address if you would like to opt out of future newsletters from CreditCards.com.</p>

			<form class="form-horizontal" role="form" method="POST">
				<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
					<label for="email" class="col-sm-4 control-label">E-mail address</label>
					<div class="col-sm-10">
						<input type="text" name="ooemail"  class="form-control" value="<?=$_REQUEST['ooemail']?>">
					</div>
					<div class="col-sm-5 misce-btn">
						<input class="btn btn-primary btn-lg" type="submit" value="Submit">
						<input type="hidden" name="validate" value="1">
					</div>
				</div>
			</form>

			<hr id="newletter-pages-divider">

			<div id="credit-card-search-categories"><!-- Credit Card Search Categories -->

				<h2><strong>Interested in a credit card offer? Find the card that's right for you</strong></h2>

				<div class="col-md-12">
					<h3>Credit Card Search Categories</h3>

					<div class="row">
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-bar-chart fa-lg" style="color:#156abd;"></i>
									Rates & Fees
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/balance-transfer.php">Balance Transfer</a></li>
										<li><a href="/0-apr-credit-cards.php">0% APR</a></li>
										<li><a href="/low-interest.php">Low Interest cards</a></li>
										<li><a href="/no-annual-fee.php">No Annual Fee</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-gift fa-lg" style="color:#156abd;"></i> Earn
									Rewards
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/cash-back.php">Cash Back Cards</a></li>
										<li><a href="/reward.php">Rewards Credit Cards</a></li>
										<li><a href="/points-rewards.php">Points Cards</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-plane fa-lg" style="color:#156abd;"></i> Travel
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/airline-miles.php">Airline Credit Cards</a></li>
										<li><a href="/no-foreign-transaction-fee.php">No Foreign Transaction</a></li>
										<li><a href="/gas-cards.php">Gas Credit Cards</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-tachometer fa-lg" style="color:#156abd;"></i>
									Credit Quality
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/excellent-credit.php">Excellent Credit</a></li>
										<li><a href="/good-credit.php">Good Credit</a></li>
										<li><a href="/fair-credit.php">Fair Credit</a></li>
										<li><a href="/bad-credit.php">Bad Credit</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-credit-card fa-lg" style="color:#156abd;"></i>
									Card Type
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a href="/top-credit-cards.php">Top Credit Cards</a></li>
										<li><a href="/business.php">Business</a></li>
										<li><a href="/college-students.php">Student Cards</a></li>
										<li><a href="/prepaid.php">Prepaid / Debit</a></li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-24 col-sm-8 col-md-8">
							<div class="panel panel-simple">
								<div class="panel-heading"><i class="fa fa-wrench fa-lg" style="color:#156abd;"></i> Tools
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
										<li><a target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form">CardMATCH &#8482;</a></li>
										<li><a target="_blank" href="https://walletup.creditcards.com/app">WalletUp&reg;</a></li>
										<li><a href="/best-credit-cards.php">Best Credit Cards</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- End of Credit Card Search Categories -->

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'contact-us';
$pageName = $channel.':newsletter:unsubscribe';
$analyticsServer = '';
$pageType = '';
$prop1 = 'contact us:newsletter';
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
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

</body>
</html>
