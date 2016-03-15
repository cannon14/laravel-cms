<!--CARD LISTING TEMPLATE-->
<?php
if(!function_exists('isNA')) {
    function isNA($arg, $arg2) {
        return preg_match('/n\/a/i',strtolower($arg)) == 1 && preg_match('/n\/a/i',strtolower($arg2)) == 1;
    }
}

if(!function_exists('isNone')) {
    function isNone($arg, $arg2) {
        return preg_match('/none/i',strtolower($arg)) == 1 && preg_match('/none/i',strtolower($arg2)) == 1;
    }
}

if(!function_exists('isUntil')) {
    function isUntil($arg) {
        return preg_match('/until/i',strtolower($arg)) == 1;
    }
}

if(!function_exists('isSeeTerms')) {
    function isSeeTerms($arg, $arg2) {
        return preg_match('/see terms/i',strtolower($arg)) == 1 && preg_match('/see terms/i',strtolower($arg2)) == 1;
    }
}

$iAPR = $this->cardData['Intro APR'];
$iAPRPeriod = $this->cardData['Intro APR Period'];
$bAPR = $this->cardData['Balance Transfer Intro APR'];
$bAPRPeriod = $this->cardData['Balance Transfer Intro Period'];

if(isNA($iAPR, $iAPRPeriod)) {
    $iText = $this->cardData['Intro APR'];
} elseif(isNone($iAPR, $iAPRPeriod)) {
    $iText = 'None';
} elseif(isSeeTerms($iAPR, $iAPRPeriod)) {
    $iText = 'See Terms';
} elseif(isUntil($iAPRPeriod)) {
    $iText = $iAPR . " " . $iAPRPeriod;
} else {
    $iText = $iAPR . " for " . $iAPRPeriod;
}

if(isNA($bAPR, $bAPRPeriod)) {
    $bText = $this->cardData['Balance Transfer Intro APR'];
} elseif(isNone($bAPR, $bAPRPeriod)) {
    $bText = 'None';
} elseif(isSeeTerms($bAPR, $bAPRPeriod)) {
    $bText = 'See Terms';
} elseif(isUntil($bAPRPeriod)) {
    $bText = $bAPR . " " . $bAPRPeriod;
} else {
    $bText = $bAPR . " for " . $bAPRPeriod;
}

$merger = new CMS_libs_MergeFilter();
//define issuer var
$strIssuer = $this->card->get('merchantname');

//exclude list for balance transfer calculator
//6 = citi
//4 = capone
$excludeList = array(4);
$strApplyPath = "/oc/?pid=" . $this->card->get('cardId') . "&pg=" . $this->page->get('fid') . "&pgpos=" . $this->cardNumber;

?>
<?php
$hideMobile = '';

if ($this->card->get('suppress_mobile') == '1') {
    $hideMobile = 'mobile-hide';
}

$see_terms = null;
$mobile_terms_url = $this->card->get('terms_mobile_url');

if (empty($mobile_terms_url)) {
    $see_terms = $mobile_terms_url;
}

