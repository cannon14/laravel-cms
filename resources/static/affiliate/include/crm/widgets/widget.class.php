<?php
QUnit_Global::includeClass('Affiliate_Merchants_Bl_SiteBuild');
class crm_widgets_widget extends Affiliate_Merchants_Bl_SiteBuild {

	var $pages = array();
	var $cards = array();
	
	var $category;
	var $width;
    
    // default constructor, really should override.
    function crm_widgets_widget($pages = null, $cards = null, $width = '100%') {

    	$this->pages = $pages;
    	$this->cards = $cards;
    	$this->width = $width;
    }
    
    function write(){
    	return "<table width=".$this->width." height=".$this->height." ><tr><td>Error Rendering Widget, no write function defined.  Please refer to the CMS manual.</td></tr></table>";
    }
    
}
?>