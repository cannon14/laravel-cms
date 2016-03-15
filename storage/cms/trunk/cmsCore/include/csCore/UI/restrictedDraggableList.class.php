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
 */

csCore_Import::importClass('csCore_UI_restrictedPage');

class csCore_UI_restrictedDraggableList extends csCore_UI_restrictedPage {
	
	var $elements = array();
	var $id;
	var $class;
	
	function addElement($element)
	{
		if(is_a($element, 'csCore_UI_draggable') || is_subclass_of($element, 'csCore_UI_draggable')){
			$this->elements[] = $element;		
		}else{
			return false;	
		}
	}
	
	function getSize()
	{
		return count($this->elements);	
	}
	
	function showData()
	{
		$this->assignValue('draggable', $this);
		$this->addContent('dragSort', GLOBAL_TEMPLATES);	
	}
	

	
	function render()
	{
		$retString = '<ul id="draggableList" class="'.$this->class.'">';
		
		foreach($this->elements as $element){
			$retString .= $element->render();
		}
				
		$retString .= '</ul>';
		
		return  $retString;
	}
}
?>