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
csCore_Import::importClass('CMS_layouts_individualCardLayout');
class CMS_layouts_individualcardlayouts_cccomIndividualCardLayout extends CMS_layouts_individualCardLayout {
	var $headerTemplate = 'cccom/header';
	var $bodyTemplate = 'cccom/individual_card_listing';
	var $footerTemplate = 'cccom/footer';	
}
?>