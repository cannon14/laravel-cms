<?php include_once('templates/partials/initTracking.php'); ?>
<!DOCTYPE HTML>
<html>
<head>
    <?php

    $htmlTitle = 'CreditCards.com';
    $metaDescription = "CardMatch can help you find special credit card deals by matching your credit profile with offers you're likely to qualify for. It's free and doesn't impact your credit score.";
    $metaKeyword = 'credit cards, credit profile, offers, match, tool, qualify, deals, score, find a card';
    include_once("templates/partials/htmlHead.php");

    include_once(AFFILIATE_PATH . '/settings/settings.php');
    if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
    ?>
</head>

<body>

<?php include_once("templates/partials/header.php"); ?>

<!-- Banner Block-->
<div class="banner-block">
    <div class="item">
        <div class="container">
            <div class="bg-img hidden-xs"> <img src="images/header-img.png" /> </div>
            <div class="row">
                <div class="col-sm-11">
                    <h1>Get matched with <span style="color:#429e5d;"><strong>better offers</strong></span>.</h1>
                    <div class="banner-description"> We match your credit profile with credit card offers from our participating partners and invite you to apply for cards you are more likely to qualify for. You could be matched with special offers only available here. </div>
                    <div class="banner-form-select">
                        <form name="start" action="./" method="POST">
                            <input type="hidden" name="action" value="show_form">
                            <button class="btn btn-success btn-lg" id="start" type="submit">GET STARTED FOR FREE <i class="fa fa-angle-right" style="padding-left:10px;"></i> </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Block-->
<div class="landing-block">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-xs-3 col-sm-5 col-md-4 landing-icn-hldr"><img src="images/thumbsup-icn.png" width="40" height="40"></div>
                    <div class="col-xs-21 col-sm-19 col-md-20 landing-content-hldr">
                        <h2>No impact to your credit score</h2>
                        <p>With your permission, we'll perform a soft inquiry to match you with offers that you are more likely to qualify for.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-xs-3 col-sm-5 col-md-4 landing-icn-hldr"><img src="images/user-icn.png" width="40" height="40"></div>
                    <div class="col-xs-21 col-sm-19 col-md-20 landing-content-hldr">
                        <h2>Offers matched to your credit profile</h2>
                        <p>You could be matched with special offers which include lower rates or better rewards not available elsewhere.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-xs-3 col-sm-5 col-md-4 landing-icn-hldr"><img src="images/watch-icn.png" width="40" height="57"></div>
                    <div class="col-xs-21 col-sm-19 col-md-20 landing-content-hldr">
                        <h2>CardMatch is free and quick</h2>
                        <p>We'll match you with offers in less than 60 seconds. Best of all, it's free!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

include_once("templates/partials/footer.php");
include_once("templates/partials/footerScripts.php");

$channel = 'tools';
$pageName = $channel.':cardmatch_landing';
$analyticsServer = '';
$pageType = '';
$prop1 = $pageName;
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = 'cardmatch';
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