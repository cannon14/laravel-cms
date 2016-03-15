<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '1144';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Appoints Matt Schulz as Senior Industry Analyst';
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
					<li>CreditCards.com Appoints Matt Schulz as Senior Industry Analyst</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<p><span class="press-release-date">April 3, 2014</span></p>

			<h1>CreditCards.com Appoints Matt Schulz as Senior Industry Analyst</h1>

			<p><strong>AUSTIN,  Texas, April. 3, 2014</strong> &mdash; CreditCards.com announced today  that Matt  Schulz has been named Senior Industry Analyst, effective immediately.</p>
			<p>With Schulz, CreditCards.com will continue its  commitment to helping consumers make smart choices when choosing and using  credit cards. </p>
			<p>This will be  Schulz&rsquo;s second stint with CreditCards.com, having previously served as  Managing Editor from 2008 to 2012. During that time, he was a member of the editorial team that won a  Society of American Business Editors and Writers award for their coverage of  the credit card industry. At CreditCards.com, Schulz also worked with the White  House for an online town hall on the topic of credit card reform. </p>
			<p>Schulz has also  led online editorial teams for an investing education website, as well as two  local television stations in Austin, Texas. He has spent much of the last decade helping people make smart decisions  about their money, particularly in regard to credit cards. </p>
			<p>A keen observer  of the payments and credit card industry, Schulz has been quoted in or had his  work appear in major media outlets including U.S. News and World Report, The  Huffington Post, AOL Daily Finance, Yahoo Finance and Business Insider. Matt is  also a frequent speaker at industry conferences.</p>
			<p>Schulz earned a  bachelor's degree in journalism from the University of Texas at Austin.</p>
			<p><strong>About  CreditCards.com:</strong><br>
			CreditCards.com, named a &ldquo;Best Site for Managing Your  Credit&rdquo; by MSN Money, is a leading online credit card marketplace, bringing  consumers and credit card issuers together. At its free website, consumers can compare hundreds of credit card  offers from America&rsquo;s leading issuers and banks and apply securely,  online. CreditCards.com is also a  destination site for consumers wanting to learn more about credit cards. Offering advice, news, features, statistics  and tools, CreditCards.com helps consumers make smart choices about credit  cards. In 2013, more than 12 million  unique visitors used CreditCards.com to find the right credit card to suit  their needs.</p>
			<p>For more information, please visit <a href="http://www.creditcards.com/">http://www.creditcards.com/</a> or contact Christie High at <a href="mailto:chigh@peppercomm.com">chigh@peppercomm.com</a> (212-931-6188). </p>

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
