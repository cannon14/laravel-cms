<?php
/**
 * Name: Home Page
 * Type: pages
 * Description: Home Page
 * Version: 1.0.0
 * Date: 2015-11-20
 */
?>

@extends('cccomus.templates.layouts.master')

@section('title', 'Creditcards.com')

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

<!-- Site Banner Block-->
<div class="banner-block">
    <div class="item">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="top-banner-text">Find a credit card that's <span style="color:#429e5d;"><strong>right</strong></span> for you</div>
                    <h1>Compare credit card offers from our partners</h1>
                    <div class="advertiser-disclosure"><a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img src="images/advertiser_dis_text.png" width="120" height="9"/></a></div>
                    <div class="banner-hero-card"><img class="img-responsive" src="/images/hero-card.png"/></div>
                    <div class="banner-form-select">
                        <form class="form-inline-hero" role="form">
                            <div class="form-group-hero input-lg-hero ">
                                <select id="hero_list_value" class="form-control-hero" onchange="window.location='/'+this.value+'.php';">
                                    <option selected="selected">-- Select a Card Category --</option>
                                    <option value="cash-back">Cash Back</option>
                                    <option value="reward">Rewards</option>
                                    <option value="airline-miles">Airline</option>
                                    <option value="balance-transfer">Balance Transfer</option>
                                    <option value="0-apr-credit-cards">0% APR</option>
                                    <option value="business">Business</option>
                                    <option value="fair-credit">Fair Credit</option>
                                    <option value="bad-credit">Bad Credit</option>
                                </select>
                            </div>
                        </form>

                        <!-- mobile form -->
                        <form class="form-inline-hero-mobile" role="form">
                            <div class="form-group-hero input-lg-hero ">
                                <select id="hero_list_value_mobile" class="form-control-hero-mobile">
                                    <option selected="selected">Select a Category</option>
                                    <option value="/fair-credit.php">Fair Credit</option>
                                    <option value="/bad-credit.php">Bad Credit</option>
                                    <option value="/no-credit-history.php">Limited or No Credit History</option>
                                    <option value="/low-interest.php">Low Interest</option>
                                    <option value="/no-annual-fee.php">No Annual Fee</option>
                                    <option value="/0-apr-credit-cards.php">0% APR</option>
                                    <option value="/balance-transfer.php">Balance Transfer</option>
                                    <option value="/reward.php">Rewards</option>
                                </select>
                            </div>
                            <input style="display:none" value="GO" type="button" id="hero_btn_mobile" class="btn-hero btn-success-hero">
                            <input value="GO" type="button" id="placeholder-mobile" class="btn-hero btn-success-hero">
                        </form>
                    </div>
                </div>
                <div class="bg-img hidden-xs"></div>
            </div>
        </div>
    </div>
</div>
<!--banner-block-->

<!-- Site Action Block -->
<div class="action-block">
    <div class="container">
        <div class="action-hldr">
            <div class="action-card-img">
                <img width="100%;" src="/images/mycc-cardmatch-banner.png">
                <a class="cardmatch" target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form"></a>
                <a class="mycreditcards" target="_blank" href="https://my.creditcards.com/?qls=MCC_DHMEBANR.080315CRED"></a>
            </div>
        </div>
        <div class="action-hldr-mobile">
            <a target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form">
                <img src="/images/cardmatch-mobile-banner.png" class="img-responsive">
            </a>
        </div>
    </div>
</div>
<div class="action-strip"><img class="img-responsive hidden-xs" src="/images/media-mentions.png"/></div>

