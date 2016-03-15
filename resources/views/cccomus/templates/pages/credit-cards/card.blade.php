<?php
/**
 * Name: Card Detail Page
 * Type: credit-cards
 * Description: Creditcard Detail Page
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>

@extends('cccomus.templates.layouts.master')

@section('title', $card->name)

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')
    <div class="card-category-block">
        <div class="container">
            <div class="row">
                <div class="col-md-24">
                    <div class="other-subnav-hldr">
                        <ol class="breadcrumb-other">
                            <li><a href="/">Credit Cards </a> <i class="fa fa-angle-right"></i></li>
                            <li><a href="/Bank-of-America.php">{{ $card->issuer_name }}</a><i class="fa fa-angle-right"></i></li>
                            <li class="active">{{ $card->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-24">
                    <div class="card-category-disclosure-hldr">
                        <a data-target="#myModalDisclosure" data-toggle="modal" href="#"><img src="/images/advertiser_dis_text.png" class="pull-right"></a>

                        <div class="clearfix"></div>
                    </div>
                    <!--card-category-disclosure-hldr-->

                    <div class="res-schumer-box-pd">
                        <div class="row">
                            <div class="col-sm-18 col-md-19 col-lg-19">
                                <div class="res-offer-left">
                                    <h1>{{ $card->name }}</h1>
                                </div>
                                <div class="row">
                                    <div class="col-xs-24 col-sm-8 col-md-7 col-lg-6">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                                <div class="res-cc-card-art-align">
                                                    <a name="{{ $card->name }}" target="_blank" href="{{ $card->link_url }}&catid=<?= '<?= $_GET["catid"] ?>' ?>">
                                                        <img border="0" alt="{{ $card->name}} Application" class="img-responsive" src="http://www.imgsynergy.com/191x120/{{ $card->image }}">
                                                    </a>
                                                </div>
                                                @if($card->overall_rating > 0)
                                                <div class="mobile-hide">
                                                    <div class="pd-star-rating">
                                                        <div class="star-rating rating-xs rating-disabled">
                                                            <div class="rating-container rating-uni" data-content="★★★★★">
                                                                <div class="rating-stars" data-content="★★★★★" style="width: 96%;"></div>
                                                                <input type="number" value="{{ $card->overall_rating }}" data-size="xs" data-show-caption="false" class="category-star-rating rating form-control" style="display: none;"></div>
                                                        </div><div class="category-total-reviews"><a href="#user_reviews_anchor">{{ $card->review_count }} customer reviews</a></div>
                                                    </div>
                                                </div><!--mobile-hide-->
                                                @endif
                                            </div>
                                            <div class="col-xs-12 col-sm-24 col-md-24 col-lg-24">
                                                <div class="res-field-apply-now-768">
                                                    <a $linkname="" .="" name="&amp;lid=" target="_blank" href="{{ $card->link_url }}&catid=<?= '<?= $_GET["catid"] ?>' ?>" class="btn btn-apply btn-lg btn-block">
                                                        <i class="fa fa-lock fa-lg"></i> APPLY ONLINE
                                                    </a>
                                                    <br>
                                                    <br>
                                                    <a onclick="var s=s_gi('ccardsccdc-us'); s.linkTrackVars='eVar25,eVar1,products,events'; s.linktrackevents='event4'; s.events='event4'; s.eVar25='12'; s.eVar1='2064'; s.products='12;220610109;0;0'; s.tl(this,'o','Apply by Phone');" href="tel:877-827-8836" class="btn btn-primary btn-lg btn-block">
                                                        <i class="fa fa-phone fa-lg"></i> &nbsp;APPLY BY PHONE
                                                    </a>
                                                    <div class="credit-needed-hldr">Credit Needed <span style="color:#16487b  ; font-weight:bold;"><br>Excellent/Good</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--row-->
                                    </div>
                                    <!--col-xs-24 col-sm-8 col-md-7 col-lg-6-->
                                    <div class="col-xs-24 col-sm-14 col-md-17 col-lg-18">
                                        <div class="res-details">
                                            {!! $card->bullets !!}
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
                                    <a name="&lid={{ $card->slug }}" target="_blank" href="{{ $card->link_url }}&catid=<?= '<?= $_GET["catid"] ?>' ?>" class="btn btn-apply btn-lg">
                                        <i class="fa fa-lock fa-lg"></i> APPLY NOW
                                    </a>
                                    <br>
                                    <p>at {{ $card->issuer_name }}'s <br>
                                        secure site</p>
                                    <p class="apply-call">
                                        <span>or call {{ $card->issuer_name }} at <br><b>877-827-8836</b></span>
                                    </p>
                                    <br>
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
                                                <dd>{{ $card->purchases_intro_apr_display }}</dd>
                                            </dl>
                                            <dl>
                                                <dt>Balance Transfers Intro APR</dt>
                                                <dd>{{ $card->bt_intro_apr_display }}</dd>
                                            </dl>
                                            <dl>
                                                <dt>Regular
                                                    APR
                                                </dt>
                                                <dd>{{ $card->purchases_reg_apr_display }}</dd>
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
                    <div style="margin-top: 15px;" class="see-terms-schumer-desktop ">
                        <a target="_blank" href="https://consumer.bankofamerica.com/USCCapp/Ctl/entry?sc=VACJCP&amp;pid=dppf">See Rates &amp; Fees</a>
                    </div>

                    <div class="see-terms-schumer-mobile ">
                        <a target="_blank" href="https://consumer.bankofamerica.com/USCCapp/Ctl/entry?sc=VACJCP&amp;pid=dppf">See Rates &amp; Fees</a>
                    </div>
                    <!--see terms-->


                    <div class="row">
                        <div class="col-sm-24 col-md-24 col-lg-24">
                            <h2 id="staff_review" class="review_header">BankAmericard&reg; Credit Card - Staff Review</h2>
                        </div><!--column-->
                    </div><!--row-->


                    <div class="row">
                        <div class="col-sm-24 col-md-24 col-lg-24">
                            <p>Apply for the {!! $card->issuer_name !!} Credit Card from our partner by filling out a secure online application.</p>
                        </div><!--column-->
                    </div><!--row-->



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
                                <a href="/Bank-of-America.php">More cards you may be interested in</a>
                                <br>
                                <br>
                                <a href="/glossary/">Credit Card Glossary</a>
                                <br>
                                <br>
                                <a href="/credit-card-news/help/">Credit Card Basics &amp; Help</a>
                            </div>
                        </div><!--column-->
                    </div><!--row-->

                    <br>
                    <!--Anchor has to be above the USER REVIEWS title to compensate for navbar coverage-->
                    <span id="user_reviews_anchor"></span>

                    <div class="row">
                        <div class="col-sm-24 col-md-24 col-lg-24">
                            <div class="complaint_text">
                                <p>Report a complaint - <a target="_blank" href="http://www.consumerfinance.gov/complaint/">Consumer Financial Protection Bureau</a></p>
                            </div>
                        </div><!--column-->
                    </div><!--row-->

                    <div class="mobile-hide">

                        <hr>

                        <!--BEGIN REVIEW STATS-->


                    </div>
                    <!--mobile-hide-->
                </div>

            </div>
            <!--col-md-24-->
        </div>
        <!--row-->
    </div>

@endsection