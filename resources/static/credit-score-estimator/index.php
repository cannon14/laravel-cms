<?php 

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1392';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

$errors = array();
$error_class = 'has-error';
// validate form
if (isset($_REQUEST['validate'])) {
	if (!isset($_REQUEST['answer-01']) || $_REQUEST['answer-01'] == '') {
		$errors['answer-01'] = true;
	}
	if (isset($_REQUEST['answer-01']) && $_REQUEST['answer-01'] != '' && $_REQUEST['answer-01'] != 'A') {
		if (!isset($_REQUEST['answer-01-follow-up']) || $_REQUEST['answer-01-follow-up'] == '') {
			$errors['answer-01-follow-up'] = true;
		}
		
	}
	if (!isset($_REQUEST['answer-02']) || $_REQUEST['answer-02'] == '') {
		$errors['answer-02'] = true;
	}
	if (!isset($_REQUEST['answer-03']) || $_REQUEST['answer-03'] == '') {
		$errors['answer-03'] = true;
	}
	if (!isset($_REQUEST['answer-04']) || $_REQUEST['answer-04'] == '') {
		$errors['answer-04'] = true;
	}
	if (!isset($_REQUEST['answer-05']) || $_REQUEST['answer-05'] == '') {
		$errors['answer-05'] = true;
	}
	if (!isset($_REQUEST['answer-06']) || $_REQUEST['answer-06'] == '') {
		$errors['answer-06'] = true;
	}
	if (!isset($_REQUEST['answer-07']) || $_REQUEST['answer-07'] == '') {
		$errors['answer-07'] = true;
	}
	if (isset($_REQUEST['answer-07']) && $_REQUEST['answer-07'] != '' && $_REQUEST['answer-07'] != 'A') {
		if (!isset($_REQUEST['answer-07-follow-up']) || $_REQUEST['answer-07-follow-up'] == '') {
			$errors['answer-07-follow-up'] = true;
		}
		
	}
	if (!isset($_REQUEST['answer-08']) || $_REQUEST['answer-08'] == '') {
		$errors['answer-08'] = true;
	}
	if (isset($_REQUEST['answer-08']) && $_REQUEST['answer-08'] != '' && $_REQUEST['answer-08'] != 'A') {
		if (!isset($_REQUEST['answer-08-follow-up']) || $_REQUEST['answer-08-follow-up'] == '') {
			$errors['answer-08-follow-up'] = true;
		}
		
	}
	if (!isset($_REQUEST['answer-09']) || $_REQUEST['answer-09'] == '') {
		$errors['answer-09'] = true;
	}
	if (!isset($_REQUEST['answer-10']) || $_REQUEST['answer-10'] == '') {
		$errors['answer-10'] = true;
	}

	if (empty($errors)) {
		header('Location: /credit-score-estimator/estimate.php?'.$_SERVER['QUERY_STRING']);
	}
}
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Free Credit Score Estimator: Get your free credit score estimated at CreditCards.com';
$metaKeywords = 'credit score estimator, credit score';
$metaDescription = 'Answer questions about your current financial status to view a free estimate of your credit score range';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link rel="stylesheet" href="/css/cc-misc.css">
<script type="text/javascript" src="/javascript/swfobject.js"></script>
</head>
<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<div class="other-block">
	<div class="container">
		<div class="row">
		  <div class="col-md-20">
		
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/credit-card-tools/">Tools</a> <i class="fa fa-angle-right"></i></li>
					<li>Credit Score Estimator</li>
				</ol>
			</div>

			<br>

              <div style="margin: 0 auto; display: block; width: 728px;">
                  <script type="text/javascript">if (!window.AdButler){(function(){var s = document.createElement("script"); s.async = true; s.type = "text/javascript";s.src = 'http://ab166629.adbutler-chargino.com/app.js';var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(s, n);}());}</script>
                  <script type="text/javascript">
                      var AdButler = AdButler || {}; AdButler.ads = AdButler.ads || [];
                      var abkw = window.abkw || '';
                      var plc187055 = window.plc187055 || 0;
                      document.write('<'+'div id="placement_187055_'+plc187055+'"></'+'div>');
                      AdButler.ads.push({handler: function(opt){ AdButler.register(166629, 187055, [728,90], 'placement_187055_'+opt.place, opt); }, opt: { place: plc187055++, keywords: abkw, domain: 'ab166629.adbutler-chargino.com' }});
                  </script>
                  <div style="text-align: right; color: #313131; font-size: 10px;">ADVERTISEMENT</div>
              </div>

              <br>

			<div class="row">
				<div class="col-sm-10 col-md-10 col-lg-8"> 
					<div class="cse-meter">
					<img src="/images/question.gif" width="300" height="150" /></div>
				</div>
				<div class="col-sm-14 col-md-14 col-lg-16">
					<h1>Estimate your Credit Score for FREE</h1>
					<p>Answer the questions below to view your estimated credit score range. Instantly see your results as well as tips on how to improve your credit score. Find a list of credit cards that match your estimated credit score.</p>
				</div>
			</div>
			<br />
			<br />

			<?php if (!empty($errors)): ?>
				<div class="alert alert-danger" role="alert"> Please select an option from the drop-down menu highlighted below. </div>
			<?php endif; ?>

			<form class="form-horizontal" role="form">
				<div class="form-group <?php if ($errors['answer-01']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">1: How many credit cards do you currently have? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-01" name="answer-01">
							<option value=""> Select one </option>
							<option value="A">I have no open credit cards</option>
							<option value="B">1</option>
							<option value="C">2 to 4</option>
							<option value="D">5 to 8</option>
							<option value="D">8 to 12</option>
							<option value="D">more than 12</option>
						</select>
						<div class="form-group est-second-dropdown <?php if ($errors['answer-01-follow-up']) { echo $error_class; } ?>" id="question-01-follow-up-div" style="display: none;">
							<label for="" class="control-label">Question 1 Follow Up:</label>
							<br />
							How long ago did you obtain your first credit card?<br />
							<select class="form-control" id="question-01-follow-up" name="answer-01-follow-up">
								<option value="">Select one </option>
								<option value="A">less than 6 months ago</option>
								<option value="B">between 6 months and 2 years ago</option>
								<option value="C">2 to 4 years ago</option>
								<option value="D">4 to 5 years ago</option>
								<option value="E">5 to 8 years ago</option>
								<option value="F">8 to 10 years ago</option>
								<option value="G">10 to 15 years ago</option>
								<option value="H">15 to 20 years ago</option>
								<option value="I">more than 20 years ago</option>
							</select>
							<br />
							<br />
						</div>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-02']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">2: How long ago did you open your first loan account? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-02" name="answer-02">
							<option value="">Select one</option>
							<option value="A">I have never had a loan</option>
							<option value="B">less than 1 year ago</option>
							<option value="C">1 to 3 years ago</option>
							<option value="D">3 to 5 years ago</option>
							<option value="E">5 to 10 years ago</option>
							<option value="F">10 to 15 years ago</option>
							<option value="G">15 to 20 years ago</option>
							<option value="H">more than 20 years ago</option>
						</select>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-03']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">3: How many credit cards or loans have you applied for in the past 12 months? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-03" name="answer-03">
							<option value="">Select one</option>
							<option value="A">0</option>
							<option value="B">1</option>
							<option value="C">2</option>
							<option value="D">3 to 5</option>
							<option value="E">6 to 9</option>
							<option value="E">10 or more</option>
						</select>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-04']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">4: How long ago did you open your most recent loan or credit card account? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-04" name="answer-04">
							<option value="">Select one</option>
							<option value="A">less than 3 months ago</option>
							<option value="B">between 3 and 6 months ago</option>
							<option value="C">6 to 10 months ago</option>
							<option value="C">10 to 15 months ago</option>
							<option value="C">more than 15 months ago</option>
						</select>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-05']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">5: How many of your loans and/or credit cards currently have a balance? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-05" name="answer-05">
							<option value="">Select one</option>
							<option value="A">0 to 4</option>
							<option value="B">5 to 6</option>
							<option value="D">9 to 10</option>
							<option value="D">11 to 13</option>
							<option value="D">14 or more</option>
						</select>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-06']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">6: Besides any mortgages, what are your total balances on all other loans and credit cards combined? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-06" name="answer-06">
							<option value="">Select one</option>
							<option value="A">I have only mortgage loan(s)</option>
							<option value="B">Less than $500</option>
							<option value="C">$500 to $999</option>
							<option value="D">$1000 to $4999</option>
							<option value="E">$5000 to $9999</option>
							<option value="F">$10000 to $19999</option>
							<option value="G">$20000 to $29999</option>
							<option value="G">$30000 to $39999</option>
							<option value="G">$40000 to $49999</option>
							<option value="G">$50000+</option>
						</select>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-07']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">7: How long ago did you last miss a loan or credit card payment? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-07" name="answer-07">
							<option value="">Select one</option>
							<option value="A">I have never missed a payment</option>
							<option value="B">in the past 3 months</option>
							<option value="C">3 to 6 months ago</option>
							<option value="D">6 months to 1 year ago</option>
							<option value="E">1 to 2 years ago</option>
							<option value="F">2 to 3 years ago</option>
							<option value="G">3 to 4 years ago</option>
							<option value="H">more than 4 years ago</option>
						</select>
						<div class="est-second-dropdown form-group <?php if ($errors['answer-07-follow-up']) { echo $error_class; } ?>" id="question-07-follow-up-div" style="display: none;">
							<label for="" class="control-label">Question 7 Follow Up: </label>
							<br />
							What is the maximum number of days you have ever been<strong> late</strong> on a loan or credit card payment? <br />
							<select class="form-control" id="question-07-follow-up" name="answer-07-follow-up">
								<option value="">Select one</option>
								<option value="A">30 days late</option>
								<option value="B">60 days late</option>
								<option value="C">90 days late</option>
								<option value="D">more than 90 days late</option>
							</select>
							<br />
							<br />
						</div>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-08']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">8: How many of your loans and/or credit cards are past due as of today? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-08" name="answer-08">
							<option value="">Select one</option>
							<option value="A">0</option>
							<option value="B">1</option>
							<option value="C">2 to 3</option>
							<option value="C">4 or more</option>
						</select>
						<div class="est-second-dropdown form-group <?php if ($errors['answer-08-follow-up']) { echo $error_class; } ?>" id="question-08-follow-up-div" style="display: none;">
							<label for="" class="control-label">Question 8 Follow Up:</label>
							<br />
							What is the total balance on all your accounts which are currently past due? <br />
							<select class="form-control" id="question-08-follow-up" name="answer-08-follow-up">
								<option value="">Select one</option>
								<option value="A">Less than $250</option>
								<option value="B">$250 to $499</option>
								<option value="C">$500 to $4999</option>
								<option value="D">$5000 to $9999</option>
								<option value="D">$9999 to $14999</option>
								<option value="D">$15000 to $19999</option>
								<option value="D">$20000 or more</option>
							</select>
							<br />
							<br />
						</div>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-09']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">9: What percentage of your total credit card limits do your current credit card balances occupy? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-09" name="answer-09">
							<option value="">Select one</option>
							<option value="A">I don't have any credit cards</option>
							<option value="B">0% to 9%</option>
							<option value="C">10% to 19%</option>
							<option value="D">20% to 29%</option>
							<option value="E">30% to 39%</option>
							<option value="F">40% to 49%</option>
							<option value="G">50% to 69%</option>
							<option value="H">70% to 89%</option>
							<option value="I">90% to 99%</option>
							<option value="J">100% or higher</option>
						</select>
					</div>
				</div>
				<div class="form-group <?php if ($errors['answer-10']) { echo $error_class; } ?>">
					<label for="" class="col-sm-10 control-label">10: 	If you have ever had a foreclosure, repossession, tax lien, collection or bankruptcy - when was the most recent occurrence of any of these events? </label>
					<div class="col-sm-14">
						<select class="form-control" id="question-10" name="answer-10">
							<option value="">Select one</option>
							<option value="A">Never had any of these events</option>
							<option value="B">less than 1 year ago</option>
							<option value="C">1 to 3 years ago</option>
							<option value="D">3 to 4 years ago</option>
							<option value="D">5 to 7 years ago</option>
							<option value="D">more than 7 years ago</option>
						</select>
					</div>
				</div>
				<br />
				<div class="form-group">
					<div class="col-sm-20">
					</div>
					<div class="col-sm-4 misce-btn text-right">
						<input class="btn btn-primary btn-lg" type="submit" value="View Results">
						<input type="hidden" name="validate" value=1>
					</div>
					
				</div>
			</form>
			<br>
			<br>
			<div class="text-right">Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a></div>
			 <br />
			<br />
			<br />
			<p style="font-size:11px;">This free credit score estimator/calculator is intended to be as accurate as possible in estimating your potential credit score. However the results are only based on the answers you provide, and in no way does this include or predict actual information contained within your credit report.</p>
			<p style="font-size:11px;">This credit score tool is meant for educational purposes only, and is not meant to replace checking your actual credit score. In addition this score estimator does not indicate approval or rejection of any loans, credit cards etc.</p>
			<br>
			
		  </div>
		  <div class="col-md-4">
		  </div>
			
		</div>
	</div>
