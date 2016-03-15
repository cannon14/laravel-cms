<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1320';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Launches Affiliate Program with DoubleClick Performics';
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
					<li>CreditCards.com Launches Affiliate Program with DoubleClick Performics</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">June 06, 2008</span></p>

			<h1>CreditCards.com Launches Affiliate Program with DoubleClick Performics</h1>

			<p>AUSTIN,  TX, June 6, 2008 - CreditCards.com, the leading online credit card  comparison marketplace, today announced an affiliate marketing program with  DoubleClick Performics, the performance marketing division of DoubleClick Inc.,  that will help consumers find a wide range of credit card choices on the  Internet.</p>
			<p>
			Under  the agreement, CreditCards.com's card offers, which are updated daily, will be  available in the DoubleClick Performics Affiliate Network. The partnership  leverages DoubleClick Performics' wide distribution and its reliable platform  with CreditCards.com's advanced ability to match consumers to offers from top  credit card issuers.</p>
			<p>
			"We  are committed to exploring the affiliate channel as a complement to  CreditCards.com's overall online marketing efforts," said Elisabeth DeMarse,  CEO of CreditCards.com. "We chose DoubleClick Performics to help us in the  affiliate space because of its innovative technology platform and highly professional team."</p>
			<p>
			The  CreditCards.com credit card search engine includes hundreds of card offers in  the most popular categories, including low interest, rewards, balance transfer  and airline credit cards. With CreditCards.com, consumers can easily sort through  key selection criteria such as card category, APR, annual fees, rewards and  other benefits, credit needed and special offers.</p>
			<p>
			DoubleClick  Performics, a leading provider of affiliate marketing services, facilitates  billions of dollars in e-commerce transactions for more than 400  advertisers. DoubleClick Performics' customized affiliate marketing programs  seek to deliver quality affiliate partnerships. DoubleClick is owned by Google  Inc. (NASDAQ: GOOG)</p>
			<strong>About CreditCards.com</strong> <br>
			CreditCards.com is a leading online credit card marketplace, bringing consumers  and credit card issuers together. At its free website, <a href="http://www.creditcards.com/" target="_blank">www.creditcards.com</a>,  consumers can compare hundreds of credit card offers from the nation's leading  issuers and banks, and apply securely online. CreditCards.com is also a  destination site for consumers wanting to learn more about credit cards;  offering advice, news, features, statistics and tools - all designed to help  consumers make smart choices about credit cards. In 2007, over 12 million  unique visitors used CreditCards.com to search for their next credit card
			<p>
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
