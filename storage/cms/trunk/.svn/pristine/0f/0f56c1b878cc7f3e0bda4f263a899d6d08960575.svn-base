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
class csCore_UI_draggable 
{
    var $id;
    var $html;
    var $class;
    
    function csCore_UI_draggable($id, $html, $class = '') 
    {
    	$this->id = $id;
    	$this->html = $html;
    	$this->class = $class;
    }
    
    function render()
    {
   		$retString = '<li id="'.$this->id.'" class="'.$this->class.'">'."\n";
   		$retString .= $this->html;
    	$retString .= '</li>'."\n";
    
    	return $retString;
    }
}

?>