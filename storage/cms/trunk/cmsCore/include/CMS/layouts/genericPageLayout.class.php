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

class CMS_layouts_genericPageLayout{

	var $tpl;
	var $headerTemplate;
	var $footerTemplate;
	var $contentTemplate;
    
    function CMS_layouts_genericPageLayout() 
    {
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template(); 	
    }
    
    function writeHeader($page, $rootPath='./') 
    {	
    	$this->assignValue('rootPath', $rootPath);
    	$this->assignValue('page', $page);
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeSubHeader($template, $input) 
    {
    	$this->assignValue('input', $input);
    	$this->bufferContent($template, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeSubFooter($template) 
    {
        $this->bufferContent($template, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeFooter($page) 
    {
        $this->assignValue('page', $page);
    	$this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeFooterWithSiteCatalystData($page, $siteCatalystData) 
    {
      if(!is_array($siteCatalystData))
      {
         trigger_error('Invalid type for param siteCatalystData', E_USER_ERROR);
      }
      
      $this->assignValue('page', $page);
      $this->assignValue(SITECATALYST_TEMPLATE_IDENTIFIER, $siteCatalystData);
      $this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeBody($template, $input)
    {
    	$this->assignValue('input', $input);
    	$this->bufferContent($template, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    } 
    
    /** 
     * @author mz
     * @desc   Writes content to a page w/out referencing the TEMPLATES_PATH or TEMPLATE_SUFFIX
     * @date   1/15/07
     * */
    function writeContentToBody($content, $input)
    {
      $this->assignValue('input', $input);
      $this->bufferNonTemplateContent($content);
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
    
    /**
     * @author mz
     * @date   1/16/08
     * @desc   Derived from bufferContent, except this doesn't validate
     *         that $content is a template file.
     **/
    function bufferNonTemplateContent($content)
    { 
      $this->outputBuffer .= trim($content);      
    }    
    
    function getBufferedOutput()
    {
    	return $this->outputBuffer;
    }
    
    function writeBufferedOutput($file)
    {
    	
    	$handle = fopen($file,"w+");
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