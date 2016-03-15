<?php
/*
 * Created on Jun 29, 2006
 *
 *Click Success L.P.
 *Author: Jason Huie
 *<jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */
 
csCore_Import::importClass('CMS_libs_PageComponents');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');

class CMS_view_componentToPage extends CMS_pages_cmsRestrictedPage
{
	function process()
	{
		if($_REQUEST['committed'])
			$this->processCommit();
		$this->showPage();
	}
	
	function processCommit()
	{
		$elements = $this->_getElementArray();
		
				
		//remove stored Data
		$sql = 'DELETE FROM cs_pagecomponentmap WHERE pageid='.$_REQUEST['pageId'].' and pagetype="cardpage"';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//store data
		foreach($elements as $rank=>$item){
			$sql = 'INSERT INTO cs_pagecomponentmap (siteid, pagetype, pageid, itemid, rank) VALUES ('
					._q($_REQUEST['siteId']).', "cardpage",'._q($_REQUEST['pageId']).','._q($item).','.$rank.')';
			//echo "$sql<hr>";
			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		}		
	}
	
	function _getElementArray(){
		$elements = array();
		$elements[] = $_REQUEST['0'];
		$elements[] = $_REQUEST['1'];
		$elements[] = $_REQUEST['2'];
		$elements[] = $_REQUEST['3'];
		$elements[] = $_REQUEST['4'];
		$elements[] = $_REQUEST['5'];
		return $elements;
	}
	
	function showPage(){
		$componentDao = new CMS_libs_PageComponents();
		$rs_assigned = $componentDao->getAssignedComponentsBySiteAndPage($_REQUEST['siteId'],$_REQUEST['pageId']);
		$rs_all = $componentDao->getAllComponents();
		
		while($rs_assigned && !$rs_assigned->EOF){
			$assigned[$rs_assigned->fields['rank']]=array('name'=>$rs_assigned->fields['item'], 'render'=>$rs_assigned->fields['render']);
			$rs_assigned->MoveNext();
		}

		while($rs_all && !$rs_all->EOF){
			$all[$rs_all->fields['itemid']]=$rs_all->fields['item'];
			$rs_all->MoveNext();
		}
		
		$this->assignValue('assigned', $assigned);
		$this->assignValue('all', $all);
		$this->addContent('assigncomponents_list');	
	}
}
?>
