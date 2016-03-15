<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "1430";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/include/Affiliate/Scripts/Services/CardService.class.php');

$cardService = new CardService();
//Get the top card for each category to be used to populate the page.
$lowInterestCards = $cardService->getTopCardsByPageId('83', 1);
$balanceTransferCards = $cardService->getTopCardsByPageId('105', 1);
$cashBackCreditCards = $cardService->getTopCardsByPageId('101', 1);
$rewardsCreditCards = $cardService->getTopCardsByPageId('100', 1);
$emvChipCards = $cardService->getTopCardsByPageId('527', 1);
$pointsRewardsCards = $cardService->getTopCardsByPageId('230', 1);
$noForeignTransactionFees = $cardService->getTopCardsByPageId('519', 1);
$travelandAirlineCards = $cardService->getTopCardsByPageId('72', 1);
$businessCreditCards = $cardService->getTopCardsByPageId('102', 1);
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Apply for a credit card that best fits you at CreditCards.com';
$metaKeywords = 'apply for a credit card, credit card offers, best credit cards, credit cards';
$metaDescription = 'All credit card offers are placed into categories according to their benefits and issuer. Apply at CreditCards.com for a secure online application.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
		
<link href="/css/cc-card-category.css" rel="stylesheet">

    <script type='text/javascript'>
        if (window.jQuery) {
            $(document).ready(function() {
                var isMobile = window.matchMedia("only screen and (min-width: 800px)");

                if (isMobile.matches) {
                    $("#header-block").sticky({ topSpacing: 0 });
                }
            });
        } else {
            window.setTimeout(timer, 100);
        };
    </script>
    </head>
    <body>
    <a name="Category-Top"></a>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

    <div class="card-category-block">
        <div class="container">
            <div class="row">
                <div class="col-md-24">
                    <h1 style="font-weight:bold;">Find and apply for a credit card that fits you</h1><br>
                    <p>Finding the <a href="/best-credit-cards.php">best credit cards</a> can be tricky. We've partnered with leading banks and issuers, and made it easy for you to search through many credit cards that are available. Credit card offers are placed into categories according to their benefits and issuer. Apply for a credit card that matches you with your unique needs.</p><br>
                    Use the menu to find the credit card that's right for you, or pick from our featured card offers from our partners below.<br><br>

                    <h2 style="font-weight:bold;">Featured credit card offers</h2>

                    <div class="row">
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/low-interest.php">Low Interest Credit Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $lowInterestCards['image_path'] ?>" border="0" alt="<?= $lowInterestCards['card_name'] ?> Application" /><br>
                                <span><?= $lowInterestCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/balance-transfer.php">Balance Transfer Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $balanceTransferCards['image_path'] ?>" border="0" alt="<?= $balanceTransferCards['card_name'] ?> Application" /><br>
                                <span><?= $balanceTransferCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/cash-back.php">Cash Back Credit Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $cashBackCreditCards['image_path'] ?>" border="0" alt="<?= $cashBackCreditCards['card_name'] ?> Application" /><br>
                                <span><?= $cashBackCreditCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/reward.php">Rewards Credit Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $rewardsCreditCards['image_path'] ?>" border="0" alt="<?= $rewardsCreditCards['card_name'] ?> Application" /><br>
                                <span><?= $rewardsCreditCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/smart-emv-chip.php">EMV Chip Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $emvChipCards['image_path'] ?>" border="0" alt="<?= $emvChipCards['card_name'] ?> Application" /><br>
                                <span><?= $emvChipCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/points-rewards.php">Points Rewards Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $pointsRewardsCards['image_path'] ?>" border="0" alt="<?= $pointsRewardsCards['card_name'] ?> Application" /><br>
                                <span><?= $pointsRewardsCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/no-foreign-transaction-fee.php">No Foreign Transaction Fees<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $noForeignTransactionFees['image_path'] ?>" border="0" alt="<?= $noForeignTransactionFees['card_name'] ?> Application" /><br>
                                <span><?= $noForeignTransactionFees['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/airline-miles.php">Travel and Airline Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $travelandAirlineCards['image_path'] ?>" border="0" alt="<?= $travelandAirlineCards['card_name'] ?> Application" /><br>
                                <span><?= $travelandAirlineCards['card_name'] ?></span></a>
                        </div>
                        <div class="col-xs-24 col-sm-12 col-md-8 featured-box">
                            <a href="/business.php">Business Credit Cards<br>
                                <img class="card-art" src="http://imgsynergy.com/191x120/<?= $businessCreditCards['image_path'] ?>" border="0" alt="<?= $businessCreditCards['card_name'] ?> Application" /><br>
                                <span><?= $businessCreditCards['card_name'] ?></span></a>
                        </div>
                    </div><!--row-->
                </div>
            </div>
        </div>
    </div>


<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

echo "<IMG SRC='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<IMG SRC='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";

$cards_array = array();
array_push($cards_array, $lowInterestCards);
array_push($cards_array, $balanceTransferCards);
array_push($cards_array, $cashBackCreditCards);
array_push($cards_array, $rewardsCreditCards);
array_push($cards_array, $emvChipCards);
array_push($cards_array, $pointsRewardsCards);
array_push($cards_array, $noForeignTransactionFees);
array_push($cards_array, $travelandAirlineCards);
array_push($cards_array, $businessCreditCards);

$boa = false;
$discover = false;
foreach($cards_array as $cards) {
    if(!$boa && $cards['merchant'] == '3') {
        echo "<img src='http://www.likedcards.com/init.php?mid=CCCOM121&cid=3' width='1' height='1' border='0' alt='initiator'>";
        $boa = true;
    }
    if(!$discover && $cards['merchant'] == '7') {
        echo "<img src='http://www.likedcards.com/init.php?mid=CCCOM121&cid=7' width='1' height='1' border='0' alt='initiator'>";
        $discover = true;
    }
}

$channel = 'tools';
$pageName = $channel.':search-splash';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
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
	$pageName = $channel.':search splash';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

    </body>
</html>