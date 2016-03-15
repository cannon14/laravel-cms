<?php

$leftNavTabs = array();

$leftNavTabs[] = array(
    "id"        => $this->exclusiveOffersCatId,
    "name"      => "Special Offers",
    "fid"       => "1947",
    "trackName" => "special offers",
);

$leftNavTabs[] = array(
    "id"        => $this->allCatId,
    "name"      => "All Matches",
    "fid"       => "1549",
    "trackName" => "all matches",
);

$leftNavTabs[] = array(
    'id' => $this->amexCatId,
    'name' => 'American Express',
    'fid' => '2430',
    'trackName' => 'american express'
);

$leftNavTabs[] = array(
    'id' => $this->boaCatId,
    'name' => 'Bank of America',
    'fid' => '2431',
    'trackName' => 'bank of america'
);

$leftNavTabs[] = array(
    'id' => $this->barclayCatId,
    'name' => 'Barclaycard',
    'fid' => '2432',
    'trackName' => 'barclaycard'
);

$leftNavTabs[] = array(
    'id' => $this->caponeCatId,
    'name' => 'Capital One',
    'fid' => '2433',
    'trackName' => 'capital one'
);

$leftNavTabs[] = array(
    'id' => $this->chaseCatId,
    'name' => 'Chase',
    'fid' => '2434',
    'trackName' => 'chase'
);

$leftNavTabs[] = array(
    'id' => $this->firstPremierCatId,
    'name' => 'First Premier',
    'fid' => '2435',
    'trackName' => 'first premier'
);

$leftNavTabs[] = array(
    'id' => $this->simmonsBankCatId,
    'name' => 'Simmons Bank',
    'fid' => '2429',
    'trackName' => 'simmons bank'
);



$leftNavTabs[] = array(
    "id"        => $this->lowInterestCatId,
    "name"      => "Low Interest",
    "fid"       => "1541",
    "trackName" => "low interest",
);

$leftNavTabs[] = array(
    "id"        => $this->cashBackCatId,
    "name"      => "Cash Back",
    "fid"       => "1542",
    "trackName" => "cash back",
);

$leftNavTabs[] = array(
    "id"        => $this->balanceTransferCatId,
    "name"      => "Balance Transfer",
    "fid"       => "1546",
    "trackName" => "balance transfer",
);

$leftNavTabs[] = array(
    "id"        => $this->businessCatId,
    "name"      => "Business",
    "fid"       => "1547",
    "trackName" => "business",
);

$leftNavTabs[] = array(
    "id"        => $this->rewardsCatId,
    "name"      => "Rewards",
    "fid"       => "1544",
    "trackName" => "rewards",
);

$leftNavTabs[] = array(
    "id"        => $this->studentCatId,
    "name"      => "Student",
    "fid"       => "1550",
    "trackName" => "student",
);

$leftNavTabs[] = array(
    "id"        => $this->airlineCatId,
    "name"      => "Travel & Airline",
    "fid"       => "1543",
    "trackName" => "airline",
);

$leftNavTabs[] = array(
    "id"        => $this->instantApprovalCatId,
    "name"      => "Instant Approval",
    "fid"       => "1545",
    "trackName" => "instant approval",
);

$leftNavTabs[] = array(
    "id"        => $this->prepaidDebitCatId,
    "name"      => "Prepaid/Debit",
    "fid"       => "1548",
    "trackName" => "prepaid",
);

//$leftNavTabs[] = array(
//    "id"    =>      $this->zeroAprCatId,
//    "name"  =>     "0% APR",
//    "fid"   =>      "1771",
//    "trackName" =>   "zero apr",
//);

$leftNavTabs[] = array(
    "id"    =>      $this->secureCatId,
    "name"  =>     "Secured",
    "fid"   =>      "1772",
    "trackName" =>   "secured",
);

foreach ($leftNavTabs as $tab) {
    if ($this->getResultCount($tab['id']) > 0 ||
        $tab['id'] == $this->allCatId ||
        $tab['id'] == $this->secureCatId||
        $tab['id'] == $this->prepaidDebitCatId

    ) {

        if (empty($this->currentCatId)) {
            $newUrl = 'index.php?action=show_results&category=' . $tab['id'];
            echo '<script>location.href = "' . $newUrl . '";</script>';
            //header('Location:' . $newUrl);
            $this->currentCatId = $tab['id'];
        }
    }
    if ($this->currentCatId == $tab['id']) {
        $pagefid = $tab['fid'];
        $pageTrackName = $tab['trackName'];
    }
}

