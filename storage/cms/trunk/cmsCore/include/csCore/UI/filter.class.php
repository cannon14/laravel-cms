<?php
/**
 * 
 * ClickSuccess, L.P.
 * April 24, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */
class csCore_UI_filter {

	var $title;
	var $items = array();
	var $action;
	var $method;
	var $name;
	var $saveState;
	
    function csCore_UI_filter($saveState=true, $name='filterform', $action ='index.php', $method='GET') 
    {
    	$this->method = $method;
    	$this->action = $action;
    	$this->name = $name;
    	$this->saveState = $saveState;
    }
    
    function setTitle($title)
    {
    	$this->title = $title;
    }
    
    function getTitle()
    {
    	return $this->title;
    }
    
    function getValue($name)
    {
    	foreach($this->items as $item){
    		if($item->params['name'] == $name)
    			return $item->params['value'];
    	}
    	return '';
    }
    
    function addItem($item)
    {
    	if((!isset($_SESSION[FILTER_SESSION][$item->params['name']]) || isset($_REQUEST[$item->params['name']]))){
    		$_SESSION[FILTER_SESSION][$item->params['name']] = $item->params['value'];
    		$this->items[] = $item;
    	}else{
    		
    		$item->params['value'] = $_SESSION[FILTER_SESSION][$item->params['name']];
    		$this->items[] = $item;
    	}
 		if(isset($_REQUEST[$item->params['name']]) && $_REQUEST[$item->params['name']] == ''){
    		$_REQUEST[$item->params['name']] = $_SESSION[FILTER_SESSION][$item->params['name']];
 		}
    }
    
    function write()
    {
		$html = '<form name='._q($this->name).' action='.$this->action . ' method=' . $this->method . '>' . "\n";
		$html .= <<<HTML
<table class=dbList width=770>
	<tr>
		<td class='listHead' colspan=2>$this->title</td>
	</tr>
	<tr>
	<td width='25%'></td><td></td>
	</tr>
HTML;
		foreach($this->items as $currentInput){
			$html .= <<<HTML
	<tr>
HTML;
			$html .= $currentInput->render();
			$html .= <<<HTML
	</tr>
HTML;
		}
    	echo $html . "</table></form><bR><br>";
    }
}
?>