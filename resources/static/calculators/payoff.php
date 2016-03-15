<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/pageInit.php');
$_SESSION['fid'] = "296";
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html ng-app="CalculatorApplication">
<head>
	<?php

	$htmlTitle = 'Credit Card Payment Calculator: How to pay off your balance';
	$metaKeywords = 'Advanta, American Express, Bank of America, BankOne, Chase Manhattan Bank, Citibank, Discover Bank, First Premier Bank, Featured Partners';
	$metaDescription = 'Calculate how long it will take you to pay off your debt with CreditCards.com\'s card payment calculators.';

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
					<li>What will it take to pay off my current balance?</li>
				</ol>
			</div>
			<br/>

			<h1>Payoff Calculator</h1>
			<br/>

			<div class="row">
				<div class="col-sm-16 col-md-16">
					<div class="cal-hldr" ng-controller="PayoffController">
						<div class="row">
							<div class="subtitle col-sm-16 col-md-16">What will it take to pay off my current balance?
							</div>
						</div>

						<div class="row">
							<div class="col-sm-16 col-md-16">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#input">Input</a></li>
									<li class="disabled"><a href="#result" id="resultTab">Result</a></li>
									<li class="disabled"><a href="#table" id="tableTab">Table</a></li>
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
												<form name="payoffForm" novalidate role="form">

													<div class="form-group">
														<div class="row">
															<label for="current_balance" class="col-xs-24 control-label">
																Current Balance:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="current_balance"
																		   id="current_balance"
																		   ng-model="current_balance"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   ng-required="true"
																		   select-on-click>
																</div>
																<!--input-group-->
															</div>
														</div>
													</div>
													<!--form-group-->

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="payoffForm.$submitted || payoffForm.current_balance.$touched">
															<span class="alert-danger"
																  ng-show="payoffForm.current_balance.$error.required">Principal Amount Required!</span>
															<span class="alert-danger"
																  ng-show="payoffForm.current_balance.$error.pattern">Enter Dollar Amounts Only!</span>
															</div>
														</div>
													</div>


													<div class="form-group">
														<div class="row">
															<label for="interest_rate" class="col-xs-24 control-label">
																Interest Rate (APR):
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">%</div>
																	<input type="text"
																		   class="form-control"
																		   name="interest_rate"
																		   id="interest_rate"
																		   ng-model="interest_rate"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   ng-required="true"
																		   select-on-click>
																</div>
																<!--input-group-->
															</div>
														</div>
													</div>
													<!--form-group-->

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="payoffForm.$submitted || payoffForm.interest_rate.$touched">
															<span class="alert-danger"
																  ng-show="payoffForm.interest_rate.$error.required">Interest Rate Required!</span>
															<span class="alert-danger"
																  ng-show="payoffForm.interest_rate.$error.pattern">Enter Numeric Percentage Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="monthly_charges" class="col-xs-24 control-label">
																Monthly Charges:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="monthly_charges"
																		   id="monthly_charges"
																		   ng-model="monthly_charges"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
																<!--input-group-->
															</div>
														</div>
													</div>
													<!--form-group-->

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="payoffForm.$submitted || payoffForm.monthly_charges.$touched">
															<span class="alert-danger"
																  ng-show="payoffForm.monthly_charges.$error.pattern">Enter Dollar Amounts Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="months_to_payoff" class="col-xs-24 control-label">
																Desired Months to Pay Off:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">#</div>
																	<input type="text"
																		   class="form-control"
																		   name="months_to_payoff"
																		   id="months_to_payoff"
																		   ng-click="monthsToPayoffClicked()"
																		   ng-model="months_to_payoff"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="payoffForm.$submitted || payoffForm.months_to_payoff.$touched">
                                                <span class="alert-danger"
													  ng-show="payoffForm.months_to_payoff.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<br>

													<div class="row">
														<div class="col-xs-24 text-center">
															<span class="text-danger bold_me">--OR--</span>
														</div>
													</div>

													<br>

													<div class="form-group">
														<div class="row">
															<label for="desired_monthly_payment" class="col-xs-24 control-label">
																Desired Monthly Payment:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-24">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<input type="text"
																		   class="form-control"
																		   name="desired_monthly_payment"
																		   id="desired_monthly_payment"
																		   ng-click="monthlyPaymentClicked()"
																		   ng-model="desired_monthly_payment"
																		   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																		   select-on-click>
																</div>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="payoffForm.$submitted || payoffForm.desired_monthly_payment.$touched">
                                                <span class="alert-danger"
													  ng-show="payoffForm.desired_monthly_payment.$error.pattern">Enter Dollar Amounts Only!</span>
															</div>
														</div>
													</div>

													<br>

													<div class="form-group">
														<div class="row">
															<div class="col-xs-24">
																<button type="submit" id="calculate_button"
																		class="btn btn-danger btn-block calculator_green_button"
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
									</div>
									<!--input-->
									<div class="tab-pane" id="result">
										<div class="row">
											<div class="col-xs-24">
												<div class="row">
													<div class="col-xs-24">
														<div ng-bind-html="result"></div>
													</div>
												</div>

												<div class="row text-center" ng-show="retry == false">
													<div class="col-xs-24">
														<h5 class="save_money">Save Money</h5>
														<hr class="save_money_line">
													</div>
												</div>

												<div class="row" ng-show="retry == false">
													<div class="col-xs-24">
														<div ng-bind-html="result2"></div>
													</div>
												</div>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-xs-24">
												<button class="btn btn-danger btn-block calculator_green_button"
														onclick="window.location = 'http://www.creditcards.com/low-interest.php'">
													Find a Low Interest Card Now!
												</button>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="table">
										<div class="table-responsive scrolling-table">
											<table
												class="table table-condensed table-striped table-bordered table-hover">
												<thead>
												<tr>
													<th>Month</th>
													<th>Monthly Payment</th>
													<th>Principal Paid</th>
													<th>Interest Paid</th>
													<th>Remaining Balance</th>
													<th>Total Interest</th>
												</tr>
												</thead>

												<tbody class="table_body">
												<tr ng-repeat="element in tableData ">
													<td>{{element.month}}</td>
													<td>{{element.payment}}</td>
													<td>{{element.principal}}</td>
													<td>{{element.interest}}</td>
													<td>{{element.owed}}</td>
													<td>{{element.totalInterest}}</td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="tab-pane" id="graph">
										<div id="high_chart"></div>
									</div>
									<div class="tab-pane" id="about">
										<div class="row">
											<div class="col-xs-24">
												<p>This calculator calculates either:</p>
												<ul>
													<li>
														The monthly payment amount required to repay your credit
														card balance in full, given your estimated monthly purchases
														and number of months you'd like to pay off your balance.
													</li>

													<br>

													<li>
														The number of months it will take to pay your credit card
														balance in full, given the monthly payment amount you plan to
														make, along with your estimated monthly purchases.
													</li>
												</ul>
												<p>
													When estimating your monthly charges, be sure to include any
													annual fees or other fees charged by the card issuer.
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
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
							<li><a href="/calculators/cash-back-or-low-interest.php">Which is better: Cash Back or Low
									Interest Card?</a></li>
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
							<p>This calculator calculates either:</p>

							<p>The monthly payment amount required to repay your credit card balance in full, given your
								estimated monthly purchases and number of months you'd like to pay off your balance.
								<br>
								<br><strong>OR</strong><br><br>
								The number of months it will take to pay your credit card balance in full, given the
								monthly payment amount you plan to make, along with your estimated monthly purchases.
							</p>

							<p>When estimating your monthly charges, be sure to include any annual fees or other fees
								charged by the card issuer.</p>

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
$pageName = $channel.':calculators:payoff';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:calculators';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'payoff';
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

<script src="/javascript/highstock/highstock.js"></script>
<script src="/javascript/angular.min.js"></script>
<script src="/javascript/calculators/global.js"></script>
<script src="/javascript/calculators/Calculator.js"></script>
<script src="/javascript/calculators/PayoffCalculator.js"></script>
<script src="/javascript/calculators/PayoffController.js"></script>

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
