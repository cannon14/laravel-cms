<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '909';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com to Feature Credit Card Search Engine and Rate Table on Kiplinger.com - CreditCards.com';
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
					<li>CreditCards.com to Feature Credit Card Search Engine and Rate Table on Kiplinger.com</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">May 21, 2007</span></p>

			<h1>CreditCards.com to Feature Credit Card Search Engine and Rate Table on Kiplinger.com</h1>

			<p>
				AUSTIN, Texas--(BUSINESS WIRE)--CreditCards.com announced today an agreement to provide a credit card search engine with hundreds of card offers to Kiplinger.com, the noted personal finance Web site. The search engine will provide Kiplinger.com visitors a means to compare credit cards in order to get the best deal.
			</p>
			<p>
				Under the agreement, a CreditCards.com rate table with the average rates for popular card categories, such as low interest, rewards and airline credit cards, will be placed on the Kiplinger.com site. Site visitors will gain access to the card search engine, which is to be updated daily, by clicking on the rate table.
			</p>
			<p>
				"CreditCards.com always strives to provide consumers a wide range of credit card choices so that they can obtain the card that suits their needs," said Elisabeth DeMarse, CEO of CreditCards.com. "The strong personal finance tradition of the Kiplinger organization provides an ideal venue for us to continue achieving that goal."
			</p>
			<p>
				"We're pleased to be working with CreditCards.com in providing timely, comprehensive, and unbiased information to our online audience," said Doug Harbrecht, director of new media for Kiplinger.com.
			</p>
			<p>
				The CreditCards.com rate table and search engine access is expected to go live in the "Spending Wisely" section of Kiplinger.com during the third quarter of this year.
			</p>
			<p>
				About CreditCards.com
			</p>
			<p>
				CreditCards.com is the leading online credit card marketplace, bringing consumers and credit card issuers together. At its free website, www.creditcards.com, consumers can compare hundreds of credit card offers from the nation's leading issuers and banks, and apply securely online. CreditCards.com is also a destination site for consumers wanting to learn more about credit cards, offering news, advice, features, statistics and tools all designed to help consumers make smart choices about credit cards.
			</p>
			<p>
				About Kiplinger.com
			</p>
			<p>
				Kiplinger.com (www.kiplinger.com) offers the same great advice that appears in Kiplinger's Personal Finance magazine, plus additional features that include interactive tools and calculators, daily personal finance features, stock and mutual fund quotes, Web-only columns offering timely insights into today's trends, personal finance tutorials, and up-to-the-minute business news from the new Kiplinger Business Resource Center. Founded in 1920 by W.M. Kiplinger, the Kiplinger organization developed one of the nation's first successful newsletters in modern times. In 1947, the company launched the nation's first personal finance magazine, Kiplinger's Personal Finance. Recently, the Kiplinger organization was named one of the "World's Most Ethical Companies" List by Ethisphere Magazine, and was nominated a 2007 finalist in the MINs Best of the Web awards for the redesign/relaunch of Kiplinger.com.
			</p>

			<div style="text-align: center;">###</div>


			<p>
				Contacts:
				<br />
				CreditCards.com, Austin
				<br />
				Ben Woolsey, 512-996-8663, ext. 106
				<br />
				Director of Marketing
				<br />
				<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">
				<br />
				or
				<br />
				Kiplinger.com
				<br />
				Jenney Nalevanko, 202-887-6649
				<br />
				<img src="/images/email_jnalevanko_kiplinger.gif" width="146" height="18" border="0" alt="jnalevanko@kiplinger.com">
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
