<?php

include_once('../actions/pageInit.php');
$_SESSION['fid'] = '911';
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Named to 2007 Inc. 500 List - CreditCards.com';
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
					<li>CreditCards.com Named to 2007 Inc. 500 List</li>
				</ol>
				<ol class="breadcrumb">
					<li class="active">Press Releases</li>
					<li><a href="/about-us/in-the-news.php">In the News</a></li>
					<li><a href="/about-us/press-kit.php">Press Kit</a></li>
					<li><a href="/public-relations.php">Media Inquiry</a></li>
				</ol>
			</div>

			<h1>CreditCards.com Named to 2007 Inc. 500 List</h1>

			<p><em>Online Credit Card Comparison Website Ranks No. 205 on list based on three year revenue growth</em></p>
			<p>Austin, TX  September 14, 2007 - CreditCards.com, a leading Internet credit card comparison website, announced today their selection to the Inc. Magazine's 26th annual Inc. 500 list.  The Inc. 500 represents a list of the fastest growing privately held businesses in the United States.  Based on revenue growth of 1050% over the past three years, CreditCards.com was ranked No. 205 on this year's list. </p>
			<p>CreditCards.com allows consumers to compare credit card offers from national card issuers and apply securely online for the card that best suits their needs.  Credit card offers are organized by issuer, credit quality and popular card segments like low interest, rewards, students and business.  The site also provides consumer resources including calculators, a credit card recommender and an extensive library of articles related to credit cards.</p>
			<p>Elisabeth DeMarse, president and CEO of CreditCards.com, said, "We are extremely honored to be recognized as one of the nation's most innovative and fastest growing companies.  This recognition is a tribute to the hard work of our employees and management team to provide consumers with the tools and resources to make informed credit card decisions."</p>
			<p>"If you want to find out which companies are going to change the world, look at the Inc. 500," said Inc. Editor Jane Berentson.  "These are the most innovative, dynamic, fast-growth companies in the nation, the ones coming up with solutions to some of our most intractable ills, creating systems that let us conduct business faster and easier, and manufacturing products we soon discover we can't live without. The Inc. 500 list is Inc. magazine's tribute to American business ingenuity and ambition."</p>
			<p>The 2007 Inc. 500, as revealed in the September issue of Inc. magazine (on newsstands August 28 - October 2), reported aggregate revenue of $16 billion and median three-year growth of 939 percent.  Most important, the 2007 Inc. 500 companies were engines of job growth, having created more than 64,064 jobs since those companies were founded. </p>
			<p>Complete information on this year's Inc. 500, including company profiles and a list of the fastest-growing companies that can be sorted by industry and region can be found at www.inc.com/inc5000.<br>
			</p>
			<p>
			<strong>Methodology</strong></p>
			<p>The 2007 Inc. 500 list measures revenue growth from 2003 through 2006.  To qualify, companies had to be U.S.-based, privately held independent - not subsidiaries or divisions of other companies - as of December 31, 2006. Revenue in 2003 must have been at least $200,000, and revenue in 2006 must have been at least $2 million. </p>
			<p><strong>About Inc. magazine</strong></p>
			<p>Founded in 1979 and acquired in 2005 by Mansueto Ventures, LLC., Inc. magazine (www.inc.com) is the only major business magazine dedicated exclusively to owners and managers of growing private companies that delivers real solutions for today's innovative company builders.  With a total paid circulation of 681,421, Inc. provides hands-on tools and market-tested strategies for managing people, finances, sales, marketing, and technology. </p>

			<strong>About CreditCards.com</strong>
			<br>
			<p>CreditCards.com is a leading online credit card marketplace, bringing consumers and credit card issuers together. At its free website, www.creditcards.com, consumers can compare more than 150 credit card offers from the nation's leading issuers and banks, and apply securely online. CreditCards.com is also a destination site for consumers wanting to learn more about credit cards; offering advice, news, features, statistics and tools - all designed to help consumers make smart choices about credit cards. In 2006, over 12 million unique visitors used CreditCards.com to search for their next credit card.</p>
			For more information, contact:<br>


			<div style="text-align: center;">###</div>


			<p>Ben Woolsey<br>
			Director of Marketing<br>
			<img src="/images/email_benw_creditcards.gif" width="130" height="18" border="0" alt="benw@creditcards.com"><br>
			512-996-8663 x106
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
