<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '907';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - October 18, 2007 - CreditCards.com';
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

			<p><span class="press-release-date">October 18, 2007</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas &ndash; Credit card interest rates largely declined this week, even as some news reports highlighted certain banks' reluctance to lower rates amid higher costs for loan delinquencies. Data on consumer prices and results of the Federal Reserve's &quot;beige book&quot; survey suggest a mixed likelihood of further loosening to monetary policy. </p>
			<p>A majority of banks index their credit card annual percentage rates (APRs) to the prime rate. According to the Fed, 54% of card issuers tie card interest rates to prime, with most banks adjusting variable rates 30 days or one billing cycle after a change in the prime rate. </p>
			<p>Among the popular credit card categories tracked by CreditCards.com, airline and student cards had the highest APRs. </p>
			<p>Rates for card categories tracked by CreditCards.com are listed below:</p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td height="26" colspan="2">
			<u>Credit Card Rate Averages</u>							</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>11.92%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>11.75%</td>
			</tr>
			<tr>
			<td>Bad Credit</td>
			<td>13.24%</td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>12.51%</td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>13.65%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>13.90%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>13.41%</td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>15.38%</td>
			</tr>
			<tr>
			<td>Student</td>
			<td>16.89%</td>
			</tr>
			<tr>
			<td colspan="2">
			Source: CreditCards.com
			<br />
			Updated: 10-18-07
			</td>
			</tr>
			</table>
			</p>
			<p>Consumer prices outpaced estimates in September on gains in food and energy costs, but when prices for these volatile items were discounted, the advance was near the high end of the central bank's assumed comfort zone. Meanwhile, the beige book survey of economic activity for September and early October indicated that the pace of economic expansion slowed from August.</p>

			<p>The central bank will need to weigh the danger of an economic slowdown against the risk posed by inflationary pressures when it meets at the end of this month. </p>

			<p>The CreditCards.com credit card rate survey is conducted each week using data from the leading card issuers in the United States. </p>
			<p>Introductory offer periods and actual regular interest rates can vary depending on applicants&rsquo; credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card marketplace connecting consumers with multiple credit card issuers, including nine of the ten largest in the United States, based on credit card transaction volume. Through its website, <a href="http://www.creditcards.com/" target="_blank">http://www.creditcards.com/</a>, CreditCards.com enables consumers to search for, compare and apply for more than 150 credit cards and offers credit card issuers an online channel to acquire qualified applicants.</p>
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
