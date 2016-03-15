<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '901';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - May 17, 2007 - CreditCards.com';
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

			<p><span class="press-release-date">May 17, 2007</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>AUSTIN, Texas--(BUSINESS WIRE)--Credit card rates for all popular categories covered by CreditCards.com remained flat this week, reflecting the calm after the Federal Reserve's recent decision to leave the Federal Discount Rate unchanged.
			</p>
			<p>
			Rates for major card categories tracked by CreditCards.com are listed below:
			</p>
			<p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td colspan="2">
			<u>Credit Card Rate Averages</u>
			</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>11.41%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>11.41%</td>
			</tr>
			<tr>
			<td>Bad Credit</td>
			<td>12.81%</td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>13.13%</td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>13.66%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>13.95%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>14.18%</td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>15.08%</td>
			</tr>
			<tr>
			<td>Student</td>
			<td>17.88%</td>
			</tr>
			<tr>
			<td colspan="2">
			Source: CreditCards.com
			<br />
			Updated: 05-17-07
			</td>
			</tr>
			</table>
			</p>
			<p>
			The vast majority of credit cards issued in the United States feature variable rates, indexed to either the Prime Rate or Libor (London Interbank Offered Rate). Credit card rates pegged to one of these benchmarks typically move in lockstep with any changes after a set period of time (typically within 30 days or one billing cycle of an adjustment). Specific terms of such rate adjustments are disclosed in the terms and conditions included with credit card marketing material and card member agreements (as mandated by the Office of the Comptroller of the Currency, which regulates the banking and credit card industry).
			</p>
			<p>
			The CreditCards.com national weekly credit card rate survey is conducted each week using data from the leading credit card issuers in the United States.
			</p>
			<p>
			Introductory offer periods and actual regular interest rates can vary depending on individual applicants' credit quality and issuer risk-based pricing policies.
			</p>
			<p>
			About CreditCards.com
			</p>
			<p>
			CreditCards.com (www.creditcards.com) is an Internet publisher and marketing organization that operates the leading and fastest growing online destination for consumers to search, compare, and apply for credit cards. The company matches millions of consumers each year with the credit card offers that best meet their financial needs. CreditCards.com is based in Austin, Texas and was founded in 2003.
			</p>
			<p>
			NOTE TO EDITORS: The information contained in this release is available for print or broadcast with attribution to CreditCards.com.
			</p>

			<div style="text-align: center;">###</div>


			<p>
			Contact:
			<br />
			CreditCards.com, Austin
			<br />
			Ben Woolsey, 512-996-8663, ext. 106
			<br />
			Director of Marketing
			<br />
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">
			</p>

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
