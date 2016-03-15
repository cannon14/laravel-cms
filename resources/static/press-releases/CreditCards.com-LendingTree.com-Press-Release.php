<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1242';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Powers Credit Card Channel on LendingTree.com and GetSmart.com - CreditCards.com';
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
					<li>CreditCards.com Powers Credit Card Channel on LendingTree.com and GetSmart.com - CreditCards.com</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">February 18, 2008</span></p>

			<h1>CreditCards.com Powers Credit Card Channel on LendingTree.com and GetSmart.com</h1>

			<p>AUSTIN, TX, February 18, 2008 (BUSINESSWIRE) -- CreditCards.com announced today that it has been selected by LendingTree, LLC  to power the credit card channels on LendingTree.com and its sister site, GetSmart.com.</p>
			<p>Visitors to both LendingTree.com and GetSmart.com can now  shop, compare and apply for competing credit cards through the CreditCards.com  search engine technology. The search  engine, which is updated daily with current credit card offers, provides potential  customers a means to compare hundreds of current credit card offers in order to  find the best deal for them. </p>
			<p>Keith Moore, vice president of LendingTree's emerging  businesses group, says "This new offering is a win for users of both LendingTree.com  and GetSmart.com, allowing them to see multiple offers from competing credit  card companies in one easy-to-navigate setting.  The CreditCards.com search engine is the best in its class, organizing  hundreds of offers by category including low-interest credit cards, credit  cards with rewards programs, airline credit cards, cash-back credit cards,  small business credit cards, student credit cards, instant approval credit  cards as well as prepaid debit cards.  We're delighted to bring this new level of choice, competition and price  transparency to anyone who's looking for the best deals in the credit card  category."</p>
			<p>"CreditCards.com strives to help  consumers, shop, compare and apply for credit cards in a searchable and easy-to-navigate  setting," said Elisabeth DeMarse, CEO of CreditCards.com. "We are honored to be  selected as the choice to power the credit card channels of LendingTree.com and  GetSmart.com."</p>
			<p>About CreditCards.com<br>
			  CreditCards.com is a leading online credit card marketplace,  bringing consumers and credit card issuers together. At its free website, <a href="http://www.creditcards.com/">www.creditcards.com</a> , consumers can  compare hundreds of credit card offers from the nation's leading issuers and  banks, and apply securely online. CreditCards.com is also a destination site  for consumers wanting to learn more about credit cards; offering advice, news,  features, statistics and tools - all designed to help consumers make smart choices  about credit cards. In 2007, over 12 million unique visitors used  CreditCards.com to search for their next credit card.</p>
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
