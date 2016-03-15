<?php
/**
 * Name: Balance Transfer Schumer Box
 * Type: partials-schumers
 * Description: Balance Transfer Schumer Box
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>
<div class="res-schumer-box ">
	<div class="row">
		<div class="col-sm-18 col-md-18 col-lg-18">
            @if($card->pivot->rank == 1)
                <div class="res-offer-left-featured"><span class="res-top-pick2"></span>
                    @else
                        <div class="res-offer-left">
                            @endif
                            <div>
                                <a href="credit-cards/{{ $card->slug}}.php?catid={{  $page->category_id }}" name="{{ $card->card_id}}" id="a{{ $card->card_id}}">{{ $card->name}}</a>
                            </div>
                </div>
			<!--res-offer--left-->
			<div class="row">
				<div class="col-xs-24 col-sm-8 col-md-9 col-lg-7">
					<div class="row">
						<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
							<div class="res-cc-card-art-align">
								<a name="&amp;lid={{ $card->name}}" target="_blank" href="{{ $card->link_url }}">
									<img border="0" alt="{{ $card->name}} Application" class="img-responsive" src="http://www.imgsynergy.com/191x120/{{ $card->image }}">
								</a>
							</div>

							@if($card->review_count > 0)
								<div class="mobile-hide">
									<div class="star-rating rating-xs rating-disabled">
										<div class="rating-container rating-uni" data-content="★★★★★">
											<div class="rating-stars" data-content="★★★★★" style="width: 96%;"></div>
											<input type="number" value="{{ $card->overall_rating }}" data-size="xs" data-show-caption="false" class="category-star-rating rating form-control" style="display: none;">
										</div>
									</div>
									<div class="category-total-reviews"><a href="credit-cards/{{ $card->slug}}.php?catid={{  $page->category_id }}">{{ $card->review_count }} customer reviews</a></div>
								</div>
								<!--mobile-hide-->
							@endif
						</div>
						<div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
							<div class="res-field-apply-now-768">
								<a name="&lid={{ $card->name}}" target="_blank" href="{{ $card->link_url }}" class="btn btn-apply btn-lg btn-block">
									<i class="fa fa-lock fa-lg"></i>
									&nbsp;APPLY
									ONLINE</a>
								<br>
								<!--Only show the apply by phone number button if card has a phone number-->
								<p class="issuer">at {{ $card->advertiser_name }}'s <br>secure site</p>
								<a onclick="var s=s_gi('ccardsccdc-us'); s.linkTrackVars='eVar25,products,events'; s.linktrackevents='event4'; s.events='event4'; s.eVar25='12'; s.products='12;220610109;0;0'; s.tl(this,'o','Apply by Phone');" href="tel:877-827-8836" class="btn btn-primary btn-lg btn-block">
									<i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
								</a>

								<div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br>{{ $card->credit_needed_display }}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--column-->
				<div class="col-xs-24 col-sm-14 col-md-15 col-lg-17">
                    <div class="res-details">
                        {!! $card->bullets !!}
                        <ul>
                            <li>See additional <a href="credit-cards/{{ $card->slug}}.php?catid={{  $page->category_id }}">{{  $card->issuer_name }} Credit Card details</a></li>
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
				<a name="&amp;lid={{ $card->name}}" target="_blank" href="/oc/?pid={{ $card->card_id}}&;pg=12&;pgpos=1" class="btn btn-apply btn-lg">
					<i class="fa fa-lock fa-lg"></i>
					&nbsp;APPLY NOW
				</a>
				<br>
				<p>at {{ $card->advertiser_name }}'s <br>
					secure site</p>
				<p class="apply-call">
					<span>or call {{ $card->advertiser_name }} at <br><b>877-827-8836</b></span>
				</p>
				<br>

				<div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br>{{ $card->credit_needed_display }}</span>
				</div>
			</div>
		</div>
		<!--column-->

	</div>
	<!--column-->

	<div class="row">
		<div class="col-sm-24 col-md-24 col-lg-24">
			<div class="res-card-data-hldr">


				<ul class="responsive-table-bt">
					<li class="first-row">
						<dl>
							<dt>Balance Transfers Intro APR</dt>
							<dd>{{ $card->bt_intro_apr_display }}
								<input type="hidden" value="0%" id="bt-intro-apr-{{ $card->card_id}}">
								<input type="hidden" value="18" id="bt-intro-period-{{ $card->card_id}}">
							</dd>
						</dl>
						<dl>
							<dt>Balance Transfer Fee</dt>
							<dd>{{ 'fix' }}
								<input type="hidden" value="3.000" id="bt-fee-{{ $card->card_id}}">
							</dd>
						</dl>
						<dl>
							<dt>Regular
								APR
							</dt>
							<dd>{{ $card->bt_reg_apr_display }}<input type="hidden" value="10.990" id="bt-min-apr-220610109">
							</dd>
						</dl>
						<dl>
							<dt>Annual
								Fee
							</dt>
							<dd>{{ $card->annual_fee_display }}</dd>
						</dl>
						<dl>
							<dt>
								Credit Needed
							</dt>
							<dd>{{ $card->credit_needed_display }}</dd>
						</dl>
						<dl>
							<dt><a id="card-estimate-{{ $card->card_id}}" style="color:#66c0ff; cursor:pointer; text-decoration: none" class="card-estimate-button" name="card-estimate-button">
									<i data-target="#bt-calculator-modal" data-toggle="modal" class="fa fa-info-circle fa-lg card-estimate-button"></i>
								</a>
								Potential Savings Estimate*
							</dt>
							<input type="hidden" id="bt-calc-exclude-{{ $card->card_id}}" value="0">
							<dd class="potential_savings" id="bt-calc-result-{{ $card->card_id}}">$299.92</dd>
						</dl>
					</li>
				</ul>


				<div style="clear:both;"></div>
			</div>
			<!--res-card-data-hldr-->
		</div>
		<!--column-->
	</div>
	<!--row-->
</div>

<div class="row see-terms-link-row">
    <div class="col-lg-24">
		@if(!empty($card->terms_url))
			<a href="{{  $card->terms_url }}" alt="Rates and Fees Link">See Rates & Fees</a>
		@endif
	</div>
</div>
