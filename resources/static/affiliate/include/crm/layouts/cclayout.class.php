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

QUnit_Global::includeClass('crm_widgets_cccom_cardListingWidget');
QUnit_Global::includeClass('crm_widgets_cccom_subHeadingWidget');
QUnit_Global::includeClass('crm_widgets_cccom_headerWidget');
QUnit_Global::includeClass('crm_widgets_cccom_specialOfferWidget');

class crm_layouts_cclayout extends Affiliate_Merchants_Bl_SiteBuild
{
		
	// This defines the location of your site's source. 
	//
	// *Note* I have created a directory to just hold the 
	// images and style sheets and have pointed $sourcebase there
	// just because to pull the whole site over it takes about a minute
	// and during testing this becomes quite annoying.
	
	//var $sourceBase = "C:/cardsdev/projects/build/cssandimages/";
	var $sourceBase = "/usr/local/apache2/htdocs/dev/";
	
	// This defines where you want your project built.
	
	//var $baseBuild = "C:/cardsdev/projects/build/";
	var $baseBuild = "/usr/local/apache2/htdocs/ccbuild/";
	
	// This defines which categories (and subsequently which pages) 
	// you want displayed on your site.  Refer to the manager console
	// under "Manage Categories" for the category shortnames.
	var $categories = array("cccom", "cccom-type", "cccom-bank");
	
	// This defines how many cards to show per page.
	var $cardsPerPage = 15;

	
	
	// Declare Widgets
	// **********************************************
	var $carsListingWidget;
	var $subHeadingWidget;
	var $headerWidget;
	var $specialOfferWidget;
	// **********************************************

	
	
	function createWidgets($pages, $cards){	
		if(!$this->cardListingWidget = new crm_widgets_cccom_cardListingWidget($pages, "90%"))
			return false;	
		if(!$this->subHeadingWidget = new	crm_widgets_cccom_subHeadingWidget())
			return false;
		if(!$this->headerWidget = new	crm_widgets_cccom_headerWidget())
			return false;				
		if(!$this->specialOfferWidget = new	crm_widgets_cccom_specialOfferWidget())
			return false;	
		return true;
	}
	
