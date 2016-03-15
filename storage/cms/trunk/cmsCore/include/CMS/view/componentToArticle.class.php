<?php
/*
 * Created on Aug 17, 2006
 *
 *Click Success L.P.
 *Author: Jason Huie
 *<jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */
 
csCore_Import::importClass('CMS_libs_PageComponents');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_Articles');
csCore_Import::importClass('CMS_libs_Sites');

class CMS_view_componentToArticle extends CMS_pages_cmsRestrictedPage
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
		$articleList = $this->loadArticles();
		
				
		//remove stored Data
		$sql = 'DELETE FROM cs_pagecomponentmap WHERE pageid in ('.$articleList.') and pagetype="articlepage"';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//store data
		$articles = explode(',', $articleList);
		foreach($articles as $article){
			foreach($elements as $rank=>$item){
				$sql = 'INSERT INTO cs_pagecomponentmap (siteid, pagetype, pageid, itemid, rank) VALUES ('
						._q($_REQUEST['siteId']).', "articlepage",'._q($article).','._q($item).','.$rank.')';
				//echo $sql.'<hr>';
				$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			}		
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
		$rs = CMS_libs_Sites::getSite($_REQUEST['siteId']);
        $site = new site($rs->fields);
		$componentDao = new CMS_libs_PageComponents();
		$rs_articles = CMS_libs_Articles::getArticlesByCategory($_REQUEST['articlecategoryid'],$site->get('articledbhost'), $site->get('articledbun'), $site->get('articledbpw'), $site->get('articledb'), $site->get('articletableprefix'));
        $rs_assigned = array();
		if($_REQUEST['articleid'])
			$rs_assigned = $componentDao->getAssignedComponentsBySiteAndPage($_REQUEST['siteId'],$_REQUEST['articleid'], "articlepage");
		$rs_all = $componentDao->getAllComponents();
		
		$articles=array();
		while($rs_articles && !$rs_articles->EOF){
			$articles[] = $rs_articles->fields;
			$rs_articles->MoveNext();	
		}
		
		$assigned=array();
		while($rs_assigned && !$rs_assigned->EOF){
			$assigned[$rs_assigned->fields['rank']]=array('name'=>$rs_assigned->fields['item'], 'render'=>$rs_assigned->fields['render']);
			$rs_assigned->MoveNext();
		}

		$all=array();
		while($rs_all && !$rs_all->EOF){
			$all[$rs_all->fields['itemid']]=$rs_all->fields['item'];
			$rs_all->MoveNext();
		}
		
		$this->assignValue('articles', $articles);
		$this->assignValue('assigned', $assigned);
		$this->assignValue('all', $all);
		$this->addContent('assign_article_components_list');	
	}
	
	function loadArticles(){
	   $rs = CMS_libs_Sites::getSite($_REQUEST['siteId']);
       $site = new site($rs->fields);
		if($_REQUEST['applyAll']){
			$rs_articles = CMS_libs_Articles::getArticlesByCategory($_REQUEST['articlecategoryid'],$site->get('articledbhost'), $site->get('articledbun'), $site->get('articledbpw'), $site->get('articledb'), $site->get('articletableprefix'));
			$articles=array();
			while($rs_articles && !$rs_articles->EOF){
				$articles[] = $rs_articles->fields['id'];
				$rs_articles->MoveNext();	
			}
			return implode(',', $articles);
		}else{
			return ($_REQUEST['articleid']);
		}
	}
}
?>
