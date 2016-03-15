<?php

/**
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Click Success, L.P.
 * January 3, 2005
 * 
 * cclayout.class.php
 * Creditcards.com example layout file.
 * This class inherits from SiteBuild.class.php (Affiliate/Merchants/Bl/SiteBuild.class.php)
 *  
 */
 
QUnit_Global::includeClass('Affiliate_Merchants_Bl_SiteBuild');

class crm_layouts_fflayout extends Affiliate_Merchants_Bl_SiteBuild
{
	
	// This defines the location of your site's source. 
	//
	// *Note* I have created a directory to just hold the 
	// images and style sheets and have pointed $sourcebase there
	// just because to pull the whole site over it takes about a minute
	// and during testing this becomes quite annoying.
	
	//var $sourceBase = "C:\cardsdev\projects\build\ffcssandimages";
	//var $sourceBase = "/usr/local/apache2/htdocs/dev";
	var $sourceBase = "/home/patrickm/workspace/Devel-CCs-v2";
	
	// This defines where you want your project built.
	
	//var $baseBuild = "C:/cardsdev/projects/build/";
	var $baseBuild = "/usr/local/apache2/htdocs/ccbuild/";
	
	// This defines which categories (and subsequently which pages) 
	// you want displayed on your site.  Refer to the manager console
	// under "Manage Categories" for the category shortnames.
	var $categories = array("type", "bank");
	
	// This defines how many cards to show per page.
	var $cardsPerPage = 999999;
	
	// These variables define some style and image attributes
	// of the Nav Bar.
	// **************************************************
	var $cssSelecedLink = "class='nav-red-bold'";
	var $cssUnSelectedLinkImage = "<img src='/images/bb.gif' width='15' height='8'>";
	var $cssSelectedLinkImage = "<img src='/images/br1.gif' width='15' height='8'>";
	var $cssNavClass = "class='leftnav'";
	// ************************************************** 
	

	function createWidgets($pages, $cards){
		
	}
	
	function createSplash($pages){
		foreach($pages['type'] as $currPage){
			
		}
		return $pageStr;
		
	}

	// createPageHeader
	//
	// This method allows you to style the way your pages are displayed.
	//
	// ******************************************************************************************
	// @param  $currpage  a cardpage object representing the current page. 
 	// @param  $pageNum an integer representing the current page number.
    // @return html encoded string which will be written to a php file.
    // ******************************************************************************************
	// When creating a page string you have access to a cardPage ($currPage) object and can access
	// the following member data:
	// 
	// $currPage['pageName'] = The Page's Name
	// $currPage['pageDescription'] = The Page's Description
	// $currPage['pageMeta'] = The Page's Meta Data (in html form, just dump it out).
	// $currPage['pageDisclaimer'] = The Page's Disclaimer
	// $currPage['pageLearnMore'] = The Page's "Learn More" Section
	
