<?php
/**
 * 
 * ClickSuccess, L.P.
 * April 12, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
 
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
class CMS_view_permissions extends CMS_pages_cmsRestrictedPage
{

    function process()
    {
    	$moduleArray = $this->_getModules();
    	$this->assignValue('modules', $moduleArray);
    	$this->addContent('set_perms');
    
    }
    
    function getModuleLabel()
    {
    	return "Permissions Module";
    }
    
    function _getModules()
    {
    	$moduleArray = array();
    	
    	$root = $GLOBALS['IncludesPath'].'/CMS/view';
    	$handle = @opendir($root);
    	while(false !== ($module = @readdir($handle))) {
    		if(@is_file($root.'/'.$module)){
    			$modName = explode(".", $module);
    			$modName = $modName[0];
    			$className = 'CMS_view_'.$modName;
    			
    			$mod = csCore_Import::instanciateObject($className);
    			if(is_subclass_of($mod, 'csCore_UI_restrictedPage')){
    				$moduleArray[] = array("filename" => $module, "classname" => $className, "modulelabel" => $mod->getModuleLabel());
    			}
    		}
    	}
    	
    	return $moduleArray;
    }
}
?>