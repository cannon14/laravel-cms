<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "297";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html ng-app="CalculatorApplication">
<head>
<?php

$htmlTitle = 'Which is better: Airlines or Low Interest Card? - CreditCards.com';
$metaKeywords = 'Advanta, American Express, Bank of America, BankOne, Chase Manhattan Bank, Citibank, Discover Bank, First Premier Bank, Featured Partners';
$metaDescription = 'Use the calculator below to find out which is better: an Airline credit card or Low Interest credit card.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link href="/css/cc-misc.css" rel="stylesheet">
<link href="/css/calculators.css" rel="stylesheet">

</head>

<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Other Block -->
<div class="other-block">
	<div class="container">
		<div class="row">
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="http://www.creditcards.com/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/credit-card-tools/">Tools</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/calculators/">Calculators</a> <i class="fa fa-angle-right"></i></li>
					<li>Which is better: Airlines or Low Interest Card?</li>
				</ol>
			</div>
			<br />
			<h1>Airlines or Low Interest Card</h1>
			<br />
			<div class="row">
				<div class="col-sm-16 col-md-16">
					<div class="cal-hldr" ng-controller="AirlineLowInterestController">

						<div class="row">
							<div class="subtitle col-sm-16 col-md-16">Which is better: Airlines or Low
								Interest Card?</div>
						</div>

						<div class="row">
							<div class="col-sm-16 col-md-16">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#input">Input</a></li>
									<li class="diabled"><a href="#result" id="resultTab">Result</a></li>
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
												  ng-show="comparisonForm.principal.$error.pattern">Enter Dollar Amounts Only!</span>
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
																 ng-show="comparisonForm.$submitted || comparisonForm.years.$touched">
																<span class="alert-danger" ng-show="comparisonForm.years.$error.required">Years Required!</span>
																<span class="alert-danger" ng-show="comparisonForm.years.$error.pattern">Enter Numeric Value Only!</span>
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
																<span class="alert-danger" ng-show="comparisonForm.charges.$error.required">Monthly Charges Required!</span>
																<span class="alert-danger" ng-show="comparisonForm.charges.$error.pattern">Enter Numeric Value Only!</span>
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
													  ng-show="comparisonForm.payment.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-offset-12 col-xs-6 text-center"><strong>Airlines</strong></div>
														<div class="col-xs-6 text-center"><strong>Low Interest</strong></div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="airline_intro_rate" class="col-xs-12 control-label">
																Introductory interest rate:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_rate"
																	   id="airline_intro_rate"
																	   placeholder="0.0"
																	   ng-model="airline_intro_rate"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_rate"
																	   id="low_interest_intro_rate"
																	   placeholder="0.0"
																	   ng-model="low_interest_intro_rate"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.intro_rate.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_rate.$error.required">Introductory Interest Rate Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_rate.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="airline_intro_term" class="col-xs-12 control-label">
																Introductory term (months):
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_term"
																	   id="airline_intro_term"
																	   placeholder="0"
																	   ng-model="airline_intro_term"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_term"
																	   id="low_interest_intro_term"
																	   placeholder="0"
																	   ng-model="low_interest_intro_term"
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
													  ng-show="comparisonForm.intro_term.$error.required">Introductory Term Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_term.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">

														<div class="row">
															<label for="airline_regular_rate" class="col-xs-12 control-label">
																Regular Interest Rate (APR):
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="regular_rate"
																	   id="airline_regular_rate"
																	   placeholder="0.0"
																	   ng-model="airline_regular_rate"
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
													  ng-show="comparisonForm.regular_rate.$error.required">Introductory Term Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.regular_rate.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="airline_intro_annual_fee"
																   class="col-xs-12 control-label">
																Introductory Annual Fee:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_annual_fee"
																	   id="airline_intro_annual_fee"
																	   placeholder="0.00"
																	   ng-model="airline_intro_annual_fee"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="intro_annual_fee"
																	   id="low_interest_intro_annual_fee"
																	   placeholder="0.00"
																	   ng-model="low_interest_intro_annual_fee"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.intro_annual_fee.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_annual_fee.$error.required">Introductory Annual Fee Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.intro_annual_fee.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="airline_regular_annual_fee"
																   class="col-xs-12 control-label">
																Regular Annual Fee:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="regular_annual_fee"
																	   id="airline_regular_annual_fee"
																	   placeholder="0.00"
																	   ng-model="airline_regular_annual_fee"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="regular_annual_fee"
																	   id="low_interest_regular_annual_fee"
																	   placeholder="0.00"
																	   ng-model="low_interest_regular_annual_fee"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.regular_annual_fee.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.regular_annual_fee.$error.required">Regular Annual Fee Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.regular_annual_fee.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="miles_per_dollar" class="col-xs-12 control-label">
																Miles earned per dollar spent:
															</label>


															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="miles_per_dollar"
																	   id="miles_per_dollar"
																	   placeholder="0"
																	   ng-model="miles_per_dollar"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.miles_per_dollar.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.miles_per_dollar.$error.required">Miles Earned Per Dollar Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.miles_per_dollar.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="miles_to_apply" class="col-xs-12 control-label">
																Miles earned for applying:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="miles_to_apply"
																	   id="miles_to_apply"
																	   placeholder="0"
																	   ng-model="miles_to_apply"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.miles_to_apply.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.miles_to_apply.$error.required">Miles Earned for Applying Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.miles_to_apply.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="max_yearly_miles" class="col-xs-12 control-label">
																Maximum miles earned yearly:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="max_yearly_miles"
																	   id="max_yearly_miles"
																	   placeholder="0"
																	   ng-model="max_yearly_miles"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.max_yearly_miles.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.max_yearly_miles.$error.required">Maximum Miles Earned Yearly Required!</span>
                                                <span class="alert-danger"
													  ng-show="comparisonForm.max_yearly_miles.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="miles_for_free_ticket"
																   class="col-xs-12 control-label">
																Miles required for 1 free ticket:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="miles_for_free_ticket"
																	   id="miles_for_free_ticket"
																	   placeholder="0"
																	   ng-model="miles_for_free_ticket"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.miles_for_free_ticket.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.miles_for_free_ticket.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<div class="form-group">
														<div class="row">
															<label for="cost_of_ticket" class="col-xs-12 control-label">
																Regular cost of ticket:
															</label>

															<div class="col-xs-6">
																<input type="text"
																	   class="form-control"
																	   name="cost_of_ticket"
																	   id="cost_of_ticket"
																	   placeholder="0.00"
																	   ng-model="cost_of_ticket"
																	   ng-model-options="{updateOn: 'blur'}"
																	   ng-pattern="/^[0-9]+([\,\.][0-9]+)?$/"
																	   select-on-click>

															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-xs-24">
															<div class="custom-error text-center"
																 ng-show="comparisonForm.$submitted || comparisonForm.cost_of_ticket.$touched">
                                                <span class="alert-danger"
													  ng-show="comparisonForm.cost_of_ticket.$error.pattern">Enter Numeric Value Only!</span>
															</div>
														</div>
													</div>

													<br>

													<div class="form-group">
														<div class="row">
															<div class="col-xs-24">
																<button type="submit" id="calculate_button"
																		class="btn btn-success btn-block calculator_green_button"
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
												<table class="table">
													<thead>
													<tr>
														<td></td>
														<td><strong>Airlines</strong></td>
														<td><strong>Low Interest</strong></td>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td><strong>Flight miles earned:</strong></td>
														<td>{{totalMilesEarned}}</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td><strong>Number of tickets earned:</strong></td>
														<td>{{totalTicketsEarned}}</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td><strong>Dollar value of tickets:</strong></td>
														<td>{{totalValueOfTickets}}</td>
														<td>N/A</td>
													</tr>
													<tr>
														<td><strong>Interest and Fees:</strong></td>
														<td>{{cardOneTotalInterestAndFees}}</td>
														<td>{{cardTwoTotalInterestAndFees}}</td>
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
														onclick="window.location = 'http://www.creditcards.com/low-interest.php'">Find a Low
													Interest Card Now!
												</button>
											</div>
										</div>
									</div>

									<div class="tab-pane" id="graph" style="position:relative">
										<div class="row">
											<div class="col-xs-24">
												<div id="high_chart"></div>
											</div>
										</div>

										<div class="row">
											<div class="col-xs-24">
												<p>This graph compares your interest and fees, remaining balance, and value of free tickets
													earned at the end of the {{numOfYears}} year period.</p>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="about">
										<div class="row">
											<div class="col-xs-24">
												<p>Airlines cards let you accumulate frequent flier miles when you make purchases. These
													cards usually have higher annual fees and higher interest rates compared to other Low
													Interest credit cards. If you pay your balance in full each month and owe nothing, the
													free tickets earned using an Airlines card may be advantageous to you.</p>

												<p>This calculator compares the value of an Airlines card and a Low Interest credit card to
													help you determine which card is better for you.</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!--col-xs-24-->
						</div>
						<!--row-->

						<br />

						<div class="cal-fb-other-hldr">
							<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcalculators%2Fminimum-payment.php&amp;layout=standard&amp;show_faces=false&amp;width=500&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:35px;" allowTransparency="true"></iframe>
							<br/>
							<div style="text-align:left;"> Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a> </div>
						</div>
						<br />
					</div>
				</div>
				<div class="col-sm-8 col-md-8">
					<div class="cal-right-rutter">
						<h2>More Calculators</h2>
						<ul class="list-unstyled">
							<li><a href="/calculators/minimum-payment.php">The true cost of paying the minimum</a></li>
							<li><a href="/calculators/payoff.php">What will it take to pay off my current balance?</a></li>
							<li><a href="/calculators/cash-back-or-low-interest.php">Which is better: Cash Back or Low Interest Card?</a></li>
							<li><a href="/calculators/balance-transfer.php">How much could I save by transferring my balances?</a></li>
						</ul>
					</div>
				</div>
			</div>
			<br />
			<br />
			<br />
			<div class="cal-fb-other-hldr">
				<div class="row">
					<div class="col-md-24">
						<div style="font-size:12px;">
							<p>Airlines cards let you accumulate frequent flier miles when you make purchases. These cards usually have higher annual fees and higher interest rates compared to other Low Interest credit cards. If you pay your balance in full each month and owe nothing, the free tickets earned using an Airlines card may be advantageous to you.</p>
							<p>This calculator compares the value of an Airlines card and a Low Interest credit card to help you determine which card is better for you.</p>
							<p>This calculator is intended solely for general information and educational purposes and does not take into account all of the personal, economic and other factors that may be relevant to your decision making. The accuracy of this calculator and its applicability to your personal financial circumstances is not guaranteed or warranted.</p>
						</div>
					</div>
				</div>
			</div>
			<br />
			<br />
			<br />
		</div>
	</div>
</div>
<!-- End of Other Block -->

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>

<?php
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$channel = 'tools';
$pageName = $channel.':calculators:airlines-vs-low-interest';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:calculators';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'airlines-or-low-interest';
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
	$pageName = $channel.':calculators:airlines vs low interest';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

<script src="/javascript/highstock/highstock.js"></script>
<script src="/javascript/angular.min.js"></script>
<script src="/javascript/calculators/global.js"></script>
<script src="/javascript/calculators/Calculator.js"></script>
<script src="/javascript/calculators/ComparisonCalculator.js"></script>
<script src="/javascript/calculators/AirlineLowInterestCalculator.js"></script>
<script src="/javascript/calculators/AirlineLowInterestController.js"></script>

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
