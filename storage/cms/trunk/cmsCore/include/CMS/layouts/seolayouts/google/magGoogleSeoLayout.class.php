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
csCore_Import::importClass('CMS_layouts_seoLayout');
class CMS_layouts_seolayouts_google_magGoogleSeoLayout extends CMS_layouts_seoLayout {
	var $subHeaderTemplate = 'mag/google_static_pages';
	
	function writeHeader() 
    {	
    	$data = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    	$this->bufferString($data);
    }
    
    
    function writeStaticData() 
    {	
    	$this->bufferContent($this->subHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    
    function writeFooter() 
    {
    	$data = '</urlset>';
    	$this->bufferString($data);
    }
    
    
	function writeEntry($pageUrl, $changeFreq, $priority)
    {
		$data = "<url>\n" .
				"\t<loc>$pageUrl</loc>\n" .
				"\t<changefreq>$changeFreq</changefreq>\n" .
				"\t<priority>$priority</priority>\n" .
				"</url>\n";
		$this->bufferString($data);
    }
}
?>