include_once('templates/partials/initTracking.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <?php

    $htmlTitle = empty($this->title) ? 'CardMatch - CreditCards.com' : $this->title;
    $metaDescription = empty($this->keywords) ? '' : $this->keywords;
    $metaKeywords = empty($this->description) ? '' : $this->description;
    include_once('templates/partials/htmlHead.php');
    include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
    if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
    ?>
    <link href="css/bootstrap.offcanvas.css" rel="stylesheet">
</head>

<body class="body-offcanvas">

<?php include_once('templates/partials/header.php'); ?>

<!-- Steps Block-->
<div class="steps-block">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-5 col-md-6 inactive-step mobile-results-hide"><i class="fa fa-check-circle green-check"></i> About You</div>
            <div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-results-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
            <div class="col-xs-6 col-sm-7 col-md-8 inactive-step mobile-results-hide"><i class="fa fa-check-circle green-check"></i> Term & Conditions</div>
            <div class="col-xs-3 col-sm-2 col-md-2 step-arrow-hldr mobile-results-hide"><i class="fa fa-long-arrow-right step-arrow"></i></div>
            <div class="col-xs-24 col-sm-24 col-md-6 active-step"> <i class="fa fa-check-circle blue-check"></i> Card Matches
                <button type="button" class="navbar-toggle offcanvas-toggle" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas" style="float:right; font-size:14px;">
                    <!--<i class="fa fa-filter"></i> filter -->
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="cm-mobile-menu-hldr">
    <header class="clearfix">
        <nav class="navbar navbar-default navbar-offcanvas navbar-offcanvas-touch" role="navigation" id="js-bootstrap-offcanvas">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <?php

                    foreach ($leftNavTabs as $tab) {
                        if ($this->getResultCount($tab['id']) > 0 || $tab['id'] == $this->allCatId || $tab['id'] == $this->secureCatId || $tab['id'] == $this->prepaidDebitCatId) {
                            ?>
                            <li class="<?= ($this->currentCatId == $tab['id']) ? 'active' : '' ?>"><a href="?action=<?= $this->showResultsAction ?>&category=<?= $tab['id'] ?>">
                                    <?php

                                    // card count per category
                                    if ($tab['id'] == $this->allCatId) {
                                        echo '<span class="badge pull-right">' . $this->totalMatches . '</span>';
                                    }
                                    else if ($tab['id'] != $this->prepaidDebitCatId && $tab['id'] != $this->secureCatId ) {
                                        echo '<span class="badge pull-right">' . $this->getResultCount($tab['id']) . '</span>';
                                    }
                                    echo $tab['name'];
                                    ?>
                                </a>
                            </li>
                        <?
                        }
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
</div>



<!-- Main Content Block-->
<div class="maincontent-block">
    <div class="container">

        <div class="row"><!-- Heading and initial card text -->
            <div class="col-md-24">

                <h1 class="results-header-text">
                    <?php

                    switch ($this->currentCatId) {
                        case $this->allCatId:
                            echo 'Full list of credit cards you are more likely to qualify for';
                            break;

                        case $this->prepaidDebitCatId:
                            echo strtoupper($this->categoryLabel) . ' cards';
                            break;

                        case $this->secureCatId:
                            echo 'SECURED cards';
                            break;

                        case $this->exclusiveOffersCatId:
                            echo 'SPECIAL Offers';
                            break;

                        default:
                            echo strtoupper($this->categoryLabel) . ' Credit Cards';
                    }
                    ?>
                </h1>

                <div class="results-description">
                    <span class="results-greentext"><?= $this->user->getFirstName() .' '. $this->user->getLastName() ?>, </span>
                    <?php

                    switch ($this->currentCatId) {
                        case $this->prepaidDebitCatId:
                            echo "the following " . strtoupper($this->categoryLabel) . " cards may be of interest to you.";
                            break;

                        case $this->secureCatId:
                            echo "the following SECURED cards may be of interest to you.";
                            break;

                        case $this->allCatId:
                            echo "here is a list of ALL credit cards from our participating partners that have been matched to your credit profile. You are more likely to qualify for the cards you have been matched with.";
                            break;

                        case $this->exclusiveOffersCatId:
                            echo "CONGRATULATIONS! You have been matched with the following Special Offers. We've partnered with major issuers to show even better offers to well-qualified customers like you. These are offers you won't find elsewhere on our site.";
                            break;
                        case $this->amexCatId:
                        case $this->boaCatId:
                        case $this->barclayCatId:
                        case $this->caponeCatId:
                        case $this->chaseCatId:
                        case $this->firstPremierCatId:
                        case $this->simmonsBankCatId:
                            echo 'you are more likely to qualify for the following partner credit cards from ' . $this->categoryLabel;
                            break;
                        default:
                            echo "you are more likely to qualify for the following " . strtoupper($this->categoryLabel) . " credit cards from our participating partners.";
                    }
                    ?>
                </div>

                <div class="results-choose-text-mobile"> Choose from the categories in the top menu to view more cards.</div>
                <div class="results-choose-text-desktop"> Choose from the categories in the left menu to view more cards.</div>

                <div class="cm-disclosure-hldr">
                    <a data-target="#myModalDisclosure" data-toggle="modal" href="#"><img src="images/advertiser_dis_text.png" class="pull-right"></a>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div><!-- End of Heading and initial card text -->

        <div class="row">
            <div class="col-md-6"><!-- Left Menu -->
                <div class="results-left-gutter">
                    <div class="panel panel-grey">
                        <div class="panel-heading">Your Matches</div>

                        <div class="panel-body">
                            <div class="list-group">

                                <?php

                                foreach ($leftNavTabs as $tab):
                                    if ($this->getResultCount($tab['id']) > 0 || $tab['id'] == $this->allCatId || $tab['id'] == $this->secureCatId || $tab['id'] == $this->prepaidDebitCatId) :
                                        ?>
                                        <a class="list-group-item <?= ($this->currentCatId == $tab['id']) ? 'active' : '' ?>" href="?action=<?= $this->showResultsAction ?>&category=<?= $tab['id'] ?>">
                                            <?php

                                            // card count per category
                                            if ($tab['id'] == $this->allCatId) {
                                                echo '<span class="badge">' . $this->totalMatches . '</span>';
                                            }
                                            else if ($tab['id'] != $this->prepaidDebitCatId && $tab['id'] != $this->secureCatId ) {
                                                echo '<span class="badge">' . $this->getResultCount($tab['id']) . '</span>';
                                            }
                                            echo $tab['name'];
                                            ?>
                                        </a>
                                    <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="cm-walletup-banner-hldr mobile-hide">
                        <div class="panel panel-grey">
                            <div class="panel-heading">Tools</div>
                            <div class="panel-body">
                                <div class="list-group"> <a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_lnav&utm_campaign=walletup" target="_blank" class="list-group-item"> Maximize Cash Back with WalletUp&reg; </a> <br><br></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End of Left Menu -->

            <div class="col-md-18"><!-- Card Listing & Clear Rusults-->

                <?php

                $positionCounter = 0;

                if (sizeof($this->cards) > 0) :
                    /**
                     * @var $card Cardmatch_Card
                     */
                    foreach ($this->cards as $card):
                        $positionCounter++;

                        $cardId = $card->getId();
                        $applyLink = sprintf(APPLY_LINK, $cardId, $_SESSION['fid'], $positionCounter, 1);

                        $presenter = new Cardmatch_CardPresenter($card);

                        if(!empty($this->ptvs[$cardId])) {
                            $applyLink .= $this->ptvs[$cardId];
                        }

                        $cardLink = sprintf(CARD_LINK, $card->getCardLink());
                        $termsLink = $card->getTermsLink();

                        //We need to get the issuer somehow
                        $strIssuer = $card->getMerchant();
                        //Apply by phone number option???
                        $applyByPhoneNumber = $card->getApplyByPhoneNumber();
                        if (!empty($applyByPhoneNumber)) {
                            $strApplyByPhoneNumber = '
								<p class="apply-call">
									<span>or call ' . $strIssuer . ' at <br><b>' . $applyByPhoneNumber . '</b></span>
								</p>';
                        } else {
                            $strApplyByPhoneNumber = '';
                        }
                        ?>
                        <div class="res-schumer-box"><!-- Shummer Box -->
                            <div class="row"><!-- Card Heading and main info -->
                                <div class="col-sm-18 col-md-18 col-lg-18">
                                    <div class="res-offer-left">
                                        <?= $card->getName() ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-24 col-sm-8 col-md-9 col-lg-7">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                                    <div class="res-cc-card-art-align">
                                                        <a href="<?= $applyLink ?>" target="_blank">
                                                            <img border="0" class="img-responsive" src="<?= CCCOMUS_CARD_IMAGE_ROOT ?>/<?= $card->getImagePath(); ?>" alt="<?= $card->getName() ?> Offer">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                                    <div class="res-field-apply-now-768">
                                                        <a name="<?= $card->getName() ?>" target="_blank" href="<?= $applyLink ?>" class="btn btn-apply btn-lg btn-block">
                                                            <i class="fa fa-lock fa-lg"></i> &nbsp;APPLY ONLINE
                                                        </a>
                                                        <br>
                                                        <br>
                                                        <?php if (!empty($applyByPhoneNumber)) : ?>
                                                            <a onclick="var s=s_gi('ccardsccmobile'); s.linkTrackVars='eVar33,events'; s.linktrackevents='event9'; s.events='event9'; s.eVar33='22105049'; s.tl(this,'o','Apply by Phone');" href="tel:<?= $applyByPhoneNumber ?>" class="btn btn-primary btn-lg btn-block"> <i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE </a>
                                                        <?php endif; ?>
                                                        <div class="credit-needed-hldr">
                                                            Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br>
                                                                <?= $card->getCreditNeeded() ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-24 col-sm-14 col-md-15 col-lg-17">
                                            <div class="res-details">
                                                <?= $card->getBulletPoints() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 apply-now-btn-padding">
                                    <div class="res-field-apply-now">
                                        <a name="<?= $card->getName() ?>" target="_blank" href="<?= $applyLink ?>" class="btn btn-apply btn-lg" alt="Click Here to Apply">
                                            <i class="fa fa-lock fa-lg"></i> &nbsp;APPLY NOW
                                        </a>
                                        <br>
                                        <p>at <?= $strIssuer ?>&#39;s <br>secure site</p>
                                        <?= $strApplyByPhoneNumber ?>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <?php


                            $iText = $presenter->getPurchaseIntroApr();
                            $bText = $presenter->getBalanceTransferIntroApr();

                            ?>
                            <div class="row">
                                <div class="col-sm-24 col-md-24 col-lg-24">
                                    <div class="res-card-data-hldr">
                                        <ul class="<?= ($this->currentCatId == 2) ? 'responsive-table-bt' : 'responsive-table' ?>">
                                            <li class="first-row">
                                                <dl>
                                                    <dt>Purchases Intro APR</dt>
                                                    <dd><?= $iText; ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt>Balance Transfers Intro APR</dt>
                                                    <dd><?= $bText; ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt>Regular APR</dt>
                                                    <dd><?= $card->getRegularApr() ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt>Annual Fee</dt>
                                                    <dd><?= $card->getAnnualFee() ?></dd>
                                                </dl>
                                                <dl>
                                                    <dt>Credit Needed</dt>
                                                    <dd><?= $card->getCreditNeeded() ?></dd>
                                                </dl>
                                            </li>
                                        </ul>
                                        <div style="clear:both;"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End of Shummer Box -->
                        <?php if (isset($termsLink) && !empty($termsLink) && $card->getLinkTypeId() == 4): ?>
                        <div class="see-terms-schumer-desktop">
                            <a href="<?= $termsLink ?>" target="_blank">See Rates & Fees</a>
                        </div>
                        <div class="see-terms-schumer-mobile">
                            <a href="<?= $termsLink ?>" target="_blank">See Rates & Fees</a>
                        </div>
                    <?php endif; ?>

                        <!--FA# 0044134 -->
                        <?php if($positionCounter == 2):
                        switch ($this->currentCatId) {
                            case 420: //All Matches ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&amp;utm_medium=referral&amp;utm_content=cardmatch_all&amp;utm_campaign=walletup" target="_blank"><img src="images/walletup-banner-n.png" class="img-responsive"></a></div>

                                <?php	break;
                            case 10:	// Cash Back ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_cashback&utm_campaign=walletup" target="_blank"><img src="images/walletup-banner.png" class="img-responsive"></a></div>

                                <?php	break;
                            case 4:	//Rewards ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_rewards&utm_campaign=walletup" target="_blank"><img src="images/walletup-banner-n.png" class="img-responsive"></a></div>
                                <?php break;
                            case 8: // Travel & Airlines ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_travel&utm_campaign=walletup" target="_blank"><img src="images/walletup-banner-n.png" class="img-responsive"></a></div>
                                <?php	break;



                                break;
                            case 10:	// Cash Back ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_cashback&utm_campaign=walletup" target="_blank"><img src="images/walletup-banner.png" class="img-responsive"></a></div>

                                <?php	break;
                            case 4:	//Rewards ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_rewards&utm_campaign=walletup" target="_blank"><img src="images/walletup-banner-n.png" class="img-responsive"></a></div>
                                <?php break;
                            case 8: // Travel & Airlines ?>

                                <div class="cm-walletup-banner-hldr mobile-hide"><a href="http://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=cardmatch_travel&utm_campaign=walletup" target="_blank"><img src="images/walletup-banner-n.png" class="img-responsive"></a></div>
                                <?php	break;
                            default:
                        }

                    endif;
                    endforeach; ?>

                    <div class="cm-disclosure-hldr bottom">
                        <a data-target="#myModalDisclosure" data-toggle="modal" href="#"><img src="images/advertiser_dis_text.png" class="pull-right"></a>
                        <div class="clearfix"></div>
                    </div>

                <?php elseif ($this->currentCatId != 14): ?>

                    <div>
                        <p style="text-align: center;font-weight: bold;">There are no cards in this category that match your credit profile.</p>
                    </div>

                <?php endif; ?>

                <? if ($this->currentCatId != 14): ?>
                    <br>
                    <br>
                <? endif; ?>

                <?php
                if (isset($this->otherCards) && $this->otherCards->hasNext()): ?>

                    <?php if ($this->currentCatId == 14): ?>
                        <?php

                        $isPrepaid = $this->currentCatId == $this->prepaidDebitCatId;

                        $positionCounter = 0;
                        while (($this->otherCards->hasNext()) && ($positionCounter <= 9)) :
                            $positionCounter++;
                            $card = $this->otherCards->getNext();
                            $applyLink = sprintf(APPLY_LINK, $card->getId(), $_SESSION['fid'], $positionCounter, 0);
                            $cardLink = sprintf(CARD_LINK, $card->getCardLink());

                            //We need to get the issuer somehow
                            $strIssuer = $card->getMerchant();

                            //Apply by phone number option???
                            $applyByPhoneNumber = $card->getApplyByPhoneNumber();
                            if (!empty($applyByPhoneNumber)) {
                                $strApplyByPhoneNumber = '
							<p class="apply-call">
								<span>or call ' . $strIssuer . ' at <br><b>' . $applyByPhoneNumber . '</b></span>
							</p>';
                            } else {
                                $strApplyByPhoneNumber = '';
                            }

                            $iText = $presenter->getPurchaseIntroApr();
                            $bText = $presenter->getBalanceTransferIntroApr();
                            ?>


                            <div class="res-schumer-box"><!-- Shummer Box -->
                                <div class="row"><!-- Card Heading and main info -->
                                    <div class="col-sm-18 col-md-18 col-lg-18">
                                        <div class="res-offer-left">
                                            <?= $card->getName() ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-24 col-sm-8 col-md-9 col-lg-7">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                                        <div class="res-cc-card-art-align">
                                                            <a href="<?= $applyLink ?>" target="_blank">
                                                                <img border="0" class="img-responsive" src="<?= CCCOMUS_CARD_IMAGE_ROOT ?>/<?= $card->getImagePath(); ?>" alt="<?= $card->getName() ?> Offer">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                                        <div class="res-field-apply-now-768">
                                                            <a name="<?= $card->getName() ?>" target="_blank" href="<?= $applyLink ?>" class="btn btn-apply btn-lg btn-block">
                                                                <i class="fa fa-lock fa-lg"></i> &nbsp;APPLY ONLINE
                                                            </a>
                                                            <br>
                                                            <br>
                                                            <?php if (!empty($applyByPhoneNumber)) : ?>
                                                                <a onclick="var s=s_gi('ccardsccmobile'); s.linkTrackVars='eVar33,events'; s.linktrackevents='event9'; s.events='event9'; s.eVar33='22105049'; s.tl(this,'o','Apply by Phone');" href="tel:<?= $applyByPhoneNumber ?>" class="btn btn-primary btn-lg btn-block"> <i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE </a>
                                                            <?php endif; ?>
                                                            <div class="credit-needed-hldr">
                                                                Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br>
                                                                    <?= $card->getCreditNeeded() ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-24 col-sm-14 col-md-15 col-lg-17">
                                                <div class="res-details">
                                                    <?= $card->getBulletPoints() ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-6 apply-now-btn-padding">
                                        <div class="res-field-apply-now">
                                            <a name="<?= $card->getName() ?>" target="_blank" href="<?= $applyLink ?>" class="btn btn-apply btn-lg" alt="Click Here to Apply">
                                                <i class="fa fa-lock fa-lg"></i> &nbsp;APPLY NOW
                                            </a>
                                            <br>
                                            <p>at <?= $strIssuer ?>&#39;s <br>secure site</p>
                                            <?= $strApplyByPhoneNumber ?>
                                            <br>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-24 col-md-24 col-lg-24">
                                        <div class="res-card-data-hldr">
                                            <ul class="<?= ($this->currentCatId == 2) ? 'responsive-table-bt' : 'responsive-table' ?>">
                                                <li class="first-row">
                                                    <dl>
                                                        <dt>Purchases Intro APR</dt>
                                                        <dd><?= $iText; ?></dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>Balance Transfers Intro APR</dt>
                                                        <dd><?= $bText; ?></dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>Regular APR</dt>
                                                        <dd><?= $card->getRegularApr() ?></dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>Annual Fee</dt>
                                                        <dd><?= $card->getAnnualFee() ?></dd>
                                                    </dl>
                                                    <dl>
                                                        <dt>Credit Needed</dt>
                                                        <dd><?= $card->getCreditNeeded() ?></dd>
                                                    </dl>
                                                </li>
                                            </ul>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End fo Shummer Box -->

                        <?php

                        endwhile;
                    endif;
                    ?>

                    <div class="cm-disclosure-hldr bottom">
                        <a data-target="#myModalDisclosure" data-toggle="modal" href="#"><img src="images/advertiser_dis_text.png" class="pull-right"></a>
                        <div class="clearfix"></div>
                    </div>

                <?php

                endif;
                ?>

                <div class="cm-results-disclaimer-hldr"> <span class="mobile-hide">Comments/Suggestions? <a target="_blank" href="http://www.creditcards.com/site-feedback.php"> Send us your feedback</a></span>
                    <div class="row">
                        <div class="col-md-18 results-text-bold">Matched results will be saved for 7 days. Clear results if you are using a public computer. </div>
                        <div class="col-md-6 results-btn-hldr"> <a href="./?action=clear_results" class="btn btn-default btn-xs">clear results</a></div>
                    </div>
                    <div class="results-disclaimer-text">
                        <p>At this stage in the process, you have not applied for credit and you have not been approved or denied for any credit card product. If you wish to apply for a credit card with any participating issuer, you will need to click through and make an application directly with that issuer. CreditCards.com does not retain any of your information, including your name, address, social security number or credit score or other credit report information, after you use the filter feature, except as a record of your authorization, and CreditCards.com will not be able to tell you why you did or did not appear to be a match with any particular credit card product.</p>
                        <p>If you click through to apply for some of the credit card products shown, some issuers will know that you have come through the filtering process and that you meet certain criteria established by the issuer. If you do not click through and apply, the issuer will not know this information about you.</p>
                    </div>
                </div>

            </div><!-- End of Card Listing & Clear Rusults -->

        </div>

    </div>
</div>

<?php

include_once('templates/partials/footer.php');
include_once('templates/partials/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:cardmatch-'.$pageTrackName;
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools:cardmatch-'.$pageTrackName;
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
<script src="js/bootstrap.offcanvas.js"></script>
</body>
</html>