<!-- Site Main Content Block-->
<div class="maincontent-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Credit Card Search Categories</h3>

                <div class="row">
                    <div class="col-xs-24 col-sm-8 col-md-8">
                        <div class="panel panel-simple">
                            <div class="panel-heading"><i class="fa fa-bar-chart fa-lg" style="color:#156abd;"></i>
                                Rates & Fees
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li><a href="/balance-transfer.php">Balance Transfer</a></li>
                                    <li><a href="/0-apr-credit-cards.php">0% APR</a></li>
                                    <li><a href="/low-interest.php">Low Interest cards</a></li>
                                    <li><a href="/no-annual-fee.php">No Annual Fee</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-24 col-sm-8 col-md-8">
                        <div class="panel panel-simple">
                            <div class="panel-heading"><i class="fa fa-gift fa-lg" style="color:#156abd;"></i> Earn
                                Rewards
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li><a href="/cash-back.php">Cash Back Cards</a></li>
                                    <li><a href="/reward.php">Rewards Credit Cards</a></li>
                                    <li><a href="/points-rewards.php">Points Cards</a></li>
                                    <li><a href="/gas-cards.php">Gas Credit Cards</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-24 col-sm-8 col-md-8">
                        <div class="panel panel-simple">
                            <div class="panel-heading"><i class="fa fa-plane fa-lg" style="color:#156abd;"></i> Travel
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li><a href="/airline-miles.php">Airline Credit Cards</a></li>
                                    <li><a href="/hotel-cards.php">Hotel Cards</a></li>
                                    <li><a href="/no-foreign-transaction-fee.php">No Foreign Transaction Fee</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-24 col-sm-8 col-md-8">
                        <div class="panel panel-simple">
                            <div class="panel-heading"><i class="fa fa-tachometer fa-lg" style="color:#156abd;"></i>
                                Credit Quality
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li><a href="/excellent-credit.php">Excellent Credit</a></li>
                                    <li><a href="/good-credit.php">Good Credit</a></li>
                                    <li><a href="/fair-credit.php">Fair Credit</a></li>
                                    <li><a href="/bad-credit.php">Bad Credit</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-24 col-sm-8 col-md-8">
                        <div class="panel panel-simple">
                            <div class="panel-heading"><i class="fa fa-credit-card fa-lg" style="color:#156abd;"></i>
                                Card Type
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li><a href="/top-credit-cards.php">Top Credit Cards</a></li>
                                    <li><a href="/business.php">Business</a></li>
                                    <li><a href="/college-students.php">Student Cards</a></li>
                                    <li><a href="/prepaid.php">Prepaid / Debit</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-24 col-sm-8 col-md-8">
                        <div class="panel panel-simple">
                            <div class="panel-heading"><i class="fa fa-wrench fa-lg" style="color:#156abd;"></i> Tools
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled">
                                    <li><a href="/cardmatch/?action=show_form" target="_blank">CardMatch&#8482;</a></li>
                                    <li><a href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=home_category&utm_campaign=walletup" target="_blank">WalletUp&#8482;</a></li>
                                    <li><a href="/best-credit-cards.php">Best Credit Cards</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <div class="col-md-12">
                <h3>Latest Credit Card News</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="latest-news-hldr">
                            <!-- STORY 1-->
                            <div class="storyhome-hldr"><div class="storyhome-content">
                                    <h3><a href="/credit-card-news/balance-transfer-survey.php">Balance transfer survey:<br>You better act quickly</h3></a>
                                    <p>Our survey finds  where the best offers are .. See <a href="/credit-card-news/balance-transfer-survey.php">Balance transfer</a></p></div>
                                <a href="/credit-card-news/balance-transfer-survey.php">
                                    <img src="/credit-card-news/images/good-better-best-cc-thumb.jpg" width="56" height="69" class="latesthome-img" /> </a>
                                <div style="clear:both;"></div></div>
                            <!-- STORY 2-->
                            <div class="storyhome-hldr"><div class="storyhome-content">
                                    <h3><a href="/credit-card-news/rating-fraud-not-all-security-breaches-are-equal-1264.php">Rating fraud on a scale<br>from low-risk to omigod</h3></a>
                                    <p>
                                        Some fraud is an easy fix; others take time and patience ... See <a href="/credit-card-news/rating-fraud-not-all-security-breaches-are-equal-1264.php">Fraud</a></p></div>
                                <a href="/credit-card-news/rating-fraud-not-all-security-breaches-are-equal-1264.php">
                                    <img src="/credit-card-news/images/fraud-risk-gauge-pills-thumb.jpg" width="56" height="69" class="latesthome-img" /> </a>
                                <div style="clear:both;"></div></div>

                            <!-- STORY 3-->
                            <div class="storyhome-hldr"><div class="storyhome-content">
                                    <h3><a href="/credit-card-news/balance-transfer-survey.php">Combining cards: Rolling 2 credit limits into 1 card</h3></a>
                                    <p>Little-known practice helps preserve credit scores ... See <a href="/credit-card-news/combining-cards-credit-limits-1267.php">Combine</a></p></div>
                                <a href="/credit-card-news/combining-cards-credit-limits-1267.php">
                                    <img src="/credit-card-news/images/combined-credit-line-thumb.jpg" width="56" height="69" class="latesthome-img" /> </a>
                                <div style="clear:both;"></div></div>

                            <!-- STORY 4 -->
                            <div class="storyhome-hldr"><div class="storyhome-content">
                                    <h3><a href="/credit-card-news/debt-repayment-collection-1294.php">Don't agree to debt repayment you can't afford</h3></a>
                                    <p>Stick to your budget when dealing with pushy collectors ... See <a href="/credit-card-news/debt-repayment-collection-1294.php">Budget</a></p></div>
                                <a href="/credit-card-news/debt-repayment-collection-1294.php">
                                    <img src="/credit-card-news/images/sally-herigstad-thumb.jpg" width="56" height="69" class="latesthome-img" /> </a>
                                <div style="clear:both;"></div></div>

                            <!-- STORY 5 -->
                            <div class="storyhome-hldr">
                                <div class="storyhome-content">
                                    <h3><a href="http://blogs.creditcards.com">Taking Charge:<br>
                                            A credit card blog</h3> </a>
                                    <p><a href="http://blogs.creditcards.com/2015/11/guilt-over-using-savings-can-lead-to-unnecessary-debt.php">Guilt can lead to unnecessary debt</a></p>
                                    <p><a href="http://blogs.creditcards.com/2015/11/be-wary-of-holiday-scams-and-free-gifts.php">Be wary of holiday scams, free 'gifts'</a></p>
                                </div>
                                <a href="http://blogs.creditcards.com/2015/11/guilt-over-using-savings-can-lead-to-unnecessary-debt.php"><img src="/credit-card-news/images/savings-vs-credit-card-thumb.jpg" width="56" height="69" class="latesthome-img" /> </a>
                                <div style="clear:both;"></div></div>                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="rate-report-hldr">
                            <div class="rate-title"><a href="/rate-report">Credit Card Rate Report</a></div>
                            <div class="rate-updated-date">Updated:
                                11-13-2015                            </div>

                            <!--Hide this div by default so if it fails it won't blink into existence then implode-->
                            <div id="rateChartArticleBox" style="display:none">
                                <!--This <p> is important because it contains the bottom border of the parent div.-->
                                <!--<p class="moreinfo" id="rateChartMoreInfo">&nbsp;</p>-->
                            </div>
                            <!--rateChartArticleBox-->
                        </div>
                        <!--rate-report-hldr-->
                    </div>
                    <!--col-md-12-->
                </div>
                <!--row-->
            </div>
            <!--col-md-12-->
        </div>
    </div>
