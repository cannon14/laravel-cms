<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1300';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Partners with ProQuo to Launch CommandPost&trade;';
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
					<li>CreditCards.com Partners with ProQuo to Launch CommandPost&trade;</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">April 21, 2008</span></p>

			<h1>CreditCards.com Partners with ProQuo to  Launch CommandPost&trade;, a New Service for Helping Consumers Reduce  Wasteful Paper Junk Mail and Better Manage Marketing Offers</h1>

			<p>AUSTIN, TX, April 21, 2008 --(<a href="http://www.businesswire.com/">BUSINESS WIRE</a>)--CreditCards.com, the  leading online credit card comparison marketplace, today announced the launch  of CommandPost&trade;, a free and innovative service that helps consumers  control the marketing offers and junk mail that arrives in their homes. </p>
			<p> CommandPost&trade; is powered by ProQuo, a consumer services firm led  by pioneers in the online security and privacy arena. By leveraging ProQuo's  innovative, web-based technology, CommandPost&trade; gives visitors to  CreditCards.com the ability to stop or start receiving everything from coupon  books to catalogs with just a few clicks of the mouse. In addition, users can  take their names off national mailing lists, while also telling credit bureaus  to stop selling their information for marketing purposes. </p>
			<p>At no charge, CommandPost&trade; helps consumers reduce wasteful junk  mail and prevent profiling without their consent, as well as help reduce their  exposure to potential identity theft. </p>
			<p>"With the approach of Earth Day, we feel that this is an ideal time to  launch this important service to further empower our visitors and help the  environment by reducing unwanted paper junk mail," said Jody Farmer,  CreditCards.com Vice President of Strategic Marketing. "We are extremely  excited to partner with a leader in the privacy and security industry like  ProQuo to further our mission of providing consumers with choice." </p>
			<p>"As a leader in the industry, CreditCards.com understands the importance of  providing choice and helping protect consumers' personal information," said  Chris Kermoian, ProQuo's Vice President of Marketing. "ProQuo is pleased to  help CreditCards.com provide its users with a seamless experience for better  managing marketing offers and helping eliminate annoying junk mail." </p>
			<p> CommandPost&trade;, powered by ProQuo, is available starting today,  Monday April 21st, through the CreditCards.com web site. It is  completely free to consumers. </p>
			Junk mail facts (source: Consumers Research Institute, Center for a New  American Dream, and Ecocycle.org): </p>
			<ul>
			<li>Americans receive nearly four million tons of junk mail every year </li>
			<li>More than 28 billion gallons of water are wasted to produce and recycle junk mail each year </li>
			<li>The average adult receives around 40 pounds of junk mail each year </li>
			<li>Americans throw away 44% of bulk mail unopened </li>
			</ul>
			<p><strong>About CreditCards.com</strong> <br>
			CreditCards.com is a leading online credit card marketplace, bringing  consumers and credit card issuers together. At its free website, <a href="http://www.creditcards.com" target="_blank">www.creditcards.com</a>,  consumers can compare hundreds of credit card offers from the nation's leading  issuers and banks, and apply securely online. CreditCards.com is also a  destination site for consumers wanting to learn more about credit cards;  offering advice, news, features, statistics and tools - all designed to help consumers  make smart choices about credit cards. In 2007, over 12 million unique visitors  used CreditCards.com to search for their next credit card. </p>
			<p><strong>About ProQuo, Inc.</strong> <br>
			With headquarters in La Jolla,   California, ProQuo was founded to  put consumers in control of their personal information, letting them decide if  and how businesses use it. ProQuo helps consumers stop the mail they don't want and get the offers they really do want. The company is led by pioneers in the  online security and privacy arena. For more information, visit www.proquo.com. </p>

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
