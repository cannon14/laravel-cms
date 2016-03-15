<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1290';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - April 03, 2008 - CreditCards.com';
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

			<p><span class="press-release-date">April 03, 2008</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas -- Annual percentage rates for select major  credit card categories mostly fell this week, as Federal Reserve Chairman Ben  Bernanke publicly acknowledged the possibility of a recession for the first  time and jobless claims surged. </p>
			<p>According to the Fed, 57 percent of banks index their  credit card APRs to the prime rate, with most banks adjusting variable rates 30  days or one billing cycle after a change in the prime rate.</p>
			<p>Rates for card categories tracked by CreditCards.com are  listed below:</p>
			<table width="450" border="0" cellpadding="0" cellspacing="10">
			<tr>
			<td colspan="4">
			<u>Credit Card Rate Averages</u>
			</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td>Avg. APR </td>
			<td>Last Week </td>
			<td>6 Month</td>
			</tr>
			<tr>
			<td>Balance Transfer </td>
			<td>9.63%</td>
			<td>9.54%</td>
			<td>11.93%</td>
			</tr>
			<tr>
			<td>Business </td>
			<td>9.77%</td>
			<td>10.37%</td>
			<td>13.52%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>9.94% </td>
			<td>9.94% </td>
			<td>13.61% </td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>10.41% </td>
			<td>10.70% </td>
			<td>11.86% </td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>11.04% </td>
			<td>11.32% </td>
			<td>12.63% </td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>11.42% </td>
			<td>11.68% </td>
			<td>13.77% </td>
			</tr>
			<tr>
			<td>For Bad Credit </td>
			<td>12.49% </td>
			<td>13.02% </td>
			<td>14.12% </td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>12.56% </td>
			<td>12.46% </td>
			<td>15.40% </td>
			</tr>
			<tr>
			<td>Student</td>
			<td>15.11% </td>
			<td>15.19% </td>
			<td>16.80%</td>
			</tr>
			<tr>
			<td colspan="4">
			Source: CreditCards.com
			<br />
			Updated: 04-03-08</td>
			</tr>

			</table>
			</p>

			<p>"It now appears likely that real gross domestic  product (GDP) will not grow much, if at all, over the first half of 2008 and  could even contract slightly," Bernanke said Wednesday in a speech before  Congress, adding that an economic rebound should follow later in the year. </p>
			<p>Bernanke suggested interest rates may not move much further  to the downside. The Fed chief stated that "much necessary economic and  financial adjustment has already taken place," while omitting a prior  commitment to taking action "in a timely manner as needed" to  encourage growth.</p>
			<p>The CreditCards.com credit card rate survey is conducted  weekly using data from the leading U.S. card issuers. Rate movement may also  have been influenced by changes in the composition of offers tracked. </p>
			<p>Introductory offer periods and regular interest rates vary  with applicants' credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card  marketplace connecting consumers with multiple credit card issuers, including  nine of the ten largest in the United States, based on credit card transaction  volume. Through its website, <u><a href="http://www.creditcards.com/">http://www.creditcards.com/</a></u>,  CreditCards.com enables consumers to search for, compare and apply for more  than 150 credit cards and offers credit card issuers an online channel to  acquire qualified applicants.</p>
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