</div>
<!-- main-block -->
<!-- Site Featured Cards Block-->
<div class="featured-block">
    <div class="container">
        <div class="featured-title">
            <h3>Featured Offers from our Partners</h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="featured-offers-hldr">
                    <div class="featured-card">
                        <a href="/cash-back.php">
                            <img src="http://www.imgsynergy.com/product_creatives/d2ad761eef249fd9f8a77f2e16b58d46.png" alt="Best Cash Back Credit Card">
                        </a>
                    </div>
                    <h2>
                        <a href="/cash-back.php">
                            BankAmericard Cash Rewards&#8482; Credit Card
                        </a>
                    </h2>
                    <p>$100 online cash rewards bonus after you spend at least $500 on purchases in the first 90 days of account opening</p>
                    <div class="featured-bottom text-center">
                        <a href="/cash-back.php">
                            Cash Back Credit Cards
                            <i class="fa fa-angle-right fa-lg" style="color:#fff; float:right;"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="featured-offers-hldr">
                    <div class="featured-card">
                        <a href="/balance-transfer.php">
                            <img src="http://www.imgsynergy.com/product_creatives/19fac21ccc8cefae9a1823281ba1bc26.png" alt="Best Balance Transfer Credit Card">
                        </a>
                    </div>
                    <h2>
                        <a href="/balance-transfer.php">
                            BankAmericard&#174; Credit Card
                        </a>
                    </h2>
                    <p>New Offer! 0% Introductory APR for 18 billing cycles for balance transfers made in the first 60 days, then, 10.99% - 20.99% Variable APR.</p>
                    <div class="featured-bottom text-center">
                        <a href="/balance-transfer.php">Balance Transfer Credit Cards
                            <i class="fa fa-angle-right fa-lg" style="color:#fff; float:right;"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="featured-offers-hldr">
                    <div class="featured-card">
                        <a href="/airline-miles.php"><img src="http://www.imgsynergy.com/142x89/capital-one-venture-rewards-credit-card-101614.png" alt="Best AirLine Miles Credit Card"></a></div>
                    <h2>
                        <a href="/airline-miles.php">
                            Capital One&reg; Venture&reg; Rewards Credit Card
                        </a>
                    </h2>
                    <p>Enjoy a one-time bonus of 40,000 miles once you spend $3,000 on purchases within the first 3 months, equal to $400 in travel</p>
                    <div class="featured-bottom text-center">
                        <a href="/airline-miles.php">Airlines Credit Cards
                            <i class="fa fa-angle-right fa-lg" style="color:#fff; float:right;"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="featured-offers-hldr">
                    <div class="featured-card">
                        <a href="/reward.php"><img src="http://www.imgsynergy.com/product_creatives/51e691b3df04cd285b2ac72c5e757327.png" alt="Best Rewards Credit Card"></a></div>
                    <h2>
                        <a href="/reward.php">
                            BankAmericard Travel Rewards&#174; Credit Card
                        </a>
                    </h2>
                    <p>Earn unlimited 1.5 points per $1 spent on all purchases, with no annual fee and no foreign transaction fees and your points don't expire</p>
                    <div class="featured-bottom text-center">
                        <a href="/reward.php">
                            Rewards Credit Cards
                            <i class="fa fa-angle-right fa-lg" style="color:#fff; float:right;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Site Sub Content Block-->
