<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '907';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - November 1, 2007 - CreditCards.com';
$metaKeywords = 'creditcards.com, credit cards, credit card, Visa, Mastercard, Discover, American Express, offers, apply online, credit card application, articles';
$metaDescription = 'CreditCards.com is a resource for consumers looking to apply for a credit card online.  Visitors can search our directory of credit cards by company or category. Categories include Visa, MasterCard, American Express, Discover Card, low interest, balance transfer, rewards, cash back, instant approval, airline, small business, student, and bad credit;  website includes access to professional advice & in-depth credit card articles.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
?>
</head>

<body>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/about-us.php">About Us</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="/about-us/press-releases.php">Press Releases</a> <i class="fa fa-angle-right"></i></li>
					<li>CreditCards.com: Weekly Credit Card Rate Report</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">November 1, 2007</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas &ndash; Select major credit card categories were mixed this week, following the Federal Reserve's decision to cut interest rates for the second time this year. The Fed voted to lower rates by 0.25 percent, but downplayed the likelihood of further monetary policy easing. </p>
			<p>The addition of several card products to CreditCards.com may have accounted for some of the annual percentage rate (APR) movement. </p>
			<p>A majority of banks index their credit card APRs to the prime rate, which moves in lock step with Fed decisions. According to the Fed, 54 percent of issuers tie card interest rates to prime, with most banks adjusting variable rates 30 days or one billing cycle after a change in the prime rate. </p>
			<p>Among the popular credit card categories tracked by CreditCards.com, student cards had the highest APRs. </p>
			<p>Rates for card categories tracked by CreditCards.com are listed below:</p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td height="26" colspan="2">
			<u>Credit Card Rate Averages</u>							</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>11.63%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>11.68%</td>
			</tr>
			<tr>
			<td>Bad Credit</td>
			<td>13.64%</td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>12.64%</td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>13.49%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>13.80%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>13.45%</td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>15.20%</td>
			</tr>
			<tr>
			<td>Student</td>
			<td>16.83%</td>
			</tr>
			<tr>
			<td colspan="2">
			Source: CreditCards.com
			<br />
			Updated: 11-01-07
			</td>
			</tr>
			</table>
			</p>
			<p>The central bank's decision to lower rates is unlikely to produce an immediate change in APRs or to put significant cash back into consumers' wallets. Variable rate cards could see an adjustment up to 90 days after a Fed decision. For a cardholder with a $5,000 balance and a 17.5% interest rate, a quarter-point rate reduction to 17.25% would amount to just over $1 in monthly savings. </p>

			<p>The CreditCards.com credit card rate survey is conducted weekly using data from the leading card issuers in the United States. </p>
			<p>Introductory offer periods and regular interest rates can vary depending on applicants&rsquo; credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card marketplace connecting consumers with multiple credit card issuers, including nine of the ten largest in the United States, based on credit card transaction volume. Through its website, <a href="http://www.creditcards.com/">http://www.creditcards.com/</a>, CreditCards.com enables consumers to search for, compare and apply for more than 150 credit cards and offers credit card issuers an online channel to acquire qualified applicants. </p>
			<div style="text-align: center;">###</div>


			<p>For more information, contact:</p>
			<p><br />
			Ben Woolsey<br />
			Director of Marketing <br />
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">
			<br>
			512-996-8663, ext. 106 </p>
			<p>NOTE TO EDITORS: The information contained in this release is available for print or
			broadcast with attribution to CreditCards.com.</p>
			<p>Source: CreditCards.com</p>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
?>

</body>
</html>
