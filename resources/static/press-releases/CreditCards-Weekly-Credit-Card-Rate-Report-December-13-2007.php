<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - December 13, 2007 - CreditCards.com';
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

			<p><span class="press-release-date">December 13, 2007</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Interest rates for select major credit card were  mixed this week, as banks managed to avoid broadly sharing the Federal  Reserve's latest interest rate cut with cardholders.</p>

			<p>A majority of banks index their credit card annual  percentage rates (APRs) to the prime rate, which moves in lock step with Federal  Reserve decisions. According to the Fed, 54 percent of issuers tie card  interest rates to prime, with most banks adjusting variable rates 30 days or  one billing cycle after a change in the prime rate. </p>
			<p>Of the nine card types tracked, four had higher rates this  week, three were lower, and two were unchanged. Rates for card categories  tracked by CreditCards.com are listed below: </p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td height="26" colspan="2">
			<u>Credit Card Rate Averages</u>							</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>11.53%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>11.52%</td>
			</tr>
			<tr>
			<td>Bad Credit</td>
			<td>14.04%</td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>12.81%</td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>13.38%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>13.74%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>13.36%</td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>15.03%</td>
			</tr>
			<tr>
			<td>Student</td>
			<td>17.02%</td>
			</tr>
			<tr>
			<td colspan="2">
			Source: CreditCards.com
			<br />
			Updated: 12-13-07
			</td>
			</tr>
			</table>
			</p>
			<p>On Tuesday, the Fed lowered the federal funds rate a quarter  point to 4.25 percent. In its accompanying statement, the central bank dropped  prior language that called growth and inflation risks essentially balanced,  adding that it will "act as needed to foster price stability and  sustainable economic growth," suggesting more rate cuts could follow. </p>

			<p>Economic data showed that consumers continued to use  plastic. The central bank's October consumer credit numbers showed an 8.3  percent increase in revolving credit, which includes credit cards. Meanwhile,  November retail sales sharply outpaced expectations.</p>
			<p>The CreditCards.com credit card rate survey is conducted weekly  using data from the leading card issuers in the United States. </p>
			<p>Introductory offer periods and regular interest rates can vary  depending on applicants' credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card marketplace  connecting consumers with multiple credit card issuers, including nine of the  ten largest in the United    States, based on credit card transaction  volume. Through its website, <a href="http://www.creditcards.com/">http://www.creditcards.com/</a>,  CreditCards.com enables consumers to search for, compare and apply for more  than 150 credit cards and offers credit card issuers an online channel to  acquire qualified applicants.</p>
			<div style="text-align: center;">###</div>


			<p>For more information, contact:</p>
			<p>
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
