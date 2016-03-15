<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1147';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Provides Credit Card Search Engine to Internet Broadcasting Web Sites - CreditCards.com';
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
					<li>CreditCards.com Provides Credit Card Search Engine to Internet Broadcasting Web Sites</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">August 14, 2007</span></p>

			<h1>CreditCards.com Provides Credit Card Search Engine to Internet<br>Broadcasting Web Sites</h1>

			<p>AUSTIN, TX, August 14, 2007 (BUSINESSWIRE) - CreditCards.com announced today
			an agreement to provide its credit card search engine and consumer-oriented news
			features to Internet Broadcasting, the nation's largest publisher of TV station Web sites.
			The search engine, containing hundreds of card offers updated daily, will provide
			Internet Broadcasting's broadcast partner Web sites with a means to compare credit
			cards in order to obtain the best deal.</p>
			<p>Under the agreement, a CreditCards.com rate table with the average rates for major
			credit card categories will be placed on various Internet Broadcasting partner Web sites.
			Site visitors will gain access to the card search engine by clicking the rate table. The
			search engine will be bolstered by CreditCards.com news features designed to help
			consumers make informed choices about their card usage.</p>
			<p>"One of our key objectives is always to help consumers obtain the card that best suits
			their needs," said Elisabeth DeMarse, CEO of CreditCards.com. "We are pleased to
			bring our personal finance tools and coverage to important TV station Web sites in
			partnership with Internet Broadcasting."</p>
			<p>"We take great pride in providing our Web site viewers with locally relevant news and
			information that affects their daily lives," said Erik Greenberger, business development
			director for Internet Broadcasting. "This relationship with CreditCards.com enables us to
			provide our site visitors with the necessary tools and information to make informed
			decisions about which credit card offers - or cards - make the most sense for them."</p>
			<p>The CreditCards.com rate tables, search engine access, and news features have
			already begun to appear in the business sections and related areas of various Internet
			Broadcasting partner Web sites.</p>
			<p>  <strong>About CreditCards.com</strong></p>
			<p>CreditCards.com is a leading online credit card marketplace, bringing consumers and
			credit card issuers together. At its free website, www.creditcards.com, consumers can
			compare hundreds of credit card offers from the nation's leading issuers and banks, and
			apply securely online. CreditCards.com is also a destination site for consumers wanting
			to learn more about credit cards; offering advice, news, features, statistics and tools - all
			designed to help consumers make smart choices about credit cards. In 2006, over 12
			million unique visitors used CreditCards.com to search for their next credit card.</p>
			<p> <strong>About Internet Broadcasting</strong></p>
			<p> Established in 1996, Internet Broadcasting is the nation's largest publisher of local news
			online. The Company publishes more than 70 TV station Web sites as part of partnerships with Hearst-Argyle Television, Post-Newsweek Stations, McGraw-Hill
			Broadcasting, NBC, Cox Television, and Meredith Broadcasting. The Company also has
			a strategic advertising and content alliance with CNN.com. Advertising sales
			opportunities are available on a market-by-market, regional, or national basis across its
			advertising network. Internet Broadcasting is headquartered in Minneapolis-St. Paul with
			offices in New York, Chicago, San Francisco, and Atlanta. For more information, visit
			www.ibsys.com.
			</p>
			<div style="text-align: center;">###</div>


			<p>
				Contact:
				<br>
				CreditCards.com, Austin
				<br>
				Ben Woolsey, 512-996-8663, ext. 106
				<br>
				Director of Marketing
				<br>
				<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">
			</p>
			<p>
				Internet Broadcasting<br>
				Dan Endy, 651-365-4098<br>
				Communications Manager<br>
				dendy@ibsys.com
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