	function createPageHeader($currPage, $pageNum){
		$pageStr = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 3.2 Final//EN\">
<html>
<head>

<title>Frequent Flyer Credit Cards</title>
<meta name=\"keywords\" content=\"frequent flyer credit cards, credit cards with airline miles, frequent flyer credit card, frequent flyer miles, airline credit cards, continental, delta, best, online, mileage, flier, application\">
<meta name=\"description\" content=\"Frequent flyer credit cards with airline miles can help you earn free flights and travel rewards. Compare frequent flyer miles credit card programs side by side and review frequent flier mileage rewards, annual fees, interest rates and other airline credit card benefits - Apply online.\">
<meta name=\"robots\" content=\"index,follow\">
<meta http-equiv=\"imagetoolbar\" content=\"no\">
<meta name=\"MSSmartTagsPreventParsing\" content=\"true\">
<meta name=\"revisit-after\" content=\"30 days\">
<meta name=\"resource-type\" content=\"document\">
<meta name=\"distribution\" content=\"global\">
<meta name=\"copyright\" content=\" 2002 Frequent Flyer Credit Cards\">
<meta http-equiv=\"Reply-to\" content=\"webmaster@Frequent-Flyer-Credit-Cards.com\">
<!--airline credit card - frequent flyer credit cards with miles -->
<link rel=\"stylesheet\" href=\"css/frequent-flyer.css\" type=\"text/css\">
</head> 

<body bgcolor=\"#000088\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">
<br>
<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
  <tr>
    <td background=\"images/bg1.gif\"> 
      <h1><br>
      </h1>
      <table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
        <tr>
          <td>
            <h1 align=\"center\"><b><font face=\"Arial, Helvetica, sans-serif\" color=\"#0000CC\">Frequent 
              Flyer Credit Cards</font></b></h1>
            <br><br>
            <p align=\"left\">Frequent Flyer Credit Cards allow cardholders to earn 
              Airline Miles with Travel Rewards Programs. Credit cards with frequent 
              flyer miles are usually well suited for the individual that travels 
              frequently. </p>
            <p align=\"left\">Compare the following frequent flyer credit cards 
              from Continental, Delta, US Airways, Alaska Airlines, Advanta Business 
              and America West. All offers listed have links to online credit 
              card applications. Apply for a frequent flier credit card today 
              and start enjoying the benfits an airline credit card has to offer.</p>
            
          </td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#FFFFFF\" align=\"center\">
  <tr> 
    <td> 
      <table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
        <tr>
          <td> <br>
            <table width=\"100%\" border=\"1\" cellspacing=\"2\" cellpadding=\"3\" align=\"center\" bordercolor=\"#CCCCCC\" bgcolor=\"#000099\">
              <tr> 
                <td> 
                  <h2 align=\"center\"><font face=\"Arial, Helvetica, sans-serif\"><b><font color=\"#FFFFFF\">Frequent 
                    Flyer Credit Cards with Airline Miles</font></b></font></h2>
                </td>
              </tr>
            </table>
            <h2>&nbsp;<font face=\"Arial, Helvetica, sans-serif\"><br>
              </font></h2>
            <!-- #BeginLibraryItem \"/Library/chase-visa-credit-card.lbi\" -->
<script language=\"JavaScript\">
<!--
function MM_displayStatusMsg(msgStr) { //v1.0
  status=msgStr;
  document.MM_returnValue = true;
}
//-->
</script>
";
			return $pageStr;	      
	}
	
	// createCardString
	//
	// This method allows you to style the way cards are displayed.
	//
	// ******************************************************************************************
	// @param  $cardObject  a card object representing the current card. 
    // @return html encoded string which will be written to a php file.
    // ******************************************************************************************
	// When creating a card string you have access to a card ($cardObject) object and can access
	// the following member data:
	// 
	// $cardObject['cardId'] = The card's ID, I'm assuming this will be like a campaignid within PAP. 
	// $cardObject['cardTitle'] = Long name of the card. 
	// $cardObject['cardDescription'] = Description. 
	// $cardObject['merchant'] = Name of card's mechant. 
	// $cardObject['imagePath'] = Path to cardart
	// $cardObject['categoryImage']
	// $cardObject['categoryAltText']
	// $cardObject['cardIOImage']
	// $cardObject['cardIOAltText']
	// $cardObject['cardButtonImage']
	// $cardObject['cardButtonAltText']
	// $cardObject['cardIconSmall']
	// $cardObject['cardIconMid']
	// $cardObject['cardIconLarge']
	//
	// The remaining are pretty self explanatory.
	// ******************************
	// $cardObject['introApr'] 
	// $cardObject['annualFee']
	// $cardObject['monthlyFee'] 
	// $cardObject['balanceTransfers'] 
	// $cardObject['creditNeeded'] 
	// $cardObject['ratesAndFees']
	// $cardObject['rewards']
	// $cardObject['cardBenefits']
	// $cardObject['onlineServices']
	// $cardObject['footNotes']
	// *******************************
	

   
	
