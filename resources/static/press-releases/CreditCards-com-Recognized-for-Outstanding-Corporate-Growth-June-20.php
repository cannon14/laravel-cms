<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '910';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Recognized for Outstanding Corporate Growth - CreditCards.com';
$metaKeywords = 'creditcards.com, credit cards, credit card, Visa, Mastercard, Discover, American Express, offers, apply online, credit card application, articles';
$metaDescription = 'CreditCards.com is a resource for consumers looking to apply for a credit card online.  Visitors can search our directory of credit cards by company or category. Categories include Visa, MasterCard, American Express, Discover Card, low interest, balance transfer, rewards, cash back, instant approval, airline, small business, student, and bad credit;  website includes access to professional advice & in-depth credit card articles. ';

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
					<li>CreditCards.com Recognized for Outstanding Corporate Growth</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">June 20, 2007</span></p>

			<h1>CreditCards.com Recognized for Outstanding Corporate Growth</h1>

			<p>
				<strong>Company Receives Award From Association for Corporate Growth - Central Texas</strong>
			</p>
			<p>
				AUSTIN, Texas--(BUSINESS WIRE)--CreditCards.com was selected today to receive the Outstanding Corporate Growth and Emerging Company award from the Central Texas Chapter of the Association for Corporate Growth (ACG). The company received the award for businesses with annual revenues in 2006 between $25 million and $100 million.
			</p>
			<p>
				The prestigious award recognizes excellence in sustained corporate growth and financial performance. CreditCards.com, which enables consumers to search, compare and apply for cards online, has experienced over a ten-fold growth in revenue since its startup in 2003.
			</p>
			<p>
				The company, headquartered in Austin, Texas, was originally founded by Austin-based entrepreneur and University of Texas alumnus Dan Smith. "CreditCards.com is an exceptional company due to the hard work and commitment of our outstanding team of employees, some of whom joined us during the company's humble beginnings in my 'garoffice,'" said Smith. "Working as a team, our mission has been to enable and empower consumers to make wise credit choices - using information and tools that make it easy to compare offers side by side. We give thanks for the success we've been granted so far and look forward to being of service to consumers going forward."
			</p>
			<p>
				Elisabeth DeMarse, president and CEO of Creditcards.com, said, "We are honored with this recognition of our past achievements and we are extremely excited about our plans for the future. CreditCards.com is truly committed to delivering value to consumers, to credit card issuers and to business partners. We have a strong team that is aggressively building on Dan's original vision to continue to achieve outstanding results, to perpetually delight our customers and to create a world-class company. We look forward to many more years of outstanding growth."
			</p>
			<p>
				DeMarse added, "There is enormous potential for Americans to take stock of their own personal finance habits and presumptions and transform their credit cards into a powerful tool and ally. We are positioned to help consumers do this by leveraging the power of the Internet."
			</p>
			<p>
				<strong>About CreditCards.com</strong>
			</p>
			<p>
				CreditCards.com is the leading online credit card marketplace, bringing consumers and credit card issuers together. At its free website, www.creditcards.com, consumers can compare hundreds of credit card offers from the nation's leading issuers and banks, and apply securely online. CreditCards.com is also a destination site for consumers wanting to learn more about credit cards; offering news, advice, features, statistics and tools all designed to help consumers make smart choices about credit cards. In 2006, over 11 million unique visitors used CreditCards.com to search for their next credit card.
			</p>
			<p>
				<strong>About ACG International Outstanding Corporate Growth and Emerging Company Awards</strong>
			</p>
			<p>
				The ACG International Outstanding Corporate Growth and Emerging Company awards are longstanding awards made annually. 2006 was the first year that the Central Texas Chapter of ACG participated in this program by hosting an awards ceremony recognizing local companies. The Outstanding Corporate Growth award recognizes companies with remarkable growth and financial performance. CreditCards.com was chosen for the category of companies with annual revenues between $25-100 million. Past International winners across all categories include Johnson Controls, Cisco Systems, Amgen, Bausch & Lomb, Motorola and many other leading American companies. Last year's local winners were Whole Foods Market, Valero Energy, Motion Computing, and Rackspace Managed Hosting.
			</p>

			<div style="text-align: center;">###</div>

			<p>
				Contacts:
				<br />
				<strong>CreditCards.com, Austin</strong>
				<br />
				Elisabeth DeMarse, 917-597-3306
				<br />
				<img src="/images/email_elisabeth_demarse_creditcards.gif" width="208" height="18" border="0" alt="Elisabeth.Demarse@creditcards.com">
			</p>


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
