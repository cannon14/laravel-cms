<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '1476';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

define("FEEDS_WSDL_SERVER_ADDRESS", "http://feeds.creditcards.com:8535/cardquery/QueryService?wsdl");
QUnit_Global::includeClass('Affiliate_Scripts_Bl_cardqueryclient_CardQuery');

$cardQuery = new CardQuery();
$categories = array();

$categories[] = array(
    "id" => "83",
    "category_id" => "1",
    "title" => "Best low interest credit cards",
    "tab_alt" => "Best credit cards with low interest",
    "text" => 'These low interest credit cards are best used if you have a habit of making large purchases and plan to pay them off over a period of time. Examples are large appliances, home furnishings, entertainment centers...even expensive emergencies, like home or auto repairs. More <a href="/low-interest.php">low interest credit cards</a>',
);

$categories[] = array(
    "id" => "105",
    "category_id" => "2",
    "title" => "Best balance transfer cards",
    "tab_alt" => "Best credit cards for balance transfer",
    "text" => 'Balance transfer credit cards allow you to consolidate debt that is spread across several credit cards onto one card. The best credit cards in this category feature 0% APR for an intro period from 6 to 12 months. If credit card debt is becoming a burden, a balance transfer card is best. More about <a href="/balance-transfer.php">balance transfer credit cards</a>',
);

$categories[] = array(
    "id" => "100",
    "category_id" => "4",
    "title" => "Best rewards credit cards",
    "tab_alt" => "Best credit cards with rewards",
    "text" => 'If you pay your bill in full, and like receiving coupons or discounts, a rewards credit card is best. What you spend is converted into points, and when enough are accumulated, certain benefits become available. The better of these cards offer bonus points--often in the thousands--when the application is approved. Info on other <a href="/reward.php">rewards credit cards</a>',
);

$categories[] = array(
    "id" => "101",
    "category_id" => "10",
    "title" => "Best cash back credit cards",
    "tab_alt" => "Best credit cards with cash back",
    "text" => 'Cash back cards turn 1-5% of what you spend into cash. The method and percentage varies: some programs are tiered, where the cash back increases proportional to the amount charged; others are specific, limiting the larger percentage to "everyday" items. These cards are best used if you always pay your balance in full. More info on <a href="/cash-back.php">cash back credit cards</a>',
);

$categories[] = array(
    "id" => "72",
    "category_id" => "11",
    "title" => "Best airline credit cards",
    "tab_alt" => "Best credit cards for frequent flyers",
    "text" => 'Airline or travel credit cards offer benefits targeted to travelers and frequent flyers. These credit cards use points--often called miles--to reward cardholders. What you spend, and sometimes the miles you fly, is converted to points/miles. The best airline credit cards will redeem points/miles for travel-oriented benefits: tickets, discounts, etc. See more about <a href="/airline-miles.php">airline credit cards</a>',
);

/**
 * This function outputs the details of each credit card.
 * @param $card
 */
