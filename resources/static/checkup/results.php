<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = "1491";
include_once('../actions/trackers.php');
?>
<?
QUnit_Global::includeClass('Affiliate_Scripts_Bl_CreditCardCheckup');

$checkupReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_CreditCardCheckup');

//list of cards that are to be excluded from results per marketing
//debug - $exemptCards = array();
$exemptCards = array('22524699','22525061','22265085','22265046');

//to hold cards during ordering
$ordered_cards = array();

$content = "";

$cardImage = $_REQUEST['card_image'];
$cardName = $_REQUEST["user_card_name"];
$userApr = $_REQUEST["user_apr"];
$userAnnualFee = $_REQUEST["user_annual_fee"];
$userPrinciple = $_REQUEST["user_principle"];
$userMonthlyCharges = $_REQUEST["user_monthly_charges"];
$userPayment = $_REQUEST["user_payment"];
$userQuality = $_REQUEST["user_quality"];
$marketable= $_REQUEST["marketable"];
$fid = $_SESSION['fid'];

$userQualityDisplay = $checkupReg->mapUserQuality($userQuality);
$cardImagePath = $checkupReg->setCardImagePath($marketable, $cardImage);

$cards = $checkupReg->loadResultCards($userApr, $userQuality);

//====================================
// calculate user interest and fees
//====================================
$P = $userPrinciple;
$x = $userPayment;
$netUserPayment = $userPayment - $userMonthlyCharges;
$r = $userApr / 100 / 12;
	
$userCantPayback = false;
$userLongPayback = false;

$currentPrinciple = $userPrinciple;

//====================================
//debt can never be paid off
// 1. monthly payment is less than monthly charges
// 2. principle is > 0 and payment = 0
// 3. annual fee > payment
// 4. first month's interest plus monthly charges > payment
//====================================
if($netUserPayment < 0 || (($userPrinciple > 0) && ($netUserPayment == 0)) || ($userAnnualFee > $userPayment) || ($r * $currentPrinciple > $netUserPayment))
	$userCantPayback = true;

$payoffMonths = 0;
$totalInterestFees = 0;

while( $currentPrinciple > 0 ) {

    if($payoffMonths % 12 == 0) {
        $currentPrinciple += $userAnnualFee;
        $totalInterestFees += $userAnnualFee;
	}
    
	$interest = $currentPrinciple * $r;

	$totalInterestFees += $interest;

	$currentPrinciple = $currentPrinciple + ($interest - $netUserPayment);

	$payoffMonths++;
    
	if($payoffMonths >= 36) {
       $userLongPayback = true;
       
       if($userCantPayback)
            break;
	}
    
	if($payoffMonths >= 100)
	   break;
//	echo "month: $payoffMonths | principle: $currentPrinciple | int: $interest | total int: $totalInterestFees<br />";
}


$resultCount = 0;
    
//calculate savings for each card and order by savings
foreach($cards as $card) {
    $regularApr = $card->regularAprLabel;
    
    //skip prepaid cards - some prepaid cards are set to -1, 0, 99 or 999 APR
    if( ($regularApr <= 0) || ($regularApr > 80) || in_array($card->cardId, $exemptCards))
        continue;
    
    //calc savings of each card - is the content that appears to the right of each card
    $card->savings = $checkupReg->calcCard($card, $totalInterestFees, $P, $x, $payoffMonths, $userMonthlyCharges, $userLongPayback, $userCantPayback);
    
    if(!$card->exclude) {
        $ordered_cards[] = $card;
        
        //increment card counter
        $resultCount++;
    }
}

//================================================
//custom sorting by savings_value on final results
//================================================
function compare_savings($a, $b) {
    if ($a->savings_value == $b->savings_value) {
        return 0;
    }
    return ($a->savings_value > $b->savings_value) ? -1 : 1;
}

usort($ordered_cards, "compare_savings");


//================================================
//trim list to top 'x' cards and count results after sort
//================================================
if( $resultCount > MAX_NUM_CARDS ) {

	$ordered_cards = array_slice($ordered_cards, 0, MAX_NUM_CARDS);
	$totalCards = MAX_NUM_CARDS;

} else {
    $totalCards = $resultCount;
}

if($totalCards == 0) {
    $content .= '
	    <br />    
	    <h1>Keep your current card!</h1>
	    <br />
	    Your credit card is as financially fit as can be. We couldn\'t find any card that could save you money.
	    <p>Looking for an additional credit card to increase your available credit, or accumulate <a href="/reward.php">rewards</a>? Use the menu on the left to search, compare and apply for the card that\'s right for you.</p>
    '; 

} else {
	//prepend the # of cards to content
	$content .= '<div style="font-size: 14px; font-weight: bold; margin: 10px 0;">Top <span class="savingsCallout">' . $totalCards . '</span> cards that may be healthier for you</div>';
}

