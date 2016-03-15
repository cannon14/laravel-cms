<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "10";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/geoip.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
?>

<!DOCTYPE HTML>
<html>
<head>
    <?php

    $htmlTitle = 'Credit Cards - Compare Credit Card Offers at CreditCards.com';
    $metaKeywords = 'credit cards, credit card, credit, creditcards, visa, offers, search, compare, apply, mastercard, low interest, student, instant approval, balance transfer, reward, business, cash back';
    $metaDescription = 'Find the best credit card deals by comparing a variety of offers for balance transfers, rewards, low interest, and more. Apply online at CreditCards.com.';
    include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');

    ?>

    <meta name="credit-card" content="Credit card offers: low interest, balance transfer, cash back, reward, prepaid, college students, business, bad credit, airline and instant approval credit cards.">
    <meta name="google-site-verification" content="0wsuI3yWASFsqPO19ZPLkjaYkV0gFhtK30gwdeKe_ho"/>
    <link rel="publisher" href="https://plus.google.com/+CreditcardsUS/posts"/>
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Credit Cards - Compare Credit Card Offers at CreditCards.com" />
    <meta property="og:description" content="Compare Credit Cards & Credit Card Offers at CreditCards.com. Search credit cards and reviews about the best low interest, 0% balance transfer, reward, cash back, prepaid, student, airline, business and instant approval credit cards. Apply for Credit Cards Online." />
    <meta property="og:url" content="http://www.creditcards.com" />
    <meta property="og:site_name" content="CreditCards.com" />
    <meta property="article:publisher" content="https://www.facebook.com/CreditCards.com" />
    <meta property="og:image" content="https://lh6.googleusercontent.com/-qavMHhzZ8SQ/VSqzagiasfI/AAAAAAAAAlI/GZQa1eO35dU/s395-no/smallwhiteonblue400x400.png" />
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="Official Twitter channel for CreditCards.com . Follow us for all things credit card; news, advice and offers. Also follow our blog @takingcharge." />
    <meta name="twitter:title" content="CreditCards.com"/>
    <meta name="twitter:site" content="@CreditCardsCom"/>
    <meta name="twitter:domain" content="CreditCards.com"/>
    <meta name="twitter:image:src" content="https://pbs.twimg.com/profile_images/587306479062925312/2aKe0qaj.png"/>
    <link href="https://plus.google.com/110595907088556510376" rel="publisher"/>
    <link href="/css/cc-home.css" rel="stylesheet">
    <link href="/css/cc-misc.css" rel="stylesheet" type="text/css">
    <?php if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); } ?>
    <!-- style-block --><!-- style-block -->
</head>

<body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>
<!-- main-block -->
<!-- Site Banner Block-->
<div class="banner-block">
    <div class="item">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="top-banner-text">Find a credit card that's <span style="color:#429e5d;"><strong>right</strong></span> for you</div>
                    <h1>Compare credit card offers from our partners</h1>
                    <div class="advertiser-disclosure"><a href="#" data-toggle="modal" data-target="#myModalDisclosure"><img src="images/advertiser_dis_text.png" width="120" height="9"/></a></div>
                    <div class="banner-hero-card"><img class="img-responsive" src="images/hero-card.png"/></div>
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
            <?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/creditCardSearchCategories.php'); ?>
            <div class="col-md-12">
                <h3>Latest Credit Card News</h3>
                <div class="row">
                    <div class="col-md-12">
                        <div class="latest-news-hldr">
                            <?php include 'credit-card-news/content/hpmodule1.php'; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="rate-report-hldr">
                            <div class="rate-title"><a href="/rate-report">Credit Card Rate Report</a></div>
                            <div class="rate-updated-date">Updated:
                                <?= date("m-d-Y") ?>
                            </div>

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
                    <p>The perfect card for those seeking a simple yet convenient-to-use credit card</p>
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
                        <a href="/business.php"><img src="http://www.imgsynergy.com/142x89/spark-cash-for-business-040815.png" alt="Best Business Credit Cards"></a></div>
                    <h2>
                        <a href="/business.php">
                            Capital One&reg; Spark&reg; Cash for Business
                        </a>
                    </h2>
                    <p>Earn 2% cash back on every purchase, every day</p>
                    <div class="featured-bottom text-center">
                        <a href="/business.php">
                            Business Credit Cards
                            <i class="fa fa-angle-right fa-lg" style="color:#fff; float:right;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php //Bank of America Beacon Tag - only show when a BofA card in list
