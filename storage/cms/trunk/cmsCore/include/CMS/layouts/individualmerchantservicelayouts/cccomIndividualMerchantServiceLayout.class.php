<?php
/**
 * 
 * ClickSuccess, L.P.
 * August 18, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */
csCore_Import::importClass('CMS_layouts_individualMerchantServiceLayout');
class CMS_layouts_individualmerchantservicelayouts_cccomIndividualMerchantServiceLayout extends CMS_layouts_individualMerchantServiceLayout {
	var $headerTemplate = 'cccom/header';
	var $bodyTemplate = 'cccom/individual_merchant_service_listing';   
	var $footerTemplate = 'cccom/footer';   
}
?>