<?php

class Affiliate_Merchants_Bl_Articles {
	
	var $property;
	
	function activate($value, $id){
		$sql = "UPDATE rt_articles set active = " . _q($value) . " where id=" . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function getArticle($id){
		$sql = "SELECT * FROM rt_articles WHERE articleId = " . _q($id) . " AND deleted != 1";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		return $rs;
	}
	
	function getAllArticles(){
		$siteArray = array();
		$sql = "SELECT * FROM rt_articles WHERE deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		while(!$rs->EOF){
			$siteArray[] = $rs;
			$rs->MoveNext();
		}
		
		return $siteArray;
	}
	
	function deleteArticle($ids){
		$sql = 'UPDATE rt_articles set deleted = 1 where articleId in ' . $ids;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	}
	
	function updateArticle($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_articles set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where articleId = " . _q($id);
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function addArticle($params){

		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_articles ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	/**
	function reOrder(){
		$sql = "SELECT * FROM rt_sites WHERE deleted != 1 ORDER BY rt_sites.order";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$count = 1;
		while(!$rs->EOF){
			$sql = "UPDATE rt_sites set rt_sites.order= " ._q($count) . " WHERE siteId =" ._q($rs->fields['siteId']);
			QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			$count ++;
			$rs->MoveNext();
		}
	}
	**/
	
	function getArticlesByPage($pageId, $siteId){
		
		$sql = "SELECT c.* FROM rt_articles as c, rt_articlepagemap as m WHERE (c.articleId = m.articleId) AND m.cardpageId = " . _q($pageId) . " AND c.deleted != 1 AND c.active = 1 GROUP BY c.articleId ORDER BY m.rank ASC";
		//echo "<br>" . $sql . "<br>";
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
}
?>