$cardPosition = 1;

//build content based on ordered 
foreach($ordered_cards as $card) {

	$content .= $checkupReg->buildSchumerBox($card, $cardPosition, $fid);
	
	$cardPosition++;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Compare your credit cards and their benefits - CreditCards.com</title>

<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">

<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta http-equiv="Pragma" content="no-cache">
<meta name="author" content="CreditCards.com">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
<link rel="stylesheet" href="/css/credit-cards.css" type="text/css">
<script src="/javascript/application.js"></script>

<script src="/javascript/AC_RunActiveContent.js" language="javascript"></script>
<script type="text/javascript" src="/javascript/prototype_1603.js"></script>

<style>
.savingsCallout {
    font-size: 16px;
    font-weight: bold;
    color: #cc0000;
}
.cardsearchSectionText {
    font-size: 11px;
}
.cardsearchSectionTitle {
    font-family: Arial;
    font-size: 14px;
    font-weight: bold;
    color: black;
}
.cardsearchSectionTitle a:link {
    text-decoration: none;
    color: black;
}
.cardsearchSectionTitle a:visited {
    text-decoration: none;
    color: black;
}
.cardsearchSectionTitle a:hover {
    text-decoration: none;
    color: black;
}
</style>

</head>
<body>

<div id="skeleton">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr> 
        <td class="mainLeftNav"><?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/left-nav.php"; ?></td>
        <td class="mainContentColumn">
            
            <div id="breadcrumb">
                <a href="http://www.creditcards.com">Credit Cards</a> &gt; <a href="/credit-card-tools/">Tools</a> &gt; <a href="/checkup/">Credit Card CheckUp</a> &gt; Results
            </div>
            
            <div id="pageContentArea">
            <div style="float: right; margin-top: 30px;">
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcheckup%2F&amp;layout=standard&amp;show_faces=false&amp;width=250&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:35px;" allowTransparency="true"></iframe></div>
                <table style="margin-bottom: 15px;">
                    <tr>
                        <td valign="top"><img src="/images/credit-card-checkup-tool.gif" /></td>
                        <td style="padding-left: 20px;"><h1>Credit Card CheckUp Results</h1></td>
                    </tr>
                </table>
            	
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><img src="/images/credit-corner-trans-top-lft.gif" width="6" height="6"></td>
                        <td background="/images/credit-corner-trans-hdr_fill.gif"><img src="/images/spacer.gif" width="1" height="6"></td>
                        <td><img src="/images/credit-corner-trans-top-rt.gif" width="6" height="6"></td>
                    </tr>
                    <tr>
                        <td background="/images/credit-corner-trans-body_leftfill.gif"><img src="/images/spacer.gif" width="6" height="1"></td>
                        <td width="100%" class="content">
                
                            
                            <table width="100%">
                                <tr>
                                    <td width="50%" valign="top">
                                        <img src="<?=$cardImagePath ?>" align="left" width="95" height="60" style="padding: 0 15px 10px 0" />
                                        <b><?=$cardName?></b>
                                        
                                        <br clear="all" />
                                        
                                        <table cellspacing="5">
                                            <tr>
                                                <td class="label">Interest Rate:</td>
                                                <td><?=$userApr?> %</td>
                                            </tr>
                                            <tr>
                                                <td class="label">Annual Fee:</td>
                                                <td>$ <?=number_format($userAnnualFee, 0, '.', ',')?></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Amount you currently owe:</td>
                                                <td>$ <?=number_format($userPrinciple, 0, '.', ',')?></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Estimated monthly charges:</td>
                                                <td>$ <?=number_format($userMonthlyCharges, 0, '.', ',')?></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Amount you pay off each month:</td>
                                                <td>$ <?=number_format($userPayment, 0, '.', ',')?></td>
                                            </tr>
                                            <tr>
                                                <td class="label">Credit Quality:</td>
                                                <td><?=$userQualityDisplay?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 2px; background-color: #BEBDB8;"></td>
                                    <td width="50%" valign="top">
                                        <div style="padding: 0 15px; font-weight: bold;">
                                           <span style="font-size: 14px; color: #cc0000;">With the data you entered:</span>
                                           <br />
                                           <br />
                                           
                                           <? if($userCantPayback) { ?>
                                           
	                                           <ul>
	                                               <li style="padding-bottom: 5px;">Your balance is growing each month, which is bad for your financial health.  To pay off your card, your monthly payment must be larger than your purchases and interest charges.</li>
	                                               <li>In a period of 36 months, you will pay <span class="savingsCallout">$<?=number_format($totalInterestFees, 0, '.', ',') ?></span> in interest</li>
	                                           </ul>
                                               
                                               <br />
                                               <br />
                                               <br />
                                               <br />
                                               
                                           <? } else { ?>
                                           
                                               <ul>
                                                   <li style="padding-bottom: 5px;">It will take you about <span class="savingsCallout"><?=$payoffMonths ?> months</span> to pay off your credit card debt</li>
                                                   <li>During this period, you will pay <span class="savingsCallout">$<?=number_format($totalInterestFees, 0, '.', ',') ?></span> in interest</li>
                                               </ul> 
                                           
                                           <? } ?>
                                           
                                           <? if(!$userCantPayback) { ?>
                                           
                                           <hr color="#ccc" size="1" style="height: 1px; background-color: #ccc; border: 1px solid #ccc;" />
                                           
                                           Note:
                                           <ul>
							                    <li>Savings calculations are based upon the time taken to pay off the entire debt.</li> 
							                    <li>You may be able to reduce the amount you pay in interest charges and pay off your debt sooner by increasing the amount of your monthly payment.</li>
                                           </ul>
                                           <? } ?>
                                       </div>
                                        
                                       <div style="text-align: right;"><a href="/checkup/">Start Over</a></div>
                                    </td>
                                </tr>
                            </table>
                        
                        </td>
                        <td background="/images/credit-corner-trans-body_rightfill.gif"><img src="/images/spacer.gif" width="6" height="1"></td>
                    </tr>
                    <tr>
                        <td><img src="/images/credit-corner-trans-bt-lft.gif" width="6" height="6"></td>
                        <td background="/images/credit-corner-trans-ftr_fill.gif"><img src="/images/spacer.gif" width="1" height="6"></td>
                        <td><img src="/images/credit-corner-trans-bt-rt.gif" width="6" height="6"></td>
                    </tr>
                </table>
                
                <?=$content ?>

                <br/>
                
                <? if($totalCards == 0) { ?>
                
                Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a>
                <br />
                <br />
                
                <table width="100%" border="0" cellpadding="4" cellspacing="4">
			     <tr>
                    <td class="offer-left" colspan="3" style="background-color: #fff;">
                        <h1>Other tools you may be interested in...</h1>
                    </td>
                </tr>
			    <tr>
				<td align="center" width="33%" class="step1td" style="background-color: #e1e9eb;">
					<span class="cardsearchSectionTitle">
					<a href="/credit-score-estimator/">Credit Score Estimator</a></span><br/>
					<a href="/credit-score-estimator/">
					<img src="/images/search_credit-score-estimator.png" alt="Credit Score Estimator" border="0" />
					</a><br/>
					<span class="cardsearchSectionText">
					Answer a few simple questions and get a FREE estimated credit score.
					Find cards based on your estimated credit score.
					</span>
					<a href="/credit-score-estimator/"><img src="/images/start-here-button.png" alt="Start Here" border="0" style="padding-top:6px;" /></a>
				</td>
				<td align="center" width="33%" class="step2td" style="background-color: #dff2f7;">
					<span class="cardsearchSectionTitle">
					<a href="/calculators/">Credit Card Calculators</a></span><br/>
					<a href="/calculators/">
					<img src="/images/search_calculator.png" alt="Credit Card Calculators" border="0" />
					</a><br/>
					<span class="cardsearchSectionText">
					A set of easy to use credit card calculators which help you find answers to your financial questions.
					</span><br/>
					<a href="/credit-card-finder/"><img src="/images/start-here-button.png" alt="Start Here" border="0" style="padding-top:6px;" /></a>
				</td>
				<td align="center" width="33%" class="step3td" style="background-color: #f2f2ce;">
					<span class="cardsearchSectionTitle">
					<a href="/credit-card-profiles/">Shop by Profile</a></span><br/>
					<a href="/credit-card-profiles/">
					<img src="/images/search_profiles.png" alt="Shop by Profile" border="0" />
					</a><br/>
					<span class="cardsearchSectionText">
					Try our fun Credit Profile Picker.
					Find recommendations and advice on what card is right for your credit card profile.
					</span>
					<a href="/credit-card-profiles/"><img src="/images/start-here-button.png" alt="Start Here" border="0" style="padding-top:6px;"/></a>
				</td>
			</tr>
		</table>
                <br/>
                <table cellspacing="0" cellpadding="0" border="0" width="100%" class="newsletter_signup_bottom">
                    <tr>
                        <td><img height="6" width="6" src="/images/credit-corner-top-lft.gif"/></td>
                        <td background="/images/credit-corner-hdr_fill.gif"><img height="6" width="1" src="/images/spacer.gif"/></td>
                        <td><img height="6" width="6" src="/images/credit-corner-top-rt.gif"/></td>
                    </tr>
                    <tr>
                        <td background="/images/credit-corner-body_leftfill.gif"><img height="1" width="6" src="/images/spacer.gif"/></td>
                        <td width="100%" class="content">
                            <a target="_blank" href="/newsletter.php">
                                <img align="left" class="newsletter_signup_bottom_img" alt="Get credit card news" src="/images/newsletter-background.png"/>
                            </a>
                            <span  class="cardsearchSectionTitle" >
                            <a target="_blank" href="/newsletter.php">
                                CreditCards.com's Weekly Newsletter
                            </a>
                            </span>
                            <br/>
                            <br/>
                            Did you like this story? Then sign up for CreditCards.com's weekly e-newsletter for the latest news, advice, articles and tips. It's FREE. Once a week you will receive the top credit card industry news in your inbox. Sign up now!
                            <br/>
                            <a target="_blank" href="/newsletter.php"><img class="newsletter_signup_bottom_subscribe_img" alt="Subscribe to the CreditCards.com newsletter" src="/images/subscribe-button.png"/></a>
                        </td>
                        <td background="/images/credit-corner-body_rightfill.gif"><img height="1" width="6" src="/images/spacer.gif"/></td>
                    </tr>
                    <tr>
                        <td><img height="6" width="6" src="/images/credit-corner-bt-lft.gif"/></td>
                        <td background="/images/credit-corner-ftr_fill.gif"><img height="6" width="1" src="/images/spacer.gif"/></td>
                        <td><img height="6" width="6" src="/images/credit-corner-bt-rt.gif"/></td>
                    </tr>
                </table>
                <?
                }
                ?>
                
                <?
                if($totalCards > 0) {
                ?>
                    Note:
                    <br />
                    <ul>
                        <li>Savings calculations are based upon the time taken to pay off the entire balance up to 36 months.</li>
                        <li>Calculations take into account the Annual Fee, Intro APR, Intro period, Regular APR and Balance Transfer Fees.</li>
                        <li>All calculations assume a Balance Transfer fee of 3% of the amount transferred, and a cap on the Balance Transfer fee of $100. Please check the actual rates in the Terms and Conditions of the specific card.</li>
                    </ul>
                    
                    <br />
                    <br />
	                Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a>
                
                <? } ?>
                
                <div class="credit-card-details" style="padding: 30px 0;">
                    Interactive tools are made available to you as self-help tools for your independent use, and are not intended to provide financial advice. We cannot and do not guarantee their accuracy in regard to your individual circumstances. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty.
                </div>
                
            </div> <!-- pageContentArea -->

        </td>
    </tr>
</table>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>


<? 
echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";
?>
<!-- Adobe Marketing Cloud Tag Loader Code
Copyright 1996-2013 Adobe, Inc. All Rights Reserved
More info available at http://www.adobe.com/solutions/digital-marketing.html -->
<script type="text/javascript">//<![CDATA[
var amc=amc||{};if(!amc.on){amc.on=amc.call=function(){}};
document.write("<scr"+"ipt type=\"text/javascript\" src=\"//www.adobetag.com/d1/v2/ZDEtY3JlZGl0Y2FyZHNjb20tNTY5NS0yMTg0/amc.js\"></sc"+"ript>");
//]]></script>
<!-- End Adobe Marketing Cloud Tag Loader Code -->
<script language="JavaScript" type="text/javascript">
/* You may give each page an identifying name, server, and channel on
the next lines. */
s.pageName="tools:checkup:results"
s.server=""
s.channel="tools"
s.pageType=""
s.prop1="tools:checkup"
s.prop2=""
s.prop3=""
s.prop4=""
s.prop5=""
s.prop6=""
s.prop7=""
s.prop8="checkup"
/* Conversion Variables */
s.campaign="<?= isset($_SESSION['aid']) ? $_SESSION['aid'] : 0;?>-<?= isset($_SESSION['banner_id']) ? $_SESSION['banner_id'] : 0;?>-<?= isset($_SESSION['cid']) ? $_SESSION['cid'] : 0;?>-<?= isset($_SESSION['did']) ? $_SESSION['did'] : 0;?>"
s.state=""
s.zip=""
s.events=""
s.products=""
s.purchaseID=""
s.eVar1=""
s.eVar2=""
s.eVar3=""
s.eVar4=""
s.eVar5=""
s.eVar6=""
s.eVar7=""
s.eVar8=""
s.eVar9=""
s.eVar10=""
s.eVar11=""
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><img src="http://creditcardscom.112.2o7.net/b/ss/ccardsccdc-us/1/H.25--NS/0"
height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.25. -->

</div> <!-- skeleton -->
</body>
</html>