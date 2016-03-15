<?php
/**
 * 
 * CreditCards.com
 * 01/04/08
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */

class CMS_layouts_seoLayout extends CMS_pages_cmsRestrictedPage{

	var $tpl;
	var $headerTemplate;
	var $footerTemplate;
	var $entryTemplate;
    
    function CMS_layouts_seoLayout() 
    {
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template(); 	
    }
    
    function writeHeader() 
    {	
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeSubHeader() 
    {	
    	$this->bufferContent($this->subHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeFooter() 
    {
    	$this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeEntry()
    {
    } 

    function bufferContent($name, $path = '')
    {
    	
    	if ($path == null){
    		$file = TEMPLATES_PATH.$name.TEMPLATE_SUFFIX;
    	}else{
    		$file = $path."/".$name.TEMPLATE_SUFFIX;
    	}
    	if (is_file($file)){
    		$this->outputBuffer .= $this->tpl->getTemplate($file);
    	}else{
    		 _setMessage("Template " . $file . " not found!");
    		 $this->outputBuffer .= "Template " . $file . " not found! <br>";
    	}
    }
    
    function bufferString($data){
    	$this->outputBuffer .= $data;
    }
    
    function getBufferedOutput()
    {
    	return $this->outputBuffer;
    }
    
    function writeBufferedOutput($file)
    {
    	
    	$handle = fopen($file,"w");
    	if(!$handle){
    		return false;
    	}
    	if(!fwrite($handle, $this->outputBuffer)){
    		return false;
    	}
    	return true;
    }
    
    function assignValue($key, $val)
    {
    	$this->tpl->assign($key, $val);
    }   
}
?>