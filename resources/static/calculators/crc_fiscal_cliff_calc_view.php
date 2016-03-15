<?php

/*
 * File: crc_fiscal_cliff_calc_view.php
 * Description: This is included in crc_fiscal_cliff_calc.php to present the view of the CreditCards.com Fiscal Cliff Calculator
 *          by: M D Green
 *              1 November 2012
 *       Email: mike.green@saesolved.com
 *         Web: http://www.saesolved.com
 *
 * Calculator created by SaeSolved::™ LLC for CreditCards.com. All Rights Reserved. Copyright (C) 2012 CreditCards.com. All Rights Reserved. 
 * This calculator is provided in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE. CreditCards.com may be contacted at webmaster@creditcards.com. SaeSolved::™ LLC may be contacted at webmaster@saesolved.com.
 *
 */

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
	<meta name="copyright" content="&reg; 2012 CreditCards.com" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   	<title>Fiscal Cliff Calculator</title>
    <link rel="stylesheet" href="http://www.creditcards.com/css/credit-cards.css" type="text/css" />
	<style type="text/css">
		/* Styles specifically for this calculator */
		body {
			background: #ffffff none;
		}
		.crc_container {
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
		.input-block {
			float: left;
			width: 260px; 
		}
		.output-block {
			float: left;
			width: 26px; 
		}
		.input-table {
			margin: 0px 0px 0px 0px; 
			width: 230px; 
			border: 0; 
			padding: 6px; 
			border-spacing: 0;
		}
		.output-table {
			margin: 10px 0px 0px 20px; 
			width: 250px; 
			border: 0; 
			padding: 6px; 
			border-spacing: 0;
		}
		.assumptions {
			clear: both; 
			font-size: 10px;
			border-top: 1px solid #999999;
		}
		.credit-and-caveat {
			font-size: 8px;
			margin-top: 10px;
			padding: 5px;
			color: #000000;
			background-color: #dddddd;
		}
	</style>
</head>
<body>
<table width="100%"><tr><td><h2>Fiscal cliff calculator</h2></td><td align="center"><img src="/credit-card-news/images/ccdc_logo_wet-sm.jpg"></td></tr></table>
	<div class="crc_container">							
		<form method="post" action="" name="crc_calc">
		<div class="input-block">INCOME: $<input type="text" name="gross_income" value="$gross_income" style="width: 100px;" /><br />
			Exemptions: <select style="margin-top: 10px;" name="exemptions">
EOT0;
	for ($i = 0; $i < 7 ; $i++) {
		echo "<option value=\"$i\"";
		if ($this->exemptions == $i) {
			echo ' selected="selected"';
		}
		echo ">$i</option>";
	}
	echo <<<EOT1
			</select>
			<br />(One each for self, spouse, dependents)<br />	
			<table class="input-table">
				<tbody>
					<tr>
						<td colspan="2" style="text-align: left;">Filing status:</td>
					</tr>
					<tr>
						<td>(Select one)</td><td><input type="radio" name="filing_status" value="single" 
EOT1;
		echo ("single" == $this->filing_status ? 'checked="checked"' : '');
		echo <<<EOT2
 />Single<br /></td>	
					</tr>
					<tr>
						<td>&nbsp;</td><td><input type="radio" name="filing_status" value="married_filing_jointly" 
EOT2;
		echo ("married_filing_jointly" == $this->filing_status ? 'checked="checked"' : '');
		echo <<<EOT3
 />Married filing jointly</td>		
					</tr>
						<tr>
							<td>&nbsp;</td><td><input type="radio" name="filing_status" value="head_of_household" 
EOT3;
		echo ("head_of_household" == $this->filing_status ? 'checked="checked"' : '');
		echo <<<EOT4
 />Head of household</td>	
					</tr>
				</tbody>
			</table>
		</div>
		<div class="output-block">
			<table class="output-table">
				<tbody>
					<tr>
						<td>&nbsp;</td><td colspan="2" style="text-align: center;">TAXES</td>
					</tr>
					<tr>
						<td>&nbsp;</td><td style="text-align: right;">Current law</td><td style="text-align: right;">&quot;Fiscal cliff&quot;</td>
					</tr>
					<tr>
						<td>TOTAL TAXES</td><td style="text-align: right;">\$$current_total_taxes</td><td style="text-align: right;">\$$fiscal_cliff_total_taxes</td>
					</tr>
					<tr>
						<td>NET INCOME</td><td style="text-align: right;">\$$current_net_income</td><td style="text-align: right;">\$$fiscal_cliff_net_income</td>
					</tr>
					<tr>
						<td>&nbsp;</td><td colspan="2" style="text-align: center;"><input style="margin-top: 10px;" type="submit" name="calc" value="Calculate" /></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="assumptions">							
			Note: For simplicity the calculator assumes standard deductions and excludes effects of other factors such as the child tax credit. Also, this uses only Social Security and Income tax, and excludes Medicare taxes. 
		</div>
		<div class="credit-and-caveat">							
		Calculator created by <a title="Custom-built web applications by SaeSolved::™ LLC" href="http://saesolved.com/" target="_blank">SaeSolved::™ LLC</a> for <a href="http://www.creditcards.com/" target="_top">CreditCards.com</a>. Copyright (C) 2012 CreditCards.com. All Rights Reserved. 
		</div>
		</form>
	</div>
</body>
</html>
EOT4;

?>