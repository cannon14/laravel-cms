<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1150';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - August 09, 2007 - CreditCards.com';
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

			<p><span class="press-release-date">August 09, 2007</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Credit card interest rates kept their positions this week alongside a Federal Reserve decision to leave monetary policy unchanged. However, certain Fed watchers took changes in language used by the central bank to mean that a lowering of the prime rate could be on the horizon.</p>

			<p>Student credit cards charged the highest annual percentage rates (APRs).</p>

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
			Updated: 08-09-07
			</td>
			</tr>
			</table>
			</p>
			<p>The prime rate matters to credit card holders because a majority of banks base their credit<br>
			card APRs on an index tied to the prime rate. According to the U.S. central bank, 54% of<br>
			credit card issuers tie card interest rates to prime.</p>
			<p>In its monetary policy panel meeting, the Federal Open Market Committee maintained short-term interest rates at 5.25% and reiterated its primary concerns regarding inflation. However, its accompanying statement added that the risk of an economic downturn has "increased somewhat," leading some analysts to speculate that a rate cut could occur if economic weakness materializes.</p>

			<p>Meanwhile, data showing that retailers experienced lackluster same-store sales in July suggests that consumers charged fewer purchases last month</p>

			<p>The CreditCards.com credit card rate survey is conducted each week using data from the leading credit card issuers in the United States.</p>

			<p>Introductory offer periods and actual regular interest rates can vary depending on individual applicants' credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com</p>
			<p>
			CreditCards.com is the leading online credit card marketplace, bringing consumers and
			credit card issuers together. At its free Web site, www.creditcards.com, consumers can
			compare hundreds of credit card offers from the nation's leading issuers and banks, and
			apply securely online. CreditCards.com is also a destination site for consumers wanting
			to learn more about credit cards; offering news, advice, features, statistics and tools - all
			designed to help consumers make smart choices about credit cards.</p>
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
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">				</p>
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