	function createTrackingTop($fid){
		$trackingStr = "<?
include_once('affiliate/settings/settings2.php');
\$_SESSION['fid'] = \"".$fid."\";
?>\n";
		return $trackingStr;
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
	// $currPage['listingImage']
	
function createPageHeader($currPage = null, $pageNum = null, $categoryName = null){
	
	$head = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
\"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>

<title>".$currPage['pageTitle']."</title>
". $currPage['pageMeta'] ."


<link rel=\"stylesheet\" href=\"/css/credit-cards.css\" type=\"text/css\">
<script src=\"/javascript/application.js\"></script>
</head>
";
	
$wrapper = $this->headerWidget->write();

$specialOffer .= $this->specialOfferWidget->write();
					
if($currPage != null){
		// page	info
		$pageStr .= "
<td valign=\"top\"> 
<div align=\"center\">
<table width=\"90%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">";


if($categoryName == "cccom-left-type" || $categoryName == "cccom-mid-type"){
	$pageStr .= "<tr>
	<td rowspan=\"2\" valign=\"top\"><img src=\"/images/" . $currPage['pageHeaderImage'] . "\" alt=\"" . $currPage['pageHeaderImageAltText'] . "\" border=\"0\" ></td>
	<td rowspan=\"2\"><img src='/images/10-10-spacer.gif' width=\"10\" height=\"10\"></td>
	<td><h1>".$currPage['pageHeaderString']."</h1></td>
	</tr>
	<tr>
	<td><p>".$currPage['pageDescription']."</p></td>
	</tr>";
}else{
	$pageStr .= "<tr>
            <td rowspan=\"2\" valign=\"top\"><div align=\"right\"><img src=\"/images/". $currPage['pageHeaderImage'] . "\" alt=\"". $currPage['pageHeaderImageAltText'] ."\"><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\"></td>
            <td rowspan=\"2\"style=\"border-left:1px solid #5F78A1\"><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\"></td>
            <td><h1>".$currPage['pageHeaderString']."</h1>
            </td>
          </tr>	<tr>
	<td><p>".$currPage['pageDescription']."</p></td>
	</tr>";	
	
}


$pageStr .= "</table>";


$compare = "
        <table width=\"540\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\" align=\"center\">
          <tr>
            <td><div align=\"center\">
                <table border=\"0\" cellspacing=\"0\" cellpadding=\"6\">
                  <tr>
                    <td class=\"box-dot\"><p><img src=\"/images/Credit-Cards-Search.gif\" width=\"119\" height=\"26\" alt=\"Search Airline Credit Cards Offer\"><br>
                  Search through the Airline Credit Card offers 
                                      below.<br>
                  <br>
                    </p></td>
                    <td class=\"box-dot-full\"><p><img src=\"/images/Credit-Cards-Compare.gif\" width=\"119\" height=\"26\" alt=\"Compare Airline Credit Cards\"><br>
                  Compare credit card offers in order to determine which card is best for you.    </p></td>
                    <td class=\"box-dot-right\"><p><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><b><img src=\"/images/apply-credit-cards.gif\" width=\"119\" height=\"26\" alt=\"Apply Online for Airline Cards\"><br>
                    </b></font>Apply for the Credit Card of your choice by filling out an online application! </p></td>
                  </tr>
                </table>
            </div></td>
          </tr>
        </table>		
		";	        		

$pageStr .= $compare;     
$pageStr .= "</div>";
		      
			// If this is the first page then display page info header.
			if($pageNum == 1){			
					
					$pageStr.="

					<table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
					        <tr> 
					          <td><img src=\"images/Best-Credit-Cards.gif\" width=\"184\" height=\"24\" alt=\"Best Balance Transfer Credit Card Offer\"></td>
					        </tr>
					 </table>";
			}	
		}

	return $head . $wrapper . $pageStr;	      
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
		
		$this->cardListingWidget->setCurrentCard($cardObject);
		$this->cardListingWidget->setApplyButton($this->siteInfo->fields['applyLogo']);
		$this->cardListingWidget->setApplyButtonAltText($cardObject['cardButtonAltText']);
		$this->cardListingWidget->setImageAltText($cardObject['cardButtonAltText']);
		
		return $this->cardListingWidget->write();
		
	}
	
	function createSubHeadingString($heading){
		$this->subHeadingWidget->setHeading($heading);
		
		return $this->subHeadingWidget->write();
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
	
	function createPageFooter($currPage = null){
		
		$learnMore = 
 $currPage['pageLearnMore'] . "

<br>
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"90%\" >
        
        <td valign=\"top\" class=\"credit-card-details\" width=\"100%\">" . $currPage['pageDisclaimer'] . "</td>
        </tr>
      </table>
      <img src=\"/images/spacer.gif\" width=\"445\" height=\"1\"> 
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"90%\" align=\"center\" >
        
          <td valign=\"top\" width=\"100%\"> 
            <p><br>
              ". $currPage['pageSeeAlso']."</p>
          </td>
        </tr>
      </table>
      <br>
    <img src=\"/images/spacer.gif\" width=\"375\" height=\"1\"></td>
    
</table>							
				";
		$footerStr = $learnMore . "
<!-- #BeginLibraryItem \"/Library/credit-cards-botnav.lbi\" -->

<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td><img src=\"/images/1-1-spacer.gif\" width=\"190\" height=\"1\"></td>
    <td> 
      <table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
        <tr> 
          <td> 
            <p align=\"left\">
			
<a href=\"javascript:;\" onClick=\"window.open('/SSL-Security.php','','scrollbars=yes,resizable=yes,width=400,height=350')\">
              <img src=\"/images/Security-Lock.gif\" width=\"10\" height=\"13\" border=\"0\" alt=\"Security Info\"></a> 
              Security Note: All Applications linked to on this site feature Secure 
              SSL Technology.</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img src=\"/images/500spacer.gif\" width=\"560\" height=\"1\"></td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
<tr>
    <td background=\"/images/credit-card-bot-nav.gif\"><img src=\"/images/1-1-spacer.gif\" width=\"1\" height=\"13
	
	
	\"></td>
  </tr>
  <tr>
    <td bgcolor=\"#FFFFFF\"><img src=\"/images/1-1-spacer.gif\" width=\"1\" height=\"1\"></td>
  </tr>
</table>
<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr> 
    <!--  CreditCards.com Column 2 -->
    <td valign=\"top\"> 
      <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
        <tr> 
          <td class=\"bottomnav\"> 
            <div align=\"center\">
              <a href=\"/terms.php\" class=\"bottomnav\">Terms &amp; Conditions</a> &nbsp;|&nbsp; 
              <a href=\"/privacy.php\" class=\"bottomnav\">Privacy Policy</a> &nbsp;|&nbsp; 
              <a href=\"/about-us.php\" class=\"bottomnav\">About Us</a> &nbsp;|&nbsp; 
              <a href=\"/contact.php\" class=\"bottomnav\">Contact Us</a> &nbsp;|&nbsp;
			  <a href=\"/index.php\" class=\"bottomnav\">Home Page</a> &nbsp;|&nbsp;
			  <a href=\"/site-map.php\" class=\"bottomnav\">Site Map</a><span class=\"bottomnav\"><br>
            <br>
            &copy; Copyright 2006 Credit Cards.com</span></div>
		  </td>
        </tr>
      </table>
    </td>
</table><!-- #EndLibraryItem --><? 
echo \"<IMG SRC='\".\$GLOBALS['RootPath'].\"sb.php?a_aid=\".\$_SESSION['aid'].\"&a_bid=\".\$_SESSION['hid'].\"' border=0 width=1 height=1>\";
//Banner Click Counting Code
if(\$_GET['a_aid'] != '' && \$_GET['a_bid'] != '')
print \"<img src='\".\$GLOBALS['RootPath'].\"t2.php?a_aid=\".\$_GET['a_aid'].\"&a_bid=\".\$_GET['a_bid'].\"&referrer=\".urlencode(\$_SERVER['HTTP_REFERER']).\"' border='0' width='1' height='1'>\";
?>
</body>
</html>
				";

				return $footerStr;
	}
	
	// createDetailsString (TODO)
	//
	// This method allows you to style the card details page.
	//
	// ******************************************************************************************
    // @return html encoded string which will be written to a php file.
    // ******************************************************************************************
	
	function createDetails($currCard) {
		
		$this->cardListingWidget->setCurrentCard($currCard);
		$this->cardListingWidget->setApplyButton($this->siteInfo->fields['applyLogo']);
		$this->cardListingWidget->setApplyButtonAltText($cardObject['cardIOButtonAltText']);
		$this->cardListingWidget->setImageAltText($cardObject['cardIOAltText']);
		
		$detailStr = "
<!-- #EndLibraryItem --></td>
    <!--  CreditCards.com Column 2 -->
    <td valign=\"top\"> 
     
      <div align=\"center\">
        <table width=\"90%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <td rowspan=\"2\" valign=\"top\"><img src=\"/images/American-Express-logo.gif\" alt=\"Blue Cash for Business Credit Card Application\" width=\"70\" height=\"47\"></td>
            <td rowspan=\"2\"><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\"></td>
            <td><h1>Blue Cash for Business Credit Card </h1></td>
          </tr>
          <tr>
            <td><p>The following Blue Cash for Business Credit Card features  a low 0% introductory APR on purchases and balance transfers. Apply for the Blue Cash for Business credit card  by filling out an online application.</p></td>
          </tr>
        </table>
      
        <br>
      </div>  
		". $this->cardListingWidget->write() ."<!-- #EndLibraryItem --><table width=\"90%\" align=\"center\" >
          <tr>
            <td><p class=\"credit-card-med\"> ACCESS TO THE OPEN NETWORK</p>
               <p>The Small Business Network<sup>SM</sup> is one place that's all about small business. It gives you the relationships and resources to help you run your business, including:
                 </p>
              </p>
               <ul>
                <li>
                  Unlimited fee-free additional cards</li>
                <li>0% APR for 6 months</li>
              </ul>              
              <p>Savings Save at AT&amp;T, FedEx&reg;, Hertz&reg;, Staples&reg;, 1-800-FLOWERS.COM&reg; and more by using your Business Card and see the savings on your statement. No coupons or codes are needed and the savings are in addition to other discounts your business may already receive. <br>
                  <br>
                  Online management Manage your account with the Small Business Dashboard &amp; track charges with Expense Management Reports.<br>
                  <br>
                  Community Chat, pose questions, get insights from other small business owners, and attract new business. <br>
                  <br>
              Advice Ask an expert a question, use an online tool, and read articles by other business owners. </p>
              <p></p></td></tr>
      </table>
      <img src=\"/images/445spacer.gif\" width=\"445\" height=\"1\"><br>
      <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"90%\" align=\"center\" >
        
        <td valign=\"top\" class=\"credit-card-details\" width=\"100%\"> <br>
          <br>
            See the online Blue Cash for Business credit card application for details
            about terms and conditions of offer. Reasonable efforts are made to 
            maintain accurate information. However all credit card information 
            is presented without warranty. When you click on the &quot; Apply Here &quot; button you can review the credit card terms and conditions 
            on the credit card issuer's web site.<br>
            <br><p align=\"left\">
			<strong>Still undecided or looking for a second credit card to apply for?<br>
			</strong><A href=\"/index.php\">CLICK HERE TO SEARCH, COMPARE, &amp; APPLY FOR CREDIT CARDS ONLINE</A> <br>
<br>
          </td>
        </tr>
      </table>
      <img src=\"/images/spacer.gif\" width=\"375\" height=\"1\"></td>
";
	
		return $detailStr;
		
	}
	
	function createSiteMap($pages, $cards){
			 $mapStr = "    <td valign=\"top\"> 
      <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td rowspan=\"2\" valign=\"top\"><img src=\"/images/10-10-spacer.gif\" width=\"8\" height=\"10\"></td>
          <td rowspan=\"2\"><img src=\"/images/Credit-Card-Site-Map.gif\" alt=\"Site Map\" width=\"65\" height=\"65\" border=\"0\" ><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\"></td>
          <td rowspan=\"2\"><img src=\"/images/10-10-spacer.gif\" width=\"8\" height=\"10\"></td>
		  <td><h1>Site Map</h1></td>
        </tr>
        <tr>
          <td><p>Use the following site map to find specific credit card offers quickly and conveniently. The credit card site map is categorized by credit card type and credit card issuer.</p></td>
        </tr>
      </table>
      <div align=\"center\"></div>
      <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td><table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"5\">
              <tr>
                <td><hr size=\"1px\" noshade color=\"#CCCCCC\" style=\"solid\"></td>
              </tr>
              <tr>
                <td><span class=\"credit-card-med-no-dec-BIG\">Search Credit Cards by Type </span><br>
                <img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
              </tr>
            </table>
            <table width=\"90%\"  border=\"0\" align=\"center\" cellpadding=\"1\" cellspacing=\"0\">";
           
           
           foreach($pages['cccom-type'] as $currPage){
	           $mapStr .=   "<tr>
	                <td><p><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><a href=\"".$currPage['pageLink'].".".$this->extension."\" class=\"credit-card-med-no-dec\"><img src=\"/images/ar2.gif\" alt=\"".$currPage['siteMapTitle']."\" width=\"8\" height=\"8\" border=\"0\"> ".$currPage['siteMapTitle']."</a> - " . $currPage['siteMapDescription'] . " </p></td>
	              </tr>\n";
           }
           
              
           $mapStr .= "</table>
            <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"5\">
              <tr>
                <td><hr size=\"1px\" noshade color=\"#CCCCCC\" style=\"solid\"></td>
              </tr>
              <tr>
                <td> <span class=\"credit-card-med-no-dec-BIG\">Search Credit Cards by Bank</span><br>                    
                <img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"></td>
              </tr>
            </table>
            <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
              
			foreach($pages['cccom-bank'] as $currPage){
				$mapStr .= "<tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><a href=\"Advanta.php\" class=\"credit-card-med-no-dec\"><img src=\"/images/ar2.gif\" alt=\"Advanta Credit Cards\" width=\"8\" height=\"8\" border=\"0\"></a> <a href=\"".$currPage['pageLink'].".".$this->extension."\" class=\"credit-card-med-no-dec\">".$currPage['siteMapTitle']."</a></td>
                <td>";
              	$cardObject = $this->_getCardsByPage($currPage['cardpageId']);
              	$i = 0;
              	while(!$cardObject->EOF){
					if($cardObject->fields['subCat'] == 1){
						$cardObject->MoveNext();
						continue;
					}
					if($i == 0)
						$mapStr .= "<A href=\"".$currPage['pageLink'].".".$this->extension."\" class=\"credit-card-med-no-dec-no-bold\">".$cardObject->fields['cardTitle']."</A></td>
              </tr>";
					else
						$mapStr .= "<tr>
                <td>&nbsp;</td>
                <td><A href=\"".$currPage['pageLink'].".".$this->extension."\" class=\"credit-card-med-no-dec-no-bold\">".$cardObject->fields['cardTitle']."</A></td>
              </tr>";
              		++ $i;
              		$cardObject->MoveNext();
              	}
   
              $mapStr .= "<tr>
                <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
              </tr>
              ";
			}
			  $mapStr .= "<tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Credit Report Offers\" width=\"8\" height=\"8\" border=\"0\"> <span class=\"credit-card-med\">Credit Report Offers </span></td>
                <td><A href=\"free-credit-report.php\" class=\"credit-card-med-no-dec-no-bold\">Free Credit Report</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A href=\"credit-report-monitoring.php\" class=\"credit-card-med-no-dec-no-bold\">Monitoring Your Credit with a Free Credit Report</A></td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A href=\"citi-credit-monitoring-service.php\" class=\"credit-card-med-no-dec-no-bold\">Citi Credit Monitoring Service</A></td>
		      </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A href=\"watch-guard-premier-security.php\" class=\"credit-card-med-no-dec-no-bold\">Watch Guard Premier Security</A></td>
              </tr>
              <tr>
 <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" style=\"solid\"></td>
              </tr>
              <tr>
                <td colspan=\"2\"><span class=\"credit-card-med-no-dec-BIG\">Credit Card Articles<br>
                <img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\">                </span></td>
              </tr>
              <tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Credit Card Basics\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Credit_Card_Basics\" class=\"credit-card-med-no-dec\">Credit Card Basics </a></td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"foreign-transaction-fees-article.php\">Foreign Transaction Fees for Credit Cards  Who's Affected?</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-and-credit-cards.php\">Credit Cards 101 &ndash; What are Credit Cards?</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"types-of-credit-cards.php\">Types of Credit Cards</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"compare-article.php\">How to Compare Credit Cards</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"choosing-the-right-credit-card.php\">Choosing the Right Credit Card for You</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-cards-tips-article.php\">Tips for Credit Cards</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Deciding-which-Credit-Card-is-right-for-you.php\">Deciding which Credit Card is right for you</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"staying-out-of-trouble-with-credit-cards.php\">Staying Out Of Trouble With Credit Cards</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"FAQs-Instant-Approval-Credit-Cards.php\">FAQ&rsquo;s About Credit Cards with Instant Approval</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Instant-Approval-Credit-Card-Process.php\">You Have Been Approved for An Instant Approval Credit Card</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"The-American-Express-Card.php\">The American Express Card: Is it Right for You?</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-cards-glossary.php\">Glossary of Credit Card Terms</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit_cards_faq.php\">FAQ's about Credit Cards</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"history-of-credit-cards.php\">A Brief History of Credit Cards</A> </td>
              </tr>
              <tr>
                <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
              </tr>
              <tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Bad Credit / Credit Repair\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Bad_Credit_Repair\" class=\"credit-card-med-no-dec\">Bad Credit / Credit Repair </a></td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"no-credit-history-article.php\">No Credit History? No Problem.</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Have-Bad-Credit-and-Need-a-Credit-Card.php\">Have Bad Credit and Need a Credit Card?</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-repair-get-back-your-credit.php\">Credit Repair: How to get back your credit</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"cleaning-up-and-repairing-your-credit.php\">Cleaning Up and Repairing Your Credit Rating</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-card-debt-article.php\">Repairing Credit Card Debt</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"bad-credit-reports-article.php\">How to Dispute Credit Report Errors</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"good-vs-bad-credit.php\">Good vs. Bad Credit: Why Is This Important?</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"The-Eufora-Card-is-Worth-a-Look.php\">The Eufora Card is Worth a Look</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Comparing-Credit-Cards-for-Bad-Credit.php\">Compare Credit Card Options For Those With Bad Credit</A> </td>
              </tr>
              <tr>
                <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
              </tr>
              <tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Credit / Account Management\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Credit_Account_Management\" class=\"credit-card-med-no-dec\">Credit / Account Management </a></td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Store-Credit-Cards.php\">Store Credit Cards  Enticing, but Not Always the Best Choice</A></td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-consumer-rights-article.php\">Credit &amp; Consumer Rights</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"what-is-a-credit-report.php\">What is a Credit Report?</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"credit-reporting-q&a.php\">Credit Reporting Q&amp;A</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"what-is-a-credit-score.php\">What is a credit score and how does it affect me?</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Reviewing-Your-Credit-Report.php\">Reviewing Your Credit Report Yearly</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"protecting-your-credit-card.php\">Protecting Your Credit Card</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"dos-and-donts.php\">Do&rsquo;s and Don'ts of Closing Accounts</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"limiting-your-financial-loss.php\">Limiting Your Financial Loss</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Cards-ATM-Cards-and-Debit-Cards.php\">What to Do When Credit Cards Are Lost or Stolen</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Card-Privacy-Options.php\">Privacy Options &ndash; How to Opt Out</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Phishing.php\">Phishing  What it means and how to prevent it</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Skimming.php\">
Skimming  What it is and how to avoid being a victim</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"online-account-management.php\">
Online Account Management </A></td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"identity-theft-watch-guard-premier.php\"> Identity Theft &ndash; Protect Yourself with Watch-Guard</A></td>
		      </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><A class=credit-card-med-no-dec-no-bold href=\"Citi-Credit-Monitoring-Service-New-from-Citi.php\">Citi Credit Monitoring Service  New from Citi</A></td>
			  </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"cardmember-benefits-visa-warranty-manager.php\"> Cardmember Benefits &ndash; Visa Warranty Manager</A></td>
		      </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"How-to-Opt-Out-of-Mail-Email-and-Telemarketing-Solicitations.php\">
How to Opt Out of Mail, Email and Telemarketing Solicitations</A></td>
              </tr>
              <tr>
                <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
              </tr>
              <tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Low Interest / 0% APR Cards\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Low_Interest_0_APR\" class=\"credit-card-med-no-dec\">Low Interest / 0% APR Cards </a></td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"low-interest-credit-cards-article.php\">How 0% APR credit cards can save you money</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Low-Interest-APR-Credit-Cards-Article543.php\">Saving on Interest Expenses with 0% APR Credit Cards</A></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"0-Credit-Card-Offers.php\">0% APR Credit Card Offers &ndash; Here to Stay or a Fad?</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Variable-vs-Fixed-Rate-Credit-Cards.php\">After the Intro &ndash; Variable vs. Fixed Rate Credit Cards</A> </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Using-Low-APR-Credit-Cards.php\">How to use low APR credit cards to become debt free</A> </td>
              </tr>
			  <tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"HSBC-Has-a-Card-for-Every-Occasion.php\">HSBC Has a Card for Every Occasion</A> </td>
              </tr>
              <tr>
                <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
              </tr>
			   <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Balance Transfer / Debt Consolidation\" width=\"8\" height=\"8\" border=\"0\"><a href=\"credit-card-articles.php#Balance_Transfer_Debt_Consolidation\" class=\"credit-card-med-no-dec\"> Balance Transfer / Debt Consolidation </a></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"credit-card-debt-the-real-cost.php\">Credit Card Debt  What's the Real Cost</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Holiday-Spending-Can-Lead-to-Financial-Hangovers.php\">Holiday Spending Can Lead to Financial Hangovers</A> </td>
		      </tr>
			  <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Eliminate-Credit-Card-Debt.php\">Eliminate Credit Card Debt</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Comparing-0-Balance-Transfer-Credit-Cards.php\">Comparing 0% Balance Transfer Offers</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"debt-consolidation-article.php\">Credit Card Debt Consolidation</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"managing-and-getting-rid-of-debt.php\">Credit Card Debt </A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Card-Debt-Article821.php\">Transferring your way out of Credit Card Debt</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Card-Consolidation.php\">Credit Card Consolidation</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Card-Debt-Consolidation.php\">Credit card debt consolidation - Retire Those High Rate Plastics </A></td>
		      </tr>
			  <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"balance-transfers-101.php\">Balance Transfers 101</A></td>
		      </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			   <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Reward Programs / Cash Back Cards\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Reward_Programs_Cash_Back_Cards\" class=\"credit-card-med-no-dec\">Reward Programs / Cash Back Cards </a></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"holiday-savings-american-express-card-members-get-it.php\">Holiday Savings  American Express Card Members Get It</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Become-Part-of-the-IN-Crowd.php\">Become Part of the IN-Crowd</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"become-one-with-the-american-express-one-card.php\">Become One with the American Express One Card</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Which-Reward-Credit-Card-Is-Best.php\">How To Determine Which Reward Credit Card Is For You </A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Card-Rewards-Programs.php\">How to Super-size Your Credit Card Reward Program </A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Maximize-Your-Credit-Card-Rewards-Program.php\">Maximize Your Reward Card Program</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"How-Cash-Back-Credit-Cards-Work.php\">How Cash Back Credit Cards Work</A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Comparing-Cash-Back-Credit-Card-Offers.php\">How To Compare Cash Back Credit Card Offers</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Cash-Back-vs-Reward-Credit-Cards.php\">Cash Back vs. Reward Credit Cards</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Gas-Rebate-Credit-Cards.php\">Cut Your Gas Bill with Gas Rebate Credit Cards</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Cash-Back-Airline-Reward-Credit-Cards.php\">Cash Back or Airline Reward Credit Cards</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"gas-rebate-credit-card.php\">Gas Rebate Credit Cards  Looking Better All the Time</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"automobile-rebate-credit-cards.php\">Automobile Rebate Credit Cards</A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"so-many-rewards-so-little-time.php\">So Many Rewards, So Little Time</A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"cash-back-bonus-credit-card.php\">Cash Back Bonus Credit Card  5% back on Everyday Purchases</A></td>
		      </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			   <tr>
                 <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Airline / Frequent Flyer Programs\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Airline_Frequent_Flyer_Programs\" class=\"credit-card-med-no-dec\">Airline / Frequent Flyer Programs </a></td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"United-We-Fly-Credit-Card-Article.php\">United We Fly</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Which-Airline-Frequent-Flyer-Credit-Card-is-Best.php\">Which Airline Frequent Flyer Credit Card is Best?</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Get-Miles-Ahead-with-the-Discover-Miles-Card.php\">Get Miles Ahead with the Discover Miles Card</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Earning-Frequent-Flyer-Credit-Card-Points.php\">Strategies For Earning A Free Airline Ticket Sooner</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Survey-of-Airline-Reward-Credit-Cards.php\">A Survey of Airline Rewards Programs</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"FAQs-Airline-Credit-Cards.php\">FAQ&rsquo;s About Airline Frequent Flyer Credit Cards</A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Cash-Back-Airline-Reward-Credit-Cards.php\">Cash Back or Airline Reward Credit Cards</A> </td>
		      </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			   <tr>
                 <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Student Credit Card Education\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Student_Credit_Card_Education\" class=\"credit-card-med-no-dec\">Student Credit Card Education </a></td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Saving-for-College-with-the-UPromise-Credit-Card.php\">Saving for College with the UPromise Credit Card</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Earn-Extra-Credit-with-a-Rewards-Student-Credit-Card.php\">Earn Extra Credit with a Rewards Student Credit Card</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Student-Credit-Cards-101.php\">Student Credit 101</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Comparing-College-Student-Credit-Cards.php\">Comparing Student Credit Cards vs. Debit Cards</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Establishing-Credit-With-A-Student-Credit-Card.php\">How to Establish Credit with a Student Credit Card</A> </td>
		      </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			   <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Credit Cards for Small Business\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Credit_Cards_for_Small_Business\" class=\"credit-card-med-no-dec\">Credit Cards for Small Business </a></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Special-Business-Gold-Card.php\">Businessman's Special  Get $50 with the Business Gold Card</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Reasons-For-A-Small-Business-Credit-Card.php\">Reasons For A Small Business Credit Card</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Using-Business-Credit-Card.php\">Using a Business Credit Card to Manage Expenses</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"credit-cards-for-small-business.php\">Credit Cards for Small Business</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold 
href=\"Simplify-Your-Bookkeeping-Corporate-Credit-Card.php\">Simplify Your Bookkeeping with a Corporate Credit Card</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Reward-Options-For-Business-Credit-Cards.php\">Reward Options for Business Credit Cards</A> </td>
		      </tr><tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"small-business-corporate-card.php\">How Small Business Credit Cards Differ from Corporate Cards</A> </td>
		      </tr><tr>
                <td>&nbsp;</td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"Advanta-Means-Business.php\">Advanta Means Business</A> </td>
              </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			   <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Prepaid / Debit Cards\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"credit-card-articles.php#Prepaid_Debit_Cards\" class=\"credit-card-med-no-dec\">Prepaid / Debit Cards</a></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Rebuild-Your-Credit-with-the-Eufora-Prepaid-MasterCard.php\">Rebuild Your Credit with the Eufora Prepaid MasterCard</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Using-Plastics-for-Payments.php\">Using Plastics for Payments</A></td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Pros-and-Cons-of-Prepaid-Debit-Cards.php\">What Are The Pro&rsquo;s and Con&rsquo;s of Prepaid Debit Cards</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"New-Technology-For-Prepaid-Debit-Cards.php\">New Technology Features Offered for Prepaid Debit Cards</A></td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"How-Do-Prepaid-Debit-Cards-Differ.php\">How Do Prepaid Debit Cards Differ</A></td>
		      </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" style=\"solid\"></td>
		      </tr>
			   <tr>
                 <td colspan=\"2\"><span class=\"credit-card-med-no-dec-BIG\">News About Credit Cards<br>
                       <img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"> </span></td>
		      </tr>
			   <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"2005 Credit Card News\" width=\"8\" height=\"8\" border=\"0\"> <a href=\"/news/news.php\" class=\"credit-card-med-no-dec\">2005 Credit Card News</a></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"holiday-savings-american-express-card-members-get-it.php\">Holiday Savings  American Express Card Members Get It</A> </td>
		      </tr><tr>
		        <td>&nbsp;</td>
		        <td><A class=credit-card-med-no-dec-no-bold href=\"2005-Year-in-Review-for-Credit-Cards.php\">2005 Year in Review for Credit Cards</A> </td>
		      </tr><tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"New-Starbucks-Duetto-Visa-Credit-Card.php\">The New Starbucks Duetto Visa</A> </td>
		      </tr>
			  <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"citi-simplicity-rewards-credit-card.php\">The Citi Simplicity Rewards Card</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Credit-Card-Debt-in-2005.php\">Credit Card Debt in 2005</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Pay-in-the-Blink-of-an-Eye.php\">Pay in the Blink of an Eye with the Chase Blink Card</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"The-New-Bankruptcy-Law.php\">The New Bankruptcy Law &ndash; What Does it all Mean?</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"Earn-Cash-Back-with-Discover.php\">Earn 5% Cash Back with Discover</A> </td>
		      </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"The-New-Chase-Love-the-Double-Promotion-Could-Have-You-Seeing-Double.php\">The New Chase Love the Double Promotion Could Have You Seeing Double</A> </td>
		      </tr>
			   <tr>
                 <td>&nbsp;</td>
                 <td><A class=credit-card-med-no-dec-no-bold href=\"Jetblue-American-Express-Credit-Card.php\">JetBlue and American Express launch new card &ndash; September 12, 2005</A> </td>
		      </tr>
			   <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" style=\"solid\"></td>
		      </tr>
			  <tr>
                <td colspan=\"2\"><span class=\"credit-card-med-no-dec-BIG\">CreditCards.com Resources<br>
                <img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\">                </span></td>
              </tr>
			  <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"CreditCards.com\" width=\"8\" height=\"8\" border=\"0\"> <span class=\"credit-card-med\">CreditCards.com</span></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"about-us.php\">About Us</A></td>
		     
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><A href=\"SSL-Security.php\" target=\"_blank\" class=credit-card-med-no-dec-no-bold>SSL - Security</A></td>
		      </tr> 
			  
			  <tr>
			    <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			  <tr>
			     <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Contact\" width=\"8\" height=\"8\" border=\"0\"> <span class=\"credit-card-med\">Contact</span></td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"advertising.php\">Advertising</A></td>
		     
			  </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><a href=\"business-development.php\" class=credit-card-med-no-dec-no-bold>Business Development</a></td>
		      </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><a href=\"customer-support-department.php\" class=credit-card-med-no-dec-no-bold>Customer Support</a></td>
		      </tr><tr>
			    <td>&nbsp;</td>
			    <td><A class=credit-card-med-no-dec-no-bold href=\"newsletter.php\">Newsletter</A></td>
		      </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><A class=credit-card-med-no-dec-no-bold href=\"public-relations.php\">Public Relations</A></td>
			  </tr>
			  <tr>
			     <td>&nbsp;</td>
			     <td><A class=credit-card-med-no-dec-no-bold href=\"publishing-department.php\">Publishing</A></td>
		     
			  </tr><tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" class=\"hr-dashed\" style=\"dashed\"></td>
		      </tr>
			  <tr>
                <td><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"10\" border=\"0\"><img src=\"/images/ar2.gif\" alt=\"Policies\" width=\"8\" height=\"8\" border=\"0\"> <span class=\"credit-card-med\">Policies</span></td>
                <td><A class=credit-card-med-no-dec-no-bold href=\"terms.php\">Terms &amp; Conditions</A></td>
		      </tr><tr>
			    <td>&nbsp;</td>
			    <td><A class=credit-card-med-no-dec-no-bold href=\"privacy.php\">Privacy</A></td>
		      </tr>
			  <tr>
			     <td colspan=\"2\"><hr size=\"1px\" noshade color=\"#CCCCCC\" style=\"solid\"></td>
		      </tr>
            </table>
          </td>
        </tr>
      </table>
      <p><br>
    <img src=\"/images/spacer.gif\" width=\"650\" height=\"1\"></p>  </td>

  </table>
					";
		return $mapStr;
	}
	
}

?>
