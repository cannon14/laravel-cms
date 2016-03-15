<?php
/**
 * 
 * ClickSuccess, L.P.
 * April 20, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */ 
class csCore_UI_formItem 
{
	var $params = array();
	
    function csCore_UI_formItem($params) 
    {
    	$this->params = $params;
    }
    
    function render()
    {
    	return '';
    }
}

class csCore_UI_formText extends csCore_UI_formItem
{
	function render()
	{
		return '<td>'.$this->params['label'] . '</td><td> <INPUT TYPE=text VALUE='._q($this->params['value']).' NAME='._q($this->params['name']).'>' ."</td>\n";
	}
}

class csCore_UI_formSelect extends csCore_UI_formItem
{
	
	function render()
	{
		$select = '<td>' . $this->params['label'] . '</td><td> <SELECT NAME='.$this->params['name'].'>' . "\n";
		if(is_array($this->params['options']))
		foreach($this->params['options'] as $value => $label){
			$sel = '';
			
			if(!isset($this->params['value'])) $this->params['value'] = '';
			if(!isset($this->params['default'])) $this->params['default'] = '';
			
			if($value == $this->params['value'] || ($this->params['value'] == '' && $value == $this->params['default'])){
				
				$sel = ' SELECTED ';
			}
			$select .= '\t<OPTION VALUE=' . $value . ' ' .$sel . '>' . $label . '</OPTION>' ."\n";
		}
		$select .= '</SELECT></td>';
		
		return $select;
	}
	
}

class csCore_UI_formCheckBox extends csCore_UI_formItem
{
	function render()
	{
		return "<INPUT TYPE=CHECKBOX NAME=" . _q($this->params['name']) . " " .
				$this->params['checked'] . " VALUE=" . _q($this->params['value']) . " " .
				" ONCLICK=" . _q($this->params['onclick']) . ">";  
	}
}

class csCore_UI_formSubmitButton extends csCore_UI_formItem
{
	function render()
	{
		if(!isset($this->params['label'])) $this->params['label'] = '';
		if(!isset($this->params['value'])) $this->params['value'] = '';
		
		return '<td>' . $this->params['label'] . '</td>
				<td> <INPUT TYPE="submit" VALUE="' . $this->params['value'] . '"/>' . "</td>\n";
	}
}

class csCore_UI_formHidden extends csCore_UI_formItem
{
	function render()
	{
		return '<INPUT TYPE="hidden" NAME="' . $this->params['name'] . '" VALUE="' . $this->params['value'] . '"/>' .  "\n";
	}
}

?>