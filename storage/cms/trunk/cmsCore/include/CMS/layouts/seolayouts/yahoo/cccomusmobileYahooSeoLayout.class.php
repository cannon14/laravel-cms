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
class CMS_layouts_seolayouts_yahoo_cccomus_mobileYahooSeoLayout extends CMS_layouts_seoLayout {
	var $subHeaderTemplate = 'cccomus_mobile/yahoo_static_pages';
	
	function writeHeader() 
    {	
    	$data = "URL\tTracking URL\tTitle\tDescription\tKeywords\n";
    	$this->bufferString($data);
    }
    
    function writeStaticData() 
    {	
    	$this->bufferContent($this->subHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeFooter() 
    {
    	$data = '';
    	$this->bufferString($data);
    }
    
	function writeEntry($url, $title, $description, $keywords)
    {
		$data = "$url\t$url?a_aid=1017&a_cid=1204\t$title\t$description\t$keywords\n";
		$this->bufferString($data);
    } 
    
	function writeEntryMeta($url, $title, $meta)
    {
		// parse meta tags
		$keywords = $description = '';
		if (preg_match('/"keywords" content="(.*)"/Ui', $meta, $matches))
			$keywords = $matches[1];
		if (preg_match('/"description" content="(.*)"/Ui', $meta, $matches))
			$description = $matches[1];
		
		// write entry
		$this->writeEntry($url, $title, $description, $keywords);
    } 
}
?>