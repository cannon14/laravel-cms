<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '907';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - September 6, 2007 - CreditCards.com';
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

			<p><span class="press-release-date">September 6, 2007</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Credit card interest rates remained stuck in neutral this week, but for card holders, the upcoming Federal Reserve meeting represents the first chance in months that interest rates on their plastic could fall. </p>

			<p>Since a majority of banks base their credit card annual percentage rates (APRs) on an index tied to the prime rate, a lowering of the prime could result in lessened interest rates for most cardholders. According to the U.S. central bank, 54% of credit card issuers tie card interest rates to prime. </p>
			<p>With schools back in session, student cards charged the highest APRs. </p>
			<p>Rates for card categories tracked by CreditCards.com are listed below:</p>
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
			Updated: 09-06-07
			</td>
			</tr>
			</table>
			</p>
			<p>The Federal Reserve's Open Market Committee meets Sept. 18 to discuss interest rates. The committee indirectly controls a key rate called the federal funds rate, and banks move their prime rates in lock step with the Fed's action.</p>
			<p>The prime rate has remained at 5.25% since June 2006; many analysts expect a rate cut of a half percentage point or a quarter-point. </p>
			<p>Consumers, however, are not waiting for the Fed. Newly released retail sales data for August were robust, indicating that consumers made ample use of their credit cards for back-to-school purchases. </p>
			<p>The CreditCards.com credit card rate survey is conducted each week using data from the leading card issuers in the United States. </p>
			<p>Introductory offer periods and actual regular interest rates can vary depending on applicants' credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card marketplace, bringing consumers and credit card issuers together. At its free Web site, www.creditcards.com, consumers can compare hundreds of credit card offers from the nation's leading issuers and banks, and apply securely online. CreditCards.com is also a destination site for consumers wanting to learn more about credit cards; offering news, advice, features, statistics and tools - all designed to help consumers make smart choices about credit cards.<br>
			</p>
			<div style="text-align: center;">###</div>


			<p>For more information, contact:</p>
			<p>Ben  Woolsey<br>
			Director  of Marketing<br>
			<a href="mailto:benw@creditcards.com">benw@creditcards.com</a><br>
			512-996-8663 x106</p>
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
