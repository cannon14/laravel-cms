<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1148';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Provides Credit Card Search Engine to ShopLocal - CreditCards.com';
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
					<li>CreditCards.com Provides Credit Card Search Engine to ShopLocal</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date"></span></p>

			<h1>CreditCards.com Provides Credit Card Search Engine to ShopLocal</h1>

			<p>AUSTIN, TX, September 25, 2007 (BUSINESSWIRE) - CreditCards.com, Inc. announced today an agreement to provide its credit card search engine to ShopLocal.com, a leading comparison shopping Web site. The CreditCards.com search engine, containing current credit card offers from over 20 credit card issuers, will provide ShopLocal.com visitors the ability to select from among a wide range of credit card types, including low-interest, rewards, airline and cash back cards.</p>
			<p>
			Under the agreement, a CreditCards.com rate table with the average rates for major credit card categories will be placed on ShopLocal.com. Visitors to the ShopLocal.com Web site will gain access to the CreditCards.com search engine, which is to be updated daily, by clicking on the rate table.</p>
			"CreditCards.com aims to help consumers make informed decisions about their credit card choices," said Elisabeth DeMarse, CEO of CreditCards.com. "ShopLocal provides a great comparison shopping environment that suits that purpose."
			<p>
			"Providing our customers with additional services such as those from CreditCards.com align with our plan to be the one-stop resource for Internet-influenced online or offline shopping," said Bob Armour, CMO of ShopLocal. "We are excited to include their rate tables with our daily promotions and deals."</p>
			<p>
			The CreditCards.com rate table and search engine is expected to go live in the "Hot Deals" section of ShopLocal.com in the coming weeks.</p>
			<p><strong>About CreditCards.com</strong></p>
			<p>CreditCards.com is a leading online credit card marketplace connecting consumers with multiple credit card issuers, including nine of the ten largest in the United States, based on credit card transaction volume. Through its website, www.creditcards.com, CreditCards.com enables consumers to search for, compare and apply for more than 150 credit cards and offers credit card issuers an online channel to acquire qualified applicants.</p>
			<p><strong>About ShopLocal</strong></p>
			<p>ShopLocal, the leader in multi-channel shopping and marketing services, offers a complete suite of solutions connecting retailers and consumers online and in-store. The company's Web site, ShopLocal.com, provides consumers choice and control in their shopping experience by offering the most comprehensive selection of timely online and in-store offers on one easy-to-use site. With ShopLocal.com, consumers can find millions
			of products and up-to-date weekly sales, deals, and coupons for consumer electronics, apparel, groceries and more.</p>
			<p>ShopLocal's customers include Target, Best Buy, Home Depot, CVS and Sears. ShopLocal powers multi-channel shopping for hundreds of newspaper Web sites and other leading local and shopping sites, such as Los Angeles Times, Miami Herald, Arizona Republic, Google and Superpages.com. ShopLocal is owned by Gannett Co., Inc. (NYSE:GCI), Tribune Company (NYSE:TRB), and The McClatchy Company (NYSE:MNI). For more information, visit www.shoplocal.com.
			</p>

			<div style="text-align: center;">###</div>


			<p>For more information:</p>
			<p>
			CreditCards.com<br />
			Ben Woolsey, <br />
			Director of Marketing <br />
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">			<br>
			512-996-8663, ext. 106
			<p>ShopLocal<br>
			Marcy Dockery<br>
			Senior manager, Corporate Communications<br>
			<a href="mailto:mdockery@shoplocal.com">mdockery@shoplocal.com</a><br>
			312-768-7523


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
