<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/pageInit.php');
$_SESSION['fid'] = "293";
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html ng-app="CalculatorApplication">
<head>
	<?php

	$htmlTitle = 'Cash back or low interest credit cards from CreditCards.com';
	$metaKeywords = 'Advanta, American Express, Bank of America, BankOne, Chase Manhattan Bank, Citibank, Discover Bank, First Premier Bank, Featured Partners';
	$metaDescription = 'Compares the savings and benefits from cash back and low interest credit cards at CreditCards.com';

	include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/htmlHead.php');
	if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
	?>

	<link href="/css/cc-misc.css" rel="stylesheet">
	<link href="/css/calculators.css" rel="stylesheet">

</head>

<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/header.php'); ?>

<!-- Other Block -->
<div class="other-block">
	<div class="container">
		<div class="row">
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="http://www.creditcards.com/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/credit-card-tools/">Tools</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/calculators/">Calculators</a> <i class="fa fa-angle-right"></i></li>
					<li>Which is better: Cash Back or Low Interest card?</li>
				</ol>
			</div>
			<br/>

			<h1>Cash Back or Low Interest Card</h1>
			<br/>

			<div class="row">
				<div class="col-sm-16 col-md-16">
					<div class="cal-hldr" ng-controller="CashbackLowInterestController">

						<div class="row">
							<div class="subtitle col-sm-16 col-md-16">Which is better: Cash Back or Low Interest Card?
							</div>
						</div>

						<div class="row">
							<div class="col-sm-16 col-md-16">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#input">Input</a></li>
									<li class="disabled"><a href="#result" id="resultTab">Result</a></li>
									<li class="disabled"><a href="#graph" id="graphTab">Graph</a></li>
								</ul>
							</div>
						</div>

						<br>

						<div class="row">
							<div class="col-sm-16 col-md-16">
								<div class="tab-content">
									<div class="tab-pane active" id="input">
										<div class='row'>
											<div class='col-xs-24'>
												<form name="comparisonForm" novalidate role="form">

													<div class="form-group">
														<div class="row">
															<label for="principal" class="col-xs-24 control-label">
																Current Balance:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="principal"
																		   id="principal"
																		   placeholder="0.00"
																		   ng-model="principal"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   ng-required="true"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.principal.$touched">
															<span class="alert-danger"
																  ng-show="comparisonForm.principal.$error.required">Principal Amount Required!</span>
															<span class="alert-danger"
																  ng-show="comparisonForm.principal.$error.pattern">Enter Numeric Dollar Amount Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="years" class="col-xs-24 control-label">
																Years you will use card:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">#</div>
																	<input type="text"
																		   class="form-control"
																		   name="years"
																		   id="years"
																		   placeholder="0"
																		   ng-model="years"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   ng-required="true"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.years.$touched">
															<span class="alert-danger"
																  ng-show="comparisonForm.years.$error.required">Years Required!</span>
															<span class="alert-danger"
																  ng-show="comparisonForm.years.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="charges" class="col-xs-24 control-label">
																Monthly Charges:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="charges"
																		   id="charges"
																		   placeholder="0.00"
																		   ng-model="charges"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.charges.$touched">
															<span class="alert-danger"
																  ng-show="comparisonForm.charges.$error.required">Monthly Charges Required!</span>
															<span class="alert-danger"
																  ng-show="comparisonForm.charges.$error.pattern">Enter Numeric Dollar Amount Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="payment" class="col-xs-24 control-label">
																Estimated monthly payments:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="payment"
																		   id="payment"
																		   placeholder="0.00"
																		   ng-model="payment"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.payment.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.payment.$error.required">Monthly Charges Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.payment.$error.pattern">Enter Numeric Dollar Amount Only!</span>
															</div>
														</div>
													</div>


													<div class="row">
														<div class="col-xs-offset-12 col-xs-6 text-center"><strong>Cash Back</strong></div>
														<div class="col-xs-6 text-center"><strong>Low Interest</strong></div>
													</div>

													<div class="form-group">
														<div class="row">

															<label for="cash_back_rate" class="col-xs-12 control-label">
																Introductory interest rate:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_rate"
																	   id="cash_back_rate"
																	   placeholder="0.0"
																	   ng-model="cash_back_rate"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_rate"
																	   id="low_interest_rate"
																	   placeholder="0.0"
																	   ng-model="low_interest_rate"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>
													<!--form-group-->

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.intro_rate.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_rate.$error.pattern">Enter Numeric Percentage Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="payment" class="col-xs-12 control-label">
																Introductory term (months):
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_term"
																	   id="cash_back_term"
																	   placeholder="0.0"
																	   ng-model="cash_back_term"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_term"
																	   id="low_interest_term"
																	   placeholder="0.0"
																	   ng-model="low_interest_term"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.intro_term.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_term.$error.pattern">Enter Numeric Percentage Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="payment" class="col-xs-12 control-label">
																Regular Interest Rate (APR):
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="regular_rate"
																	   id="cash_back_regular_rate"
																	   placeholder="0.0"
																	   ng-model="cash_back_regular_rate"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="regular_rate"
																	   id="low_interest_regular_rate"
																	   placeholder="0.0"
																	   ng-model="low_interest_regular_rate"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.regular_rate.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.regular_rate.$error.pattern">Enter Numberic Percentage Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">

															<label for="payment" class="col-xs-12 control-label">
																Annual Fee:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="annual_fee"
																	   id="cash_back_annual_fee"
																	   placeholder="0.00"
																	   ng-model="cash_back_annual_fee"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="annual_fee"
																	   id="low_interest_annual_fee"
																	   placeholder="0.00"
																	   ng-model="low_interest_annual_fee"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.annual_fee.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.annual_fee.$error.pattern">Enter Numeric Dollar Amount Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="payment" class="col-xs-24 control-label">
																% earned on regular purchases:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">%</div>
																	<input type="text"
																		   class="form-control"
																		   name="cashback_percent_regular"
																		   id="cashback_percent_regular"
																		   placeholder="0.0"
																		   ng-model="cashback_percent_regular"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.cashback_percent_regular.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.cashback_percent_regular.$error.pattern">Enter Numeric Percentage Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="payment" class="col-xs-24 control-label">
																% earned on specific brands/items:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">%</div>
																	<input type="text"
																		   class="form-control"
																		   name="cashback_percent_specific"
																		   id="cashback_percent_specific"
																		   placeholder="0.0"
																		   ng-model="cashback_percent_specific"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.cashback_percent_specific.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.cashback_percent_specific.$error.pattern">Enter Numeric Percentage Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="payment" class="col-xs-24 control-label">
																Portion of monthly charge that qualifies for brand specific reward:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="cashback_specific_reward"
																		   id="cashback_specific_reward"
																		   placeholder="0.0"
																		   ng-model="cashback_specific_reward"
																		   ng-model-options="{updateOn: 'blur'}"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.cashback_specific_reward.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.cashback_specific_reward.$error.pattern">Enter Numeric Percentage Value Only!</span>
															</div>
														</div>
													</div>

													<br>

													<div class="form-group">
														<div class="row">
															<div class="col-xs-24">
																<button type="submit" id="calculate_button" class="btn btn-success btn-block calculator_green_button"
																		ng-click="calculate()">Calculate
																</button>
															</div>
														</div>
													</div>
												</form>
											</div>
											<!--col-lg-12-->
										</div>
										<!--row-->
									</div><!--input-->

									<div class="tab-pane" id="result">
										<div class="row">
											<div class="col-xs-24">
												<table class="table">
													<thead>
													<tr>
														<td></td>
														<td><strong>Cash Back</strong></td>
														<td><strong>Low Interest</strong></td>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td><strong>Interest:</strong></td>
														<td>{{cbTotalInterest}}</td>
														<td>{{liTotalInterest}}</td>
													</tr>
													<tr>
														<td><strong>Fees:</strong></td>
														<td>{{cbTotalFees}}</td>
														<td>{{liTotalFees}}</td>
													</tr>
													<tr>
														<td><strong>Cash award earned:</strong></td>
														<td>{{totalCashAward}}</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td><strong>Net cost:</strong></td>
														<td>{{cbNetCost}}</td>
														<td>{{liNetCost}}</td>
													</tr>
													</tbody>
												</table>
												<div ng-bind-html="result"></div>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-xs-24">
												<button class="btn btn-success btn-block calculator_green_button"
														onclick="window.location = 'http://www.creditcards.com/cash-back.php'">
													Find a Cash Back Card Now!
												</button>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-xs-24">
												<button class="btn btn-success btn-block calculator_green_button"
														onclick="window.location = 'http://www.creditcards.com/low-interest.php'">
													Find a Low
													Interest Card Now!
												</button>
											</div>
										</div>
									</div><!--result-->

									<div class="tab-pane" id="graph" style="position:relative">
										<div class="row">
											<div class="col-xs-24">
												<div id="high_chart"></div>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-24">
												<p>This graph compares interest and fees paid with a cash back and low
													interest card. It
													also shows the total amount earned in cash awards at the end of
													{{numOfYears}}
													years.</p>
											</div>
										</div>
									</div><!--graph-->

									<div class="tab-pane" id="about">
										<div class="row">
											<div class="col-xs-24">
												<p>Cash Back cards allow you to earn a percentage of your charges back
													in the form of a cash
													award at the end of each year. Often, Cash Back cards have a higher
													interest rate and
													annual fee compared to an ordinary credit card.</p>

												<p>This calculator compares a Cash Back card with a Low Interest rate
													card. This information
													will help you determine which card is better for your. If you pay
													your balance in full
													each month and owe nothing, the Cash Back card will be advantageous
													to you.</p>
											</div>
										</div>
									</div>

								</div><!--tab-content-->
							</div>
							<!--col-md-16-->
						</div>

						<br/>

						<div class="cal-fb-other-hldr">
							<iframe
								src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcalculators%2Fminimum-payment.php&amp;layout=standard&amp;show_faces=false&amp;width=500&amp;action=like&amp;colorscheme=light&amp;height=35"
								scrolling="no" frameborder="0"
								style="border:none; overflow:hidden; width:500px; height:35px;"
								allowTransparency="true"></iframe>
							<br/>

							<div style="text-align:left;"> Comments or suggestions about this tool? <a
									href="/site-feedback.php">Send us feedback</a></div>
						</div>
						<br/>
					</div>
				</div>
				<div class="col-sm-8 col-md-8">
					<div class="cal-right-rutter">
						<h2>More Calculators</h2>
						<ul class="list-unstyled">
							<li><a href="/calculators/minimum-payment.php">The true cost of paying the minimum</a></li>
							<li><a href="/calculators/payoff.php">What will it take to pay off my current balance?</a>
							</li>
							<li><a href="/calculators/airlines-or-low-interest.php">Which is better: Airlines or Low
									Interest Card?</a></li>
							<li><a href="/calculators/balance-transfer.php">How much could I save by transferring my
									balances?</a></li>
						</ul>
					</div>
				</div>
			</div>
			<br/>
			<br/>
			<br/>

			<div class="cal-fb-other-hldr">
				<div class="row">
					<div class="col-md-24">
						<div style="font-size:12px;">
							<p>Cash Back cards allow you to earn a percentage of your charges back in the form of a cash
								award at the end of each year. Often, Cash Back cards have a higher interest rate and
								annual fee compared to an ordinary credit card.</p>

							<p>This calculator compares a Cash Back card with a Low Interest rate card. This information
								will help you determine which card is better for you. If you pay your balance in full
								each month and owe nothing, the Cash Back card will be advantageous to you.</p>

							<p>This calculator is intended solely for general information and educational purposes and does not take into account all of the personal, economic and other factors that may be relevant to your decision making. The accuracy of this calculator and its applicability to your personal financial circumstances is not guaranteed or warranted.</p>

						</div>
					</div>
				</div>
			</div>
			<br/>
			<br/>
			<br/>
		</div>
	</div>
</div>
<!-- End of Other Block -->

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/footerScripts.php'); ?>

<?php
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = $channel.':calculators:cash-back-vs-low-interest';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:calculators';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'cash-back-or-low-interest';
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
	$pageName = $channel.':calculators:cash back vs low interest';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

<script src="/javascript/highstock/highstock.js"></script>
<script src="/javascript/angular.min.js"></script>
<script src="/javascript/calculators/global.js"></script>
<script src="/javascript/calculators/Calculator.js"></script>
<script src="/javascript/calculators/ComparisonCalculator.js"></script>
<script src="/javascript/calculators/CashbackLowInterestCalculator.js"></script>
<script src="/javascript/calculators/CashbackLowInterestController.js"></script>

<script>
	$(document).ready(function () {
		$('#graphTab').click(function () {
			setTimeout(function () {
				$('#high_chart').highcharts().reflow();
			}, 10);
		});

		$('#calculate_button').click(function () {
			$('.nav-tabs > li').removeClass('disabled');
			$('.nav-tabs > .active').next('li').find('a').trigger('click');
		});

		$('.nav-tabs a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
	});
</script>

</body>
</html>
