<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1106';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Credit Card News, Advice and Tools - CreditCards.com';
$metaKeywords = 'credit card news, credit card columns, credit card tools, expert credit card advice';
$metaDescription = 'Daily news, expert advice and financial tools designed for consumers who use credit cards.';
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
<link rel="stylesheet" href="/css/cc-editorial.css" type="text/css">
<link rel="alternate" type="application/rss+xml" title="CreditCards.com Top News" href="/credit-card-news/rss/news-top-story.rss" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: All credit card news" href="/credit-card-news/rss/rss-view.php?id=25" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Bad credit, credit repair" href="/credit-card-news/rss/rss-view.php?id=11" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Balance transfer, debt consolidation" href="/credit-card-news/rss/rss-view.php?id=3" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit account management" href="/credit-card-news/rss/rss-view.php?id=17" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit card fundamentals" href="/credit-card-news/rss/rss-view.php?id=13" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit cards for small business owners" href="/credit-card-news/rss/rss-view.php?id=8" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit Score Report" href="/credit-card-news/rss/rss-view.php?id=42" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Credit scores, credit reports" href="/credit-card-news/rss/rss-view.php?id=24" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Emerging payment systems: Prepaid, debit, gift cards" href="/credit-card-news/rss/rss-view.php?id=16" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Frequent flier programs, airline rewards" href="/credit-card-news/rss/rss-view.php?id=7" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com News: Expert Q&amp;A" href="/credit-card-news/rss/rss-view.php?id=23" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Innovations, features, new products" href="/credit-card-news/rss/rss-view.php?id=20" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Low interest, zero percent cards" href="/credit-card-news/rss/rss-view.php?id=2" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Merchant accounts" href="/credit-card-news/rss/rss-view.php?id=15" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: New Frugal You" href="/credit-card-news/rss/rss-view.php?id=43" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Opening Credits" href="/credit-card-news/rss/rss-view.php?id=30" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Research, statistics" href="/credit-card-news/rss/rss-view.php?id=19" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Reward programs, cash back cards" href="/credit-card-news/rss/rss-view.php?id=6" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Spotlight: People and their plastic" href="/credit-card-news/rss/rss-view.php?id=12" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Student credit cards, young credit" href="/credit-card-news/rss/rss-view.php?id=9" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Shopping" href="/credit-card-news/rss/rss-view.php?id=21" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: Legal, regulatory, privacy issues" href="/credit-card-news/rss/rss-view.php?id=22" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: The Credit Guy" href="/credit-card-news/rss/rss-view.php?id=27" />
<link rel="alternate" type="application/rss+xml" title="CreditCards.com: To Her Credit" href="/credit-card-news/rss/rss-view.php?id=29" />
</head>

