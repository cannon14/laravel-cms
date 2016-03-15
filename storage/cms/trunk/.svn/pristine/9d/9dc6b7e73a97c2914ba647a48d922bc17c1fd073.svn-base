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
csCore_Import::importClass('CMS_layouts_cardPageLayout');
class CMS_layouts_cardpagelayouts_cccomusAltSpecialsPageLayout extends CMS_layouts_cardPageLayout {
	
	var $headerTemplate = 'cccomus/header';
	var $preSubHeaderTemplate = 'cccomus/card_pre_sub_header';
    var $subHeaderTemplate = 'cccomus/card_sub_header';
    var $subFooterTemplate = 'cccomus/card_sub_footer';
    var $footerTemplate = 'cccomus/footer';
    var $cardTemplate = 'cccomus/card_listing';

	var $showGeoIpBanner  = true;
	
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