<div class="subcontent-block">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="about-cclogo"><img class="img-responsive" src="images/aboutcc_logo.png" width="230" height="88"/> </div>
            </div>
            <div class="col-md-12">
                <div class="about-cccom-content">
                    <h2> About CreditCards.com</h2>
                    <p>At CreditCards.com we&apos;ve partnered with leading banks and issuers in order to bring you credit card offers online. Offers are displayed side by side so you can easily compare key factors such as interest rates, annual fees as well as other key features.</p>
                    <br/>
                    <p>Once you have found the card from one of our partners that is best for you, you can fill out an online application and in some cases even get a credit decision within 60 seconds.</p>
                    <br/>
                    <p>At CreditCards.com our goal is to provide consumers a resource to search, compare and <a href="/apply/">apply</a> for a selection of credit card offers online.</p>
                    <br/>
                </div>
                <div class="about-showhide-btn"> <a href="collapse-show" data-toggle="collapse" data-target="#bank-content"><i class="fa fa-plus-circle fa-lg" style="color:#fff;"></i> &nbsp; <span id='show_more_less_text'>Show more</span> </a> </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-blue">
                    <div class="panel-heading">We&apos;re Here to Help You</div>
                    <div class="panel-body">
                        <div class="list-group">
                            <a target="_blank" href="https://my.creditcards.com/?qls=MCC_BTMHOMEP.091115CRED" class="list-group-item list-group-item-blue">
                                <img src="/images/my-creditcards-home.png" style=" padding:3px 0 8px 0;">
                                <i class="fa fa-angle-right fa-lg pull-right" style=" padding-top:5px;"></i>
                                <div class="list-group-item-heading">Free Credit Score and Monitoring</div>
                                <p class="list-group-item-text">Get an updated credit score for free each month.</p>
                            </a> </div>
                        <div class="list-group">
                            <a target="_blank" href="https://www.creditcards.com/cardmatch/?action=show_form" class="list-group-item list-group-item-blue">
                                <img src="/images/card-match.png" style=" padding:3px 0 8px 0;">
                                <i class="fa fa-angle-right fa-lg pull-right" style=" padding-top:5px;"></i>
                                <div class="list-group-item-heading">Better Offers via CardMatch&trade; </div>
                                <p class="list-group-item-text">See offers matched with your credit profile.</p>
                            </a> </div>
                        <div class="list-group">
                            <a target="_blank" href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=home_about&utm_campaign=walletup" class="list-group-item list-group-item-blue">
                                <img src="/images/wallet-up.png" style=" padding:3px 0 8px 0;">
                                <i class="fa fa-angle-right fa-lg pull-right" style=" padding-top:5px;"></i>
                                <div class="list-group-item-heading">Max Rewards with WalletUp&reg;</div>
                                <p class="list-group-item-text">Maximize your rewards, cash back, and points earnings.</p>
                            </a> </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="bank-content" class="collapse">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-24">
                            <div class="about-cccom-content">
                                <h4>Search for a Credit Card by Bank</h4>
                                <p>CreditCards.com has partnered with dozens of banks, including the ones listed below, to allow our users to search for a credit card by bank.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/american-express.php"><img src="images/icon_americanexpress_bank.png" width="80" height="80" class="ccbank-img" alt="American Express"></a>
                                <div class="ccbank-content">
                                    <p><a href="/american-express.php">American Express</a> credit cards offer rewards programs and great rates. Cards include Platinum and Gold Charge Cards, Delta SkyMiles, and Starwood Preferred Guest&reg; Credit Card.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/bank-of-america.php"><img src="images/icon_bankofamerica_bank.png" width="80" height="80" class="ccbank-img" alt="Bank of America"></a>
                                <div class="ccbank-content">
                                    <p><a href="/bank-of-america.php"><strong>Bank of America</strong></a> offers a variety of high-value credit cards, like the BankAmericard Cash Rewards&trade;, BankAmericard Travel Rewards&reg;, BankAmericard&reg; Credit Card, and <a href="/mlb-credit-cards.php">MLB BankAmericard Cash Rewards&trade;</a> featuring competitive rates.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/capital-one.php"><img src="images/icon_capitalone_bank.png" width="80" height="80" class="ccbank-img" alt="Capital One"></a>
                                <div class="ccbank-content">
                                    <p><a href="/capital-one.php">Capital One</a> offers credit cards for frequent flyers and shoppers who want to redeem rewards for travel, merchandise or cash back. Capital One cards feature competitive rates designed for all types of credit. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/credit-one.php"><img src="images/icon_capitalonebank_bank.png" width="80" height="80" class="ccbank-img" alt="Credit One"></a>
                                <div class="ccbank-content">
                                    <p><a href="/credit-one.php">Credit One Bank&reg;</a> is one of America's leading issuers of VISA&reg; credit cards. Credit One Bank&reg; provides  credit cards to individuals who have been historically overlooked by other banks because of their less than perfect credit.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/barclaycard.php"><img src="images/icon_barclaycard_bank.png" width="80" height="80" class="ccbank-img" alt="Barclaycard"></a>
                                <div class="ccbank-content">
                                    <p><a href="/barclaycard.php">Barclaycard&reg;</a> is one of the world's largest financial services companies with over 300 years of experience. Barclaycard issues the Barclaycard Rewards MasterCard credit card and <a href="/nfl-extra-points.php">NFL Extra Points team cards</a>.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/chase.php"><img src="images/icon_chase_bank.png" width="80" height="80" class="ccbank-img" alt="Chase Bank Credit Cards"></a>
                                <div class="ccbank-content">
                                    <p><a href="/chase.php">Chase</a> provides many great offers: Chase Freedom&reg;, Chase Sapphire Preferred&reg; Card, Chase Slate&reg;, and more.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/citi.php"><img src="images/icon_citi_bank.png" width="80" height="80" class="ccbank-img" alt="Citibank"></a>
                                <div class="ccbank-content">
                                    <p><a href="/citi.php">Citibank</a> offers a great choice of cards with rewards, low interest rates and no annual fee. Cards include Citi Simplicity card, Citi Forward card, Citi ThankYou card. Also see Citi business and student credit cards.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/discover.php"><img src="images/icon_discover_bank.png" width="80" height="80" class="ccbank-img" alt="Discover"></a>
                                <div class="ccbank-content">
                                    <p><a href="/discover.php">Discover&reg;</a> offers the Discover it&reg; card with 0% intro APR and unlimited cash rewards. Card members can sign up for free to earn 5% cash back each quarter. Plus, a full 1% cash back on all other purchases. Also available: Discover it&reg; for Students.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/visa.php"><img src="images/icon_visa_bank.png" width="80" height="80" class="ccbank-img" alt="Visa"></a>
                                <div class="ccbank-content">
                                    <p><a href="/visa.php">Visa Credit Cards</a> offer exceptional convenience and reliability and are used by people around the world. Visa is acceptance in more than 150 countries. It's a secure, reliable way to pay anywhere in the world.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/mastercard.php"><img src="images/icon_mastercard_bank.png" width="80" height="80" class="ccbank-img" alt="Mastercard"></a>
                                <div class="ccbank-content">
                                    <p><a href="/mastercard.php">MasterCard</a> credit cards are widely accepted around the world. They serve customers in over 210 countries, and process over 15 million transactions a day in over 180 currencies.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/first-premier.php"><img src="images/icon_firstpremier_bank.png" width="80" height="80" class="ccbank-img" alt="First Premier Bank Credit Card"></a>
                                <div class="ccbank-content">
                                    <p><a href="/first-premier.php">First PREMIER&reg; Bank</a> offers secured and unsecured fee based credit cards.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/us-bank-credit-cards.php"><img src="images/icon_usbank_bank.png" width="80" height="80" class="ccbank-img" alt="First Premier Bank Credit Card"></a>
                                <div class="ccbank-content">

                                    <p><a href="/us-bank-credit-cards.php">U.S. Bank</a> is the 5th largest commercial bank in the United States. The company operates 3,086 banking offices and 5,086 ATMs, and provides a comprehensive line of banking, brokerage, and payment services products.</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/usaa.php"><img src="/images/icon_usaa_bank.png" width="80" height="80" class="ccbank-img" alt="USAA"></a>
                                <div class="ccbank-content">
                                    <p><a href="/usaa.php"><strong>USAA Bank</strong></a> offers competitive credit card products to military members, veterans who have received an Honorable discharge, and their eligible family members.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/bbt.php"><img src="/images/icon_bbt_bank.png" width="80" height="80" class="ccbank-img" alt="BB&T"></a>
                                <div class="ccbank-content">
                                    <p><a href="/bbt.php"><strong>BB&amp;T</strong></a> is among the largest financial services companies in the U.S. and offers excellent credit cards supported by outstanding client service. Whether you want a low rate or clear and flexible rewards, the choice is yours. </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/td-bank-credit-cards.php"><img src="/images/td-bank-logo-100715.png" width="80" height="80" class="ccbank-img" alt="TD Bank"></a>
                                <div class="ccbank-content">
                                    <p><a href="/td-bank-credit-cards.php"><strong>TD Bank</strong></a>, America's Most Convenient Bank&#174;, is one of the 10 largest banks in the U.S. With over 1300 locations, weekend & extended hours, and strong community ties, TD might be the right bank for you.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br/>
                    <br/>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-darkblue">
                        <div class="panel-heading">Card Offers from Our Partners</div>
                        <div class="panel-body">
                            <!-- ////////Content Goes Here////////// -->
                            <div class="list-group"> <a href="/low-interest.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-percent"></i></span>
                                    <div class="list-group-item-heading">Low Interest Credit Cards</div>
                                    <p class="list-group-item-text">Cards with 0% intro APRs & low fixed rate offers.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/balance-transfer.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-arrows-h"></i></span>
                                    <div class="list-group-item-heading">Balance Transfer Cards</div>
                                    <p class="list-group-item-text">Transfer a high interest balance onto a low APR card.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/reward.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-gift "></i></span>
                                    <div class="list-group-item-heading">Rewards Credit Cards</div>
                                    <p class="list-group-item-text">Cards that "reward" you for your purchases.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/cash-back.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"> <i class="fa fa-usd"></i> </span>
                                    <div class="list-group-item-heading"> Cash Back Credit Cards</div>
                                    <p class="list-group-item-text">Cards that allow you to earn cash back on purchases.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/airline-miles.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-plane"></i></span>
                                    <div class="list-group-item-heading">Airline Credit Cards</div>
                                    <p class="list-group-item-text">Earn frequent flyer miles with an airline card.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/smart-emv-chip.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-barcode"></i></span>
                                    <div class="list-group-item-heading">EMV Chip Credit Cards</div>
                                    <p class="list-group-item-text">Cards that utilize EMV Chip security.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/instant-approval.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-check"></i></span>
                                    <div class="list-group-item-heading">Instant Approval Cards</div>
                                    <p class="list-group-item-text">Get approved instantly on select card offers from specific
                                        banks.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/prepaid.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-credit-card"></i></span>
                                    <div class="list-group-item-heading">Prepaid & Debit Cards</div>
                                    <p class="list-group-item-text">Control your spending with debit cards, prepaid debit cards, and
                                        prepaid cards.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/secured-credit-cards.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"> <i class="fa fa-lock"></i> </span>
                                    <div class="list-group-item-heading">Secured Credit Cards</div>
                                    <p class="list-group-item-text">Secured cards give you a credit line and report your payment
                                        activity to the major credit bureaus.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/bad-credit.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-chain-broken"></i></span>
                                    <div class="list-group-item-heading">Cards for Bad Credit</div>
                                    <p class="list-group-item-text">Cards for people with bad credit or less than perfect credit.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/college-students.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-book"></i></span>
                                    <div class="list-group-item-heading">Student Credit Cards</div>
                                    <p class="list-group-item-text">Card offers for high school & college students.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/business.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-briefcase"></i></span>
                                    <div class="list-group-item-heading">Business Credit Cards</div>
                                    <p class="list-group-item-text">Cards for corporate & small-business owners.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/no-foreign-transaction-fee.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-globe"></i></span>
                                    <div class="list-group-item-heading">Cards with No Foreign Transaction Fee</div>
                                    <p class="list-group-item-text">Cards that do not charge a foreign transaction fee.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/apple-pay.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-apple"></i></span>
                                    <div class="list-group-item-heading">Apple Pay&#8482; Ready Credit Cards</div>
                                    <p class="list-group-item-text">Cards that are Apple Pay compatible.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/retail-rewards.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="list-group-item-heading">Retail Credit Cards</div>
                                    <p class="list-group-item-text">Cards that offer points that can be redeemed with specific retailers.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/0-apr-credit-cards.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-ban"></i></span>
                                    <div class="list-group-item-heading">0% APR Credit Cards</div>
                                    <p class="list-group-item-text">Cards with 0% APR for up to 18 months on purchases or balance
                                        transfers.</p>
                                </a> </div>
                            <div class="list-group"> <a href="/limited-time-offers.php" class="list-group-item list-group-item-darkblue"> <i class="fa fa-angle-right fa-lg pull-right gutter-arrow-padding"></i> <span class="gutter-icon-hldr pull-left"><i class="fa fa-clock-o"></i></span>
                                    <div class="list-group-item-heading">Limited Time Offers</div>
                                    <p class="list-group-item-text">Take advantage of these offers - will not last long.</p>
                                </a> </div>
                        </div>
                    </div>
                </div>
                <!--col-lg-6-->
            </div>
            <!--row-->
        </div>
        <!--#bank-content-->
    </div>
    <!--container-->
</div>
<!--subcontent-block-->
@endsection
