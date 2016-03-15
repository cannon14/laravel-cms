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
 * This class instanciates view modules on the fly.
 * 
 */
 

class csCore_UI_uiEngine 
{

	var $defaultTpl;
	var $defaultMod;
	
    function csCore_UI_uiEngine() 
    {
		
    }
    
    function setDefaultTemplate($tpl)
    {
    	$this->defaultTpl = $tpl;
    }
    
    function setDefaultModule($mod)
    {
    	$this->defaultMod = $mod;
    }    
    
    function processModule($moduleName, $embed=false) 
    {

        if(!strlen($moduleName)) {
            $moduleName = $this->defaultMod;
        }
        
        if($moduleName != '') {
            if(is_object($moduleObj =& csCore_Import::instanciateObject($moduleName)))
            {
              $moduleObj->setDefaultTemplate($this->defaultTpl);
              
              if(!$moduleObj->checkLogged($moduleName)){
              	$moduleObj =& csCore_Import::instanciateObject(NOT_LOGGED);
              	if(!$embed) $moduleObj->drawHeader();
              	$moduleObj->process();
              	if(!$embed) $moduleObj->drawFooter();

              	return false;
              }              
              
              if(!$moduleObj->checkPermissions()){
              	$moduleObj =& csCore_Import::instanciateObject($this->defaultMod);
              	if(!$embed) $moduleObj->drawHeader();
              	_userAttention("You do not have permission to access this module.");
              	$moduleObj->process();
              	if(!$embed) $moduleObj->drawFooter();

              	return false;
              }
              
              if(!$embed) $moduleObj->drawHeader();
              $moduleObj->process();
              if(!$embed) $moduleObj->drawFooter();
  
              return true;
              
            } else {
            	echo " ";
            	
            	csCore_Import::importClass($this->defaultMod);
            	_setMessage($moduleName . ' Does not exist.', true);
            	$moduleObj =& csCore_Import::instanciateObject($this->defaultMod);    	
                if(!$embed) $moduleObj->drawHeader();
              	$moduleObj->process();
              	if(!$embed) $moduleObj->drawFooter();

                return false;
            }
        } else {
            _setMessage('No module selected!', true);

            return false;
        }
    }
}
?>