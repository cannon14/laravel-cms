<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Credit Card News RSS Feeds - CreditCards.com';
$metaKeywords = 'rss, xml, feeds, rss feeds, xml feeds, credit cards, debit cards, news, headlines, stories, subscribe, rewards, credit card help';
$metaDescription = 'You can now get the latest credit card news headlines sent straight to your desktop or Web browser through CreditCards.com\'s RSS feeds.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
	<link rel="stylesheet" href="/credit-card-news/css/editorial.css" type="text/css">
    <link href="/css/cc-misc.css" rel="stylesheet">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com Top News" href="/credit-card-news/rss/news-top-story.rss">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: All credit card news" href="/credit-card-news/rss/rss-view.php?id=25">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Bad credit, credit repair" href="/credit-card-news/rss/rss-view.php?id=11">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Balance transfer, debt consolidation" href="/credit-card-news/rss/rss-view.php?id=3">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit account management" href="/credit-card-news/rss/rss-view.php?id=17">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit card fundamentals" href="/credit-card-news/rss/rss-view.php?id=13">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit cards for small business owners" href="/credit-card-news/rss/rss-view.php?id=8">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit scores, credit reports" href="/credit-card-news/rss/rss-view.php?id=24">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Emerging payment systems: Prepaid, debit, gift cards" href="/credit-card-news/rss/rss-view.php?id=16">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Frequent flier programs, airline rewards" href="/credit-card-news/rss/rss-view.php?id=7">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Expert Q&amp;A" href="/credit-card-news/rss/rss-view.php?id=23">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Innovations, features, new products" href="/credit-card-news/rss/rss-view.php?id=20">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Low interest, zero percent cards" href="/credit-card-news/rss/rss-view.php?id=2">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Merchant accounts" href="/credit-card-news/rss/rss-view.php?id=15">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Research, statistics" href="/credit-card-news/rss/rss-view.php?id=19">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Reward programs, cash back cards" href="/credit-card-news/rss/rss-view.php?id=6">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Politics & Society" href="/rss/rss.php?id=1012">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Spotlight: People and their plastic" href="/credit-card-news/rss/rss-view.php?id=12">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Student credit cards, young credit" href="/credit-card-news/rss/rss-view.php?id=9">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Shopping" href="/credit-card-news/rss/rss-view.php?id=21">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Legal, regulatory, privacy issues" href="/credit-card-news/rss/rss-view.php?id=22">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: The Credit Guy" href="/credit-card-news/rss/rss-view.php?id=27">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Maturing Loans" href="/credit-card-news/rss/rss-view.php?id=28">
	<link rel="alternate" type="application/rss+xml" title="CreditCards.com: To Her Credit" href="/credit-card-news/rss/rss-view.php?id=29">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<!-- breadcrumbs -->
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li>RSS News Feeds</li>
				</ol>
			</div><!-- End of breadcrumbs -->

			<h1>RSS news feeds</h1>

			<p>To get the latest news from Creditcard.com click the category links below to be added to your RSS feed reader.</p>
                        
			<h2>News categories</h2>

			<ul>
                                <li><a class="rss-feed" href="/credit-card-news/rss/news-top-story.rss" target="blank">Top Story - Subscribe to this feed to receive CreditCards.com's daily top story</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=25" target="blank">All credit card news</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=11" target="blank">Bad credit, credit repair</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=3" target="blank">Balance transfer, debt consolidation</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=17" target="blank">Credit account management</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=8" target="blank">Credit cards for small business owners</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=24" target="blank">Credit scores, credit reports</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=16" target="blank">Emerging payment systems: Prepaid, debit, gift cards</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=7" target="blank">Frequent flier programs, airline rewards</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=23" target="blank">Expert Q&amp;A</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=20" target="blank">Innovations, features, new products</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=30" target="blank">Opening Credits</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=19" target="blank">Research, statistics</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=6" target="blank">Reward programs, cash back cards</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=9" target="blank">Student credit cards, young credit</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=21" target="blank">Shopping</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=22" target="blank">Legal, regulatory, privacy issues</a></li>
				<li><a class="rss-feed" href="/credit-card-news/rss/rss-view.php?id=29" target="blank">To Her Credit</a></li>
			</ul>

			<h2>Terms and conditions for use of the CreditCards.com RSS feeds</h2>

			<p>CreditCards.com's RSS feeds are protected by U.S. and international copyright laws. All rights in and to CreditCards.com's RSS feeds, including the content and technology included therein, are reserved to CreditCards.com. CreditCards.com's RSS feeds are available for personal, noncommercial use or for noncommercial use on the Web site, weblog or similar application of a nonprofit corporation which is exempt from federal income taxes under Section 501(c)(3) of the Internal Revenue Code ("501(c)(3) Nonprofit Corporation"). You may display the headlines, active links and other information contained in the RSS feeds (the "RSS feed content") on your personal Web site weblog, or similar application, or on your 501(c)(3) Nonprofit Corporation Web site, weblog, or similar application, provided that:</p>

			<ol type="a">
				<li>you do not modify or delete any of the RSS feed content;</li>
				<li>you do not redistribute the RSS feeds;</li>
				<li>you do not post CreditCards.com full-text stories other than as included in the RSS feed;</li>
				<li>the links redirect the user to the CreditCards.com Web sites when the user clicks on them;</li>
				<li>you do not insert any intermediate page, splash page or other content between the links and the applicable CreditCards.com Web page;</li>
				<li>the use or display does not suggest that CreditCards.com promotes or endorses any third party causes, ideas, Web sites, products or services.</li>
			</ol>

			<p>If you display the RSS feed content publicly, including on your Web site, you must provide attribution to CreditCards.com adjacent to the RSS feed content, by including "CreditCards.com news headlines" or "CreditCards.com" in text adjacent to the RSS feed content, without modification. Any other use of CreditCards.com's trademarks, or service marks, or of the RSS feeds requires the prior written permission of CreditCards.com. For permission requests, please visit CreditCards.com's <a href="/contact.php">Contact Us</a> page. CreditCards.com reserves the right to discontinue providing RSS feeds and to require that you cease accessing or using the CreditCards.com RSS feeds, or RSS feed content, at any time for any reason. Please see CreditCards.com's terms of use for more information before you use our RSS feeds. By using the CreditCards.com RSS feeds, you agree to be bound by the terms and conditions set forth above, as well as those in our <a href="/terms.php">terms of use</a>.</p><br />

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'tools';
$pageName = $channel.':rss-feeds';
$analyticsServer = '';
$pageType = '';
$prop1 = '';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = '';
$analyticsProducts = '';
$purchaseId = '';
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar9 = '';
$eVar10 = '';
$eVar11 = '';
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) {
	$channel = 'tools';
	$pageName = $channel.':rss feeds';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
