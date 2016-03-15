<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1280';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com: Weekly Credit Card Rate Report - March 06, 2008 - CreditCards.com';
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

			<p><span class="press-release-date">March 06, 2008</span></p>

			<h1>CreditCards.com: Weekly Credit Card Rate Report</h1>

			<p>Austin, Texas - Annual percentage rates for select major  credit card categories fell this week, as the Federal Reserve appears ready to  offer another sharp rate cut when it meets on March 18. Meanwhile, retail data  suggested that consumers continued to use their credit cards in February. </p>
			<p>A majority of banks index their credit card APRs to the  prime rate, which moves in lock step with Fed decisions. According to the Fed,  54 percent of issuers tie card interest rates to prime, with most banks  adjusting variable rates 30 days or one billing cycle after a change in the  prime rate.</p>
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
			<td>Balance Transfer</td>
			<td>9.71%</td>
			<td>9.85%</td>
			<td>11.73%</td>
			</tr>
			<tr>
			<td>Business</td>
			<td>10.50%</td>
			<td>10.85%</td>
			<td>13.99%</td>
			</tr>
			<tr>
			<td>Instant Approval</td>
			<td>10.65% </td>
			<td>11.23% </td>
			<td>13.95% </td>
			</tr>
			<tr>
			<td>Low Interest</td>
			<td>10.80% </td>
			<td>10.91% </td>
			<td>11.62% </td>
			</tr>
			<tr>
			<td>Cash Back</td>
			<td>11.44% </td>
			<td>11.68% </td>
			<td>12.36% </td>
			</tr>
			<tr>
			<td>Reward</td>
			<td>11.76% </td>
			<td>11.99% </td>
			<td>13.54% </td>
			</tr>
			<tr>
			<td>For Bad Credit</td>
			<td>13.02% </td>
			<td>13.02% </td>
			<td>12.80% </td>
			</tr>
			<tr>
			<td>Airline</td>
			<td>13.14% </td>
			<td>12.80% </td>
			<td>15.28% </td>
			</tr>
			<tr>
			<td>Student</td>
			<td>15.57% </td>
			<td>15.69% </td>
			<td>17.55%</td>
			</tr>
			<tr>
			<td colspan="4">
			Source: CreditCards.com
			<br />
			Updated: 03-06-08</td>
			</tr>

			</table>
			</p>
			<p>The central bank is expected to cut rates again after  economic data released this week suggested mild contraction in the services  sector, while the Fed's beige book report noted that economic activity was  "softening or weakening" in eight of its 12 districts alongside  "subdued, slow, or modest growth" in the other four districts. </p>
			<p>Separately, a majority of retailers posted same-store  sales results that topped modest expectations in February. </p>
			<p>The CreditCards.com credit card rate survey is conducted  weekly using data from the leading U.S. card issuers. Rate movement may also  have been influenced by changes in the composition of offers tracked. </p>
			<p>Introductory offer periods and regular interest rates vary  with applicants' credit quality and issuer risk-based pricing policies.</p>
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
