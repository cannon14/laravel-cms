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
csCore_Import::importClass('csCore_UI_template');
class CMS_layouts_individualMerchantServiceLayout 
{

	var $tpl;
	var $headerTemplate;
	var $footerTemplate;
	var $cardTemplate;
    
    function CMS_layouts_individualMerchantServiceLayout() 
    {
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template(); 	
    }
    
    function writeHeader($page)
    {
    	$this->assignValue('rootPath', '../');
    	$this->assignValue('page', $page);
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeBody($service, $serviceData) 
    {
        $this->assignValue('merchantService', $service);
        $this->assignValue('merchantServiceData', $serviceData);
        $this->bufferContent($this->bodyTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
   
    }

    function writeFooter($service) 
    {
        $this->assignValue('page', $service);
        $this->assignValue(SITECATALYST_TEMPLATE_IDENTIFIER, $service->get(SITECATALYST_VAR_IDENTIFIER));
        
        $this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");   
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