//<img src='http://www.likedcards.com/init.php?mid=CCCOM121&cid=5' width='1' height='1' border='0' alt='initiator'>
?>
<?php //Discover Beacon Tag - only show when a Discover card in list
//<img src='http://www.likedcards.com/init.php?mid=CCCOM121&cid=7' width='1' height='1' border='0' alt='initiator'>
?>
<?php
//X+1 Discover Card Art Banner - This code is only for Discover Card Art and should be removed if card is removed
//<img src="https://d.xp1.ru4.com/activity?_o=15755&_t=ccrmkt" height="1" width="1" style="display:none;"/>
?>

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
                            <div class="about-ccbank-hldr"> <a href="/American-Express.php"><img src="images/icon_americanexpress_bank.png" width="80" height="80" class="ccbank-img" alt="American Express"></a>
                                <div class="ccbank-content">
                                    <p><a href="/American-Express.php">American Express</a> credit cards offer rewards programs and great rates. Cards include Platinum and Gold Charge Cards, Delta SkyMiles, and Starwood Preferred Guest&reg; Credit Card.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/Bank-of-America.php"><img src="images/icon_bankofamerica_bank.png" width="80" height="80" class="ccbank-img" alt="Bank of America"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Bank-of-America.php"><strong>Bank of America</strong></a> offers a variety of high-value credit cards, like the BankAmericard Cash Rewards&trade;, BankAmericard Travel Rewards&reg;, BankAmericard&reg; Credit Card, and <a href="/mlb-credit-cards.php">MLB BankAmericard Cash Rewards&trade;</a> featuring competitive rates.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/Capital-One.php"><img src="images/icon_capitalone_bank.png" width="80" height="80" class="ccbank-img" alt="Capital One"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Capital-One.php">Capital One</a> offers credit cards for frequent flyers and shoppers who want to redeem rewards for travel, merchandise or cash back. Capital One cards feature competitive rates designed for all types of credit. </p>
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
                            <div class="about-ccbank-hldr"> <a href="/Chase.php"><img src="images/icon_chase_bank.png" width="80" height="80" class="ccbank-img" alt="Chase Bank Credit Cards"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Chase.php">Chase</a> provides many great offers: Chase Freedom&reg;, Chase Sapphire Preferred&reg; Card, Chase Slate&reg;, and more.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/Citi.php"><img src="images/icon_citi_bank.png" width="80" height="80" class="ccbank-img" alt="Citibank"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Citi.php">Citibank</a> offers a great choice of cards with rewards, low interest rates and no annual fee. Cards include Citi Simplicity card, Citi Forward card, Citi ThankYou card. Also see Citi business and student credit cards.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/Discover.php"><img src="images/icon_discover_bank.png" width="80" height="80" class="ccbank-img" alt="Discover"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Discover.php">Discover&reg;</a> offers the Discover it&reg; card with 0% intro APR and unlimited cash rewards. Card members can sign up for free to earn 5% cash back each quarter. Plus, a full 1% cash back on all other purchases. Also available: Discover it&reg; for Students.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/Visa.php"><img src="images/icon_visa_bank.png" width="80" height="80" class="ccbank-img" alt="Visa"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Visa.php">Visa Credit Cards</a> offer exceptional convenience and reliability and are used by people around the world. Visa is acceptance in more than 150 countries. It's a secure, reliable way to pay anywhere in the world.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="about-ccbank-hldr"> <a href="/Mastercard.php"><img src="images/icon_mastercard_bank.png" width="80" height="80" class="ccbank-img" alt="Mastercard"></a>
                                <div class="ccbank-content">
                                    <p><a href="/Mastercard.php">MasterCard</a> credit cards are widely accepted around the world. They serve customers in over 210 countries, and process over 15 million transactions a day in over 180 currencies.</p>
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

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>
<script>
    /* Ajax call that returns the html on success and unhides the div with data.*/
    $.ajax({
        type: "POST",
        url: 'lib/rate_chart/rate_chart.inc.php',
        success: function(data) {
            //Detach and save the #rateChartMoreInfo data for use after HTML is overwritten.
            var moreInfo = $('#rateChartMoreInfo').detach();
            /*Add the html table data inside the #rateChartArticleBox,
             append the #rateChartMoreInfo data after it, then show all.*/
            $('#rateChartArticleBox').html(data).append(moreInfo).show();
        }
    });
