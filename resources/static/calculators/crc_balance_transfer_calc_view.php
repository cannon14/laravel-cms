<?php
/*
 * File: crc_balance_transfer_calc_view.php
 * Description: This is included in crc_balance_transfer_calc.php to present the view of the CreditCards.com Balance Transfer Calculator
 *          by: M D Green
 *              6 January 2015
 *       Email: mike.green@saesolved.com
 *         Web: http://www.saesolved.com
 *
 * Calculator created by SaeSolved::™ LLC for CreditCards.com. All Rights Reserved. Copyright (C) 2015 CreditCards.com. All Rights Reserved. 
 * This calculator is provided in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. CreditCards.com may be contacted at webmaster@creditcards.com. SaeSolved::™ LLC may be contacted at webmaster@saesolved.com.
 *
 */
	if (!$_REQUEST['calc_what']) {
		echo <<<EOT0
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="Robots" content="ALL">
	<meta name="revisit-after" content="10 days" />
	<meta name="resource-type" content="document" />
	<meta name="distribution" content="global" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta name="author" content="Saesolved:: LLC, http://saesolved.com/" />
	<meta name="copyright" content="&reg; 2015 CreditCards.com" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   	<title>Balance Transfer Calculator</title>
    <link rel="stylesheet" href="http://www.creditcards.com/css/credit-cards.css" type="text/css" />
	<style type="text/css">
		/* Styles specifically for this calculator */
		body {
			background: #ffffff none;
		}
		.btc_container {
			background-color: #ffffff;
			padding: 10px;
			width: 540px;
			color: black;
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
			font-style: normal;
			line-height: 17px;
			font-weight: normal;
			font-variant: normal;
			margin: 0;
		}
		.input-table {
			margin: 0px 0px 0px 0px; 
			width: 95%; 
			border: 0; 
			padding: 6px; 
			border-spacing: 0;
		}
		.assumptions {
			clear: both; 
			text-align: left;
			font-weight: bold;
			border-top: 1px solid #999999;
			border-bottom: 1px solid #999999;
			margin-top: 10px;
			padding: 5px 0;
		}
		.credit-and-caveat {
			font-size: 8px;
			margin-top: 10px;
			padding: 5px;
			color: #000000;
			background-color: #dddddd;
		}
	</style>
	<script type="text/javascript">	
		function get_result (addnl_qrystr) {
			var qrystr		= \$( "form" ).serialize();
			var crc_btc_url	= '{$_SERVER['SCRIPT_NAME']}?' + qrystr + '&' + addnl_qrystr;
			\$('.btc_container').load(crc_btc_url);
		}
	</script> 
	</head>
<body>
	<div class="btc_container">
EOT0;
	}
	if ($error_message) {
		echo '<h2 style="color: red; background-color: #ff9; text=align: center; padding: 7px;">'.$error_message.'<h2>';
	}
	echo <<<EOT1
		<h1 style="text-align: center;">Balance Transfer Calculator</h1>
		<div class="assumptions">							
			If you're looking to minimizing the costs of credit card debt, making a balance transfer can save you money on interest, especially if you take advantage of a no-interest promotional offer.
			<br /><br />
			However, that zero-interest rate on your transfer won't last forever. Assuming you don't use the transfer-receiving card for anything else, can you afford to pay down your balance before the promotional transfer APR expires?
			<br /><br />
			Follow this calculator's step-by-step instructions to find out:
			<br /><br />
			<em>Note: This calculator assumes you will be making one transfer of existing credit card debt to a new card with an active 0% interest promotional offer and will not charge anything else to the card before or after making said balance transfer.</em>
		</div>
		<p>
			To determine how much your monthly payments will have to be in order to pay off your desired transfer without paying interest, enter the following:
		</p>
		<div id="btc_core">
			<form method="get" action="" name="btc_calc">
				<table class="input-table">
					<tbody>
						<tr>
							<td>
								Amount to be transferred:
							</td>
							<td style="text-align: right;">
								$
							</td>
							<td style="width: 100px;">
								<input type="text" name="amount_to_be_transferred" value="$amount_to_be_transferred" style="width: 93%;" />
							</td>
							<td>
								&nbsp;
							</td>
						</tr>
						<tr>
							<td>
								Balance transfer fee:
							</td>
							<td>
								&nbsp;
							</td>
							<td style="width: 100px;">
								<input type="text" name="balance_transfer_fee" value="$balance_transfer_fee" style="width: 93%; text-align:right;" />
							</td>
							<td style="text-align: left;">
								%
							</td>
						</tr>
						<tr>
							<td>
								Introductory rate time period:
							</td>
							<td>
								&nbsp;
							</td>
							<td style="width: 100px;">
								<input type="text" name="intro_rate_time_period" value="$intro_rate_time_period" style="width: 93%; text-align:right;" />
							</td>
							<td style="text-align: left;">
								months
							</td>
						</tr>
						<tr>
							<td colspan="4" style="text-align: center;">
								<button type="button" style="margin-top: 10px;" onClick="get_result('calc_what=amount_to_be_paid_each_month')" name="calc">Calculate</button>
							</td>
						</tr>
					</tbody>
				</table>
