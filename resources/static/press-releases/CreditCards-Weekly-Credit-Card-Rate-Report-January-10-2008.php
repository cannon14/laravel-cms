<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1141';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - January 10, 2008 - CreditCards.com';
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

			<p><span class="press-release-date">January 10, 2008</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Interest rates for select major credit  card categories declined this week, as Federal Reserve Chairman Bernanke  indicated economic sluggishness now poses a greater threat than inflationary  pressures. The Fed chief's remarks suggest the central bank will lower interest  rates by a half-percentage point at its Jan. 29-30 meeting. </p>
			<p>A majority of banks index their credit card annual  percentage rates (APRs) to the prime rate, which moves in lock step with Fed  decisions. According to the Fed, 54 percent of issuers tie card interest rates  to prime, with most banks adjusting variable rates 30 days or one billing cycle  after a change in the prime rate. </p>
			<p>Rates for card categories tracked by CreditCards.com are listed below:</p>
			<table cellpadding="0" cellspacing="10" border="0">
			<tr>
			<td colspan="2">
			<u>Credit Card Rate Averages</u>
			</td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>11.01%</td>
			</tr>
			<tr>
			<td>Balance Transfer</td>
			<td>10.37%</td>
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
			<td>11.86%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>10.83%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>11.57%</td>
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
			Updated: 01-10-08
			</td>
			</tr>
			</table>
			</p>
			<p>Some of this week's rates decline may stem from a change  to the way CreditCards.com calculates APRs. </p>

			<p>In a speech Thursday, Bernanke acknowledged that with  "more pronounced" economic risks, "additional policy easing may  well be necessary." </p>
			<p>Bernanke's comments followed the release of a December  jobs report showing unemployment at its highest level in more than two years.  Although job uncertainty poses a threat to consumer spending, Fed statistics released  Tuesday showed revolving credit -- largely comprised of credit card debt --  posted the biggest gain in six months during November.</p>
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
