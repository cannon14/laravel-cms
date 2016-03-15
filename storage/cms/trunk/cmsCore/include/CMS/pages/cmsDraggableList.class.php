<?php
/**
 * 
 * ClickSuccess, L.P.
 * June 28, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Pages
 */  

csCore_Import::importClass('csCore_UI_restrictedDraggableList');

class CMS_pages_cmsDraggableList extends csCore_UI_restrictedDraggableList
{	
	
	function drawHeader()
	{
		$this->addContent('header',GLOBAL_TEMPLATES);
	}
	
	function drawFooter()
	{
		if(in_array('console', $this->auth->getPermissions()))
			$this->addContent('floatingconsole',GLOBAL_TEMPLATES);
		$this->addContent('footer',GLOBAL_TEMPLATES);
	}	
		
}
?>