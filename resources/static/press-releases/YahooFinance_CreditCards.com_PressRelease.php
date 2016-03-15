<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1262';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Announces Distribution Agreement to Power New Rate Tables Feature on Yahoo! Finance - CreditCards.com';
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
					<li>CreditCards.com Announces Distribution Agreement to Power New Rate Tables Feature on Yahoo! Finance</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">March 5, 2008</span></p>

			<h1>CreditCards.com Announces Distribution Agreement to Power New Rate Tables Feature on Yahoo! Finance</h1>

			<p align="center">New Module Allows  Users to Search and Compare Hundreds of Credit Card</p>
			<p>AUSTIN, TX, March 5, 2008 (BUSINESSWIRE) &ndash; CreditCards.com,  the leading online credit card comparison marketplace, today announced an  agreement to distribute the noted CreditCards.com rate tables on Yahoo!  Finance, the #1 finance site on the Web.</p>
			<p>The CreditCards.com search engine, containing hundreds of  card offers updated daily, has been integrated into Yahoo! Finance&rsquo;s rate  averages module, which is located on pages across the Yahoo! Finance site. The  search engine will enable Yahoo! Finance&rsquo;s 18 million users to make more  informed and confident financial decisions by allowing them to compare cards  and identify favorable terms in the most popular categories including low interest,  rewards and airline credit cards. </p>
			<p>Under the agreement, Yahoo! Finance users gain access to the  card search engine by clicking on the &ldquo;Credit Cards&rdquo; tab on the rates averages  module. </p>
			<p>&ldquo;One of our key objectives is always to help consumers obtain  the card that best suits their needs, and to empower them so they can make  informed decisions&rdquo; said Elisabeth DeMarse, CEO of CreditCards.com. &ldquo;We are  pleased to bring our personal finance tools and coverage to the world&rsquo;s largest  financial audience.&rdquo;</p>
			<p>The agreement provides Yahoo! Finance users a means to search,  compare and apply for leading credit cards from CreditCards.com by easily sorting  the most important criteria such as card category, APR, annual fees, rewards  and other benefits, credit needed, and special offers.</p>
			<p>About CreditCards.com<br>
			CreditCards.com is a leading online credit card marketplace, bringing  consumers and credit card issuers together. At its free website, <a href="http://www.creditcards.com">www.creditcards.com</a>, consumers can  compare hundreds of credit card offers from the nation's leading issuers and  banks, and apply securely online. CreditCards.com is also a destination site  for consumers wanting to learn more about credit cards; offering advice, news,  features, statistics and tools - all designed to help consumers make smart  choices about credit cards. In 2007, over 12 million unique visitors used  CreditCards.com to search for their next credit card.</p>
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
