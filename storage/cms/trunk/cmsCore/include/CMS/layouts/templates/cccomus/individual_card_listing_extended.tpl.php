<!-- individual_card_listing_extended.tpl -->
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

//we need to format all the numbers in our properties array
foreach ($this->card->properties as $key => $value) {
	if (is_numeric($value) && (int)$value == $value) {
		$this->card->properties[$key] = (int)$value;
	}
}

//Load the beacon tracking pixel for the following issuer ids.
if ($this->card->get('merchant') == 3) {
	//for issuer: Bank of America
	echo '<?php $BofaCookieForBeacon = true; ?>';
}
elseif ($this->card->get('merchant') == 7) {
	//for issuer: Discover
	echo '<?php $DiscoverCookieForBeacon = true; ?>';
}

$enablePrepaidMod = false; // Do not enable changes for prepaid-card-attr project yet
$detailText = $this->card->get('cardDetailText');
$strIssuer = $this->card->get('merchantname');
//apply by phone number copy
$phoneNumber = $this->card->get('applyByPhoneNumber');
if (!empty($phoneNumber)) {
	$strApplyByPhoneNumber = '
		<p class="apply-call">
			<span>or call ' . $strIssuer . ' at <br><b>' . $this->card->get('applyByPhoneNumber') . '</b></span>
		</p>';
}
else {
	$strApplyByPhoneNumber = '';
}

// The application link is now in one place on this template JIC it needs to be changed.
// Note: category ID (catid) is set in the header
$linkCardId = $this->card->get('cardId');
$linkExitPageId = $this->card->get('fid');
$linkPosition = $this->cardNumber;
$linkName = $this->card->get('cardLink');

//Api call for User Reviews, Staff Reviews, Card Rating and Card Statistics
$api = new CMS_libs_ApiClient(REVIEWS_API_URL, REVIEWS_API_USERNAME, REVIEWS_API_PASSWORD, "all/" . $this->card->get('cardId'));
$review_data = $api->getResponseAsArray();

echo '<?php
	/* JIRA CCCOM-33 - if catid passed from category page, swap catid and pg in the OC links
	*				 else, use pg for both pg and catid
	*/
	if(isset($catid)) {

		$strApplyPath = "/oc/?pid=' . $linkCardId . '&pg=$catid&pgpos=' . $linkPosition . '&catid=' . $linkExitPageId .'";

	} else {

		$strApplyPath = "/oc/?pid=' . $linkCardId . '&pg=' . $linkExitPageId . '&pgpos=' . $linkPosition . '&catid=' . $linkExitPageId . '";
	}
?>';

$merger = new CMS_libs_MergeFilter();

$see_terms = null;
$mobile_terms_url = $this->card->get('terms_mobile_url');
?>

