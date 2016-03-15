<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '911';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Provides Credit Card Search Engine to NASDAQ.com - CreditCards.com';
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
					<li>CreditCards.com Provides Credit Card Search Engine to NASDAQ.com</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">June 4, 2007</span></p>

			<h1>CreditCards.com Provides Credit Card Search Engine to NASDAQ.com</h1>

			<p>
				AUSTIN, Texas--(BUSINESS WIRE)--CreditCards.com announced today an agreement with NASDAQ.com that will provide NASDAQ.com visitors with online access to a wide range of attractive credit card offers, updated daily, from CreditCards.com partners.
			</p>
			<p>
				Under the agreement, a rate module placed on the NASDAQ.com site will serve as an entryway into the CreditCards.com search engine, where consumers may compare and apply for credit cards from leading issuers in categories such as low-interest, balance transfer and airline cards.
			</p>
			<p>
				"Consumers are increasingly relying on the Internet as a primary source when they are researching credit card offers," said Elisabeth DeMarse, CEO of CreditCards.com. "Our new agreement with NASDAQ.com takes advantage of that trend by providing consumers with the tools they need to make better-informed credit card decisions."
			</p>
			<p>
				The CreditCards.com rate module and credit card search engine are currently live on the NASDAQ.com website. Site visitors can gain access by simply clicking on the module that will be located in various locations on NASDAQ.com.
			</p>
			<p>
				NASDAQ.com is the website of NASDAQ, the largest U.S. electronic equity stock market. With approximately 3,200 companies, it lists more companies and, on average, trades more shares per day than any other U.S. market.
			</p>
			<p>
				About CreditCards.com
			</p>
			<p>
				CreditCards.com is the leading online credit card marketplace, bringing consumers and credit card issuers together. At its free website, www.creditcards.com, consumers can compare hundreds of credit card offers from the nation's leading issuers and banks, and apply securely online. CreditCards.com is also a destination site for consumers wanting to learn more about credit cards; offering news, advice, features, statistics and tools all designed to help consumers make smart choices about credit cards.
			</p>

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
				<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">
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
