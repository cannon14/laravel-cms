<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '868';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$errors = array();
$error_class = 'has-error';
//validate form
if (isset($_REQUEST['validate'])) {
	if (!isset($_REQUEST['fname']) || $_REQUEST['fname'] == '') {
		$errors['fname'] = "Please specify first your name";
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
	if (!verifyCaptcha($_REQUEST)) {
		$errors['captcha'] = "Verification code does not match. Please re-enter.";
	}
	if (empty($errors)) {
		$_POST['name'] = $_REQUEST['fname'] . " " . $_REQUEST['lname'];
		$curlUrl = "http://www.creditcardsmail.com/ec/optin.php";
		$result = sendCurl($curlUrl);

		if ($result == '1') {
			$_POST['state'] = 'thankyou';

			$redirectURL = "newsletter-thankyou.php";
			header("Location: ".$redirectURL);
		} else {
			$_POST['state'] = 'preview';
			$_POST['send_error'] = "Error saving your email. Please try again later.";
			$errors['signUpError'] = "Error saving your email. Please try again later.";
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
					<li>Newsletter</li>
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

			<h1>CreditCards.com weekly newsletter</h1>

			<p style="margin-bottom: 2em;">
				For a weekly summary of the latest credit card news articles and expert tips, subscribe to the free CreditCards.com newsletter. Sign up now, and once a week, you will receive the best personal finance news from CreditCards.com's award-winning editorial team.
			</p>


			<div class="row" id="newsletter-form">
				<div class="col-md-10">
					<div class="newletter-img-hide">
						<img src="/images/envelope-transparent.png">
					</div>
				</div>
				<div class="col-md-12">
							<form class="form-horizontal" role="form" method="POST">
								<div class="form-group <?php if (isset($errors['fname'])) { echo $error_class; } ?>">
									<label for="fname" class="col-sm-6 control-label">First Name:</label>
									<div class="col-sm-18">
										<input type="text" name="fname"  class="form-control" value="<?=$_REQUEST['fname']?>">
									</div>
								</div>

								<div class="form-group <?php if (isset($errors['lname'])) { echo $error_class; } ?>">
									<label for="lname" class="col-sm-6 control-label">Last Name:</label>
									<div class="col-sm-18">
										<input type="text" name="lname"  class="form-control" value="<?=$_REQUEST['lname']?>">
									</div>
								</div>

								<div class="form-group <?php if (isset($errors['email'])) { echo $error_class; } ?>">
									<label for="email" class="col-sm-6 control-label">E-mail:</label>
									<div class="col-sm-18">
										<input type="text" name="email"  class="form-control" value="<?=$_REQUEST['email']?>">
										<p style="font-size: .8em;">You can see our <a href="/privacy.php#share">privacy policy</a> for the details, but here's the short version: If you sign up for the newsletter, that's all you'll get. This is a spam-free zone; we won't sell or rent out your address to anyone for any reason.</p>
									</div>
								</div>

								<div class="form-group <?php if (isset($errors['captcha'])) { echo $error_class; } ?>">
									<label for="captcha" class="col-sm-6 control-label">Verification Code:</label>
									<div class="col-sm-6">
										<input type="text" name="captcha_entry" class="form-control" id="" placeholder="">
									</div>
									<div class="col-sm-5">
										<img style="border:1px solid #A5ACB2" align="middle" src="/lib/captcha/captcha.php" class="captcha">
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-6 misce-btn">
										<input class="btn btn-primary btn-lg" type="submit" value="Submit">
										<input type="hidden" name="validate" value="1">
				                        <input type="hidden" name="campaign_id" value="100">
									</div>
									<div class="col-sm-5">
									</div>
								</div>
							</form>
				</div>
			</div>

			<!-- Newsletter Archive -->
			<div class="row">
				<h2>Newsletter archives</h2>
			</div>
			<div id="newsletter-archive">
				<div class="row">
				<div class="col-md-8">
					<h3>2015</h3>
					<hr>
					<ol class="months-list">
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#january-2015" aria-expanded="false" aria-controls="january-2015">January</h4>
							<ol class="month-archive collapse" id="january-2015">
								<li>
									<span class="date">Jan 29:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-29-2015.php">
										1099-C surprise: IRS tax follows canceled debt
									</a>
								</li>
								<li>
									<span class="date">Jan 22:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-22-2015.php">
										Financial infidelity poll: 6% hid bank account from partner
									</a>
								</li>


								<li>
									<span class="date">Jan 15:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-15-2015.php">
										2015 Balance Transfer Survey: Offers more generous, but move fast
									</a>
								</li>


								<li>
									<span class="date">Jan 8:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-08-2015.php">
										9 baby steps that lead to big financial goals
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#february-2015" aria-expanded="false" aria-controls="february-2015">February</h4>
							<ol class="month-archive collapse" id="february-2015">
								<li>
									<span class="date">Feb 5:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-5-2015.php">
										Keep thieves from stealing your tax return
									</a>
								</li>
								<li>
									<span class="date">Feb 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-12-2015.php">
										6 bad reasons to open a new credit card
									</a>
								</li>
								<li>
									<span class="date">Feb 19:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-19-2015.php">
										What to do if your new gift card shows a $0 balance
									</a>
								</li>
								<li>
									<span class="date">Feb 26:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-26-2015.php">
										7 times you might be liable for fraudulent charges
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#march-2015" aria-expanded="false" aria-controls="march-2015">March</h4>
							<ol class="month-archive collapse" id="march-2015">
							
								<li>
									<span class="date">Mar 5:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-5-2015.php">
										1099-C frequently asked questions
									</a>
								</li>
								<li>
									<span class="date">Mar 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-12-2015.php">
										Smartphone apps to help with taxes
									</a>
								</li>
								<li>
									<span class="date">Mar 19:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-19-2015.php">
										When complaints pay off
									</a>
								</li>
								<li>
									<span class="date">Mar 26:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-26-2015.php">
										7 debts you may not have to pay
									</a>
								</li>
								
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#april-2015" aria-expanded="false" aria-controls="april-2015">April</h4>
							<ol class="month-archive collapse" id="april-2015">
								<li>
									<span class="date">Apr 2:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-2-2015.php">
										Should you write 'See ID' on your card?
									</a>
								</li>
								<li>
									<span class="date">Apr 9:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-9-2015.php">
										6 credit-based conspiracy theories
									</a>
								</li>
								<li>
									<span class="date">Apr 16:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-16-2015.php">
										Poll: Right age to get a card? 22
									</a>
								</li>
								<li>
									<span class="date">Apr 23:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-23-2015.php">
										What to do if your credit card rate goes up
									</a>
								</li>
								<li>
									<span class="date">Apr 30:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-30-2015.php">
										HELOC vs. cash-out refinance for card debt repayment
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#may-2015" aria-expanded="false" aria-controls="may-2015">May</h4>
							<ol class="month-archive collapse" id="may-2015">
								<li>
									<span class="date">May 7:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-7-2015.php">
										Sorry, Mom: Poll says mothers losing financial influence
									</a>
								</li>
								<li>
									<span class="date">May 14:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-14-2015.php">
										Top story: How to shop (somewhat) anonymously
									</a>
								</li>
                                                                <li>
									<span class="date">May 21:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-21-2015.php">
										Top story: Yes, you can negotiate rewards cards' annual fees
									</a>
								</li>
                                                                <li>
									<span class="date">May 28:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-28-2015.php">
										Top story: Video: Tips for using mobile gift cards
									</a>
								</li>
							</ol>
						</li>
                        <li>
                                                        <h4 class="has-articles" data-toggle="collapse" href="#june-2015" aria-expanded="false" aria-controls="june-2015">June</h4>
                                                        <ol class="month-archive collapse" id="june-2015">
                                                                <li>
                                                                        <span class="date">June 4:</span>
                                                                        <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-4-2015.php">
                                                                            Top story: 6 debt consolidation traps &mdash; and how to avoid them
                                                                        </a>
                                                                </li>
                                                                <li>
                                                                    <span class="date">June 11:</span>
                                                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-11-2015.php">
                                                                        Top story: How to dispute a credit card purchase
                                                                    </a>
                                                                </li>
                                                                 <li>
                                                                    <span class="date">June 18:</span>
                                                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-18-2015.php">
                                                                        Top story: 11 credit card travel insurance benefits
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <span class="date">June 25:</span>
                                                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-25-2015.php">
                                                                        Top story: Are you living with an identity thief?
                                                                    </a>
                                                                </li>
                            </ol>
                        </li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#july-2015" aria-expanded="false" aria-controls="july-2015">July</h4>
                                                        <ol class="month-archive collapse" id="july-2015">
                                                                <li>
                                                                    <span class="date">July 2:</span>
                                                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-2-2015.php">
                                                                        Top story: Same sex marriages mean joint debt issues
                                                                    </a>
                                                                </li>
                                                                 <li>
                                                                    <span class="date">July 9:</span>
                                                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-9-2015.php">
                                                                        Top story: 6 things to know before buying identity-theft protection
                                                                    </a>
                                                                </li>
															<li>
																<span class="date">July 23:</span>
																<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-23-2015.php">
																	Cardless cash ATMs aim to reduce fraud
																</a>
															</li>
															<li>
																<span class="date">July 30:</span>
																<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-30-2015.php">
																	Cities with the biggest, smallest credit card debt burdens
																</a>
															</li>
							</ol>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#august-2015" aria-expanded="false" aria-controls="august-2015">August</h4>
							<ol class="month-archive collapse" id="august-2015">
								<li>
									<span class="date">August 6:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-6-2015.php">
										Top story: Identity theft packs an emotional toll
									</a>
								</li>
								<li>
									<span class="date">August 13:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-13-2015.php">
										Top story: How to manage different balances on one card
									</a>
								</li>
								<li>
									<span class="date">August 20:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-20-2015.php">
										Top story: If biometric IDs become the norm, will hackers try to steal your face?
									</a>
								</li>
								<li>
									<span class="date">August 27:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-27-2015.php">
										Top story: Fewer offers, better deals for student credit cards
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#september-2015" aria-expanded="false" aria-controls="september-2015">September</h4>
							<ol class="month-archive collapse" id="september-2015">
								<li>
									<span class="date">September 3:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-3-2015.php">
										Top story: Debt collection abuse goes both ways
									</a>
								</li>
								<li>
									<span class="date">September 10:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-10-2015.php">
										Top story: You did WHAT to pay off your debt?
									</a>
								</li>
								<li>
									<span class="date">September 17:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-17-2015.php">
										Top story: Poll: 32M adults have started holiday shopping
									</a>
								</li>
								<li>
									<span class="date">September 24:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-24-2015.php">
										Top story: Retailers roll out layaway plans early for 2015 holidays
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#october-2015" aria-expanded="false" aria-controls="october-2015">October</h4>
							<ol class="month-archive collapse" id="october-2015">
								<li>
									<span class="date">October 1:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-1-2015.php">
										Top story: Poll: Most cardholders lack smart-chip cards, despite deadline
									</a>
								</li>
								<li>
									<span class="date">October 8:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-8-2015.php">
										Top story: 5 things to do now to avoid holiday debt
									</a>
								</li>
								<li>
									<span class="date">October 15:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-15-2015.php">
										Top story: Luxury reward perks: What you get for paying that big annual fee
									</a>
								</li>
								<li>
									<span class="date">October 22:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-22-2015.php">
										Top story: Which cards are best for renting a car?
									</a>
								</li>
								<li>
									<span class="date">October 29:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-29-2015.php">
										Top story: Pint-sized super savers
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#november-2015" aria-expanded="false" aria-controls="november-2015">November</h4>
							<ol class="month-archive collapse" id="november-2015">
								<li>
									<span class="date">November 5:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-5-2015.php">
										Top story: Withholding a card payment is your right, but take care
									</a>
								</li>
								<li>
									<span class="date">November 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-12-2015.php">
										Combining cards: Rolling 2 credit limits into 1 card
									</a>
								</li>
                                <li>
                                    <span class="date">November 19:</span>
                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-19-2015.php">
                                        Top story: Rating fraud: All security breaches are not equal
                                    </a>
                                </li>
                                <li>
                                    <span class="date">November 26:</span>
                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-26-2015.php">
                                        Top Story: Best ways to earn, redeem rewards points over the holidays
                                    </a>
                                </li>
							</ol>
						</li>
						<li>
                            <h4 class="has-articles" data-toggle="collapse" href="#december-2015" aria-expanded="false" aria-controls="december-2015">December</h4>
                            <ol class="month-archive collapse" id="december-2015">
                                <li>
                                    <span class="date">December 3:</span>
                                    <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-3-2015.php">
                                        Top Story: Magnetic stripe begins its farewell tour
                                    </a>
                                </li>
	                            <li>
		                            <span class="date">December 10:</span>
		                            <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-10-2015.php">
			                            Top Story: 1 in 5 Americans say they'll be in debt forever
		                            </a>
	                            </li>
	                            <li>
		                            <span class="date">December 17:</span>
		                            <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-17-2015.php">
			                            Top Story: Card APRs rise &mdash; calculate your new costs
		                            </a>
	                            </li>
	                            <li>
		                            <span class="data">December 23:</span>
		                            <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-23-2015.php">
			                            Top Story: 15 fun, easy ways to wrap gift cards
		                            </a>
	                            </li>
							</ol>
						</li>
					</ol>
				</div>

				<div class="col-md-8">
					<h3>2014</h3>
					<hr>
					<ol class="months-list">
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#january-2014" aria-expanded="false" aria-controls="january-2014">January</h4>
							<ol class="month-archive collapse" id="january-2014">
								<li>
									<span class="date">Jan 30:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-30-2014.php">
										1099-C surprise: IRS tax follows canceled debts
									</a>
								</li>
								<li>
									<span class="date">Jan 23:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-23-2014.php">
										8 myths about settline credit card debt
									</a>
								</li>

								<li>
									<span class="date">Jan 16:</span>
						            <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-16-2014.php">
							            6 ways NOT to pay off card debt
							        </a>
								</li>

								<li>
									<span class="date">Jan 9:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-9-2014.php">
										The financial power of negative thinking
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#february-2014" aria-expanded="false" aria-controls="february-2014">February</h4>
							<ol class="month-archive collapse" id="february-2014">
								<li>
									<span class="date">Feb 27:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-6-2014.php">
										4 helpful tips when calling customer service
									</a>
								</li>

								<li>
									<span class="date">Feb 20:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-20-2014.php">
										Surprise! Your card may call in the repo man
									</a>
								</li>

						        <li>
							        <span class="date">Feb 13:</span>
							        <a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-13-2014.php">
							            8 savvy habits of high-volume card users
							        </a>
						        </li>

								<li>
									<span class="date">Feb 6:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-6-2014.php">
										6 exceptions for paying tax on forgiven debt
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#march-2014" aria-expanded="false" aria-controls="march-2014">March</h4>
							<ol class="month-archive collapse" id="march-2014">
								<li>
									<span class="date">Mar 27:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-27-2014.php">
										Pros, cons of paying taxes with plastic
									</a>
								</li>

								<li>
									<span class="date">Mar 20:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-20-2014.php">
										Who pays when kids rack up card charges?
									</a>
								</li>

								<li>
									<span class="date">Mar 13:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-13-2014.php">
										9 signs your spouse is a financial bully
									</a>
								</li>

								<li>
									<span class="date">Mar 6:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-6-2014.php">
										What happens to card debt after death?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#april-2014" aria-expanded="false" aria-controls="april-2014">April</h4>
							<ol class="month-archive collapse" id="april-2014">
								<li>
									<span class="date">Apr 24:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-24-2014.php">
										Cashless toll roads and rental cars: 6 tips
									</a>
								</li>

								<li>
									<span class="date">Apr 17:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-17-2014.php">
										YOLO: When is it OK to splurge?
									</a>
								</li>

								<li>
									<span class="date">Apr 10:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-10-2014.php">
										Beware! Forgiven debt can carry tax penalty
									</a>
								</li>

								<li>
									<span class="date">Apr 3:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-3-2014.php">
										Statutes of limitations for credit card debt
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#may-2014" aria-expanded="false" aria-controls="may-2014">May</h4>
							<ol class="month-archive collapse" id="may-2014">
								<li>
									<span class="date">May 29:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-29-2014.php">
										4 ways crooks cash in on your personal data
									</a>
								</li>

								<li>
									<span class="date">May 22:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-22-2014.php">
										CFPB: Credit scores for medical debt are unfair
									</a>
								</li>

								<li>
									<span class="date">May 15:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-15-2014.php">
										Rebuilding bad credit in 5 really slow steps
									</a>
								</li>

								<li>
									<span class="date">May 8:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-8-2014.php">
										Court judgments for debt: Your options after the gavel
									</a>
								</li>

								<li>
									<span class="date">May 1:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-1-2014.php">
										Debt rises by 5 percent in top 20 US cities
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#june-2014" aria-expanded="false" aria-controls="june-2014">June</h4>
							<ol class="month-archive collapse" id="june-2014">
								<li>
									<span class="date">Jun 26:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-26-2014.php">
										10 times NOT to use credit cards
									</a>
								</li>

								<li>
									<span class="date">Jun 19:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-19-2014.php">
										What's your 'real' FICO score? All of the above
									</a>
								</li>

								<li>
									<span class="date">Jun 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-12-2014.php">
										 Are schools putting your child's information at risk?
									</a>
								</li>

								<li>
									<span class="date">Jun 5:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-5-2014.php">
										Dragnet Nation' author: Can I have my privacy back?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#july-2014" aria-expanded="false" aria-controls="july-2014">July</h4>
							<ol class="month-archive collapse" id="july-2014">
								<li>
									<span class="date">Jul 31:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-31-2014.php">
										4 reasons college students need a credit card
									</a>
								</li>

								<li>
									<span class="date">Jul 24:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-24-2014.php">
										30 renowned restaurants that don't take credit cards
									</a>
								</li>

								<li>
									<span class="date">Jul 17:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-17-2014.php">
										Debt and divorce: 5 steps to make a clean credit split
									</a>
								</li>

								<li>
									<span class="date">Jul 10:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-10-2014.php">
										How to find your credit card security code
									</a>
								</li>

								<li>
									<span class="date">Jul 3:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-3-2014.php">
										Minimum card payments rising
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#august-2014" aria-expanded="false" aria-controls="august-2014">August</h4>
							<ol class="month-archive collapse" id="august-2014">
								<li>
									<span class="date">Aug 28:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-28-2014.php">
										Poll: Cash or card for $5 purchase?
									</a>
								</li>

								<li>
									<span class="date">Aug 21:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-21-2014.php">
										6 signs of bad financial advice
									</a>
								</li>

								<li>
									<span class="date">Aug 14:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-14-2014.php">
										8 ways to get friends to repay a personal loan
									</a>
								</li>

								<li>
									<span class="date">Aug 7:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-7-2014.php">
										Ready to pay rent with credit card?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#september-2014" aria-expanded="false" aria-controls="september-2014">September</h4>
							<ol class="month-archive collapse" id="september-2014">
								<li>
									<span class="date">Sep 25:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-25-2014.php">
										Poll: Asking for better credit card terms pays off
									</a>
								</li>

								<li>
									<span class="date">Sep 18:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-18-2014.php">
										How to avoid crushing student debt
									</a>
								</li>

								<li>
									<span class="date">Sep 11:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-11-2014.php">
										Average credit card debt: How do you stack up?
									</a>
								</li>

								<li>
									<span class="date">Sep 3:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-3-2014.php">
										Buying a car with a credit card often an uphill fight
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#october-2014" aria-expanded="false" aria-controls="october-2014">October</h4>
							<ol class="month-archive collapse" id="october-2014">
								<li>
									<span class="date">Oct 30:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-30-2014.php">
										EMV switch won't eliminate travel woes
									</a>
								</li>

								<li>
									<span class="date">Oct 23:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-23-2014.php">
										How credit cards impact your credit score
									</a>
								</li>

								<li>
									<span class="date">Oct 16:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-16-2014.php">
										Trip canceled? Your card may reimburse you
									</a>
								</li>

								<li>
									<span class="date">Oct 9:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-9-2014.php">
										One family's triumph over credit card debt
									</a>
								</li>

								<li>
									<span class="date">Oct 2:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-2-2014.php">
										30 percent utilization rule' is a myth
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#november-2014" aria-expanded="false" aria-controls="november-2014">November</h4>
							<ol class="month-archive collapse" id="november-2014">
								<li>
									<span class="date">Nov 25:</span>october
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-25-2014.php">
										Survey: 3 in 4 Americans make impulse purchases
									</a>
								</li>october

								<li>
									<span class="date">Nov 20:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-20-2014.php">
										Retailer beacons raise privacy issues
									</a>
								</li>

								<li>
									<span class="date">Nov 13:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-13-2014.php">
										Retailer beacons raise privacy issues
									</a>
								</li>

								<li>
									<span class="date">Nov 6:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-06-2014.php">
										Currency changes to aid blind slow to take shape
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#december-2014" aria-expanded="false" aria-controls="december-2014">December</h4>
							<ol class="month-archive collapse" id="december-2014">
								<li>
									<span class="date">Dec 31:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-31-2014.php">
										Mobile apps raise security, privacy issues
									</a>
								</li>

								<li>
									<span class="date">Dec 23:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-23-2014.php">
										Top retailers' return and receipt policies
									</a>
								</li>

								<li>
									<span class="date">Dec 18:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-18-2014.php">
										7 high-tech holiday scams
									</a>
								</li>

								<li>
									<span class="date">Dec 11:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-11-2014.php">
										Poll: More Americans expect to be in debt forever
									</a>
								</li>

								<li>
									<span class="date">Dec 4:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-04-2014.php">
										How much do banks make off credit card loans?
									</a>
								</li>
							</ol>
						</li>
					</ol>
				</div>

				<div class="col-md-8">
					<h3>2013</h3>
					<hr>
					<ol class="months-list">
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#january-2013" aria-expanded="false" aria-controls="january-2013">January</h4>
							<ol class="month-archive collapse" id="january-2013">
								<li>
									<span class="date">Jan 31:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-31-2013.php">
										1099-C surprise: IRS tax follows canceled debt
									</a>
								</li>

								<li>
									<span class="date">Jan 24:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-24-2013.php">
										5 credit lessons to teach your daughters
									</a>
								</li>

								<li>
									<span class="date">Jan 17:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-17-2013.php">
										Multiply rewards with prepaid/reload card shuffle
									</a>
								</li>

								<li>
									<span class="date">Jan 10:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-10-2013.php">
										7 factors that do NOT impact your credit score
									</a>
								</li>

								<li>
									<span class="date">Jan 3:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-january-3-2013.php">
										When does charging taxes, tuition make sense?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#february-2013" aria-expanded="false" aria-controls="february-2013">February</h4>
							<ol class="month-archive collapse" id="february-2013">
								<li>
									<span class="date">Feb 28:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-28-2013.php">
										Credit limit trick: Know 'snapshot' date
									</a>
								</li>

								<li>
									<span class="date">Feb 14:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-14-2013.php">
										11 options for filing tax returns for free
									</a>
								</li>

								<li>
									<span class="date">Feb 7:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-february-7-2013.php">
										Big credit counseling agencies pay salaries that match
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#march-2013" aria-expanded="false" aria-controls="march-2013">March</h4>
							<ol class="month-archive collapse" id="march-2013">
								<li>
									<span class="date">Mar 28:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-28-2013.php">
										11 hidden credit card perks
									</a>
								</li>

								<li>
									<span class="date">Mar 21:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-21-2013.php">
										Pros, cons of paying taxes with a credit card
									</a>
								</li>

								<li>
									<span class="date">Mar 14:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-14-2013.php">
										What to expect if sued for card debt
									</a>
								</li>

								<li>
									<span class="date">Mar 7:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-march-7-2013.php">
										Has your credit report been viewed illegally?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#april-2013" aria-expanded="false" aria-controls="april-2013">April</h4>
							<ol class="month-archive collapse" id="april-2013">
								<li>
									<span class="date">Apr 25:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-25-2013.php">
										Card application rejected? 3 steps to getting approved
									</a>
								</li>

								<li>
									<span class="date">Apr 18:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-18-2013.php">
										6 things that won't hurt your credit score
									</a>
								</li>

								<li>
									<span class="date">Apr 11:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-11-2013.php">
										10 things not to do when applying for a card
									</a>
								</li>

								<li>
									<span class="date">Apr 4:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-april-4-2013.php">
										Damaged credit: Can you sue?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#may-2013" aria-expanded="false" aria-controls="may-2013">May</h4>
							<ol class="month-archive collapse" id="may-2013">
								<li>
									<span class="date">May 23:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-23-2013.php">
										Shared accounts: Know the difference
									</a>
								</li>

								<li>
									<span class="date">May 16:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-16-2013.php">
										How to ask for a credit limit increase
									</a>
								</li>

								<li>
									<span class="date">May 9:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-9-2013.php">
										Pay late? Carry a balance? No problem
									</a>
								</li>

								<li>
									<span class="date">May 2:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-may-2-2013.php">
										Balance transfer card fees drop, add new twist
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#june-2013" aria-expanded="false" aria-controls="june-2013">June</h4>
							<ol class="month-archive collapse" id="june-2013">
								<li>
									<span class="date">Jun 27:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-27-2013.php">


										Attorneys bust 5 bankruptcy myths
									</a>
								</li>

								<li>
									<span class="date">Jun 20:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-20-2013.php">
										5 top excuses (and fixes) for paying bills late
									</a>
								</li>

								<li>
									<span class="date">Jun 13:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-13-2013.php">
										6 ways to protect credit after a natural disaster
									</a>
								</li>

								<li>
									<span class="date">Jun 6:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-june-6-2013.php">
										Same-sex marriage means joint custody of debt
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#july-2013" aria-expanded="false" aria-controls="july-2013">July</h4>
							<ol class="month-archive collapse" id="july-2013">
								<li>
									<span class="date">Jul 25:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-25-2013.php">
										Credit reports now show card bill-paying habits
									</a>
								</li>

								<li>
									<span class="date">Jul 18:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-18-2013.php">
										Cash crisis? How salary advances work
									</a>
								</li>

								<li>
									<span class="date">Jul 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-12-2013.php">
										What's the average credit card debt? Take your pick
									</a>
								</li>

								<li>
									<span class="date">Jul 4:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-july-4-2013.php">
										Using plastic to pay off student loans?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#august-2013" aria-expanded="false" aria-controls="august-2013">August</h4>
							<ol class="month-archive collapse" id="august-2013">
								<li>
									<span class="date">Aug 29:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-29-2013.php">
										Avoid paying interest on no-interest deals
									</a>
								</li>

								<li>
									<span class="date">Aug 22:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-22-2013.php">
										Card debt negotiation in 3 (not) easy steps
									</a>
								</li>

								<li>
									<span class="date">Aug 15:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-15-2013.php">
										How to dispute bogus credit report inquiries
									</a>
								</li>

								<li>
									<span class="date">Aug 8:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-8-2013.php">
										How 'mindfulness' can curb impulse spending
									</a>
								</li>

								<li>
									<span class="date">Aug 1:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-august-1-2013.php">
										Rules of the road for improving your credit mix
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#september-2013" aria-expanded="false" aria-controls="september-2013">September</h4>
							<ol class="month-archive collapse" id="september-2013">
								<li>
									<span class="date">Sep 26:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-26-2013.php">
										4 ways to build credit without a credit card
									</a>
								</li>

								<li>
									<span class="date">Sep 19:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-19-2013.php">
										Are squiggly finger signatures legally binding?
									</a>
								</li>

								<li>
									<span class="date">Sep 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-12-2013.php">
										9 debt myths debunked
									</a>
								</li>

								<li>
									<span class="date">Sep 5:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-september-5-2013.php">
										Is sharing your credit card ever OK?
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#october-2013" aria-expanded="false" aria-controls="october-2013">October</h4>
							<ol class="month-archive collapse" id="october-2013">
								<li>
									<span class="date">Oct 31:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-31-2013.php">
										3 ways to curb pre-holiday money stress
									</a>
								</li>

								<li>
									<span class="date">Oct 24:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-24-2013.php">
										Late payments: How high can fines, fees go?
									</a>
								</li>

								<li>
									<span class="date">Oct 17:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-17-2013.php">
										7 jobs that require great credit
									</a>
								</li>

								<li>
									<span class="date">Oct 10:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-10-2013.php">

										Couple repays $50,000 in debt despite hardships
									</a>
								</li>

								<li>
									<span class="date">Oct 3:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-3-2013.php">
										12 creepy things data brokers know about you
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#november-2013" aria-expanded="false" aria-controls="november-2013">November</h4>
							<ol class="month-archive collapse" id="november-2013">
								<li>
									<span class="date">Nov 27:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-27-2013.php">
										Gift card scammers skirt security with new tricks
									</a>
								</li>

								<li>
									<span class="date">Nov 21:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-21-2013.php">
										 How to ask for a credit limit increase
									</a>
								</li>

								<li>
									<span class="date">Nov 14:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-14-2013.php">
										10 places where you should not use a debit card
									</a>
								</li>

								<li>
									<span class="date">Nov 7:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-7-2013.php">
										10 things NOT to do when applying for a new credit card
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#december-2013" aria-expanded="false" aria-controls="december-2013">December</h4>
							<ol class="month-archive collapse" id="december-2013">
								<li>
									<span class="date">Dec 31:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-31-2013.php">
										Top retailers' return policies for items without receipts
									</a>
								</li>

								<li>
									<span class="date">Dec 26:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-26-2013.php">
										How to return, replace a lost or unwanted gift card
									</a>
								</li>

								<li>
									<span class="date">Dec 19:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-19-2013.php">
										 Charity gift cards: the gift that lets recipients give back
									</a>
								</li>

								<li>
									<span class="date">Dec 12:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-12-2013.php">
										Just how bad are credit card cash advances?
									</a>
								</li>

								<li>
									<span class="date">Dec 5:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-5-2013.php">
										Can retailers ask for ID with credit card purchases?
									</a>
								</li>
							</ol>
						</li>
					</ol>
				</div>

			</div>

				<div class="row">
				<div class="col-md-8">
					<h3>2012</h3>
					<hr>
					<ol class="months-list">
						<li>
							<h4 data-toggle="collapse" href="#january-2012" aria-expanded="false" aria-controls="january-2012">January</h4>
							<ol class="month-archive" id="january-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#february-2012" aria-expanded="false" aria-controls="february-2012">February</h4>
							<ol class="month-archive" id="february-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#march-2012" aria-expanded="false" aria-controls="march-2012">March</h4>
							<ol class="month-archive" id="march-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#april-2012" aria-expanded="false" aria-controls="april-2012">April</h4>
							<ol class="month-archive" id="april-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#may-2012" aria-expanded="false" aria-controls="may-2012">May</h4>
							<ol class="month-archive" id="may-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#june-2012" aria-expanded="false" aria-controls="june-2012">June</h4>
							<ol class="month-archive" id="june-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#july-2012" aria-expanded="false" aria-controls="july-2012">July</h4>
							<ol class="month-archive" id="july-2012">
							</ol>
						</li>
						<li>
							<h4 data-toggle="collapse" href="#august-2012" aria-expanded="false" aria-controls="august-2012">August</h4>
							<ol class="month-archive" id="august-2012">
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#september-2012" aria-expanded="false" aria-controls="september-2012">September</h4>
							<ol class="month-archive collapse" id="september-2012">
								<li>
									<span class="date">Sep 20:</span><br>
									<a href="/newsletter-archive/creditcards-weekly-newsletter-september-20-2012.php" target="_blank">
										Wisconsin credit scores outrank all others
									</a>
								</li>

								<li>
									<span class="date">Sep 13:</span><br>
									<a href="/newsletter-archive/creditcards-weekly-newsletter-september-13-2012.php" target="_blank">
										How to outtalk your inner spender
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#october-2012" aria-expanded="false" aria-controls="october-2012">October</h4>
							<ol class="month-archive collapse" id="october-2012">
								<li>
									<span class="date">Oct 26:</span><br>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-october-26-2012.php">
										Study: Heavy Facebook use linked to higher debt
									</a>
								</li>

								<li>
									<span class="date">Oct 19:</span><br>
									<a href="/newsletter-archive/creditcards-weekly-newsletter-october-19-2012.php" target="_blank">
										Disputing errors on credit reports: A broken process
									</a>
								</li>

								<li>
									<span class="date">Oct 12:</span><br>
									<a href="/newsletter-archive/creditcards-weekly-newsletter-october-12-2012.php" target="_blank">
										Celebrity fan sites fined for wooing kids to charge
									</a>
								</li>

								<li>
									<span class="date">Oct 5:</span>
									<a href="/newsletter-archive/creditcards-weekly-newsletter-october-5-2012.php" target="_blank">
										10 surefire ways to remove credit report errors
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#november-2012" aria-expanded="false" aria-controls="november-2012">November</h4>
							<ol class="month-archive collapse" id="november-2012">
								<li>
									<span class="date">Nov 30:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-30-2012.php">
										How high will your fiscal cliff be?
									</a>
								</li>

								<li>
									<span class="date">Nov 21:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-21-2012.php">
										Issuers roll out limited-time deals for holidays
									</a>
								</li>

								<li>
									<span class="date">Nov 16:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-16-2012.php">
										Welcome to the U.S.! Now show us your cards
									</a>
								</li>

								<li>
									<span class="date">Nov 9:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-9-2012.php">
										Election results strengthen consumer protections
									</a>
								</li>

								<li>
									<span class="date">Nov 2:</span><br>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-november-2-2012.php">
										5 ways not to goof up credit report disputes
									</a>
								</li>
							</ol>
						</li>
						<li>
							<h4 class="has-articles" data-toggle="collapse" href="#december-2012" aria-expanded="false" aria-controls="december-2012">December</h4>
							<ol class="month-archive collapse" id="december-2012">
								<li>
									<span class="date">Dec 14:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-14-2012.php">
										11 smartphone tips for holiday shopping
									</a>
								</li>


								<li>
									<span class="date">Dec 7:</span>
									<a target="_blank" href="/newsletter-archive/creditcards-weekly-newsletter-december-7-2012.php">
										Credit reports falsely flag some as terrorists
									</a>
								</li>
							</ol>
						</li>
					</ol>
				</div>
			</div>
			</div><!-- End of Newsletter Archive -->

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