</div>

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>
<script>
	$(document).ready(function() {
		var $question01FollowUpDiv = $('#question-01-follow-up-div');
		var $question07FollowUpDiv = $('#question-07-follow-up-div');
		var $question08FollowUpDiv = $('#question-08-follow-up-div');
		var $question01FollowUp = $('#question-01-follow-up');
		var $question07FollowUp = $('#question-07-follow-up');
		var $question08FollowUp = $('#question-08-follow-up');
		var $question01 = $('#question-01');
		var $question02 = $('#question-02');
		var $question03 = $('#question-03');
		var $question04 = $('#question-04');
		var $question05 = $('#question-05');
		var $question06 = $('#question-06');
		var $question07 = $('#question-07');
		var $question08 = $('#question-08');
		var $question09 = $('#question-09');
		var $question10 = $('#question-10');


		// toggle follow up questions based on user selections
		$question01.change(function() {
			var selection = $(this).find('option:selected').val();
			if (selection != '' && selection != 'A') {
				$question01FollowUpDiv.slideDown();
			} else {
				$question01FollowUpDiv.slideUp();
			}
		});

		$question07.change(function() {
			var selection = $(this).find('option:selected').val();
			if (selection != '' && selection != 'A') {
				$question07FollowUpDiv.slideDown();
			} else {
				$question07FollowUpDiv.slideUp();
			}
		});
		
		$question08.change(function() {
			var selection = $(this).find('option:selected').val();
			if (selection != '' && selection != 'A') {
				$question08FollowUpDiv.slideDown();
			} else {
				$question08FollowUpDiv.slideUp();
			}
		});

		<?php

		$answer01 = $_REQUEST['answer-01'];
		$answer01FollowUp = $_REQUEST['answer-01-follow-up'];
		$answer02 = $_REQUEST['answer-02'];
		$answer03 = $_REQUEST['answer-03'];
		$answer04 = $_REQUEST['answer-04'];
		$answer05 = $_REQUEST['answer-05'];
		$answer06 = $_REQUEST['answer-06'];
		$answer07 = $_REQUEST['answer-07'];
		$answer07FollowUp = $_REQUEST['answer-07-follow-up'];
		$answer08 = $_REQUEST['answer-08'];
		$answer08FollowUp = $_REQUEST['answer-08-follow-up'];
		$answer09 = $_REQUEST['answer-09'];
		$answer10 = $_REQUEST['answer-10'];

		$showFollowUp01 = isset($_REQUEST['answer-01']) && $_REQUEST['answer-01'] != '' && $_REQUEST['answer-01'] != 'A';
		$showFollowUp07 = isset($_REQUEST['answer-07']) && $_REQUEST['answer-07'] != '' && $_REQUEST['answer-07'] != 'A';
		$showFollowUp08 = isset($_REQUEST['answer-08']) && $_REQUEST['answer-08'] != '' && $_REQUEST['answer-08'] != 'A';

		if ($showFollowUp01) {
			echo '$question01FollowUpDiv.show();';
		}
		if ($showFollowUp07) {
			echo '$question07FollowUpDiv.show();';
		}
		if ($showFollowUp08) {
			echo '$question07FollowUpDiv.show();';
		}
		?>

		// preselect previous answers on incomplete submission
		<?php if (!$errors['answer-01']) : ?>
			$question01.val('<?= $answer01 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-01-follow-up']) : ?>
			$question01FollowUp.val('<?= $answer01FollowUp ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-02']) : ?>
			$question02.val('<?= $answer02 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-03']) : ?>
			$question03.val('<?= $answer03 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-04']) : ?>
			$question04.val('<?= $answer04 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-05']) : ?>
			$question05.val('<?= $answer05 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-06']) : ?>
			$question06.val('<?= $answer06 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-07']) : ?>
			$question07.val('<?= $answer07 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-07-follow-up']) : ?>
			$question07FollowUp.val('<?= $answer07FollowUp ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-08']) : ?>
			$question08.val('<?= $answer08 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-08-follow-up']) : ?>
			$question08FollowUp.val('<?= $answer08FollowUp ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-09']) : ?>
			$question09.val('<?= $answer09 ?>');
		<?php endif; ?>
		<?php if (!$errors['answer-10']) : ?>
			$question10.val('<?= $answer10 ?>');
		<?php endif; ?>
	});
</script>
<?php

echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = $channel.':credit-score-estimator:form';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:credit score estimator';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'Credit Score Estimator';
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
	$channel = 'tools';
	$pageName = $channel.':credit score estimator:form';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