<div class="card-category-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<div class="other-subnav-hldr">
					<ol class="breadcrumb-other">
						<li><a href="/">Credit Cards </a> <i class="fa fa-angle-right"></i></li>
						<li><a href="/<?= $this->cardpage->get('pageLink') ?>.php"><?= $this->cardpage->get('pageName') ?> </a><i class="fa fa-angle-right"></i></li>
						<li class="active"><?= $this->card->get('cardListingString') ?></li>
					</ol>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-24">
				<div class="card-category-disclosure-hldr">
					<a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img class="pull-right" src="/images/advertiser_dis_text.png" /></a>

					<div class="clearfix"></div>
				</div>
				<!--card-category-disclosure-hldr-->

				<div class="res-schumer-box-pd">
					<div class="row">
						<div class="col-sm-18 col-md-19 col-lg-19">
							<div class="res-offer-left">
								<h1>
									<?= $this->card->get('cardTitle') ?>
								</h1>
							</div>
							<div class="row">
								<div class="col-xs-24 col-sm-8 col-md-7 col-lg-6">
									<div class="row">
										<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
											<div class="res-cc-card-art-align">
												<a href="<?= '<?= $strApplyPath ?>'; ?>" target="_blank" name="&lid=<?= $linkName ?>">
													<img
														src="<?= IMGSYNERGY_191X120_CARD_IMAGE_ROOT ?>/<?= $this->card->get('imagePath') ?>"
														border="0" class="img-responsive"
														alt="<?= $this->card->get('cardIOAltText') ?>">
												</a>
											</div>
											<?php echo '<?php if(REVIEWS_ENABLED): ?>'; ?>
											<div class="mobile-hide">
												<div class="pd-star-rating">
													<?php
													if(REVIEWS_ENABLED) {
														if($review_data->rating != null) {
															$rating = $review_data->rating[0]->overall_rating;
															$total_reviews = $review_data->rating[0]->total_reviews;
															//Create the link to the reviews located on the product details page.
															$detailPageLink = "/" . $this->siteProp['individualcarddir'] . "/" . $linkName . "." . $this->siteProp['pagetype'] . "?catid=" . $this->page->get('fid');
															//Formatt the number for the stars to have one decimal place...4.567 becomes 4.6
															$formatted_number = number_format($rating, 1, ".", "");
															echo "<input type='number' class='category-star-rating rating' data-show-caption='false' data-size='xs' value='$formatted_number'>";
															//Wrap the total number of reviews for that card in a link to the product details page.
															echo "<div class='category-total-reviews'><a href='#user_reviews_anchor'>".number_format($total_reviews)." customer reviews</a></div>";
														}
													}
													?>
												</div><!--pd-star-rating-->
											</div><!--mobile-hide-->
											<?php echo '<?php endif; ?>'; //closing REVIEWS_ENABLED ?>
										</div>
										<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
											<div class="res-field-apply-now-768">
												<a class="btn btn-apply btn-lg btn-block" href="<?= '<?= $strApplyPath ?>'; ?>" target="_blank" name="&lid=" . $linkName >
												<i class="fa fa-lock fa-lg"></i> &nbsp;APPLY ONLINE
												</a>
												<br>
												<br>
												<?php
												$phoneNumber = $this->card->get('applyByPhoneNumber');
												if (!empty($phoneNumber)) {
													?>
													<a class="btn btn-primary btn-lg btn-block"
													   href="tel:<?= $this->card->get('applyByPhoneNumber') ?>"
													   onclick="var s=s_gi('ccardsccdc-us'); s.linkTrackVars='eVar25,eVar1,products,events'; s.linktrackevents='event4'; s.events='event4'; s.eVar25='<?= '<?= $catid ?>' ?>'; s.eVar1='<?= $this->page->get('fid') ?>'; s.products='<?= '<?= $catid ?>' ?><?= ';'. $this->card->get('cardId').';0;0' ?>'; s.tl(this,'o','Apply by Phone');">
														<i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
													</a>
												<?php } ?>
												<div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br /><?= $this->cardData['Credit Needed'] ?></span></div>
											</div>
										</div>
									</div>
									<!--row-->
								</div>
								<!--col-xs-24 col-sm-8 col-md-7 col-lg-6-->
								<div class="col-xs-24 col-sm-14 col-md-17 col-lg-18">
									<div class="res-details">
										<?= $detailText ?>
									</div>
									<!--res-details-->
								</div>
								<!--col-xs-24 col-sm-14 col-md-17 col-lg-18-->
							</div>
							<!--row-->
						</div>
						<!--col-sm-18 col-md-19 col-lg-19-->
						<div class="col-sm-6 col-md-5 col-lg-5 apply-now-btn-padding">
							<div class="res-field-apply-now">
								<a class="btn btn-apply btn-lg"
								   href="<?= '<?= $strApplyPath ?>'; ?>" target="_blank" name="&lid=<?= $linkName ?>">
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
						<!--col-sm-6 col-md-5 col-lg-5 apply-now-btn-padding-->
					</div>
					<!--row-->
					<div class="row">
						<div class="col-sm-24 col-md-24 col-lg-24">
							<div class="res-card-data-hldr">
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
										<div style="clear:both;"></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<!--row-->
				</div>
				<!--res-schumer-box-pd-->

				<br>
				<?php
				//For desktop, Rates and Fees link will only appear if URL exists.
				$rates_fees = !empty($mobile_terms_url) ? "<a href=\"".$mobile_terms_url. "\" target=\"_blank\">See Rates & Fees</a>" : "" ;
				?>
				<div class="see-terms-schumer-desktop <?= $hideMobile ?>" style="margin-top: 15px;"><?= $rates_fees ?></div>
				<?php
				//See terms link will either be a specific terms link OR it will just be the offer link. This is some confusing crap.
				$see_terms = !empty($mobile_terms_url) ? $mobile_terms_url : '<?= $strApplyPath ?>';
				?>

				<div class="see-terms-schumer-mobile <?= $hideMobile ?>"><a href="<?= $see_terms ?>" target="_blank">See Rates & Fees</a></div>
				<!--see terms-->

				<?php echo '<?php if(REVIEWS_ENABLED): ?>'; ?>

					<?php
					if (REVIEWS_ENABLED) { ?>

						<div class="row">
							<div class="col-sm-24 col-md-24 col-lg-24">
								<h2 class="review_header" id="staff_review"><?= $this->card->get('cardTitle') ?> - Staff Review</h2>
							</div><!--column-->
						</div><!--row-->

						<?php
						//API call to get staff review if it exists for a given card.
						$showDefaultText = true;
						if ($review_data->staff_review != null) {
							//Show the review header.
							showReview($review_data->staff_review);
							$showDefaultText = false;
						}

						if($showDefaultText) { ?>

							<div class="row">
								<div class="col-sm-24 col-md-24 col-lg-24">
									<p>Apply for the <?= $this->card->get('cardTitle') ?> from our partner by filling out a secure online application.</p>
								</div><!--column-->
							</div><!--row-->

						<?php
						}
						?>

						<?php if (!$showDefaultText): ?>
							<div class="row apply-online-row">
								<div class="col-sm-5 col-md-5 col-lg-5">
									<div class="res-field-apply-now apply-now-below-staff-review">
									<a class="btn btn-apply btn-lg" href="<?= '<?= $strApplyPath ?>'; ?>" target="_blank" name="&lid=" . <?= $linkName ?> >
										<i class="fa fa-lock fa-lg"></i> &nbsp;APPLY ONLINE
									</a>
									</div>
								</div>
							</div>

						<?php endif; ?>

						<div class="row">
							<div class="col-sm-24 col-md-24 col-lg-24">
								<div class="review-disclaimer">
									<p>All reviews are prepared by CreditCards.com staff. Opinions expressed therein are solely
										those of the reviewer. The information, including card rates and fees, presented in the review is
										accurate as of the date of the review.</p>
								</div>
							</div><!--column-->
						</div><!--row-->

						<hr>

						<div class="row">
							<div class="col-sm-24 col-md-24 col-lg-24">
								<div class="quick-links-hldr">
									<div class="quick-links-title">Quick Links</div>
									<br>
									<?php
									//Suppress this link if the card doesn't have a page link.
									$pagelink = $this->cardpage->get('pageLink');
									if(!empty($pagelink)) {
									?>
										<a href="/<?= $this->cardpage->get('pageLink') ?>.php">More cards you may be interested in</a>
									<br>
									<br>
									<?php } ?>
									<a href="/glossary/">Credit Card Glossary</a>
									<br>
									<br>
									<a href="/credit-card-news/help/">Credit Card Basics & Help</a>
								</div>
							</div><!--column-->
						</div><!--row-->

						<br>
						<!--Anchor has to be above the USER REVIEWS title to compensate for navbar coverage-->
						<span id="user_reviews_anchor"></span>

						<div class="row">
							<div class="col-sm-24 col-md-24 col-lg-24">
								<div class="complaint_text">
									<p>Report a complaint - <a href="http://www.consumerfinance.gov/complaint/" target="_blank">Consumer Financial Protection Bureau</a></p>
								</div>
							</div><!--column-->
						</div><!--row-->

						<div class="mobile-hide">

						<hr>

						<!--BEGIN REVIEW STATS-->
						<?php

						if ($review_data->stats != null) {

								//These links need to be created at run time, but only if there is actually review stats.
								echo '<?php
									if(isset($catid)) {

										$reviewApplyLink = "/oc/?pid=' . $linkCardId . '&pg=$catid&pgpos=' . $linkPosition . '&catid=' . $linkExitPageId . '";

									} else {

										$reviewApplyLink = "/oc/?pid=' . $linkCardId . '&pg=' . $linkExitPageId . '&pgpos=' . $linkPosition . '&catid=' . $linkExitPageId . '";
									}
									?>';
								?>

								<!--If there are user stats, then there will definitely be user reviews.  Start by adding
								the title for this section-->
								<div class="row">
									<div class="col-sm-16 col-md-16 col-lg-16">
										<h2 class="review_header"><?= $this->card->get('cardTitle') ?> - User Reviews</h2>
									</div><!--column-->
									<div class="col-sm-8 col-md-8 col-lg-8">
										<div class="starrating_info">
											Ratings and reviews provided by issuer as of <?= $review_data->stats[0]->latest_date ?>.
											<br>
											<a href="/oc/?pid=<?= $this->card->get('cardId') ?>&pg=<?= $this->page->get('fid') ?>&pgpos=<?= $this->cardNumber ?>"
											   target="_blank" name="&lid=<?= $linkName ?>">
											See the latest reviews on the card issuer's site.
											</a>
										</div>
									</div><!--column-->
								</div><!--row-->

								<hr class="review_hr">

								<?php
								//Show the review header.
								showStats($review_data->stats[0], '<?= $reviewApplyLink ?>');
							}

						?>

						<?php //BEGIN: product detail page reviews
						//API call with return null if there is any sort of error, so we will skip the entire review section if that happens.
						if ($review_data->reviews != null) {
							//Show the reviews
							showReviews($review_data->reviews, $linkCardId);
						}
						}
						?>

				</div>
				<!--mobile-hide-->
				<?php echo '<?php endif; ?>'; //closing REVIEWS_ENABLED ?>
			</div>

		</div>
		<!--col-md-24-->
	</div>
	<!--row-->