function outputWhiteDetailsBox($card) {
    ?>
    <!--CARD TITLE-->
    <div class="res-bestcards-title">
        <a href="http://www.creditcards.com/oc/?<?= $card->cardId ?>" target="_blank">
            <?= $card->cardName ?>
        </a>
    </div>

    <!--CARD IMAGE-->
    <div class="res-bestcards-card">
        <a href="http://www.creditcards.com/oc/?<?= $card->cardId ?>" target="_blank">
            <img src="http://www.imgsynergy.com/191x120/<?= $card->imagePath ?>" border="0" alt="<?= $card->cardName ?> Application" />
        </a>
    </div>

    <!--CARD DATA-->
    <div class="res-data-hldr">
        <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" class="res-data-title-purchase">PURCHASES</td>
            </tr>
			<tr>
                <td class="res-data-title">Intro APR:</td>
                <td class="res-data-content"><?= $card->introAprLabel ?></td>
            </tr>
            <tr>
                <td class="res-data-title">Intro APR Period:</td>
                <td class="res-data-content"><?= $card->introAprPeriodLabel ?></td>
            </tr>
            <tr>
                <td class="res-data-title">Regular APR:</td>
                <td class="res-data-content"><?= $card->regularAprLabel ?></td>
            </tr>
        </table>
    </div>

    <!--CARD BUTTON-->
    <div class="res-btn-hldr">
        <a class="btn btn-apply btn-lg" href="http://www.creditcards.com/oc/?<?= $card->cardId ?>" target="_blank" name="<?= $card->cardName ?>">
            <i class="fa fa-lock fa-lg"></i> &nbsp;APPLY NOW</a>
    </div>

<?php
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="page-type" content="category" />
<?php

$htmlTitle = 'Best Credit Cards by Category';
$metaKeywords = 'best credit cards, best rewards cards, best airline card, best credit card, credit cards';
$metaDescription = 'Below is our guide to the best credit cards offered online, listed by category: best low interest cards, best rewards cards, best cash back cards, and best airline cards.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

    <meta name="page-type" content="category" />

<link href="/css/cc-card-category.css" rel="stylesheet">
</head>

<body>

<?php include($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Site Card Category Block -->
<div class="card-category-block">
    <div class="container">

        <div class="row">
            <div class="col-md-24">
                <h1 style="font-weight:bold;">Best Credit Cards by Category</h1><br />
                <p>We have partnered with banks and issuers to bring you the best credit cards. Each section below lists the
                    two best credit cards in that category. Compare cards in each category to find the best credit card that
                    meets your needs.
                </p>
                <br />
            </div>
        </div><!--row-->
<div class="card-category-disclosure-hldr"><a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img  class="pull-right" src="images/advertiser_dis_text.png" width="120" height="9" /></a>
							<div class="clearfix"></div>
						</div>
        <div class="row">
		
            <?php
            //Loop through all categories identified in the PHP array contructed at the top of this file.
            foreach ($categories as $category) {

                //Get all the cards in the category.
                $cards = $cardQuery->getCreditCardsByExpression($category['category_id']);
                //Create an array to hold the top two cards.
                $new_card_array = array();
                /*We are excluding all AMEX cards due to compliance (They don't want their cards on this page)
                We loop through the card array, starting with the top card until we get the top two,
                non-AMEX cards...then we break out of the loop.*/
                foreach ($cards as $card) {
                    if ($card->merchant !== 'American Express') {
                        $new_card_array[] = $card;

                        //If we have two cards, there is no need to continue loop.
                        if (count($new_card_array) >= 2) {
                            break;
                        }
                    }
                }
                ?>

                <div class="col-xs-24 col-sm-8 col-md-8">
                    <div class="res-bestcards-hldr">
                        <h3><?= $category['title'] ?></h3>
                        <p>
                            <?= $category['text'] ?>
                        </p>
                        <!--Only call this method if there is at least one card to call-->
                        <?php if (sizeof($new_card_array) > 0) echo outputWhiteDetailsBox($new_card_array[0]); ?>
                        <hr>
                        <br />
                        <!--Only call this method if there is at least two cards to call-->
                        <?php if (sizeof($new_card_array) > 1) echo outputWhiteDetailsBox($new_card_array[1]); ?>
                    </div>
                </div>

            <?php } ?>

            <!--Additional Info Box -->
            <div class="col-xs-24 col-sm-8 col-md-8">
                <div class="res-bestcards-hldr">
                    <h3>Help finding the best credit cards</h3>
                    <p>
                        <a href="/credit-card-news/help/6-consider-before-choosing-picking-credit-card-6000.php" class="res-best-card-news-link">
                            6 things to consider before choosing a credit card</a>
                        <br/>
                        When picking a card, the No. 1 tip is to know yourself and how you will use the card.
                        <br/>
                        <br/>

                        <a href="/credit-card-news/help/7-ways-to-get-most-from-rewards-credit-cards-6000.php" class="res-best-card-news-link">
                            7 ways to get the most from rewards credit cards</a>
                        <br/>
                        With virtually all credit card issuers offering rewards, the issue is not whether you should get a rewards card, but what type of rewards card is best for you.
                        <br/>
                        <br/>

                        <a href="/credit-card-news/help/9-things-you-should-know-about-balance-transfers-6000.php" class="res-best-card-news-link">
                            9 things to know about balance transfers</a>
                        <br/>
                        Transferring the balance to a card with a lower interest may sound like an enticing way to save cash but it's not quite as simple as it sounds.
                        <br/>
                        <br/>

                        <a href="/credit-card-news/help/worst-credit-card-mistakes-6000.php" class="res-best-card-news-link">
                            10 worst credit card mistakes</a>
                        <br/>
                        Making these 10 mistakes will turn good credit into bad and bad credit into lenders-won't-go-near-you credit.
                        <br/>
                        <br/>

                        See our
                        <a href="/credit-card-news/help/" class="res-best-card-news-link">
                            credit card help</a> section
                    </p>
                </div>
            </div><!--Additional Info Box-->

        </div><!--row-->
		<div class="card-category-disclosure-hldr"><a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img  class="pull-right" src="images/advertiser_dis_text.png" width="120" height="9" /></a>
							<div class="clearfix"></div>
						</div>
    </div><!--container-->
</div><!--card-category-block-->

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>

<?php
echo "<img src='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1>\n";
echo "<img src='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1>";
?>
<?php

$channel = 'TYPE';
$pageName = 'TYPE:best credit cards';
$analyticsServer = '';
$pageType = '';
$prop1 = 'best credit cards';
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
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

<img src="http://www.likedcards.com/init.php?mid=CCCOM121&cid=5" width="1" height="1" border="0" alt="initiator">
<img src="http://www.likedcards.com/init.php?mid=CCCOM121&cid=7" width="1" height="1" border="0" alt="initiator">

</body>
</html>
