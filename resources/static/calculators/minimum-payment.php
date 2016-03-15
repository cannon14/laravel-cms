<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/pageInit.php');
$_SESSION['fid'] = "294";
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html ng-app="CalculatorApplication">
<head>
	<?php

	$htmlTitle = 'Credit Card Payment - Should you pay more than the minimum?';
	$metaKeywords = 'Advanta, American Express, Bank of America, BankOne, Chase Manhattan Bank, Citibank, Discover Bank, First Premier Bank, Featured Partners';
	$metaDescription = 'Should you be paying more than your minimum credit card payment? Calculate it here.';

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
					<li>The true cost of paying the minimum</li>
				</ol>
			</div>
			<br/>

			<h1>Minimum Payment Calculator</h1>
			<br/>

			<div class="row">
				<div class="col-sm-16 col-md-16">
					<div class="cal-hldr" ng-controller="MinimumPaymentController">

						<div class="row">
							<div class="col-sm-16 col-md-16 subtitle">The True Cost Of Paying The Minimum</div>
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
										<div class="row">
											<div class="col-xs-24">
												<form name="minimum_payment_form" novalidate role="form">

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
																		   value="1000.00"
																		   ng-model="current_balance"
																		   ng-model-options="{updateOn: 'blur'}"
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
																 ng-show="minimum_payment_form.$submitted || minimum_payment_form.current_balance.$touched">
                                        <span class="angular_error alert-danger"
											  ng-show="minimum_payment_form.current_balance.$error.required">Principal Amount Required!</span>
                                        <span class="angular_error alert-danger"
											  ng-show="minimum_payment_form.current_balance.$error.pattern">Enter Dollar Amounts Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="interest_rate" class="col-xs-24 control-label">
																Interest Rate (APR)
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
																		   value="17.0"
																		   ng-model="interest_rate"
																		   ng-model-options="{updateOn: 'blur'}"
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
																 ng-show="minimum_payment_form.$submitted || minimum_payment_form.interest_rate.$touched">
                                        <span class="angular_error alert-danger"
											  ng-show="minimum_payment_form.interest_rate.$error.required">Interest Rate Required!</span>
                                        <span class="angular_error alert-danger"
											  ng-show="minimum_payment_form.interest_rate.$error.pattern">Enter Numeric Percentage Only!</span>
															</div>
														</div>
													</div>

													<div class="row">
														<label class="col-xs-24 control-label">
															What are the components of your minimum payment calculation?
														</label>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="percentage_of_balance" class="col-xs-22 col-xs-offset-2 control-label">
																Percentage of Balance:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-22 col-xs-offset-2">
																<div class="input-group">
																	<div class="input-group-addon">%</div>
																	<select class="form-control"
																			name="percentage_of_balance"
																			id="percentage_of_balance"
																			ng-model="percentage_of_balance"
																			ng-model-options="{updateOn: 'blur'}"
																			ng-required="true">
																		<option value="2">2</option>
																		<option value="2.5">2.5</option>
																		<option value="3">3</option>
																		<option value="3.5" selected>3.5</option>
																		<option value="4">4</option>
																		<option value="4.5">4.5</option>
																		<option value="5">5</option>
																		<option value="interest+1">Interest + 1%</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<!--form-group-->

													<div class="form-group">
														<div class="row">
															<label for="minimum_dollar_amount" class="col-xs-22 col-xs-offset-2 control-label">
																Minimum Dollar Amount:
															</label>
														</div>

														<div class="row">
															<div class="col-xs-22 col-xs-offset-2">
																<div class="input-group">
																	<div class="input-group-addon">$</div>
																	<select type="text"
																			class="form-control"
																			name="minimum_dollar_amount"
																			id="minimum_dollar_amount"
																			ng-model="minimum_dollar_amount"
																			ng-model-options="{updateOn: 'blur'}"
																			ng-required="true">
																		<option value="10">10.00</option>
																		<option value="15">15.00</option>
																		<option value="20">20.00</option>
																		<option value="25" selected>25.00</option>
																		<option value="30">30.00</option>
																		<option value="35">35.00</option>
																		<option value="40">40.00</option>
																		<option value="45">45.00</option>
																		<option value="50">50.00</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<!--form-group-->

													<div class="form-group">
														<div class="row">
															<div class="col-xs-24">
																<button type="button" id="calculate_button"
																		class="btn btn-success btn-block calculator_green_button"
																		ng-click="calculate()">
																	Calculate
																</button>
															</div>
														</div>
													</div>
													<!--form-group-->
												</form>
											</div>
											<!--column-->
										</div>
										<!--row-->

										<br>

										<div class="row">
											<div class="col-xs-24 note">
												<span class="text-danger">* </span>Your account agreement or monthly
												statement will contain language similar to "your minimum payment is 3% of your balance or $25,
												whichever is greater."
											</div>
											<!--column-->
										</div>
										<!--row-->
									</div>
									<!--input-->

									<div class="tab-pane" id="result">
										<div class="row">
											<div class="col-xs-24">
												<p>
													It will take you <strong>{{months}}</strong> months to pay off your
													debt, if you make minimum monthly payments on a balance of <strong>{{principal}}</strong> with a
													<strong>{{apr}} APR</strong>. In that time, you will pay
													<strong>{{interest}}</strong> in interest charges
												</p>

												<p>
													We recommend that you pay more than the minimum
													payment whenever possible. If you make only the minimum
													payment each month, it will take you longer and cost you
													more to clear your balance.
												</p>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-xs-24">
												<button class="btn btn-success btn-block calculator_green_button"
														onclick="window.location = 'http://www.creditcards.com/low-interest.php'">
													Find a Low Interest Card Now!
												</button>
											</div>
										</div>
									</div>
									<!--result-->

									<div class="tab-pane" id="table">
										<div class="table-responsive scrolling-table">
											<table
												class="table table-condensed table-striped table-bordered table-hover">
												<thead>
												<tr>
													<th>Month</th>
													<th>Minimum Payment</th>
													<th>Principal Paid</th>
													<th>Interest Paid</th>
													<th>Remaining Balance</th>
													<th>Total Interest</th>
												</tr>
												</thead>

												<tbody>
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
									<!--table-->

									<div class="tab-pane" id="graph">
										<div id="high_chart"></div>
									</div>
									<!--graph-->

									<div class="tab-pane" id="about">
										<div class="row">
											<div class="col-xs-24">
												<p>
													The minimum payment on credit card debt is calculated as a
													percentage of your total current balance, or as all interest plus 1
													percent of the principal. Card issuers also set a floor to their
													minimum payments -- a fixed dollar amount that the minimum
													payment won't fall below.
												</p>

												<p>
													The minimum payment drops as your balance is paid, but thanks to
													compounding interest, you will end up paying for a long, long time
													if
													you pay only the minimum.
												</p>

												<p>
													Check out how much interest you will pay over the life of the debt
													by
													using this calculator. To begin, click the "Inputs" tab and enter
													your
													information. Click "Calculate" and then view detailed information by
													clicking "Results", "Graphs", and "Tables."
												</p>
											</div>
										</div>
									</div>
									<!--about-->
								</div>
								<!--tab-content-->
							</div>
							<!--column-->
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
							<li><a href="/calculators/payoff.php">What will it take to pay off my current balance?</a>
							</li>
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
							<p>The minimum payment on credit card debt is calculated as a percentage of your total
								current balance, or as all interest plus 1 percent of the principal. Card issuers also
								set a floor to their minimum payments -- a fixed dollar amount that the minimum payment
								won't fall below.</p>

							<p>The minimum payment drops as your balance is paid, but thanks to compounding interest,
								you will end up paying for a long, long time if you pay only the minimum.</p>

							<p>Check out how much interest you will pay over the life of the debt by using this
								calculator. To begin, click the "Inputs" tab and enter your information. Click
								"Calculate" and then view detailed information by clicking "Results," "Graphs" and
								"Tables."</p>

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
$pageName = $channel.':calculators:minimum-payment';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:calculators';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'minimum-payment';
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
<script src="/javascript/calculators/MinimumPaymentCalculator.js"></script>
<script src="/javascript/calculators/MinimumPaymentController.js"></script>

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
