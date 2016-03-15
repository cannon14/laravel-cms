<?php

/**
 * 
 * ClickSuccess, L.P.
 * June 28, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */

csCore_Import::importClass('CMS_pages_cmsDraggableList');
csCore_Import::importClass('csCore_UI_draggable');
csCore_Import::importClass('CMS_libs_PageComponents');
csCore_Import::importClass('csCore_UI_SLLists');
 
class CMS_view_contentToPage extends CMS_pages_cmsDraggableList
{
	
	function process()
	{
		if($_REQUEST['action'] != ''){
			switch($_REQUEST['action']){
				case 'add':
					if($this->processAdd($_REQUEST['itemid'], $_REQUEST['pageid']))
						return;
					break;
				case 'remove':
					if($this->processRemove($_REQUEST['mapid']))
						return;
					break;
			}
		}
		else if($_REQUEST['draggableListsSubmitted'])
			$this->processReorder();
		
		$this->_showAddBar($_REQUEST['pageId']);
		$this->showData();
	}
	
	function processAdd(){
		$componentDao = new CMS_libs_PageComponents();
		$count = $componentDao->getNumberOfCompontentsByPage($_REQUEST['pageId']);
		$componentDao->insertAssociation($_REQUEST['siteId'], $_REQUEST['pageId'], $_REQUEST['add'], $count->fields['count(*)']++);
		return;
	}
	
	function processRemove(){
		$componentDao = new CMS_libs_PageComponents();
		$componentDao->deleteAssociation($_REQUEST['siteId'], $_REQUEST['pageId'], $_REQUEST['itemId']);	
	}
	
	function processReorder(){
		$counter = 0;
		$sql = 'SELECT * FROM cs_pagecomponentmap WHERE pageid='.$_REQUEST['pageId'];
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		while($rs && !$rs->EOF){
			$sqlArray[$rs->fields['mapid']] = 'INSERT INTO cs_pagecomponentmap (mapid, siteid, pageid, itemid, rank) VALUES ('.$rs->fields['mapid'].','.$rs->fields['siteid'].','.$rs->fields['pageid'].','.$rs->fields['itemid'].',';
			$rs->MoveNext();
		}
		$sql = 'DELETE FROM cs_pagecomponentmap WHERE pageid='.$_REQUEST['pageId'];
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$newOrder = csCore_UI_SLLists::getOrderArray($_REQUEST['draggableListOrder'], 'draggableList');
		foreach($newOrder as $item)
		{			
			$sql = $sqlArray[$item['element']].$item['order'].')';
			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		}
		
	}
	
	function _addElements($elements)
	{
		while($elements && !$elements->EOF){
			$this->addElement(new csCore_UI_draggable('item_'.$elements->fields['mapid'], $this->_drawObject(array('name' => $elements->fields['item'], 'rank' => $elements->fields['rank'], 'render' => $elements->fields['render'], 'id' => $elements->fields['itemid'])),"sortableList"));
			$elements->MoveNext();
		}
			return;
	}		
	
	function _drawObject($params)
	{
		return '<table cellspacing=0 cellpadding=0 width=600>
				<tr><td>
				<table style="border-width:3px;border-style:solid;border-color:#cccccc;">
				<tr>
				<td>
				<b><a href="index.php?mod='.$_REQUEST['mod'].'' .
						'&action=remove' .
						'&siteId='	.	$_REQUEST['siteId'] .
						'&pageId='	.	$_REQUEST['pageId']	.	
						'&itemId='	.	$params['id'].'">Remove</a>
				</td>
				</tr>
				</table>
				</tr></td>		
				<tr><td>		
				<table width=600 style="border-width:3px;border-style:solid;border-color:#cccccc;">
				<tr>
				<td width=20%>Name:</td><td>'.$params['name'].'</td>
				</tr>
				<tr>
				<td width=20%>ID:</td><td>'.$params['id'].'</td>
				</tr>
				<tr>
				<td width=20%>Render:</td><td>'.htmlentities(stripslashes($params['render'])).'</td>
				</tr>
				</table></td></tr></table><br>';
	}
	
	function _showAddBar($pageid)
	{
		$componentDao = new CMS_libs_PageComponents();
		$this->assignValue('siteId', $_REQUEST['siteId']);
		$this->assignValue('pageId', $_REQUEST['pageId']);
		$this->assignValue('rs_unassigned', $componentDao->getUnassignedComponentsBySiteAndPage($_REQUEST['siteId'], $_REQUEST['pageId']));
		$this->addContent('component_order_addbar');
		
		$elements = $componentDao->getAssignedComponentsBySiteAndPage($_REQUEST['siteId'], $_REQUEST['pageId']);
		$this->_addElements($elements);
		return;
	}

}
?>
