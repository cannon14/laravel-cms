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

// The application link is now in one place on this template JIC it needs to be changed.
//$strApplyLink = "<a href='/oc/?pid=".$this->card->get('cardId')."&pg=".$this->card->get('fid')."&pgpos=".$this->cardNumber."' target='_blank' name='&lid=".$this->card->get('cardLink')."'>";
$strApplyPath = '/oc/?pid='.$this->card->get('cardId').'&pg='.$this->card->get('fid').'&pgpos='.$this->cardNumber;
// So I don't like my html validator going off. Don't hate.
//$strApplyLinkClose = '</a>';

$hideMobile = '';
if ($this->card->get('suppress_mobile') == '1') {
    $hideMobile = 'mobile-hide';
}

$see_terms = null;
$mobile_terms_url = $this->card->get('terms_mobile_url');

?>
<div class="row <?= $hideMobile; ?>">
    <div class="col-sm-24 col-md-18 col-lg-18" style="margin-bottom: 5px">
        <!--I hate this, but here's a nasty hack remove plurality to "credit cards" so English will make sense-->
        <h2  style="font-weight:bold;"><?= substr($this->card->get('pageName'), -1)=='s' ? substr($this->card->get('pageName'), 0, -1) : $this->card->get('pageName') ?></h2>
        <a href="/<?= $this->card->get('pageLink') ?>.php">See more cards in this category</a>
    </div>
</div>

