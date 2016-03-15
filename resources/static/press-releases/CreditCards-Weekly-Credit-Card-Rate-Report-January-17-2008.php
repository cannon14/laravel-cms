<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1161';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - January 17, 2008 - CreditCards.com';
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

			<p><span class="press-release-date">January 17, 2008</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Interest rates for select major credit  card categories were mostly unchanged to higher, as an interest rate cut at the  Federal Reserve's Jan. 29-30 meeting looks increasingly likely. Today, Fed  Chairman Ben Bernanke reiterated a commitment to loosening monetary policy  "as needed." </p>
			<p>A majority of banks index their credit card annual  percentage rates (APRs) to the prime rate, which moves in lock step with Fed  decisions. According to the Fed, 54 percent of issuers tie card interest rates  to prime, with most banks adjusting variable rates 30 days or one billing cycle  after a change in the prime rate. </p>
			<p>Rates for card categories tracked by CreditCards.com are  listed below:</p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td colspan="2">
			<u>Credit Card Rate Averages</u>
			</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>11.04%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>10.40%</td>
			</tr>
			<tr>
			<td>Bad Credit</td>
			<td>13.41%</td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>11.71%</td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>11.78%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>10.83%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>11.62%</td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>13.01%</td>
			</tr>
			<tr>
			<td>Student</td>
			<td>16.46%</td>
			</tr>
			<tr>
			<td colspan="2">
			Source: CreditCards.com
			<br />
			Updated: 01-17-08
			</td>
			</tr>
			</table>
			</p>
			<p>In prepared Congressional testimony endorsing a fiscal  stimulus package, Bernanke echoed his comments from the prior week, saying that  the Fed remains prepared to take "substantive additional action" when  it comes to monetary policy. </p>

			<p>Despite recent warning signs, the Fed's latest Beige Book  economic survey indicated that while growth slowed during the mid-November to  December period, the U.S. did not experience economic contraction. That news  offered some relief from predictions of a looming recession. </p>
			<p>The Fed is also expected to cut rates in spite of data  released yesterday showing that consumer prices rose in December. Tighter  monetary policy can be used to combat inflation. </p>
			<p>The CreditCards.com credit card rate survey is conducted  weekly using data from the leading U.S. card issuers. </p>
			<p>Introductory offer periods and regular interest rates can  vary with applicants' credit quality and issuer risk-based pricing policies.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card  marketplace connecting consumers with multiple credit card issuers, including  nine of the ten largest in the United States, based on credit card transaction  volume. Through its website, <u><a href="http://www.creditcards.com/">http://www.creditcards.com/</a></u>,  CreditCards.com enables consumers to search for, compare and apply for more  than 150 credit cards and offers credit card issuers an online channel to  acquire qualified applicants. </p>
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
