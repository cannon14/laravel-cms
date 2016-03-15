<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 31, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */
csCore_Import::importClass('csCore_UI_template');
csCore_Import::importClass('CMS_libs_SortBar');
class CMS_layouts_merchantServicePageLayout 
{

	var $tpl;
	var $headerTemplate;
	var $footerTemplate;
	var $cardTemplate;
    var $applicationTemplate;
    
    function CMS_layouts_merchantServicePageLayout() 
    {
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template(); 	
    }
    
     /**
     * load information into the template for printing
     * @author Jason Huie
     * @version 1.6
     */
    function writeHeader($page, $pageNumber=0, $pagetype=".php") 
    {	
    	$this->assignValue('page', $page);
    	$this->assignValue('pageNumber', $pageNumber);
    	$this->assignValue('pagetype', $pagetype);
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
     /**
     * load information into the template for printing
     * @author Jason Huie
     * @version 1.6
     */
    function writeSubHeader($page, $pageNav='', $subPageNav='', $isPageTop='true')
    {	
    	$this->assignvalue('pageNav', $pageNav);
    	$this->assignvalue('subPageNav', $subPageNav);
    	$this->assignValue('page', $page);
    	$this->assignValue('isPageTop', $isPageTop);
    	$this->bufferContent($this->subHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
     /**
     * load information into the template for printing
     * @author Jason Huie
     * @version 1.6
     */
    function writeSubFooter($page, $pageNav, $pageNumber=0, $articles=null) 
    {
        
        $this->assignValue('page', $page, $pageNumber);
        $this->assignValue('pageNav', $pageNav);
        $this->assignValue('pageNumber', $pageNumber);
        $this->assignValue('articles', $articles);
        $this->bufferContent($this->subFooterTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
            
    }
    
     /**
     * load information into the template for printing
     * @author Jason Huie
     * @version 1.6
     */
    function writeFooter($page) 
    {
        
        $this->assignValue('page', $page);
        // added to push site catalyst variable data to the page template.  - mz 5/7/08
        $siteCatalystData = $page->get(SITECATALYST_VAR_IDENTIFIER);
        
        $this->assignValue(SITECATALYST_TEMPLATE_IDENTIFIER, $siteCatalystData);
        $this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
            
    }
    
     /**
     * load information into the template for printing
     * @author Jason Huie
     * @version 1.6
     */
    function writeMerchantService($page, $merchantService, $merchantServiceData, $merchantServiceNumber=0, $siteProp=null)
    {
    	if($merchantServiceData)
    		$this->assignValue('merchantServiceData', $merchantServiceData);
    	if($merchantService)
    		$this->assignValue('merchantService', $merchantService);
    	if($merchantServiceNumber)
    		$this->assignValue('merchantServiceNumber', $merchantServiceNumber);
    	if($page)
    		$this->assignValue('page', $page);
    	if($siteProp){
    		$this->assignValue('siteProp', $siteProp);
    	}
    	$this->bufferContent($this->cardTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");

    }

    /**
     * load information into the template for printing
     * @author Jason Huie
     * @version 1.6
     */
    function writeMerchantServiceApplication($page, $merchantService, $merchantServiceData, $merchantServiceNumber=0, $siteProp=null)
    {
    	if($merchantServiceData)
    		$this->assignValue('merchantServiceData', $merchantServiceData);
    	if($merchantService)
    		$this->assignValue('merchantService', $merchantService);
    	if($merchantServiceNumber)
    		$this->assignValue('merchantServiceNumber', $merchantServiceNumber);
    	if($page)
    		$this->assignValue('page', $page);
    	if($siteProp){
    		$this->assignValue('siteProp', $siteProp);
    	}
    	$this->bufferContent($this->applicationTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");

    }

     /**
     * buffer content for future writing
     * @author Jason Huie
     * @version 1.6
     */
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
    
     /**
     * return the buffer content
     * @author Jason Huie
     * @version 1.6
     * @return bufferedContent buffered page
     */
    function getBufferedOutput()
    {
    	return $this->outputBuffer;
    }
    
     /**
     * write the buffer content to a file
     * @author Jason Huie
     * @version 1.6
     * @return boolean successful
     */
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
    
	 /**
     * load a single value into the template
     * @author Jason Huie
     * @version 1.6
     */
    function assignValue($key, $val)
    {
    	$this->tpl->assign($key, $val);
    }   
}
?>