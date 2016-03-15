<?php
/**
 * 
 * ClickSuccess, L.P.
 * August 7, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */
csCore_Import::importClass('CMS_layouts_genericPageLayout');
class CMS_layouts_genericpagelayouts_cccomGenericPageLayout extends CMS_layouts_genericPageLayout {
	var $headerTemplate = 'cccom/header';
	var $footerTemplate = 'cccom/footer';
}
?>