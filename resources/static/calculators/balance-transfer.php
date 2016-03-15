<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/pageInit.php');
$_SESSION['fid'] = "295";
include_once($_SERVER['DOCUMENT_ROOT'] . '/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html ng-app="CalculatorApplication">
<head>
	<?php

	$htmlTitle = 'Balance Transfer Calculators - Does it make sense to transfer money?';
	$metaKeywords = 'Advanta, American Express, Bank of America, BankOne, Chase Manhattan Bank, Citibank, Discover Bank, First Premier Bank, Featured Partners';
	$metaDescription = 'Calculate whether a balance transfer makes sense. Use CreditCards.com\'s balance transfer tool.';

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
					<li>How much could I save by transferring my balances?</li>
				</ol>
			</div>
			<br/>

			<h1>Balance Transfer Calculator</h1>

			<br/>

			<div class="row">
				<div class="col-sm-16 col-md-16">
					<div class="cal-hldr" ng-controller="BalanceTransferController">
						<div class="row">
							<div class="col-sm-16 col-md-16 subtitle">How much could I save by transferring my
								balances?
							</div>
						</div>

						<br>

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
										<form name="currentBalanceForm" novalidate role="form">

											<div class="row">
												<div class="col-xs-24">
													<p class="bt_section_title">Regarding Your Current
														CreditCard(s):</p>
												</div>
											</div>
											<!--row-->

											<div class="row">
												<div class="col-xs-4">
													<span class="bt_col_title">Card</span>
												</div>

												<div class="col-xs-6 text-center">
													<span class="bt_col_title">Balance</span>
												</div>

												<div class="col-xs-offset-1 col-xs-6 text-center">
													<span class="bt_col_title">Interest Rate (APR)</span>
												</div>


												<div class="col-xs-offset-1 col-xs-6 text-center">
													<span class="bt_col_title">Monthly Payment</span>
												</div>

											</div>
											<!--row-->

											<div class="row">

												<label for="balance1" class="col-xs-4 control-label">
													<span class="text-danger">1.</span>
												</label>

												<div class="col-xs-6">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">
																$
															</div>
															<input type="text"
															       class="form-control"
															       name="balance1"
															       id="balance1"
															       placeholder="0.00"
															       ng-model="balance1"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>

												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="apr1"
															       id="apr1"
															       placeholder="0.00"
															       ng-model="apr1"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">$</div>
															<input type="text"
															       class="form-control"
															       name="payment1"
															       id="payment1"
															       placeholder="0.00"
															       ng-model="payment1"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>

													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center" style="margin-bottom: 10px;">
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance1.$error.required">Balance Amount Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance1.$error.pattern">Enter Number Only!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr1.$error.required">Annual Percentage Rate Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr1.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
													<!--errors-->
												</div>
											</div>

											<div class="row">
												<label for="balance2"
												       class="col-xs-4 control-label">
													<span class="text-danger">2.</span>
												</label>

												<div class="col-xs-6">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">
																$
															</div>
															<input type="text"
															       class="form-control"
															       name="balance2"
															       id="balance2"
															       placeholder="0.00"
															       ng-model='balance2'
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="apr2"
															       id="apr2"
															       placeholder="0.00"
															       ng-model="apr2"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">$</div>
																<input type="text"
																       class="form-control"
																       name="payment2"
																       id="payment2"
																       placeholder="0.00"
																       ng-model="payment2"
																       ng-model-options="{updateOn: 'blur'}"
																       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																       select-on-click>
															</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center" style="margin-bottom: 10px;">
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance2.$error.required">Balance Amount Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance2.$error.pattern">Enter Number Only!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr2.$error.required">Annual Percentage Rate Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr2.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
													<!--errors-->
												</div>
											</div>

											<div class="row">

												<label for="balance3"
												       class="col-xs-4 control-label">
													<span class="text-danger">3.</span>
												</label>

												<div class="col-xs-6">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">
																$
															</div>
															<input type="text"
															       class="form-control"
															       name="balance3"
															       id="balance3"
															       placeholder="0.00"
															       ng-model='balance3'
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="apr3"
															       id="apr3"
															       placeholder="0.00"
															       ng-model="apr3"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">$</div>
																<input type="text"
																       class="form-control"
																       name="payment3"
																       id="payment3"
																       placeholder="0.00"
																       ng-model="payment3"
																       ng-model-options="{updateOn: 'blur'}"
																       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																       select-on-click>
															</div>
													</div>
												</div>

											</div>
											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center" style="margin-bottom: 10px;">
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance3.$error.required">Balance Amount Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance3.$error.pattern">Enter Number Only!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr3.$error.required">Annual Percentage Rate Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr3.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
													<!--errors-->
												</div>
											</div>

											<div class="row">

												<label for="balance4"
												       class="col-xs-4 control-label">
													<span class="text-danger">4.</span>
												</label>

												<div class="col-xs-6">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">
																$
															</div>
															<input type="text"
															       class="form-control"
															       name="balance4"
															       id="balance4"
															       placeholder="0.00"
															       ng-model='balance4'
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="apr4"
															       id="apr4"
															       placeholder="0.00"
															       ng-model="apr4"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       ng-required="true"
															       select-on-click>
														</div>


													</div>
												</div>

												<div class="col-xs-6 col-xs-offset-1">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">$</div>
																<input type="text"
																       class="form-control"
																       name="payment4"
																       id="payment4"
																       placeholder="0.00"
																       ng-model="payment4"
																       ng-model-options="{updateOn: 'blur'}"
																       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																       select-on-click>
															</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center" style="margin-bottom: 10px;">
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance4.$error.required">Balance Amount Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.balance4.$error.pattern">Enter Number Only!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr4.$error.required">Annual Percentage Rate Required!</span>
														<span class="angular_error alert-danger"
														      ng-show="currentBalanceForm.apr4.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
													<!--errors-->
												</div>
											</div>

										</form>
										<div class="row">
											<div class="col-xs-24">
												<p class="bt_section_title">Regarding the Card You're Transferring
													to:</p>
											</div>
										</div>
										<!--row-->

										<form name="balanceTransferForm" novalidate role="form">

											<div class="form-group">
												<div class="row">
													<label for="intro_int_rate" class="col-xs-24 control-label">
														Introductory Interest Rate (APR)
													</label>
												</div>

												<div class="row">
													<div class="col-xs-24">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="intro_int_rate"
															       id="intro_int_rate"
															       placeholder="0.0"
															       ng-model="intro_int_rate"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-required="true"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center"
													     ng-show="balanceTransferForm.$submitted || balanceTransferForm.intro_int_rate.$touched">
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.intro_int_rate.$error.required">Introductory Interest Rate Required!</span>
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.intro_int_rate.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">
													<label for="intro_term" class="col-xs-24 control-label">
														Introductory Term (months)
													</label>
												</div>

												<div class="row">
													<div class="col-xs-24">
														<div class="input-group">
															<div class="input-group-addon">#</div>
															<input type="text"
															       class="form-control"
															       name="intro_term"
															       id="intro_term"
															       placeholder="12"
															       ng-model="intro_term"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-required="true"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xs-24">
														<div class="custom-error text-center"
														     ng-show="balanceTransferForm.$submitted || balanceTransferForm.intro_term.$touched">
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.intro_term.$error.required">Introductory Term Required!</span>
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.intro_term.$error.pattern">Enter Numeric Value Only!</span>
														</div>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">
													<label for="regular_apr" class="col-xs-12 control-label">
														Regular Interest Rate (APR)
													</label>
												</div>

												<div class="row">
													<div class="col-xs-24">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="regular_apr"
															       id="regular_apr"
															       placeholder="15"
															       ng-model="regular_apr"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-required="true"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center"
													     ng-show="balanceTransferForm.$submitted || balanceTransferForm.regular_apr.$touched">
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.regular_apr.$error.required">Regular Rate Required!</span>
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.regular_apr.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">
													<label for="annual_fee" class="col-xs-24 control-label">
														Annual Fee
													</label>
												</div>

												<div class="row">
													<div class="col-xs-24">
														<div class="input-group">
															<div class="input-group-addon">$</div>
															<input type="text"
															       class="form-control"
															       name="annual_fee"
															       id="annual_fee"
															       placeholder="0.00"
															       ng-model="annual_fee"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-required="true"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center"
													     ng-show="balanceTransferForm.$submitted || balanceTransferForm.annual_fee.$touched">
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.annual_fee.$error.required">Regular Rate Required!</span>
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.annual_fee.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">
													<label for="percent_of_balance_fee"
													       class="col-xs-24 control-label">
														Balance Transfer Fee - % of Balance
													</label>
												</div>

												<div class="row">
													<div class="col-xs-24">
														<div class="input-group">
															<div class="input-group-addon">%</div>
															<input type="text"
															       class="form-control"
															       name="percent_of_balance_fee"
															       id="percent_of_balance_fee"
															       placeholder="3"
															       ng-model="percent_of_balance_fee"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-required="true"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center"
													     ng-show="balanceTransferForm.$submitted || balanceTransferForm.percent_of_balance_fee.$touched">
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.percent_of_balance_fee.$error.required">Balance Transfer Fee Required!</span>
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.percent_of_balance_fee.$error.pattern">Enter Numeric Percentage Only!</span>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<label for="maximum_balance_fee"
													       class="col-xs-24 control-label">
														Balance Transfer Fee - Maximum Fee <i data-toggle="tooltip" data-placement="top" title="If there is no cap or maximum fee, leave at $0." class="fa fa-question-circle"></i>
													</label>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<div class="form-group">
														<div class="input-group">
															<div class="input-group-addon">$</div>
															<input type="text"
															       class="form-control"
															       name="maximum_balance_fee"
															       id="maximum_balance_fee"
															       placeholder="No Maximum"
															       ng-model="maximum_balance_fee"
															       ng-model-options="{updateOn: 'blur'}"
															       ng-required="true"
															       ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
															       select-on-click>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xs-24">
													<div class="custom-error text-center"
													     ng-show="balanceTransferForm.$submitted || balanceTransferForm.maximum_balance_fee.$touched">
													<span class="angular_error alert-danger"
													      ng-show="balanceTransferForm.maximum_balance_fee.$error.pattern">Enter Numeric Value Only!</span>
													</div>
												</div>
											</div>

											<br>

											<div class="row">
												<div class='col-xs-24 text-center'>
													<button type="submit" id="calculate_button"
													        class="btn btn-success btn-block calculator_green_button"
													        ng-click="calculate()">Calculate
													</button>
												</div>
											</div>
											<!--form-group-->
										</form>
									</div>
									<!--input-->

									<div class="tab-pane" id="result">
										<div class="row">
											<div ng-show="doIt" class="col-xs-24">
												<p>By transferring your balance and paying <strong>{{monthlyPayment}} per month</strong>, you will take <strong>{{monthsToPayoff}} months to pay off the balance</strong>.
													You will save <strong>{{totalRegularSavings}}</strong> in interest, net of fees of
													<strong>{{totalFees}}</strong>.
												</p>

												<div class="col-xs-24">
														<h5 class="save_money text-center">Save Money</h5>
														<hr class="save_money_line">
												</div>
												<p>If you would like to pay off your balances during the promotional period, we recommend that you pay <strong>{{promoPayments}} per month</strong> for a period of <strong>{{intro_term}}</strong> months.
													By doing so, <strong>you will save {{totalIntroSavings}}</strong>, net of fees of <strong>{{totalFees}}</strong> </p>

											</div>

											<div ng-show="!doIt && monthsToPayoff < 1000 " class="col-xs-24">

												<p>By transferring your balance and paying <strong>{{monthlyPayment}} per month</strong>, you will take <strong>{{monthsToPayoff}} months to pay off the balance</strong>.
													You will save <strong>{{totalRegularSavings}}</strong> in interest, net of fees of
													<strong>{{totalFees}}</strong>.
												</p>

												<p>If you would like to pay off your balances during the promotional period, you must pay <strong>{{promoPayments}} per month</strong> for a period of <strong>{{intro_term}}</strong> months.
													By doing so, <strong>you will save {{totalIntroSavings}}</strong>, net of fees of <strong>{{totalFees}}</strong> </p>

											</div>

											<div ng-show="!doIt && monthsToPayoff > 1000 " class="col-xs-24">

												<p>By transferring your balance and paying <strong>{{monthlyPayment}} per month</strong>, you will <strong>never pay off the balance</strong>.
													We recommend <strong>increasing your monthly payments</strong> on the previous form to a more appropriate amount. </p>

												<div class="col-xs-24">
														<h5 class="save_money text-center">Save Money</h5>
														<hr class="save_money_line">
												</div>
												<p>If you would like to pay off your balances during the promotional period, you must pay <strong>{{promoPayments}} per month</strong> for a period of <strong>{{intro_term}}</strong> months.
													By doing so, <strong>you will save an inestimable amount</strong>, net of fees of <strong>{{totalFees}}</strong> </p>

											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-xs-24">
												<button class="btn btn-success btn-block calculator_green_button"
												        onclick="window.location = 'http://www.creditcards.com/balance-transfer.php'">
													Find a Balance Transfer Card Now!
												</button>
											</div>
										</div>
									</div>
									<!--result-->

									<div class="tab-pane" id="graph">
										<div id="high_chart"></div>
									</div>
									<!--graph-->

									<div class="tab-pane" id="about">
										<div class="row">
											<div class="col-xs-24">
												<p>This calculator calculates the amount of interest you'll save by
													transferring existing
													balances to a lower rate card. It factors in the fees often
													associated with transferring
													balances. Be sure to read the fine print of any balance transfer
													offer.</p>

												<p>Note that the savings shown are based on the difference in total
													compound interest charges
													between the higher APR cards you entered and the lower promotional
													balance transfer APR,
													net of transfer fess. Your actual savings may be different based on
													your purchase and
													payment activity and other fees.</p>
											</div>
										</div>
									</div>
									<!--about-->
								</div>
								<!--tab-content-->
							</div>
							<!--column-->
						</div>
						<!--row-->


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
							<li><a href="/calculators/minimum-payment.php">The true cost of paying the minimum</a>
							</li>
							<li><a href="/calculators/payoff.php">What will it take to pay off my current
									balance?</a>
							</li>
							<li><a href="/calculators/cash-back-or-low-interest.php">Which is better: Cash Back or
									Low
									Interest Card?</a></li>
							<li><a href="/calculators/airlines-or-low-interest.php">Which is better: Airlines or Low
									Interest Card?</a></li>
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
							<p>This calculator calculates the amount of interest you'll save by transferring
								existing
								balances to a lower rate card.&nbsp; It factors in the fees often associated with
								transferring balances.&nbsp; Be sure to read the fine print of any balance transfer
								offer.</p>

							<p>Note that the savings shown are based on the difference in total compound interest
								charges
								between the higher APR cards you entered and the lower promotional balance transfer
								APR,
								net of transfer fees.&nbsp; Your actual savings may be different based on your
								purchase
								and payment activity and other fees.</p>

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
$pageName = $channel.':calculators:balance-transfer';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:calculators';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'balance-transfer';
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
	$pageName = $channel.':calculators:balance transfer';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

<script src="/javascript/highstock/highstock.js"></script>
<script src="/javascript/angular.min.js"></script>
<script src="/javascript/calculators/global.js"></script>
<script src="/javascript/calculators/Calculator.js"></script>
<script src="/javascript/calculators/BalanceTransferCalculator.js"></script>
<script src="/javascript/calculators/BalanceTransferController.js"></script>

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
