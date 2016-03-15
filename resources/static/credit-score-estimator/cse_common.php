<?php

//global connection file
require_once('../global.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');

QUnit_Global::includeClass('QCore_Settings');
Qunit_Global::includeClass('Affiliate_Scripts_Bl_TermsAndConditionsHelper');

/*** patrickm_creditcards: 
 *
 * A URL can be used as a filename with this function if the 
 * http://us2.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen 
 * have been enabled. 
 * See http://us2.php.net/manual/en/function.fopen.php for more details on how to specify the 
 * filename and http://us2.php.net/manual/en/wrappers.php for a list of supported URL protocols. 
 */
$cse_widget_node_url = IMPS_WIDGET_URL;
$cse_internal_aid = CCCOM_DEFAULT_AID;
$cardImagesRoot = 'http://images.creditcards.com';
?>

<body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>
<a class="back-to-top" href="#Page-Top" style="display:none;"><i class="fa fa-chevron-up"></i><br><br>BACK<br>TO TOP</a>

<div class="card-category-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<div class="other-subnav-hldr">
					<ol class="breadcrumb-other">
						<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
						<li><a href="/credit-card-tools/">Tools</a> <i class="fa fa-angle-right"></i></li>
						<li>Credit Score Estimator</li>
					</ol>
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-md-18">

                <div style="margin: 15px auto; display: block; width: 728px;">
                    <script type="text/javascript">if (!window.AdButler){(function(){var s = document.createElement("script"); s.async = true; s.type = "text/javascript";s.src = 'http://ab166629.adbutler-chargino.com/app.js';var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(s, n);}());}</script>
                    <script type="text/javascript">
                        var AdButler = AdButler || {}; AdButler.ads = AdButler.ads || [];
                        var abkw = window.abkw || '';
                        var plc187056 = window.plc187056 || 0;
                        document.write('<'+'div id="placement_187056_'+plc187056+'"></'+'div>');
                        AdButler.ads.push({handler: function(opt){ AdButler.register(166629, 187056, [728,90], 'placement_187056_'+opt.place, opt); }, opt: { place: plc187056++, keywords: abkw, domain: 'ab166629.adbutler-chargino.com' }});
                    </script>
                    <div style="text-align: right; color: #313131; font-size: 10px;">ADVERTISEMENT</div>
                </div>

            </div>
        </div>

		<div class="row">
			<div class="col-md-18">

				<div class="row">
					<div class="col-sm-12">
					<div class="cse-meter"> <img src="/images/<?= $cse_credit_type ?>.gif" width="300" height="150" /></div>

					</div>

					<div class="col-sm-12 text-right cse-hldr">
						<h2>Your Estimated Credit Score:<? if(ucwords($cse_credit_type) == "Bad"){ echo "**"; }?></h2>

						<div class="cse-score-hldr">
							<span><?=ucwords($cse_credit_type)?></span>
							<h1><?=$cse_bottom_range?>-<?=$cse_top_range?></h1>
						</div>

						<div class="cse-start-over"> <a href="/credit-score-estimator/">Start Over</a> </div>
					</div>
				</div>
				
				<?php

				QUnit_Global::includeClass('Affiliate_Scripts_Bl_CardQuery');

				$cardQuery = new CardQuery();

				$cards = $cardQuery->getCreditCardsByExpression($cse_cat_id);

				// this should really be done in the query.
				// max amount of cards we can show on page
				$max_card_count = 10;
				// there may be less cards than the max, so let's count how many cards there are.
				$cardCount = (count($cards));
				// if there are less than maxcards, how many are there.
				$realCardCount = min($cardCount,$max_card_count);

				$counter = 1;

				$fid = $_SESSION['fid'];
				?>

				<div class="cse-top-10">Top <?= $realCardCount ?> cards that match your estimated credit score are listed below.</div>

				<div class="row">
					<div class="col-md-24">
						<!--Advertising Disclosure-->
						<div class="card-category-disclosure-hldr">
							<a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img class="pull-right" src="/images/advertiser_dis_text.png" width="120" height="9"></a>
								<div class="clearfix"></div>
						</div>
						<!--End Advertising Disclosure-->

						<?php
						foreach ($cards as $card) { 
							if($counter >= $max_card_count + 1)
							   break;
							include('card_listing.php');
							$counter++;
						}
						?>

						<div class="cse-info-text">
							<div class="cse-disclaimer-text">
								<?= $cse_disclaimer_text ?>
							</div>
								
							<?php

							if (ucwords($cse_credit_type) == "Bad") {
								echo "<div class=\"mobile-show-hide\"><p>** FICO scores/credit scores are used to represent the creditworthiness of a person and may be one indicator to the credit type you are eligible for. However, credit score alone does not guarantee or imply approval for any credit product.</p></div>";
							}
							?>
							
							<div class="mobile-show-hide">
								<strong>What does &quot;<?= ucwords($cse_credit_type) ?>&quot; mean to you?</strong>

								<?=$cse_body_text ?>
							</div>

							<div class="cse-bottom-content">
								<div class="cse-fb-like">
									<iframe frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:350px; height:2em;" scrolling="no" src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcredit-score-estimator%2F&amp;layout=standard&amp;show_faces=false&amp;width=300&amp;action=like&amp;colorscheme=light&amp;height=35"></iframe>
								</div>
								<br>
								<br>

								<p class="mobile-show-hide">Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a></p>

								<div class="cse-glossary"> <img alt="credit card glossary" src="/images/online-glossary.gif"> <span>Looking for a term?  Find it in our online <a href="/glossary/">credit card glossary</a></span> </div>
								
								<div class="cse-all-cards-link">
									<a href="<?=$category_page_url ?>">See all cards for <?=$cse_credit_label ?> Credit</a>
								</div>
							</div>

						</div>

					</div><!--col-lg-24-->
				</div><!--row-->
			</div><!--col-md-18-->

			<div class="col-md-6">

			</div><!--col-md-6-->
		</div><!--row-->
	</div><!--container-->
</div>

<?php

include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/inc/footerScripts.php";

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
$site_cat_pageName = "tools:credit score estimator:" . $cse_credit_type . " credit";
$site_cat_range = $cse_bottom_range . "-" . $cse_top_range;

$channel = 'tools';
$pageName = $channel.':credit score estimator:' . $cse_credit_type . ' credit';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:credit score estimator';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'Credit Score Estimator';
$prop13 = $site_cat_range;
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
$eVar23 = $site_cat_range;
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) {
	$pageName = $site_cat_pageName;
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>
	<script src="/javascript/thickbox/jquery.js"></script>
	<script><?php include_once('../javascript/credit-score-estimator-card-details-toggle.js'); ?></script>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".advertising_disclosure_link>a").click(function(e){
			e.preventDefault();
			$(this).parent().siblings('.advertising_disclosure_text').show();
		});
		$(".advertising_disclosure_text>div>a.close_adtext").click(function(e){
			e.preventDefault();
			$(this).parent().parent().hide();
		});
	});
	</script>
</body>
</html>