<div class="res-schumer-box <?= $hideMobile; ?>">
    <div class="row">
        <div class="col-sm-24 col-md-18 col-lg-18">

            <div class='res-offer-left'>

                <a href="<?=$this->siteProp['individualcarddir'] . '/' . $this->card->get('cardLink') . '.' . $this->siteProp['pagetype'] . '?catid=' . $this->page->get('fid')?>">
                    <?= $this->card->get('cardTitle') ?>
                </a>

                </div>
                <div class="row">
                    <div class="col-xs-24 col-sm-24 col-md-9 col-lg-7">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-24 col-lg-24">
                                <div class="res-cc-card-art-align">
                                    <?= '<? echo "<a href=\'/oc/?pid=' . $this->card->get('cardId') . '&pg=' . $this->page->get('fid') . '&pgpos=' . $this->cardNumber . '\' target=\'_blank\'>"; ?>' ?>
                                        <img
                                            src="<?= IMGSYNERGY_191X120_CARD_IMAGE_ROOT ?>/<?= $this->card->get('imagePath') ?>"
                                            border="0" class="img-responsive"
                                            alt="<?= $this->card->get('cardIOAltText') ?>">
                                    </a>
                                </div>

                                <?php echo '<?php if(REVIEWS_ENABLED): ?>'; ?>
                                <div class="mobile-hide">
                                <?php
                                if(REVIEWS_ENABLED) {
                                    //Create the PHP that will be included in the finished page.
                                    $api = new CMS_libs_ApiClient(REVIEWS_API_URL, REVIEWS_API_USERNAME, REVIEWS_API_PASSWORD, "rating/".$this->card->get('cardId'));

                                    if (!$api->isNull()) {
                                        $data = $api->getResponseAsArray();

                                        //If the data has a 200 status, then it has data.  If not, skip because there are no reviews for this card.
                                        if ($data->status === 200) {
                                            $rating = $data->data[0]->overall_rating;
                                            $total_reviews = $data->data[0]->total_reviews;
                                            //Create the link to the reviews located on the product details page.
                                            $detailPageLink = "/".$this->siteProp['individualcarddir']."/".$this->card->get
                                                ('cardLink').".".$this->siteProp['pagetype']."?catid=".$this->page->get('fid');
                                            //Formatt the number for the stars to have one decimal place...4.567 becomes 4.6
                                            $formatted_number = number_format($rating, 1, ".", "");
                                            echo "<input type='number' class='category-star-rating rating' data-show-caption='false' data-size='xs' value='$formatted_number'>";
                                            //Wrap the total number of reviews for that card in a link to the product details page.
                                            echo "<div class='category-total-reviews'><a href='{$detailPageLink}#user_reviews_anchor'>" . number_format($total_reviews) . " customer reviews</a></div>";
                                        }
                                    }
                                }
                                ?>
                                </div><!--mobile-hide-->
                                <?php echo '<?php endif; ?>'; //closing REVIEWS_ENABLED ?>

                            </div>
                            <div class="col-xs-12 col-sm-16 col-md-24 col-lg-24">
                                <div class="res-field-apply-now-768">
                                    <a class="btn btn-apply btn-lg btn-block" href="/oc/?pid=<?= $this->card->get('cardId') ?>&pg=<?= $this->page->get('fid') ?>&pgpos=<?= $this->cardNumber ?>" target="_blank" name="&lid=<?= $this->card->get('cardLink') ?>">
                                        <i class="fa fa-lock fa-lg"></i> &nbsp;
                                        APPLY ONLINE
                                    </a>
                                    <br>
                                    <!--Only show the apply by phone number button if card has a phone number-->
                                    <p class="issuer">at <?= $strIssuer ?>&#39;s <br/>secure site</p>
                                    <?php
                                    $phoneNumber = $this->card->get('applyByPhoneNumber');
                                    if (!empty($phoneNumber)) {
                                    ?>
                                    <a class="btn btn-primary btn-lg btn-block"
                                       href="tel:<?=$this->card->get('applyByPhoneNumber')?>"
                                       onclick="var s=s_gi('ccardsccdc-us'); s.linkTrackVars='eVar25,products,events'; s.linktrackevents='event4'; s.events='event4'; s.eVar25='<?= $this->page->get('fid') ?>'; s.products='<?= $this->page->get('fid') ?>;<?= $this->card->get('cardId') ?>;0;0'; s.tl(this,'o','Apply by Phone');">
                                        <i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
                                    </a>
                                    <?php } ?>
                                    <div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br /><?= $this->cardData['Credit Needed'] ?></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-24 col-sm-24 col-md-15 col-lg-17">
                        <div class="res-details">
                            <?php
                            //Get the card Details text list that is stored as a string.
                            $detailText = $this->card->get('cardDetailText');

                            // Gets rid of the last </li></ul>
                            $detailText = explode('</li></ul>', $detailText);

                            //Since the card ID is used as the ID, a random number is added to prevent multile drop-downs
                            //from being called when the same card has multiple instances on the page.
                            $rand_num = mt_rand(1, 1000);

                            // Breaks the rest of the bullets up
                            $detailTextParts = explode('</li>', $detailText[0]);
                            $detailTextParts[1] = $detailTextParts[1] . "</li>";

                            // Add a dynamic last bullet
                            array_push($detailTextParts, '</ul>');
                            $detailText = implode('</li>', $detailTextParts);

                            echo $detailText;

                            $amex_specific_text = "";
                            if ($this->card->get('merchant') == 2) {
                                $amex_specific_text = "<span class='amex_terms_and_restrictions' style='display: block; margin-bottom:10px'></span>";
                            }
                            ?>
                            <div class="category-showhide-btn">
                                    <?= $amex_specific_text ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-24 col-md-6 col-lg-6 apply-now-btn-padding">
                <div class="res-field-apply-now">
                    <a class="btn btn-apply btn-lg"
                       href="/oc/?pid=<?= $this->card->get('cardId') ?>&pg=<?= $this->page->get('fid') ?>&pgpos=<?= $this->cardNumber ?>"
                       target="_blank" name="&lid=<?= $this->card->get('cardLink') ?>">
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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-24 col-md-24 col-lg-24">
                <div class="res-card-data-hldr">
                    <ul class="responsive-table-all">
                        <li class="first-row">
                            <dl>
                                <dt>Purchases Intro APR</dt>
                                <dd><?= $iText ?></dd>
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
                                <?php } else { ?>
                                    <dd><?= $this->cardData['Annual Fee']; ?></dd>
                                <?php } ?>
                            </dl>
                            <dl>
                                <dt>
                                    Credit Needed
                                </dt>
                                <dd><?= $this->cardData['Credit Needed'] ?></dd>
                            </dl>
                            <div style="clear:both;"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php
//See terms link will either be a specific terms link OR it will just be the offer link.
$see_terms = !empty($mobile_terms_url) ? $mobile_terms_url : $strApplyPath;
?>

<div class="see-terms-schumer-mobile <?= $hideMobile ?>"><a href="<?= $see_terms ?>" target="_blank">See Terms*</a></div>
<!--see terms-->

    <?php
    //Load the beacon tracking pixel for the following issuer ids.
    if ($this->card->get('merchant') == 3) {
        //for issuer: Bank of America
        echo '<?php $BofaCookieForBeacon = true; ?>';
    } elseif ($this->card->get('merchant') == 7) {
        //for issuer: Discover
        echo '<?php $DiscoverCookieForBeacon = true; ?>';
    }
    ?>
