<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1145';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com announces the Uniquely Yours credit card design competition - CreditCards.com';
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
					<li>CreditCards.com announces the Uniquely Yours<sup>TM</sup> credit card design competition</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">November 13, 2007</span></p>

			<h1>CreditCards.com announces the Uniquely Yours<sup>TM</sup> credit card design competition.</h1>

			<p>Austin, Texas - CreditCards.com, a leading online  marketplace for credit card seekers, announced a design competition that should  appeal to anyone seeking self expression through an unusual and overlooked  medium &ndash; the credit card.</p>
			<p>At the contest website, <a href="http://design.creditcards.com/">http://design.creditcards.com</a>, the  public is invited to enter their favorite photographs or designs for  consideration in this fun and unique competition.</p>
			<p>&ldquo;From clothing to cell phones, consumer co-design and mass  customization are redefining commodity products as avenues for self expression&rdquo;  said Jody Farmer, Vice President of Marketing for CreditCards.com.&nbsp; &ldquo;We think debit and credit cards are in the  next wave.&rdquo;</p>
			<p>The top design will be selected by a panel of design experts  and awarded the top prize of a $2,500 prepaid debit card.&nbsp; Two runner-up designs will also be selected  and will receive $500 prepaid gift cards.&nbsp; </p>
			<p>Visitors can also vote for their favorite entry, and the  entry receiving the most votes will be awarded $1,000 &ldquo;Most Popular&rdquo; award.</p>
			<p>The competition platform is powered by Serverside Group, a  global technology provider to the payment card industry.&nbsp; Serverside&rsquo;s cutting-edge software allows  users to upload, enlarge, rotate, move and flip their chosen photos inside a  card template, allowing them to view how their finished card design will  actually appear.</p>
			<p>While CreditCards.com doesn&rsquo;t directly issue any cards, at  the website, consumers will find a number of issuers that can fulfill their  design.</p>
			<p><strong>About CreditCards.com</strong><br>
			  CreditCards.com is a leading online credit card marketplace,  connecting consumers with multiple credit card issuers, including nine of the  ten largest in the United    States, based on transaction volume. Through  its website, <a href="http://www.creditcards.com/">http://www.creditcards.com</a>,  CreditCards.com enables consumers to search for, compare and apply for more  than 150 cards and offers credit card issuers an online channel to acquire  qualified applicants.&nbsp; </p>
			<p><strong>About Serverside</strong></p>
			<p>Founded in 2003, Serverside Group is the global technology  leader in digital card design and a provider of innovative software solutions  to issuers, personalization bureaus and card manufacturers. The company&rsquo;s two  flagship products are AllAboutMe, a web-based application that allows  cardholders to design their own unique payment card online, and Virtual  Portfolio, a web-based management tool enabling issuers to rapidly  launch card campaigns of any size, adjust them in real time and print cards on  demand. Serverside currently has 52 signed clients in 19  countries covering more than 200 card programs globally.</p>
			<p>Serverside Group is headquartered in London  and has offices in Taipei, New   York, Chicago and Auckland, New Zealand.  The company has strategic alliances with Visa and Datacard Group. For more  information and to see a live card demonstration, visit <a href="http://www.serversidegroup.com">www.serversidegroup.com</a>.</p>
			<div style="text-align: center;">###</div>


			<p>
				Contacts<br>
				CreditCards.com, Austin<br>
				Jody Farmer, 512-996-8663, ext. 128<br>
				VP of Strategic Marketing<br>
				<a href="mailto:jody.farmer@creditcards.com" target="_blank">jody.farmer@creditcards.com</a>
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
