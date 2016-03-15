<?php

/*
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Created on Jan 12, 2006
 *
 */

 
QUnit_Global::includeClass('crm_widgets_widget');
class crm_widgets_cccom_headerWidget extends crm_widgets_widget {

	// These variables define some style and image attributes
	// of the Nav Bar.
	// **************************************************
	var $cssSelecedLink = "class='nav-red-bold'";
	var $cssUnSelectedLinkImage = "<img src='/images/bb.gif' width='15' height='8'>";
	var $cssSelectedLinkImage = "<img src='/images/br1.gif' width='15' height='8'>";
	var $cssNavClass = "class='leftnav'";
	// ************************************************** 

	var $pageLink;
	var $specialCode;


	function crm_widgets_cccom_typeNavCategoryWidget(){

	}
	
	function write(){
		$retString = "<body bgcolor=\"#FFFFFF\" leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" link=\"#003399\" alink=\"#CC0000\" vlink=\"#003399\"><!-- #BeginLibraryItem \"/Library/credit-card-topbar.lbi\" --><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#FFFFFF\">
  <tr>
    <td>
      <div align=\"left\"><a href=\"/index.php\"><img src=\"/images/credit-cards.gif\" width=\"362\" height=\"113\" border=\"0\" alt=\"Credit Cards\"></a></div>
    </td>
    <td width=\"100%\" background=\"/images/Credit-Cards-com-Spacer.gif\"></td>
    <td valign=\"top\">
      <div align=\"right\"><img src=\"/images/credit-card-offer-r.gif\" alt=\"Search, Compare &amp; Apply for Credit Card Offers - Visa, Mastercard, American Express and Discover\" width=\"202\" height=\"113\" border=\"0\" usemap=\"#Map\"></div>
    </td>
  </tr>
</table>
<map name=\"Map\">
  <area shape=\"rect\" coords=\"124,97,189,117\" href=\"/index.php\" alt=\"Credit Cards Home Page\">
</map><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr> 
    <td width=\"191
	\" valign=\"top\"><!-- #BeginLibraryItem \"/Library/credit-cards-leftnav.lbi\" --><table width=\"191\" border=\"0\" cellpadding=\"0\"  cellspacing=\"0\">
   <tr> 
    <td><img src=\"/images/10-10-spacer.gif\"></td>
  </tr>
  <tr> 
    <td>
      
        <div align=\"right\"><img src=\"/images/menu.gif\" width=\"191\" height=\"31\" alt=\"Credit Cards Menu\"></div>
     
    </td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/low-interest.php\">Low 
      Interest Credit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/balance-transfer.php\">Balance 
      Transfer Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/instant-approval.php\">Instant 
      Approval Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/reward.php\">Reward 
      Credit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/cash-back.php\">Cash 
      Back Credit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/airline-miles.php\">Airline 
      Credit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/business.php\">Business 
      Credit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/college-students.php\">Student Credit Cards</a> </td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/prepaid.php\">Prepaid 
      Debit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/bad-credit.php\">Credit 
      Cards for Bad Credit</a></td>
  </tr>
   <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/specials.php\">Credit 
      Card Specials</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"25\"></td>
  </tr>
  <tr> 
    <td><div align=\"right\"><a href=\"/bank.php\"><img src=\"/images/bank-credit-cards.gif\" alt=\"Bank Credit Cards\" width=\"191\" height=\"31\" border=\"0\"></a></div></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Advanta.php\">Advanta</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/American-Express.php\">American 
      Express&reg; </a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Bank-of-America.php\">Bank 
      of America&reg; </a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Chase.php\">Chase</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Citi.php\">Citi&reg; Credit Cards</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Discover.php\">Discover&reg; 
      </a> </td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/first-premier.php\">First Premier 
      </a> </td>
  </tr>
  
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/HSBC-Bank.php\">HSBC Bank</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Mastercard.php\">MasterCard&reg; 
      </a> </td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\" border=\"0\"><a href=\"/Visa.php\">Visa&reg; 
      </a> </td>
  </tr>
   <tr> 
    <td class=\"leftnav\"><img src=\"/images/10-10-spacer.gif\" width=\"10\" height=\"25\"></td>
  </tr>
 
  <tr> 
    <td>
      <div align=\"right\"><img src=\"/images/credit-cards-resource-center.gif\" alt=\"Credit Cards Resource Center\" width=\"191\" height=\"30\"></div>
    </td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/credit-card-articles.php\">Credit 
      Card Articles</a></td>
  </tr>
  <tr>
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/news/news.php\">News About Credit Cards</a></td>
  </tr>
  <tr>
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/credit_cards_faq.php\">FAQ's about Applying Online</a></td>
  </tr>
  <tr>
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/site-map.php\">Credit 
      Card Site Map</a></td>
  </tr>
  <tr> 
    <td class=\"leftnav\"><img src=\"/images/bb.gif\" width=\"15\" height=\"8\"><a href=\"/newsletter.php\">Credit 
      Card Newsletter</a></td>
  </tr>
  <tr> 
    <td><div align=\"right\"><img src=\"/images/Credit-Cards-com-Fader-191x46.gif\" alt=\"Online Credit Card Applications\" width=\"191\" height=\"28\"></div></td>
  </tr>
</table>
</td>";

		return "<!--BEGIN headerWidget !-->" . $retString . "<!--END headerWidget !-->";
	}
}
?>