</script>
<?php
echo "<img src='" . $GLOBALS['RootPath'] . "sb.php?a_aid=" . $_SESSION['aid'] . "&a_bid=" . $_SESSION['hid'] . "' border=0 width=1 height=1  style=\"display: none;\">\n";
echo "<img src='" . $GLOBALS['RootPath'] . "xtrack.php?" . $_SERVER['QUERY_STRING'] . "' border=0 width=1 height=1 style=\"display: none;\">";
//Banner Click Counting Code
//if($_GET['a_aid'] != '' && $_GET['a_bid'] != '')
//print "<img src='".$GLOBALS['RootPath']."t2.php?a_aid=".$_GET['a_aid']."&a_bid=".$_GET['a_bid']."&referrer=".urlencode($_SERVER['HTTP_REFERER'])."' border='0' width='1' height='1'>";
?>
<script type="text/javascript">
    $(document).ready(function () {

        //About show more/less button function that changes icon and wording
        $('.about-showhide-btn a').click(function () {

            var value = $('#show_more_less_text').text();
            if (value == 'Show more') {
                $('.about-showhide-btn i').attr('class', 'fa fa-minus-circle fa-lg');
                $('#show_more_less_text').text('Show less');
            }
            else {
                $('.about-showhide-btn i').attr('class', 'fa fa-plus-circle fa-lg');
                $('#show_more_less_text').text('Show more');
            }
        });

        //Click function for the hero box dropdown menu.  Sends user to the selected page.
        $('#hero_btn').click(function () {
            $(location).attr('href', $('#hero_list_value').val());
        });
        $('#hero_btn_mobile').click(function () {
            $(location).attr('href', $('#hero_list_value_mobile').val());
        });

    });
</script>

<?php

$channel = 'home';
$pageName = 'home';
$analyticsServer = '';
$pageType = '';
$prop1 = 'home';
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
$eVar27 = $_GET['adsrc'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

<!-- Adobe Media Optimizer -->
<script type='text/javascript'>
    (function () {
        var f = function () {
            EF.init({
                eventType: "pageview",
                pageviewProperties: "",
                segment: "21041",
                searchSegment: "",
                sku: "",
                userid: "4397",
                pixelHost: "pixel.everesttech.net", allow3rdPartyPixels: 1
            });
            EF.main();
        };
        window.EF = window.EF || {};
        if (window.EF.main) {
            f();
            return;
        }
        window.EF.onloadCallbacks = window.EF.onloadCallbacks || [];
        window.EF.onloadCallbacks[window.EF.onloadCallbacks.length] = f;
        if (!window.EF.jsTagAdded) {
            var efjs = document.createElement('script');
            efjs.type = 'text/javascript';
            efjs.async = true;
            efjs.src = 'https://www.everestjs.net/static/st.v3.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(efjs, s);
            window.EF.jsTagAdded = 1;
        }
    })();
</script>
<noscript>
    <img src="https://pixel.everesttech.net/4397/v?" width="1" height="1" style="display: none;"/>
</noscript>
<!-- End Adobe Media Optimizer -->

<!-- X+1 -->
<script language="javascript" type="text/javascript">
    <!--
    var _dropTag = function () {
        var _qS = '';
        var _rand = Math.random() + '';
        var _rs = document.location.protocol + '//';
        var xp1_qs =
        {
            '_t': '62298232ct',


            '_random': _rand * 100000000000
        };
        for (var qsKey in xp1_qs) {
            _qS += '&' + qsKey + '=' + xp1_qs[qsKey];
        }
        document.write('<iframe src="' + _rs + 'd.xp1.ru4.com/meta?_o=62298178' + _qS + '" width="0" height="0" frameborder="0" scrolling="no" style="position: absolute; left: -5000px"></iframe>');
    };
    _dropTag();
    //-->
</script>
<!-- End X+1 -->


<?php
// show drtv banner impression pixel when banner is show above
if (isset($_SESSION['drtv_banner'])) {
    ?>
    <span id="trackingCode"><img
            src="https://tracker.revshare.com/trk.php?rsid=<?= $_SESSION['drtv_impression_id'] ?>&uid=<?= $_SESSION['external_visit_id'] ?>"
            width="1" height="1" border="0" style="display: none;"></span>
<?php
} //close drtv banner
?>
</body>
</html>
