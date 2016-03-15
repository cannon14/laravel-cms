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
class CMS_layouts_genericpagelayouts_cccomusmobileGenericPageLayout extends CMS_layouts_genericPageLayout {
	var $headerTemplate = 'cccomusmobile/header';
	var $footerTemplate = 'cccomusmobile/footer';
	
    function writeHeader($page, $rootPath='./') 
    {	
    	$page->properties['pageMeta'] = 
<<<META
<meta name="keywords" content="merchant account providers, merchant account help,  accept credit cards, merchant services">
<meta name="description" content="Locate helpful articles and specific merchant account providers. Accept credit cards today.">
META;
        $page->properties['pageTitle'] = $page->getTitle();
        $this->assignValue('rootPath', $rootPath);
    	$this->assignValue('page', $page);
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
}
?>