</div><!--container-->
</div><!--card-category-block-->

<!-- Site Back Up Block-->
<div class="back-to-top-block">
	<div class="container">
		<div class="row">
			<div class="col-md-24">
				<a class="back-to-top" href="#Page-Top" style="display:none;"><i class="fa fa-chevron-up"></i><br><br>BACK<br>TO TOP</a>
			</div>
			<div class="col-md-24 see-terms-footer">
				<div class="credit-card-details">
					See the online <?= $this->card->get('cardTitle') ?> application for details about terms and conditions of offer.
					Reasonable efforts are made to maintain accurate information. However all credit card information is presented
					without warranty. When you click on the &quot; Apply Now &quot; button you can review the credit card terms and
					conditions on the credit card issuer's web site.
				</div>

			</div>

			<div class="col-md-24 see-terms-footer-mobile"> * For additional rates, fees and costs see issuer's website for detailed pricing and terms. </div>

		</div>
	</div>
</div>

<script>
	$(document).ready(function() {

		<?php
           //If the catid is in the url...use it.  $catid is captured in the header.tpl.php
           //Else, if not set, use the FID with is set as the $linkExitPageId in the individual_card_listing pages.
            echo '<?php
                if(isset($catid)) {

                    $catId = $catid;

                } else {

                    $catId = "' . $linkExitPageId . '";
                }
                ?>';
            ?>

		//Get the review url.  There should be an <a> in the .staff-review-text container whose link text states
		//"Read full review"  if there is...get the href for the <a> tag and attach the catid.
		var reviewLink = $('.staff-review-text a:contains("Read full review")');
		//Add the category/fid to the url
		var newLink = reviewLink.attr('href') + '?catid=<?= '<?= $catId ?>' ?>';

		reviewLink.attr('href', newLink);
	});
</script>