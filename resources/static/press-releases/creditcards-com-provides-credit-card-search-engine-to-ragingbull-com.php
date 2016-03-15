<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1144';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Provides Credit Card Search Engine to RagingBull.com - CreditCards.com';
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
					<li>CreditCards.com Provides Credit Card Search Engine to RagingBull.com</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">September 25, 2007</span></p>

			<h1>CreditCards.com Provides Credit Card Search Engine to RagingBull.com</h1>

			<p>AUSTIN, TX,  September 25, 2007 (BUSINESSWIRE) - CreditCards.com announced today an agreement to provide its credit card search engine to RagingBull.com, an online investment community portal and message board site that is part of the eSignal suite of financial and business information products.</p>
			<p>The CreditCards.com search engine, containing credit card offers from over 20 credit card issuers, will provide RagingBull.com visitors the ability to select from among a wide range of credit card types including low-interest, rewards, airline and cash back cards.</p>
			<p>Under the agreement, a CreditCards.com rate table with the average rates for major credit card categories will be placed in various locations on the RagingBull.com site. Visitors to the RagingBull.com Web site will gain access to the CreditCards.com search engine, which is to be updated daily, by clicking on the rate table.</p>
			<p>"CreditCards.com strives to be the foremost destination for consumers who want to make informed decisions about their credit card choices," said Elisabeth DeMarse, CEO of CreditCards.com. "We are pleased to enter a relationship with such a distinguished investment site as RagingBull.com."</p>
			<p>The CreditCards.com rate table and search engine is expected to go live on RagingBull.com in coming weeks.<br>
			</p>
			<p>About CreditCards.com</p>
			<p>CreditCards.com is a leading online credit card marketplace connecting consumers with multiple credit card issuers, including nine of the ten largest in the United States, based on credit card transaction volume. Through its website, www.creditcards.com, CreditCards.com enables consumers to search for, compare and apply for more than 150 credit cards and offers credit card issuers an online channel to acquire qualified applicants.</p>
			<p>About eSignal:<br>
			RagingBull.com is operated by eSignal (www.eSignal.com), Interactive Data's (NYSE: IDC) desktop solutions business. eSignal is a leading global provider of financial and business information to professional and active individuals. Building on a legacy of nearly 25 years of delivering time-sensitive financial information, eSignal provides streaming, real-time market data, news and analytics. eSignal's suite of products includes eSignal&reg;, Advanced GET&reg;, QuoTrek&reg;, FutureSource&reg;, MarketCenter LIVE&trade;, QCharts&reg;, LiveCharts&reg;, Market-QSM and the web portals FutureSource.com, Quote.com&reg; and RagingBull.com.<br>
			</p>
			<div style="text-align: center;">###</div>


			<p>For more information:</p>
			<p>
			CreditCards.com<br>
			Ben Woolsey,<br>
			Director of Marketing<br>
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com"><br>
			512-996-8663, ext. 106


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
