<?php
/**
 * Name: Personal Loans Schumer Box
 * Type: partials-schumers
 * Description: Personal Loans Schumer Box
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>



<div class="res-schumer-box ">
	<div class="row">
		<div class="col-sm-18 col-md-18 col-lg-18">
			<div>
				<span class="res-top-pick2"></span>
				<a href="credit-cards/<?= $card->slug?>?catid=<?=  $page->category_id ?>" name="<?= $card->card_id?>" id="a<?= $card->card_id?>"><?= $card->name?></a>
			</div>
			<!--res-offer--left-->
			<div class="row">
				<div class="col-xs-24 col-sm-8 col-md-9 col-lg-7">
					<div class="row">
						<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
							<div class="res-cc-card-art-align">
								<a name="&amp;lid=<?= $card->name?>" target="_blank" href="<?=  $card->link_url ?>">
									<img border="0" alt="<?= $card->name?> Application" class="img-responsive" src="http://www.imgsynergy.com/191x120/<?=  $card->image ?>">
								</a>
							</div>

							<div class="mobile-hide">
							</div>
							<!--mobile-hide-->
						</div>
						<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
							<div class="res-field-apply-now-768">
								<a name="&amp;lid=<?= $card->name?>" target="_blank" href="<?=  $card->link_url ?>" class="btn btn-apply btn-lg btn-block">
									<i class="fa fa-lock fa-lg"></i>
									&nbsp;APPLY
									ONLINE</a>
								<br>
								<!--Only show the apply by phone number button if card has a phone number-->
								<p class="issuer">at <?=  $card->advertiser_name ?>'s <br>secure site</p>
								<a onclick="var s=s_gi('ccardsccdc-us'); s.linkTrackVars='eVar25,products,events'; s.linktrackevents='event4'; s.events='event4'; s.eVar25='12'; s.products='12;220610109;0;0'; s.tl(this,'o','Apply by Phone');" href="tel:877-827-8836" class="btn btn-primary btn-lg btn-block">
									<i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
								</a>

								<div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br><?=  $card->credit_needed_display ?></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--column-->
				<div class="col-xs-24 col-sm-14 col-md-15 col-lg-17">
					<div class="res-details">
						<?=  $card->bullets ?>
						<ul>
							<li>See additional <a href="credit-cards/<?= $card->slug?>?catid=<?=  $page->category_id ?>"><?=  $card->advertiser_name ?> Credit Card details</a></li>
						</ul>
					</div>

					<div class="show-more-link">
						<a href="#" >Show More <i class="fa fa-chevron-down"></i></a>
					</div>
					<!--res-details-->
				</div>
				<!--column-->
			</div>
			<!--row-->

		</div>

		<div class="col-sm-6 col-md-6 col-lg-6 apply-now-btn-padding">
			<div class="res-field-apply-now">
				<a name="&amp;lid=<?= $card->name?>" target="_blank" href="/oc/?pid=<?= $card->card_id?>&;pg=<?=  $page->category_id ?>&;pgpos=<?= 1 ?>" class="btn btn-apply btn-lg">
					<i class="fa fa-lock fa-lg"></i>
					&nbsp;APPLY NOW
				</a>
				<br>
				<p>at <?=  $card->advertiser_name ?>'s <br>secure site</p>
				<p class="apply-call">
					<span>or call <?=  $card->advertiser_name ?> at <br><b>877-827-8836</b></span>
				</p>
				<br>

				<div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br><?=  $card->credit_needed_display ?></span>
				</div>
			</div>
		</div>
		<!--column-->

	</div>
	<!--column-->

	<div class="row">
		<div class="col-sm-24 col-md-24 col-lg-24">
			<div class="res-card-data-hldr">


				<ul class="responsive-table">
					<li class="first-row">
						<dl>
							<dt>Purchases Intro APR</dt>
							<dd>
								<?=  $card->purchases_intro_apr_display ?>
							</dd>
						</dl>
						<dl>
							<dt>Balance Transfers Intro APR</dt>
							<dd>
								<?=  $card->bt_intro_apr_display ?>
							</dd>
						</dl>
						<dl>
							<dt>Regular
								APR
							</dt>
							<dd>
								<?=  $card->purchases_reg_apr_display ?>
							</dd>
						</dl>
						<dl>
							<dt>Annual
								Fee
							</dt>
							<dd>
								<?=  $card->annual_fee_display ?>
							</dd>
						</dl>
						<dl>
							<dt>
								Credit Needed
							</dt>
							<dd>
								<?=  $card->credit_needed_display ?>
							</dd>
						</dl>
					</li>
				</ul>
			</div>
			<!--res-card-data-hldr-->
		</div>
		<!--column-->
	</div>
	<!--row-->
</div>
<div class="row see-terms-link-row">
	<div class="col-lg-24">
		<a href="<?=  $card->terms_url ?>" alt="Rates and Fees Link">See Rates & Fees</a>
	</div>
</div>


