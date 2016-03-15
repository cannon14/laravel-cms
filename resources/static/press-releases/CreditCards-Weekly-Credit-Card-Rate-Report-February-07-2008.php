<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - February 07, 2008 - CreditCards.com';
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

			<p><span class="press-release-date">February 07, 2008</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Annual percentage rates for select major  credit card categories moved in varied directions this week, with some pushed  lower by the Federal Reserve's latest round of interest rate cuts and others  raised by a reaction to a slowdown in consumer credit card use. </p>
			<p>Despite the Fed's half-point rate cut announced Jan. 30,  only five of the nine credit card rates tracked by CreditCards.com fell, while  four moved up. Banks often tie their rates to the prime rate, which moves up  and down with Fed actions, but are not required to. In this period of poor  financial results from banks, many are slow to pass along the Fed rate cuts. </p>
			<p>Rates for card categories tracked by CreditCards.com are  listed below:</p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td colspan="2">
			<u>Credit Card Rate Averages</u>
			</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>10.97%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>10.03%</td>
			</tr>
			<tr>
			<td>Bad Credit</td>
			<td>13.25%</td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>11.46%</td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>11.66%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>10.91%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>10.65%</td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>12.69%</td>
			</tr>
			<tr>
			<td>Student</td>
			<td>15.83%</td>
			</tr>
			<tr>
			<td colspan="2">
			Source: CreditCards.com
			<br />
			Updated: 02-07-08
			</td>
			</tr>
			</table>
			</p>
			<p>Retailers this week posted January sales figures that fell  shot of already-diminished expectations, suggesting more-limited card use by  shoppers. Meanwhile, the Fed's latest report on consumer credit showed  revolving credit, which includes credit cards, increased at an annual rate of  2.7 percent in December, down sharply from the 13.7 percent gain one month  earlier.</p>

			<p>The latest results could add to recession worries. Against  that backdrop, some experts have predicted that the central bank will cut rates  by a further half-percentage point at its March meeting in a further effort to  enliven a dragging U.S. economy. </p>
			<p>The CreditCards.com credit card rate survey is conducted  weekly using data from the leading U.S. card issuers. </p>
			<p>Introductory offer periods and regular interest rates can  vary with applicants' credit quality and issuer risk-based pricing policies.</p>
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
