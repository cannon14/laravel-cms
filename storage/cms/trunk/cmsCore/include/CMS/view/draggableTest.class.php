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
 * @package CMS_View
 */

csCore_Import::importClass('CMS_pages_cmsDraggableList');
csCore_Import::importClass('csCore_UI_draggable');
 
class CMS_view_draggableTest extends CMS_pages_cmsDraggableList
{
	
	function process()
	{
		$this->addElement(new csCore_UI_draggable(1, $this->_drawObject(array('name' => 'Patrick', 'id' => 1))));
		$this->addElement(new csCore_UI_draggable(2, $this->_drawObject(array('name' => 'Jason', 'id' => 2))));		
		
		$this->showData();
	}
	
	function _drawObject($params)
	{
		return '<table width=30 border=1>
				<tr>
				<td>Name:</td><td>'.$params['name'].'</td>
				</tr>
				<tr>
				<td>ID</td><td>'.$params['id'].'</td>
				</tr>
				</table>';
	}

}
?>