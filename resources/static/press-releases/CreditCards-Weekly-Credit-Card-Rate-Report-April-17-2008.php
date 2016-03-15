<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1299';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - April 17, 2008 - CreditCards.com';
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

			<p><span class="press-release-date">April 17, 2008</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Annual percentage rates for select major  credit card categories trended upward this week amid increasingly bleak economic  news. </p>
			<p>The Federal Reserve's Beige Book -- a compilation of  anecdotal economic reports from across the country -- reported that consumers  spending is "softening across most of the country." Consumer spending  is the largest single component of the American economy.</p>
			<p>In addition to the bad news from the Fed, the  Commerce Department reported that the already-battered housing industry got  worse, with housing starts falling to the lowest level since the recession of  the early '90s. </p>
			<p>Rates for card categories tracked by CreditCards.com are  listed below:</p>
			<table width="450" border="0" cellpadding="0" cellspacing="10">
			<tr>
			<td colspan="4">
			<u>Credit Card Rate Averages</u>							</td>
			</tr>
			<tr>
			<td>&nbsp;</td>
			<td>Avg. APR </td>
			<td>Last Week </td>
			<td>6 Month</td>
			</tr>
			<tr>
			<td>Balance Transfer </td>
			<td>9.74%</td>
			<td>9.64%</td>
			<td>11.93%</td>
			</tr>
			<tr>
			<td>Business </td>
			<td>9.93%</td>
			<td>9.77%</td>
			<td>13.90%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>9.94% </td>
			<td>9.94% </td>
			<td>13.61% </td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>10.60% </td>
			<td>10.49% </td>
			<td>11.97% </td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>11.18% </td>
			<td>11.96% </td>
			<td>12.85% </td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>11.43% </td>
			<td>11.39% </td>
			<td>13.70% </td>
			</tr>
			<tr>
			<td>For Bad Credit </td>
			<td>12.47% </td>
			<td>12.49% </td>
			<td>14.12% </td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>12.49% </td>
			<td>12.56% </td>
			<td>15.50% </td>
			</tr>
			<tr>
			<td>Student</td>
			<td>15.00% </td>
			<td>15.00% </td>
			<td>16.89%</td>
			</tr>
			<tr>
			<td colspan="4">
			Source: CreditCards.com
			<br />
			Updated: 04-17-08</td>
			</tr>

			</table>
			</p>

			<p>Of the nine credit card categories tracked, five were  higher, two were lower and two were unchanged. Rates can move because of  changes in the prime rate prompted by interest rate changes by the Federal  Reserve, or by policy changes by issuing institutions.</p>
			<p>The CreditCards.com credit card rate survey is conducted  weekly using data from the leading U.S. card issuers. The reported rate  movements may also have been influenced by changes in the composition of offers  tracked. </p>
			<p>Introductory offer periods and regular interest rates vary  with applicants' credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card  marketplace connecting consumers with multiple credit card issuers, including  nine of the 10 largest in the United States, based on credit card transaction  volume. Through its Web site, <u><a href="http://www.creditcards.com/">http://www.creditcards.com/</a></u>,  CreditCards.com enables consumers to search for, compare and apply for more  than 150 credit cards and offers credit card issuers an online channel to  acquire qualified applicants.</p>
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