?>
<div class="res-schumer-box <?= $hideMobile; ?>">
    <div class="row">
        <div class="col-sm-18 col-md-18 col-lg-18">
            <?php
            if ($this->cardNumber == 1 && $this->page->get('flagTopPick')) {
            ?>
            <div class='res-offer-left-featured'><span class='res-top-pick2'></span>
                <?php } else { ?>
                <div class='res-offer-left'>
                    <?php } ?>

                    <a id="a<?=$this->card->get('cardId');?>" name="<?=$this->card->get('cardId');?>"
                       href="<?=$this->siteProp['individualcarddir'] . '/' . $this->card->get('cardLink') . '.' . $this->siteProp['pagetype'] . '?catid=' . $this->page->get('fid') ?>">
                        <?= $this->card->get('cardTitle') ?>
                    </a>
                </div>
                <!--res-offer--left-->
                <div class="row">
                    <div class="col-xs-24 col-sm-8 col-md-9 col-lg-7">
                        <div class="row">
                            <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                <div class="res-cc-card-art-align">
                                    <a href="<?= $strApplyPath ?>" target="_blank" name="&lid=<?= $this->card->get('cardLink') ?>" >
                                        <img
                                            src="<?= IMGSYNERGY_191X120_CARD_IMAGE_ROOT ?>/<?= $this->card->get('imagePath') ?>"
                                            border="0" class="img-responsive"
                                            alt="<?= $this->card->get('cardIOAltText') ?>">
                                    </a>
                                </div>

                                <?php echo '<?php if(REVIEWS_ENABLED): ?>'; ?>
                                <div class="mobile-hide">
                                    <?php
                                    if (REVIEWS_ENABLED) {
                                        $api = new CMS_libs_ApiClient(REVIEWS_API_URL, REVIEWS_API_USERNAME, REVIEWS_API_PASSWORD, "rating/" . $this->card->get('cardId'));
                                        if (!$api->isNull()) {
                                            $data = $api->getResponseAsArray();

                                            //If the data has a 200 status, then it has data.  If not, skip because there are no reviews for this card.
                                            if ($data->status === 200) {
                                                $rating = $data->data[0]->overall_rating;
                                                $total_reviews = $data->data[0]->total_reviews;
                                                //Create the link to the reviews located on the product details page.
                                                $detailPageLink = "/" . $this->siteProp['individualcarddir'] . "/" .
                                                    $this->card->get('cardLink') . "." . $this->siteProp['pagetype']
                                                    . "?catid=" . $this->page->get('fid');
                                                //Formatt the number for the stars to have one decimal place...4.567 becomes 4.6
                                                $formatted_number = number_format($rating, 1, ".", "");
                                                echo "<input type='number' class='category-star-rating rating' data-show-caption='false' data-size='xs' value='$formatted_number'>";
                                                //Wrap the total number of reviews for that card in a link to the product details page.
                                                echo "<div class='category-total-reviews'><a href='{$detailPageLink}#user_reviews_anchor'>" . number_format($total_reviews) . " customer reviews</a></div>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <!--mobile-hide-->
                                <?php echo '<?php endif; ?>'; //closing REVIEWS_ENABLED ?>
                            </div>
                            <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                <div class="res-field-apply-now-768">
                                    <a class="btn btn-apply btn-lg btn-block" href="<?= $strApplyPath ?>" target="_blank" name="&lid=<?= $this->card->get('cardLink') ?>">
                                        <i class="fa fa-lock fa-lg"></i>
                                        &nbsp;APPLY
                                        ONLINE</a>
                                    <br>
                                    <!--Only show the apply by phone number button if card has a phone number-->
                                    <p class="issuer">at <?= $strIssuer ?>&#39;s <br/>secure site</p>
                                    <?php
                                    $phoneNumber = $this->card->get('applyByPhoneNumber');
                                    if (!empty($phoneNumber)) {
                                        ?>
                                        <a class="btn btn-primary btn-lg btn-block"
                                           href="tel:<?= $this->card->get('applyByPhoneNumber') ?>"
                                           onclick="var s=s_gi('ccardsccdc-us'); s.linkTrackVars='eVar25,products,events'; s.linktrackevents='event4'; s.events='event4'; s.eVar25='<?= $this->page->get('fid') ?>'; s.products='<?= $this->page->get('fid') ?>;<?= $this->card->get('cardId') ?>;0;0'; s.tl(this,'o','Apply by Phone');">
                                            <i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
                                        </a>
                                    <?php } ?>

                                    <div class="credit-needed-hldr">Credit Needed <span
                                            style="color:#16487b  ; font-weight:bold;"><br/><?= $this->cardData['Credit Needed'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--column-->
                    <div class="col-xs-24 col-sm-14 col-md-15 col-lg-17">
                        <div class="res-details">
                            <?php
                            //Get the card Details text list that is stored as a string.
                            $detailText = $this->card->get('cardDetailText');

                            // Gets rid of the last </li></ul>
                            $detailText = explode('</li></ul>', $detailText);

                            // Breaks the rest of the bullets up
                            $detailTextParts = explode('</li>', $detailText[0]);
                            $detailTextParts[1] = $detailTextParts[1] . "</li></ul><div style='height:0px' id=" . $this->card->get('cardId') . " class=\"collapse\"><ul>";

                            // Add a dynamic last bullet
                            array_push($detailTextParts, '<li>See additional <a href=' . $this->siteProp['individualcarddir'] . '/' . $this->card->get('cardLink') . '.' . $this->siteProp['pagetype'] . '?catid=' . $this->page->get('fid') . '>' . $this->card->get('cardTitle') . ' details</a></li></ul></div>');
                            $detailText = implode('</li>', $detailTextParts);

                            echo $detailText;

                            $amex_specific_text = "";
                            if ($this->card->get('merchant') == 2) {
                                $amex_specific_text = "<span class='amex_terms_and_restrictions'></span>";
                            }
                            ?>
                            <div class="category-showhide-btn">
                                <a class="collapsed" data-toggle="collapse"
                                   data-target="#<?= $this->card->get('cardId') ?>">
                                    <span class="showHide-text">Show More</span> <?= $amex_specific_text ?>
                                </a> &nbsp;&nbsp;<i class="fa fa-chevron-down" style="color: #156abd"
                                                    data-toggle="collapse"
                                                    data-target="#<?= $this->card->get('cardId') ?>"></i>
                            </div>
                        </div>
                        <!--res-details-->
                    </div>
                    <!--column-->
                </div>
                <!--row-->

            </div>

            <div class="col-sm-6 col-md-6 col-lg-6 apply-now-btn-padding">
                <div class="res-field-apply-now">
                    <a class="btn btn-apply btn-lg"
                       href="<?= $strApplyPath ?>" target="_blank" name="&lid=<?= $this->card->get('cardLink') ?>">
                        <i class="fa fa-lock fa-lg"></i>
                        &nbsp;APPLY NOW
                    </a>
                    <br>
                    <p>at <?= $strIssuer ?>&#39;s <br/>
                        secure site</p>
                    <?php
                    $phoneNumber = $this->card->get('applyByPhoneNumber');
                    if (!empty($phoneNumber)) {
                        ?>
                        <p class="apply-call">
                            <span>or call <?= $strIssuer ?>
                                at <br/><b><?= $this->card->get('applyByPhoneNumber') ?></b></span>
                        </p>
                        <br>
                    <?php } ?>

                    <div class="credit-needed-hldr">Credit Needed <span
                            style="color:#16487b  ; font-weight:bold;"><br/><?= $this->cardData['Credit Needed'] ?></span>
                    </div>
                </div>
            </div>
            <!--column-->

        </div>
        <!--column-->

        <?php

        /***
         * CardPage IDs:
         *
         *      - these can be found in cms.rt_cardpage (DB.Table)
         *      - these IDs are used to output the associated css class for front end mobile display
         *      - there are four main groupings,
         *          1) responsive-table
         *          2) responsive-table-bt
         *          3) responsive-table-prepaid
         *          4) responsive-table-all
         **/

        // these get the css class 'responsive-table'
        $byCategoryPageIds = array(64 => 'Instant Approval', 173 => 'Secured', 81 => 'Student', 73 => 'Business', 519 => 'No Foreign Transaction Fee', 538 => 'Travel & Airline', 76 => 'Cash Back', 231 => 'Retail Rewards', 232 => 'Gas', 230 => 'Points Rewards', 100 => 'Reward', 474 => '0% APR', 83 => 'Low Interest');

        // this gets the css class 'responsive-table-bt'
        $balanceTransferPageId = array(105 => 'Balance Transfer');

        // this gets the css class 'responsive-table-prepaid'
        $prepaidDebitPageId = array(103 => 'Prepaid & Debit Cards');

        // these get the css class 'responsive-table-all'
        $issuerNetworkTopOfferPageIds = array(107 => 'American Express', 323 => 'American Express Charge', 324 => 'American Express Airline', 326 => 'American Express Cash Back', 123 => 'American Express Business', 509 => 'American Express Prepaid', 567 => 'American Express Gift', 108 => 'Bank Of America', 422 => 'Bank Of America Rewards', 137 => 'Capitol One', 241 => 'Capitol One Business', 309 => 'Capitol One Cash Back', 310 => 'Capitol One Points', 313 => 'Capitol One Miles', 486 => 'Capitol One Fair Credit', 490 => 'Capitol One Secured', 587 => 'Credit One', 280 => 'Barclay', 109 => 'Chase', 125 => 'Chase Small Business', 346 => 'Chase Points', 347 => 'Chase Airline-Hotel', 110 => 'Citi', 510 => 'Citi Low Interest', 349 => 'Citi Points', 350 => 'Citi Airline-Hotel', 126 => 'Citi Students', 127 => 'Citi Small Businesses', 111 => 'Discover', 117 => 'Discover Student', 115 => 'Visa', 114 => 'Mastercard', 112 => 'First PREMIER Bank', 520 => 'U.S. Bank');
        ?>
        <div class="row">
            <div class="col-sm-24 col-md-24 col-lg-24">
                <div class="res-card-data-hldr">

                    <?php if (array_key_exists($this->page->get('cardpageId'), $byCategoryPageIds)) { ?>

                        <ul class="responsive-table">
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
                                    <dt>Regular
                                        APR
                                    </dt>
                                    <?php if (isset($this->cardData['Regular APR'])) { ?>
                                        <dd><?= $this->cardData['Regular APR'] ?></dd>
                                    <?php }
                                    if (isset($this->cardData['Typical APR'])) { ?>
                                        <dd><?= $this->cardData['Typical APR'] ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>Annual
                                        Fee
                                    </dt>
                                    <?php if ($this->cardData['Annual Fee'] == '') { ?>
                                        <dd><?= $this->cardData['Monthly Fee (up&nbsp;to)']; ?></dd>
                                    <?php }
                                    else { ?>
                                        <dd><?= $this->cardData['Annual Fee']; ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>
                                        Credit Needed
                                    </dt>
                                    <dd><?= $this->cardData['Credit Needed'] ?></dd>
                                </dl>
                            </li>
                        </ul>

                    <?php }
                    elseif (array_key_exists($this->page->get('cardpageId'), $issuerNetworkTopOfferPageIds)) { ?>

                        <ul class="responsive-table-all">
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
                                    <dt>Regular
                                        APR
                                    </dt>
                                    <?php if (isset($this->cardData['Regular APR'])) { ?>
                                        <dd><?= $this->cardData['Regular APR'] ?></dd>
                                    <?php }
                                    if (isset($this->cardData['Typical APR'])) { ?>
                                        <dd><?= $this->cardData['Typical APR'] ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>Annual
                                        Fee
                                    </dt>
                                    <?php if ($this->cardData['Annual Fee'] == '') { ?>
                                        <dd><?= $this->cardData['Monthly Fee (up&nbsp;to)']; ?></dd>
                                    <?php }
                                    else { ?>
                                        <dd><?= $this->cardData['Annual Fee']; ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>
                                        Credit Needed
                                    </dt>
                                    <dd><?= $this->cardData['Credit Needed'] ?></dd>
                                </dl>
                            </li>
                        </ul>

                    <?php }
                    elseif (array_key_exists($this->page->get('cardpageId'), $prepaidDebitPageId)) { ?>

                        <ul class="responsive-table-prepaid">
                            <li class="first-row">
                                <dl>
                                    <dt>Purchases Intro APR</dt>
                                    <dd><?= $iText ?></dd>
                                </dl>
                                <dl>
                                    <dt>Balance Transfers Intro APR</dt>
                                    <dd><?= $bText ?></dd>
                                </dl>
                                <dl>
                                    <dt>Regular
                                        APR
                                    </dt>
                                    <?php if (isset($this->cardData['Regular APR'])) { ?>
                                        <dd><?= $this->cardData['Regular APR'] ?></dd>
                                    <?php }
                                    if (isset($this->cardData['Typical APR'])) { ?>
                                        <dd><?= $this->cardData['Typical APR'] ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>Annual
                                        Fee
                                    </dt>
                                    <?php if ($this->cardData['Annual Fee'] == '') { ?>
                                        <dd><?= $this->cardData['Monthly Fee (up&nbsp;to)']; ?></dd>
                                    <?php }
                                    else { ?>
                                        <dd><?= $this->cardData['Annual Fee']; ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>
                                        Credit Needed
                                    </dt>
                                    <dd><?= $this->cardData['Credit Needed'] ?></dd>
                                </dl>
                            </li>
                        </ul>

                    <?php }
                    elseif (array_key_exists($this->page->get('cardpageId'), $balanceTransferPageId)) { ?>

                        <ul class="responsive-table-bt">
                            <li class="first-row">
                                <dl>
                                    <dt>Balance Transfers Intro APR</dt>
                                    <dd><?= $bText ?>
                                        <input type="hidden" id="bt-intro-apr-<?= $this->card->get('cardId'); ?>"
                                               value="<?= $merger->translate($this->card->get('balanceTransferIntroApr'), $this->card->get('cardId')) ?>"/>
                                        <input type="hidden" id="bt-intro-period-<?= $this->card->get('cardId'); ?>"
                                               value="<?= $this->card->get('bt_min_intro_period'); ?>"/>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Balance Transfer Fee</dt>
                                    <dd><?= number_format($this->card->get('ccx_bt_fee_rate'), 2); ?>%
                                        <input type="hidden" id="bt-fee-<?= $this->card->get('cardId'); ?>"
                                               value="<?= $this->card->get('ccx_bt_fee_rate') ?>"/>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Regular
                                        APR
                                    </dt>
                                    <?php if (isset($this->cardData['Regular APR'])) { ?>
                                        <dd><?= $this->cardData['Regular APR'] ?>
                                            <input type="hidden" id="bt-min-apr-<?= $this->card->get('cardId'); ?>"
                                                   value="<?= $this->card->get('min_ongoing_apr'); ?>"/>
                                        </dd>
                                    <?php }
                                    if (isset($this->cardData['Typical APR'])) { ?>
                                        <dd><?= $this->cardData['Typical APR'] ?>
                                            <input type="hidden" id="bt-min-apr-<?= $this->card->get('cardId'); ?>"
                                                   value="<?= $this->card->get('min_ongoing_apr'); ?>"/>
                                        </dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>Annual
                                        Fee
                                    </dt>
                                    <?php if ($this->cardData['Annual Fee'] == '') { ?>
                                        <dd><?= $this->cardData['Monthly Fee (up&nbsp;to)']; ?></dd>
                                    <?php }
                                    else { ?>
                                        <dd><?= $this->cardData['Annual Fee']; ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>
                                        Credit Needed
                                    </dt>
                                    <dd><?= $this->cardData['Credit Needed'] ?></dd>
                                </dl>
                                <dl>
                                    <dt><a name="card-estimate-button" class="card-estimate-button"
                                           style="color:#66c0ff; cursor:pointer; text-decoration: none"
                                           id="card-estimate-<?= $this->card->get('cardId'); ?>">
                                            <i class="fa fa-info-circle fa-lg card-estimate-button" data-toggle="modal"
                                               data-target="#bt-calculator-modal"></i>
                                        </a>
                                        Potential Savings Estimate*
                                    </dt>
                                    <input type="hidden"
                                           value="<?= in_array($this->card->get('merchant'), $excludeList) ? 1 : 0 ?>"
                                           id="bt-calc-exclude-<?= $this->card->get('cardId') ?>"/>
                                    <dd id="bt-calc-result-<?= $this->card->get('cardId'); ?>"
                                        class="potential_savings"></dd>
                                </dl>
                            </li>
                        </ul>

                    <?php }
                    else { ?>

                        <ul class="responsive-table">
                            <li class="first-row">
                                <dl>
                                    <dt>Purchases Intro APR</dt>
                                    <dd><?= $iText ?></dd>
                                </dl>
                                <dl>
                                    <dt>Balance Transfers Intro APR</dt>
                                    <dd><?= $bText ?></dd>
                                </dl>
                                <dl>
                                    <dt>Regular
                                        APR
                                    </dt>
                                    <?php if (isset($this->cardData['Regular APR'])) { ?>
                                        <dd><?= $this->cardData['Regular APR'] ?></dd>
                                    <?php }
                                    if (isset($this->cardData['Typical APR'])) { ?>
                                        <dd><?= $this->cardData['Typical APR'] ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>Annual
                                        Fee
                                    </dt>
                                    <?php if ($this->cardData['Annual Fee'] == '') { ?>
                                        <dd><?= $this->cardData['Monthly Fee (up&nbsp;to)']; ?></dd>
                                    <?php }
                                    else { ?>
                                        <dd><?= $this->cardData['Annual Fee']; ?></dd>
                                    <?php } ?>
                                </dl>
                                <dl>
                                    <dt>
                                        Credit Needed
                                    </dt>
                                    <dd><?= $this->cardData['Credit Needed'] ?></dd>
                                </dl>
                            </li>
                        </ul>

                    <?php } ?>

                    <div style="clear:both;"></div>
                </div>
                <!--res-card-data-hldr-->
            </div>
            <!--column-->
        </div>
        <!--row-->
    </div>
    <!--res-schumer-box-->

<?php
//For desktop, Rates and Fees link will only appear if URL exists.
$rates_fees = !empty($mobile_terms_url) ? "<a href=\"".$mobile_terms_url. "\" target=\"_blank\">See Rates & Fees</a>" : "" ;
?>
<div class="see-terms-schumer-desktop <?= $hideMobile ?>"><?= $rates_fees ?></div>

<?php
//For mobile, See terms link will either be a specific terms link OR it will just be the offer link.
$see_terms = !empty($mobile_terms_url) ? $mobile_terms_url : $strApplyPath;
?>
<div class="see-terms-schumer-mobile <?= $hideMobile ?>"><a href="<?= $see_terms ?>" target="_blank">See Rates & Fees</a></div>
<!--see terms-->

<?php
//Load the beacon tracking pixel for the following issuer ids.
if ($this->card->get('merchant') == 3) {
    //for issuer: Bank of America
    echo '<?php $BofaCookieForBeacon = true; ?>';
}
elseif ($this->card->get('merchant') == 7) {
    //for issuer: Discover
    echo '<?php $DiscoverCookieForBeacon = true; ?>';
}
?>