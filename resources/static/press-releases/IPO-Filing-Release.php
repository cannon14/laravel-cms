<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '911';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com, Inc. Files for Initial Public Offering - CreditCards.com';
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
					<li>CreditCards.com, Inc. Files for Initial Public Offering</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">August 10, 2007</span></p>

			<h1>CreditCards.com, Inc. Files for Initial Public Offering</h1>

			<p>AUSTIN, TEXAS (August 10, 2007) - CreditCards.com, Inc. announced today that it has filed a
			registration statement with the Securities and Exchange Commission relating to a proposed
			initial public offering of its common stock. The shares in the offering will be offered by
			CreditCards.com and certain selling stockholders. The number of shares to be offered and the
			price range for the offering has not been determined.
			</p>
			<p> Credit Suisse Securities (USA) LLC and Citigroup Global Markets, Inc. will act as joint bookrunners
			for the offering and Thomas Weisel Partners LLC will serve as a co-manager. Copies of
			the preliminary prospectus for the offering, when available, may be obtained from Credit Suisse
			Securities (USA) LLC, Prospectus Department, One Madison Avenue, New York, NY 10010.
			</p>
			<p>A registration statement relating to these securities has been filed with the Securities and
			Exchange Commission but has not yet become effective. These securities may not be sold nor
			may offers to buy be accepted prior to the time the registration statement becomes effective.
			This press release shall not constitute an offer to sell or the solicitation of an offer to buy nor
			shall there be any sale of these securities in any state or jurisdiction in which such offer,
			solicitation or sale would be unlawful prior to registration or qualification under the securities
			laws of any such state or jurisdiction.</p>

			<p>About CreditCards.com</p>

			<p>CreditCards.com is a leading online credit card marketplace connecting consumers with multiple
			credit card issuers. Through its website, www.creditcards.com, the company enables
			consumers seeking credit cards to search for, compare and apply for credit cards and offers
			credit card issuers an online channel to acquire qualified applicants.</p>

			Contact:<br>
			CreditCards.com, Austin<br>
			Chris Speltz, 512-996-8663, ext. 123<br>
			Chief Financial Officer<br>
			chris.speltz@creditcards.com</p>

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
