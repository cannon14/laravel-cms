<?PHP
/**
 * 
 * ClickSuccess, L.P.
 * March 24, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */
class csCore_UI_action
{
	var $label;
	var $action;
	var $vars = array();
	var $confirm;
	var $message;
	
	function csCore_UI_action($label, $action, $varNames, $confirm, $message = '')
	{
		$this->label = $label;
		$this->action = $action;
		$this->vars = (array)$varNames;
		$this->confirm = (bool)$confirm;
		$this->message = $message;
	}
	
	function makeArray()
	{
		return array($this->action, array($this->vars, $this->confirm));
	}
}
?>