<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 15, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */

csCore_Import::importClass('csCore_UI_template');
csCore_Import::importClass('csCore_Authentication_authentication');
csCore_Import::importClass('CMS_libs_settings');
csCore_import::importClass('csCore_Messaging_messager');

class csCore_UI_page 
{
	
	var $tpl;
	var $outputBuffer;
	var $defaultTemplate;
	var $auth;
	
    function __construct()
    {
    	if(!headers_sent()){
    		header("Content-Encoding: iso-8859-1");
    	}
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template();
    	$this->initPage();
    	//session_start();
    	
    	$this->auth = csCore_import::instanciateSingleton('csCore_Authentication_authentication');
   		$this->settings = csCore_import::instanciateSingleton('CMS_libs_settings');
		$this->messager = csCore_import::instanciateSingleton('csCore_Messaging_messager');
    }
    
    function classDefinitions()
    {
    	
    }
    
    function initPage() 
    {
    	if(isset($_REQUEST['mailConsole']) && $_REQUEST['mailConsole'] == 1){
    		_sendDebug();
    	}   
    }
    
    function setDefaultTemplate($template)
    {
    	$this->defaultTemplate = $template;
    }
    
    function checkPermissions()
    {
    	return true;
    }
    
    function checkLogged($modName)
    {
    	return true;
    }
    
    function process()
    {
    	$this->addContent($this->defaultTemplate);
    }
    
    function addContent($name, $path = '')
    {
    	
    	if ($path == null){
    		$file = TEMPLATES_PATH.$name.TEMPLATE_SUFFIX;
    	}else{
    		$file = $path."/".$name.TEMPLATE_SUFFIX;
    	}
    	
    	if (is_file($file)){
    		
    		$this->tpl->display($file);
    	}else{
    		echo "Template " . $file . " not found! <br>";
    	}
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
    		 $this->outputBuffer .= "Template " . $file . " not found! <br>";
    	}
    }
    
    function getBufferedOutput()
    {
    	return $this->outputBuffer;
    }
    
    function writeBufferedOutput($file)
    {
    	
    	$handle = @fopen($file,"w");
    	if(!$handle){
    		return false;
    	}
    	if(!@fwrite($handle, $this->outputBuffer)){
    		fclose($handle);
    		return false;
    	}
    	
    	return fclose($handle);
    }    
    
    function assignValue($key, $val)
    {
    	$this->tpl->assign($key, $val);
    }
    
    function redirect($request, $time=0)
    {
    	
    	csCore_UI_page::timeRedirectNomsg($request, $time);
    }
    
    function timeRedirectNomsg($request, $time = 0)
    {
      
      echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time;URL=index.php?mod=$request\">";
    }    
    
    function drawHeader()
    {
    	
    }
    
    function drawFooter()
    {
    	
    }
}