EOT1;
	if ($amount_to_be_paid_each_month > 0 || $affordable_monthly_payment > 0) {
		echo <<<EOT2
			<br/><b>Amount to be paid each month:&nbsp; \$$amount_to_be_paid_each_month.</b><br/><br/>
			<h2>Can't afford this monthly payment?</h2>
			<p>
				Enter how much you can afford to put towards your balance transfer each month here and the interest rate after the intro period:
			</p>
			<table class="input-table">
				<tbody>
					<tr>
						<td>
							Monthly payment you can afford:
						</td>
						<td style="text-align: right;">
							$
						</td>
						<td style="width: 100px;">
							<input type="text" name="affordable_monthly_payment" value="$affordable_monthly_payment" style="width: 93%;" />
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td>
							Post-introductory balance transfer interest rate:
						</td>
						<td>
							&nbsp;
						</td>
						<td style="width: 100px;">
							<input type="text" name="interest_rate_after_intro" value="$interest_rate_after_intro" style="width: 93%; text-align:right;" />
						</td>
						<td style="text-align: left;">
							%
						</td>
					</tr>
						<tr>
							<td colspan="4" style="text-align: center;">
								<button type="button" style="margin-top: 10px;" onClick="get_result('calc_what=can_be_afforded')" name="calc">Calculate</button>
							</td>
						</tr>
				</tbody>
			</table>
EOT2;
	}
	if ($extra_months_repayment > 0) {
		echo <<<EOT3
			<p>
				Paying only \$$affordable_monthly_payment toward your balance transfer will not get it paid off within the 0% interest rate time period. Making such payments will extend your repayment time by $extra_months_repayment months
EOT3;
		if ($final_payment) {
			echo " (".($extra_months_repayment - 1)." months of paying \$$affordable_monthly_payment and a final payment of \$$final_payment)";
		}
		echo <<<EOT4
				and cost you \$$extra_interest in interest.
			</p>
			<p>
				<b>The total cost of your balance transfer will be: \$$total_cost.</b>
			</p>
			<p style="text-align: center;">
				<button type="button" style="margin-top: 10px;" onClick="get_result('calc_what=start_over'); window.scrollTo(0, 0);" name="calc">Start Over</button>
			</p>
EOT4;
	}
		echo <<<EOT5
			</form>
		</div>
		<div class="credit-and-caveat">							
		Calculator created by <a title="Custom-built web applications and WordPress site implementations by SaeSolved::™ LLC" href="http://saesolved.com/" target="_blank">SaeSolved::™ LLC</a> for <a href="http://www.creditcards.com/" target="_top">CreditCards.com</a>. Copyright (C) 2015 CreditCards.com. All Rights Reserved. This calculator is provided in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
		</div>
		</form>
EOT5;
if (!$_REQUEST['calc_what']) {
	echo "</div>
</body>
</html>";
}
?>