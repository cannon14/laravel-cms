<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1986';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'The Breakroom';
$metaKeywords = 'creditcards.com commercial, rewards credit cards, cashback credit cards, airline miles credit cards';
$metaDescription = 'View the latest commercial from Creditcards.com along with hilarious out-takes and supplemental videos in the office breakroom. Which credit card makes the best wingman: rewards, airline miles or cash back?';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link href="/css/cc-misc.css" rel="stylesheet">

<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<div id="social-icons">
				<div id="fb-root"></div>
				<!-- Google PlusOne & Twitter icons -->
				<div class="pull-right">
					<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
					<g:plusone></g:plusone>
					<iframe src="http://www.facebook.com/plugins/like.php?href=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&amp;layout=button_count&amp;show_faces=true&amp;width=75&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:75px; height:21px;" allowTransparency="true"></iframe>
				</div>
			</div>

			<h1>The Breakroom</h1>

			<div id="breakroom-banner">
				<div id="breakroom-banner-text">
					<h3>So... how was your weekend?</h3>
					<p>In our latest commercial, Joe is besieged by misfit cards, vying to be his "wingman" for the weekend. Throughout Monday, he runs into them in the office breakroom.
					</p>
					<p>How did that turn out?</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 youtube-video">
					<iframe width="480" height="315" src="http://www.youtube.com/embed/6W9fUL5ZDWE" frameborder="0" allowfullscreen></iframe>
					<div class="video-subtitle">
						<p>Joe heads back to the breakroom for his mid-afternoon snack and runs into Travel Rewards.</p>
						<p>Compare leading <a href="/airline-miles.php">travel credit cards</a> and earn points or miles that can be redeemed for travel.</p>
					</div>
				</div>

				<div class="col-md-12 youtube-video">
					<iframe width="480" height="315" src="http://www.youtube.com/embed/-b0G-qyteYA" frameborder="0" allowfullscreen></iframe>
					<div class="video-subtitle">
						<p>Back in the office on Monday morning, before he's even had his first cup of coffee, Cash Back confronts Joe.</p>
						<p>Check our <a href="/points-rewards.php">Points Rewards credit card offers</a> These cards let you earn rewards points for card purchases. Redeem points earned towards merchandise, travel and gift cards.
						</p>
					</div>
				</div>
			</div>

			<div id="latest-commerical-video" class="youtube-video">
				<h3>Check out our latest commercial</h3>
				<iframe width="560" height="315" src="http://www.youtube.com/embed/m8RIFlj7xG8" frameborder="0" allowfullscreen></iframe>
			</div>

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

<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=381830088582969";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<!-- Adobe Marketing Cloud Tag Loader Code
Copyright 1996-2013 Adobe, Inc. All Rights Reserved
More info available at http://www.adobe.com/solutions/digital-marketing.html -->
<script>
//<![CDATA[
	var amc=amc||{};if(!amc.on){amc.on=amc.call=function(){}};
	document.write("<scr"+"ipt type=\"text/javascript\" src=\"//www.adobetag.com/d1/v2/ZDEtY3JlZGl0Y2FyZHNjb20tNTY5NS0yMTg0/amc.js\"></sc"+"ript>");
//]]>
</script>
<?php

$channel = 'breakroom';
$pageName = $channel;
$analyticsServer = '';
$pageType = '';
$prop1 = 'breakroom';
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

</body>
</html>
