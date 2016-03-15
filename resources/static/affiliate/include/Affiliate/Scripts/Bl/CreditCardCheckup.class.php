<?php

QUnit_Global::includeClass('QCore_Settings');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_cardqueryclient_CardQuery');
Qunit_Global::includeClass('Affiliate_Scripts_Bl_TermsAndConditionsHelper');

define("FEEDS_WSDL_SERVER_ADDRESS", "http://feeds.creditcards.com:8535/cardquery/QueryService?wsdl");
//define("FEEDS_WSDL_SERVER_ADDRESS", "http://linops01.in.creditcards.com:8535/cardquery/QueryService?wsdl");

define('MAX_NUM_CARDS', 10);
define('BALANCE_TRANSFER_FEE_RATE', 3);
define('MAX_BALANCE_TRANSFER_FEE', 100);

class Affiliate_Scripts_Bl_CreditCardCheckup
{
	function saveCheckupData($cardName, $apr, $annualFee, $principle, $monthlyCharges, $monthlyPayment, $quality)
    {
    	$insertTime = date('Y-m-d H:i:s');

    	$sql = "insert into credit_card_checkup ".
            "(".
                "external_visit_id,
                server_id,
                credit_card_name,
                interest_rate,
                annual_fee,
                amount_owed,
                monthly_charged,
                monthly_paid,
                credit_quality,
                insert_time".
            ")".
	        " values(".
	    	    _q($_SESSION['external_visit_id']).
	    	    ","._q(ENTITY_ID).
	    	    ","._q($cardName).
	    	    ","._q($apr).
	            ","._q($annualFee).
	            ","._q($principle).
	            ","._q($monthlyCharges).
	            ","._q($monthlyPayment).
	            ","._q($quality).
	    	    ","._q($insertTime).
	        ")";
	    	    
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            $errorMsg = "Credit Card Checkup: Error saving form data";
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }
    }

    function loadResultCards($userApr, $userQuality='') {
    	
    	$expression = '';
    	
	    switch( $userQuality ) {
	        
	    	case "no_history": $expression = '!21&!22&!23&!24&2';
	    	break;
	    	
	    	case "bad": $expression = '!21&!22&!23&2';
            break;
	    	
	        case "fair": $expression = '!21&!22&2';
	        break;
	        
	        case "good": $expression = '!21&2';
            break;
            
	        //excellent or N/A
	        //pass in "!0" since we don't have an expression and want all cards
	        default: $expression = '2';
	    }
	    
	    $cardQuery = new CardQuery();
        
        $cards = $cardQuery->getCreditCardsByExpressionAndMaxApr($expression, $userApr);
        
        return $cards;
    }
    
	function setCardImagePath($marketable, $cardImage) {
	    
	    $path = "";
	    
	    if($marketable == 1) {
	        $path = "http://www.imgsynergy.com/cccom/" . $cardImage;
	        
	    } else if($cardImage == '') {
            $path = "http://www.imgsynergy.com/cccom/card-not-available.gif";
            
	    } else {
	        $path = "http://allcardrates.com/ratehub/cardimages/" . $cardImage;
	    }
	    
	    return $path;
	}
	
	function mapUserQuality($param) {
	    
	    switch( $param ) {
	        
	        case "excellent": return "Excellent";
	        break;
	        
	        case "good": return "Good";
	        break;
	        
	        case "fair": return "Fair";
	        break;
	        
	        case "bad": return "Bad";
	        break;
	
	        case "no_history": return "Limited or no credit history";
	        break;
	        
	        default: return "N/A";
	    }
	}
	
	function calcCard(&$card, $userFees, $principle, $payment, $userTerm, $userMonthlyCharges, $userLongPayback, $userCantPayback)
    {
    	$currentPrinciple = $principle;
        $cardTotalFees = 0;
        $cardRate = $card->regularApr / 100 / 12;
        
        $intoAprPeriod = $card->introAprPeriod;
        $introRate = $card->introApr / 100 / 12;
        
        $termCount = 0;
        
        //**********************************
        //add in balance transfer fee
        //**********************************
        $balanceTransferFee = $currentPrinciple * BALANCE_TRANSFER_FEE_RATE;
        $balanceTransferFee = ($balanceTransferFee > MAX_BALANCE_TRANSFER_FEE ? MAX_BALANCE_TRANSFER_FEE : $balanceTransferFee );
        
        $currentPrinciple += $balanceTransferFee;
        $cardTotalFees += $balanceTransferFee;
        
        
    	while( $currentPrinciple > 0 ) {
    		
        	//**********************************
            //add annual fee
            //**********************************
            if(($termCount % 12 == 0) && ($card->annualFee != 0)) {
                $currentPrinciple += $card->annualFee;
                $cardTotalFees += $card->annualFee;
            }
            
            
            //**********************************
	        //calc intro apr fees
	        //NOTE: hasIntroApr flag does not always reflect true data. Check for 999 rules out non-intro APR cards.
	        //**********************************
    		if(($termCount <= $introAprPeriod) && ($card->introApr != '999')) {
	            
	            $introInterest = $currentPrinciple * $introRate;
	            
	            $currentPrinciple += $introInterest - $payment;
	            $cardTotalFees += $introInterest;
	            
    		} else {
	        
	            //**********************************
			    //calc regular apr fees
			    //**********************************
	            $interest = $currentPrinciple * $cardRate;
	            
	            $cardTotalFees += $interest;
	            
	            $currentPrinciple = $currentPrinciple + $interest - $payment;
	        }
	        
	        //add in user monthly charges
            $currentPrinciple += $userMonthlyCharges;
            
	        $termCount++;
	        
	        //**********************************
	        //if user can't pay back or user payback > 36 months, cap results at 36 months
	        //**********************************
	        if(($userLongPayback || $userCantPayback) && ($termCount >= 36)) {
                break;
                
	        } else if( $termCount >= 100 || ($userFees-$cardTotalFees < 0)) {
	        	
	        	//exclude card from results since it will NOT benefit them
	        	$card->exclude = true;
	        	break;
	        }
    	}
    	
    	//if you only save cents, then exclude card
        if( $userFees-$cardTotalFees < 1 ) {
            
            //exclude card from results since it will NOT benefit them
            $card->exclude = true;
        }
    	
    	//**********************************
        //create output for card savings
        //**********************************
        
        $card->savings_value = $userFees-$cardTotalFees;
        
        if( $userCantPayback || $userLongPayback ) {
            $savings = 'You could save up to <span class="savingsCallout">$'.number_format($userFees-$cardTotalFees, 0, '.', ',').'</span> in a period of 36 months';
            
        } else {
           $savings = 'You could save up to <span class="savingsCallout">$'.number_format($userFees-$cardTotalFees, 0, '.', ',').'</span> in the time taken to pay off the debt';
        }
        
        $out = '<table border="0">
            <tr>
            <td align="left"><strong style="font-family: Arial, Helvetica, sans-serif; color: #BD0606; font-size: 15px; padding-left: 10px;">With this card:</strong></td>
            </tr>
            <tr>
            <td align="left" class="calcResults">'.$savings.'<br><br>
            </td></tr></table>';
    
        return $out;
    }
    
	function buildSchumerBox($card, $cardPosition, $fid) {

        $tncHelper = QUnit_Global::newObj('Affiliate_Scripts_Bl_TermsAndConditionsHelper');
        $tncLink = $tncHelper->getTermsAndConditionsLink($card->cardId);
        $tncAid = $tncHelper->getSentinelAidValue();
        $tncSid = $tncHelper->getSentinelWebsiteIdValue();

	    $cardLink = $card->individualOfferLink;
	    $cardTitle = $card->cardName;
	    $appLink = $card->appLink;
	    $imagePath = $card->imagePath;
	    $cardId = $card->cardId;
	    $cardDetailText = $card->detailList;
	    $regularApr = $card->regularAprLabel;
	    $introApr = $card->introAprLabel;
	    $introAprPeriod = $card->introAprPeriodLabel;
		$balanceTransferIntroApr = $card->balanceTransferIntroAprLabel;
		$balanceTransferIntroAprPeriod = $card->balanceTransferIntroAprPeriodLabel;
	    $annualFee = $card->annualFeeLabel;
	    $balanceTransfers = $card->balanceTransfersLabel;
	    $creditNeeded = $card->creditNeededLabel;
	    $savings = $card->savings;
	    $appUrl = "/oc/?pid=" . $cardId . "&pg=" . $fid . "&pgpos=" . $cardPosition;
	    $appTncUrl = "/oc/?pid=" . $cardId . "&pg=" . $fid . "&pgpos=" . $cardPosition . "&aid=" . $tncAid . "&sid=" . $tncSid;
		$imgRoot = IMGSYNERGY_CARD_IMAGE_ROOT;
	    $out = <<<ENDCONTENT
		<table class="old-schumer-box" width="100%" border="0" cellpadding="0" cellspacing="0">
		    <tr>
		        <td>
		            <table width="100%" align="center" cellpadding="0" cellspacing="0" style="border: 3px solid #CCC;">
		                <tr> 
		                    <th colspan="2" class="offer-left"><a href="$appUrl" target="_blank">$cardTitle</a></th>
		                </tr>
		                <tr>
		                    <td width="15%" class="cc-card-art-align">
		                        <a href="$appUrl" target="_blank"><img src="$imgRoot/$imagePath" width="95" height="60" border="0" alt="$cardTitle"></a><br /><a href="$appUrl" target="_blank"><img name="Apply-Now" border="0" src="/images/apply-now.gif" width="95" height="28" alt="$cardTitle"></a>
ENDCONTENT;

        if ($tncLink) {
            $out .= "<a href=\"$appTncUrl\" class=\"tnc-link\" target=\"_blank\">Rates &amp; Disclosures</a>";
        } // terms and conditions link
	    $out .= <<<MORECONTENT
		                    </td>
		                    <td width="85%" class="details">$cardDetailText</td>
		                </tr>
		                <tr> 
		                    <td colspan="2"> 
		                        <table align="center" class="rate-rc" cellpadding="0" cellspacing="1">
		                            <tr>
		                                <td colspan="2" class="rate-top">Purchases</td>
                                                <td nowrap="nowrap" colspan="2" class="rate-top">Balance Transfers</td>
                                                <td rowspan="2" class="rate-top">Regular APR</td>
                                                <td rowspan="2" class="rate-top">Annual Fee</td>
        	                                <td rowspan="2" class="rate-top">Credit Needed</td>
		                           </tr>
                                            <tr>
                                                <td nowrap="nowrap" class="rate-top">Intro APR</td>
                                                <td nowrap="nowrap" class="rate-top">Intro APR Period</td>
                                                <td nowrap="nowrap" class="rate-top">Intro APR</td>
                                                <td nowrap="nowrap" class="rate-top">Intro APR Period</td>
                                            </tr>
		                            <tr>
		                                <td class="rates-bottom">$introApr</td>
		                                <td class="rates-bottom">$introAprPeriod</td>
        
                                                <td class="rates-bottom">$balanceTransferIntroApr</td>
                                                <td class="rates-bottom">$balanceTransferIntroAprPeriod</td>
		                                     
                                                <td class="rates-bottom">$regularApr</td>
		                                <td class="rates-bottom">$annualFee</td>
		                                <td class="rates-bottom">$creditNeeded</td>
		                            </tr>
		                        </table>
		                    </td>
		                </tr>
		            </table>
		        </td>
		        <td width="150px" valign="top">$savings</td>
		    </tr>
		</table>
		<br>
MORECONTENT;
		
        return $out;
        
	}//buildShumerBox
	
}
?>
