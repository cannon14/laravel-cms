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
class CMS_layouts_seolayouts_yahoo_YahooSeoLayout extends CMS_layouts_seoLayout {
	var $subHeaderTemplate = '';
	var $aid = 1017; // defaults just in case these don't get set properly
	var $cid = 10000;
	
	function setSite( $site )
	{
		$this->subHeaderTemplate = "$site/yahoo_static_pages";
	}
	
	function setAID( $aid )
	{
		$this->aid = $aid;
	}
	
	function setCID( $cid )
	{
		$this->cid = $cid;
	}
	
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
    
	function writeEntry($url, $title, $description, $keywords, $aid = null, $cid = null)
    {
    	if ( is_null( $aid ) )
    	{
    		$aid = $this->aid;
    	}
    	
    	if ( is_null( $cid ) )
    	{
    		$cid = $this->cid;
    	}
    	
		$data = "$url\t$url?a_aid=$aid&a_cid=$cid\t$title\t$description\t$keywords\n";
		$this->bufferString($data);
    } 
    
	function writeEntryMeta($url, $title, $meta, $aid = null, $cid = null)
    {
		// parse meta tags
		$keywords = $description = '';
		if (preg_match('/"keywords" content="(.*)"/Ui', $meta, $matches))
			$keywords = $matches[1];
		if (preg_match('/"description" content="(.*)"/Ui', $meta, $matches))
			$description = $matches[1];
		
		// write entry
		$this->writeEntry($url, $title, $description, $keywords, $aid, $cid );
    } 
}
?>