	function createCardString($cardObject){
		$cardString = " 
<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\" bgcolor=\"#CCCCCC\">
  <tr> 
    <td> 
      <div align=\"left\"> 
        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#FFFFFF\">
          <tr bgcolor=\"#CCCCCC\"> 
            <th colspan=\"6\"> <a href=\"http://www.ncsreporting.com/LinkTrack/Redirect.asp?LinkID=CHP10564\" target=\"_blank\" onMouseOver=\"MM_displayStatusMsg('Chase Credit Card Application');return document.MM_returnValue\" onMouseOut=\"MM_displayStatusMsg('');return document.MM_returnValue\">Chase 
              Platinum Credit Card</a>
          </tr>
          <tr> 
            <td width=\"120\" valign=\"top\" bgcolor=\"#FFFFFF\"> 
              <p align=\"center\"><a href=\"http://www.ncsreporting.com/LinkTrack/Redirect.asp?LinkID=CHP10564\" target=\"_blank\"><img src=\"images/Chase-Visa-Credit-Cards.gif\" width=\"120\" height=\"80\" alt=\"Chase platinum credit cards\" onMouseOver=\"MM_displayStatusMsg('Chase Platinum Credit Card Offer');return document.MM_returnValue\" onMouseOut=\"MM_displayStatusMsg('');return document.MM_returnValue\" border=\"0\"></a><br>
                <a href=\"http://www.ncsreporting.com/LinkTrack/Redirect.asp?LinkID=CHP10564\" target=\"_blank\"><img src=\"images/apply-online.gif\" width=\"120\" height=\"26\" onMouseOver=\"MM_displayStatusMsg('Click here for an online credit card application');return document.MM_returnValue\" onMouseOut=\"MM_displayStatusMsg('');return document.MM_returnValue\" alt=\"Online Credit Card Application\" border=\"0\"></a> 
              </p>
            </td>
            <td colspan=\"4\" valign=\"top\" bgcolor=\"#FFFFFF\"> 
              <table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"0\">
                <tr> 
                  <td><b><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">Credit 
                    Card Highlights:</font></b> 
                    <ul>
                      <li>Low 0% Introductory APR on Purchases and Balance Transfers*</li>
                      <li>This Platinum Credit Card also features a low regular 
                        APR </li>
                      <li>No annual fee</li>
                      <li>Free travel services and a travel rewards program including 
                        Auto Rental Insurance</li>
                      <li>Free secure online account access and bill pay</li>
                    </ul>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td colspan=\"6\" bordercolor=\"#FFFFFF\" bgcolor=\"#999999\"> 
              <table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" bordercolor=\"#FFFFFF\" bgcolor=\"#FFFFFF\">
                <tr bgcolor=\"#CCCCCC\"> 
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Intro<br>
                      APR</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Intro 
                      APR<br>
                      Period </font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Regular<br>
                      APR </font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Annual<br>
                      Fee </font></div>
                  </td>
                  <td> 
                    <div align=\"center\"> 
                      <div align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"1\">Account<br>
                        Setup Fee</font></div>
                    </div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Grace<br>
                      Period</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Balance<br>
                      Transfers</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Credit 
                      Needed<br>
                      for Approval</font></div>
                  </td>
                </tr>
                <tr bgcolor=\"#E5E5E5\"> 
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">0%*</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">6 
                      Months* </font></div>
                  </td>
                  <td bgcolor=\"#E5E5E5\"> 
                    <div align=\"center\"> <font size=\"1\" face=\"Arial, Helvetica, sans-serif\">8.79%*</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">None*</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">None* 
                      </font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">22 
                      Days*</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Yes*</font></div>
                  </td>
                  <td> 
                    <div align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">Good 
                      Credit*</font></div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </td>
  </tr>
</table>
<br>
<!-- #EndLibraryItem --><!-- #BeginLibraryItem \"/Library/discover-miles-card-credit-card.lbi\" -->
<script language=\"JavaScript\">
<!--
function MM_displayStatusMsg(msgStr) { //v1.0
  status=msgStr;
  document.MM_returnValue = true;
}
//-->
</script>";
		return $cardString;
	}
	
