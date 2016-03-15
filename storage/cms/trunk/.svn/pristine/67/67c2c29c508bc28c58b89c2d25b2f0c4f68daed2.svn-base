<?php
/**
 * 
 * ClickSuccess, L.P.
 * May 3, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Layouts
 * 
 */
csCore_Import::importClass('CMS_layouts_cardpagelayouts_magCardPageLayout');
class CMS_layouts_cardpagelayouts_magSpecialsPageLayout extends CMS_layouts_cardpagelayouts_magCardPageLayout {
	
	var $headerTemplate = 'mag/header';
	var $subHeaderTemplate = 'mag/sub_header';
	var $subFooterTemplate = 'mag/card_sub_footer';
	var $footerTemplate = 'mag/footer';
	var $cardTemplate = 'mag/specials_listing';
	
	function _getCardListingAsAssociativearray($cardObject){
		$listingArray = array();
		$listingArray['Intro APR'] = array($cardObject['active_introApr'], $cardObject['introApr']);
		$listingArray['Intro APR Period'] = array($cardObject['active_introAprPeriod'], $cardObject['introAprPeriod']);
		$listingArray['Regular APR'] = array($cardObject['active_regularApr'], $cardObject['regularApr']);
		$listingArray['Annual Fee'] = array($cardObject['active_annualFee'], $cardObject['annualFee']);
		$listingArray['Monthly Fee (up&nbsp;to)'] = array($cardObject['active_monthlyFee'], $cardObject['monthlyFee']);
		$listingArray['Balance Transfers'] = array($cardObject['active_balanceTransfers'], $cardObject['balanceTransfers']);
		$listingArray['Credit Needed'] = array($cardObject['active_creditNeeded'], $cardObject['creditNeeded']);
		
		return $listingArray;
	}
}
?>