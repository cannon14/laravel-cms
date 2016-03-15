<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1146';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Provides Credit Card Search Engine to ApartmentRatings.com - CreditCards.com';
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
					<li>CreditCards.com Provides Credit Card Search Engine to ApartmentRatings.com</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">August 14, 2007</span></p>

			<h1>CreditCards.com Provides Credit Card Search Engine to ApartmentRatings.com</h1>

			<p><strong>AUSTIN, TX, August 14, 2007 </strong>(BUSINESSWIRE) - CreditCards.com announced today an agreement to provide its credit card search engine to ApartmentRatings.com, operator of the largest and most popular Internet community for apartment renters.</p>
			<p>The search engine, containing hundreds of card offers updated [daily], provides visitors to ApartmentRatings.com a means to compare credit cards in order to get the best deal.</p>
			<p>Under the agreement, a CreditCards.com link has been placed in the "Finance Organizer" area of ApartmentRatings.com. Site visitors may gain access to the co-branded card search engine provided by CreditCards.com by clicking on the link.</p>
			<p>"One of our key objectives is always to help consumers obtain the card that best suits their needs," said Elisabeth DeMarse, CEO of CreditCards.com. "We are pleased to provide our services to ApartmentRatings.com so that the site's visitors can make informed decisions in this important personal finance area."</p>
			<p>"A move across town or across the country can cost thousands of dollars. Now ApartmentRatings.com users can easily find credit cards with cash back or rewards to help make their move a little easier on their finances," said Jeremy Bencken of ApartmentRatings.com.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card marketplace, bringing consumers and credit card issuers together. At its free website, www.creditcards.com, consumers can compare hundreds of credit card offers from the nation's leading issuers and banks, and apply securely online. CreditCards.com is also a destination site for consumers wanting to learn more about credit cards; offering advice, news, features, statistics and tools - all designed to help consumers make smart choices about credit cards.  In 2006, over 12 million unique visitors used CreditCards.com to search for their next credit card.</p>
			<p>About ApartmentRatings.com<br>
			ApartmentRatings.com is the largest online rating community for rental housing, reaching approximately 30% of apartment hunters nationwide, and is among the Top 5 most-visited apartment hunting sites in the world. The company's goal is to help renters make an informed renting decision. As an independent resource for renters, ApartmentRatings.com's reviews provide a realistic insider's perspective of apartment communities because they are in renters' own words. </p>
			<p>ApartmentRatings.com also maps apartments via Google Maps, offering the largest and most comprehensive mapping of apartments online. Renters can also use our detailed graphs to discover how much other renters in the same apartment community pay in rent.  The company is a division of Internet Brands, Inc., a leading operator of media and e-commerce websites.<br>
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
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com">				</p>
			<p>
				ApartmentRatings.com<br>
				Joe Ewaskiw, 310-280-4539<br>
				Public Relations Manager, Internet Brands, Inc.<br>
				jewaskiw@internetbrands.com
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