 	// createPagingString
 	//
 	// Style the paging box.  The <table> and <div> tags are teminated within the SiteBuild class.
 	//
	// ******************************************************************************************
    // @return html encoded string which will be written to a php file.
    // ******************************************************************************************

	function createPagingString(){
		$pagingString = "
			<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\" align=\"center\">
  			<tr>
    		<td><div align=\"center\">
        	<font class=\"nav-link\">";
        return $pagingString;
	}
	
	
	//createPageFooter
	//
	// Style the footer.
	//
	// ******************************************************************************************
	// @param  $currpage  a cardpage object representing the current page. 
 	// @param  $pageNum an integer representing the current page number.
    // @return html encoded string which will be written to a php file.
    // ******************************************************************************************
	// When creating a page string you have access to a cardPage ($currPage) object and can access
	// the following member data:
	// 
	// $currPage['pageName'] = The Page's Name
	// $currPage['pageDescription'] = The Page's Description
	// $currPage['pageMeta'] = The Page's Meta Data (in html form, just dump it out).
	// $currPage['pageDisclaimer'] = The Page's Disclaimer
	// $currPage['pageLearnMore'] = The Page's "Learn More" Section
	
	function createPageFooter($currPage){
		$footerStr = "
              <tr> 
                <td> 
                  <table border=\"0\" cellspacing=\"0\" cellpadding=\"6\" width=\"100%\" >
                      <td valign=\"top\" class=\"credit-card-details\" width=\"100%\"> 
                        * Please see Frequent Flyer Credit Cards with Airline 
                        Miles applications for additional details about terms 
                        and conditions of offers. Reasonable efforts are made 
                        to maintain accurate information. However all frequent 
                        flier credit card information is presented without warranty. 
                        When you click on the &quot;Click Here To Apply&quot; 
                        button you can review the airline credit card terms and 
                        conditions on the card issuer's web site. </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"6\" align=\"center\" bgcolor=\"#FFFFFF\">
              <tr> 
                <td> 
                  <table border=\"0\" cellspacing=\"0\" cellpadding=\"6\" width=\"100%\" >
                      <td valign=\"top\" class=\"credit-card-details\" width=\"100%\"> 
                        <div align=\"center\">
                          <p>Still Undecided?<br>
                            <a href=\"http://www.credit-card-applications-center.com\">Click 
                            Here for a complete listing of Credit Card Offers 
                            at the Credit Card Applications Center</a></p>
                        </div>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <p><!-- #BeginLibraryItem \"/Library/frequent-flyer-credit-cards-bottomnav.lbi\" --><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
              <tr> 
                <td> 
                  <div align=\"center\"></div>
                </td>
              </tr>
              <tr> 
                <td class=\"bottomnav\"> 
                  <div align=\"center\"> <font color=\"#FFFFFF\"><br>
        </font>|&nbsp; <a href=\"terms.htm\">Terms</a> &nbsp;|&nbsp; <a href=\"privacy-statement.htm\">Privacy</a> 
        &nbsp;|&nbsp; <a href=\"about-us.htm\">About Us</a> &nbsp;|&nbsp; <a href='contact-us.htm'>Contact 
        Us</a> | <a href=\"index.html\">Home Page</a>&nbsp;| 
        <p> </p>
                    
        <font color=\"#000000\">Copyright 2004 Frequent Flyer Credit Cards</font></div>
                </td>
              </tr>
            </table><!-- #EndLibraryItem --><p></p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
</body>
</html> ";
				return $footerStr;
	}
	
	// createDetailsString (TODO)
	//
	// This method allows you to style the card details page.
	//
	// ******************************************************************************************
    // @return html encoded string which will be written to a php file.
    // ******************************************************************************************
	
	function createDetails() {
		
	}
}

?>
