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
 */
csCore_Import::importClass('CMS_layouts_merchantServicePageLayout');
class CMS_layouts_merchantservicepagelayouts_cccomcafrMerchantServicePageLayout extends CMS_layouts_merchantServicePageLayout {
	var $headerTemplate = 'cccomcafr/header';
	var $subHeaderTemplate = 'cccomcafr/sub_header';
	var $footerTemplate = 'cccomcafr/footer';
	var $subFooterTemplate = 'cccomcafr/card_sub_footer';
	var $cardTemplate = 'cccomcafr/merchant_service_listing';	
}
?>