<body>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="editor-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<div class="title-header">
					<div class="title-text">NEWS & ADVICE
						<div class="pull-right mobile-show-hide">
							<ul class="list-inline">
								<li><a href="http://www.facebook.com/CreditCards.com" target="_blank"><img src="images/editorial/social-fb-grey.png" width="20" height="20" /></a></li>
								<li><a target="_blank" href="https://twitter.com/creditcardscom"><img src="images/editorial/social-tw-grey.png" width="20" height="20" /></a></li>
								<li><a target="_blank" href="http://www.youtube.com/creditcardstv"><img src="images/editorial/social-youtube-grey.png" width="20" height="20" /></a></li>
								<li><a href="/rss-feed-credit-card-news-headlines.php"><img src="images/editorial/social-feed-grey.png" width="20" height="20" /></a></li>
								<li><a target="_blank" href="https://plus.google.com/110595907088556510376?prsrc=3"><img src="images/editorial/social-google-grey.png" width="20" height="20" /></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-24 col-md-18 col-lg-18">
				<div class="main-story-block"> 
					<!--Beginning of main text--> 
					<!--////////////// Beginning Top & Featured Story //////////// --> 
					<!--  ***** [ Top & Featured Story Goes Here ]  ***** -->
					
					<div class="top-story"> 
						<!-- TOP STORY -->
						<?php include 'credit-card-news/content/elp_topstory.php'; ?>
						<!-- END TOP STORY --> 
					</div>
					<br clear="all">
					<div class="more-featured"> 
						<!-- FEATURED ARTICLES -->
						<?php include 'credit-card-news/content/elp_featured.php'; ?>
					</div>
					
					<!--////////////// End Top & Featured Story //////////// --> 
					<!--Beginning of main text--> 
				</div>
				<div class="row">
					<div class="col-sm-24 col-md-16 col-lg-16">
						<div class="maincontent-other"> 
							<!--////////////// Beginning Botttom 1st Col //////////// --> 
							<!--  ***** [ 1st Col Goes Here ]  ***** -->
							
							<div class="info-graphic"> 
								<!-- INFOGRAPHIC -->
								<?php include 'credit-card-news/content/elp_infographic.php'; ?>
								<!-- END INFOGRAPHIC --> 
							</div>
							
						
							
							<!--////////////// End Botttom 1st Col //////////// -->
							
							<hr>
							
						</div>
					</div>
					<div class="col-sm-24 col-md-8 col-lg-8">
						<div class="maincontent-other"> 
							
							<!--////////////// Beginning Botttom 2nd Col //////////// --> 
							
							<!--  ***** [ 2nd Col Goes Here ] *****  -->
							<div class="expert-corner"> 
								<!-- EXPERT CORNER -->
								<?php include 'credit-card-news/content/elp_expertcorner.php'; ?>
							</div>
							<hr>
							<div class="cchelpdiv"> 
								<!-- CREDIT CARD HELP -->
								<?php include 'credit-card-news/content/elp_cchelp.php'; ?>
							</div>
							<hr>
							<div class="glossary"> 
								<!-- CREDIT CARD HELP -->
								<?php include 'credit-card-news/content/elp_glossary.php'; ?>
							</div>
							<hr>
							<div class="ccquiz"> 
								<!-- CREDIT CARD QUIZ -->
								<?php include 'credit-card-news/content/elp_ccquiz.php'; ?>
							</div>
							<hr>
							<div class="calculators"> 
								<!-- CREDIT CARD CALCULATORS -->
								<?php include 'credit-card-news/content/elp_calculators.php'; ?>
							</div>
							<hr>
							<!--////////////// End Botttom 2nd Col //////////// --> 
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-24 col-md-6 col-lg-6">
				<div class="last-column"> 
					<!--////////////// Beginning of side text //////////////--> 
					
					<!-- *****  [ Side Col Content Goes Here ] *****  -->
					
					<div class="topright"> 
						<!-- FEATURED ARTICLES -->
						<?php include 'credit-card-news/content/elp_topright.php'; ?>
					</div>
					<hr>
					<div class="polldiv"> 
						<!-- POLL -->
						<?php include 'credit-card-news/content/elp_poll.php'; ?>
					</div>
					<hr>
					<div class="weekly-subscribe">
						<h2><a href="/newsletter.php">Weekly newsletter</a></h2>
							<a target="_blank" href="/newsletter.php"> <i class="fa fa-newspaper-o fa-3x"></i> </a>Get the latest news, advice, articles and tips delivered to your inbox. It's FREE.
						<div class="subcribe-btn"> <a target="_blank" href="/newsletter.php" class="btn btn-success">SUBSCRIBE</a></div>
					</div>
					<hr>
					<div class="fundamentals"> 
						<!-- FUNDAMENTALS -->
						<?php include 'credit-card-news/content/elp_fundamentals.php'; ?>
					</div>
					<!-- ESTIMATOR -->
					<?php /*?><hr>
					<div class="estimator"> 
						<?php include 'credit-card-news/content/elp_estimator.php'; ?>
					</div><?php */?>			
					<hr>
					<div class="actionIcon"> <a href="mailto:editors@creditcards.com"><i class="fa fa-question-circle fa-2x"></i></a><a href="mailto:editors@creditcards.com">Comments/Questions?</a> </div>
					<div class="actionIcon"> <a href="/credit-card-news/corrections-policy-1264.php"><i class="fa fa-check-circle fa-2x"></i></a><a href="/credit-card-news/corrections-policy-1264.php">Corrections Policy</a> </div>
					<hr>
					<div class="rate-report-hldr">
						<div class="rate-title"><a href="/rate-report">Credit Card Rate Report</a></div>
						<div class="rate-updated-date">Updated:
							<?= date("m-d-Y") ?>
						</div>
						
						<!--Hide this div by default so if it fails it won't blink into existence then implode-->
						<div id="rateChartArticleBox" style="display:none"> 
							<!--This <p> is important because it contains the bottom border of the parent div.-->
							<p class="moreinfo" id="rateChartMoreInfo">&nbsp;</p>
						</div>
						<!--rateChartArticleBox--> 
					</div>
					
					<!--////////////// End Side Text //////////////--> 
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End of editor-block -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'news';
$pageName = $channel.':home';
$analyticsServer = '';
$pageType = '';
$prop1 = 'news';
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
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>
<script>
		<!-- Yahoo! Inc.
			var ysm_accountid = "1MBCQ6C90RP2S7QCLV2LRQAT4N0";
			document.write("<scr" + "ipt "
				+ "src=//" + "srv1.wa.marketingsolutions.yahoo.com" + "/script/ScriptServlet" + "?aid=" + ysm_accountid
				+ "></scr" + "ipt>");
		// -->
	</script> 
<script>
		/* Ajax call that returns the html on success and unhides the div with data.*/
		$.ajax({
			type: "POST",
			url: 'lib/rate_chart/rate_chart.inc.php',
			success: function (data) {
				//Detach and save the #rateChartMoreInfo data for use after HTML is overwritten.
				var moreInfo = $('#rateChartMoreInfo').detach();
				/*Add the html table data inside the #rateChartArticleBox,
				 append the #rateChartMoreInfo data after it, then show all.*/
				$('#rateChartArticleBox').html(data).append(moreInfo).show();
			}
		});
	</script>
</body>
</html>
