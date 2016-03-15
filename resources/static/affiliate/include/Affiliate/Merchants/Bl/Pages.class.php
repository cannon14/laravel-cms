<?php

class Affiliate_Merchants_Bl_Pages {
	
	function getPage($id, $version){
		$sql = "SELECT * FROM rt_cardpages as p, rt_pagedetails as d WHERE (d.deleted != 1 AND p.deleted != 1) AND (d.cardpageId = p.cardpageId) AND d.pageDetailversion = " . _q($version) . " AND p.cardpageId = " . _q($id);
		//echo "<b>" . $sql . "<b/>"; 
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		return $rs;
	}
	function updatePage($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_cardpages set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where cardpageId = " . _q($id);
		echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 
	}
	
	function deletePages($ids){
		$sql = 'UPDATE rt_cardpages set deleted = 1 where cardpageId in ' . $ids;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	}	
	
	function addPage($params){

		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_cardpages ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = "SELECT cardpageId FROM rt_cardpages ORDER BY cardpageid DESC LIMIT 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$cardpageId = $rs->fields['cardpageId'];
		
		return $cardpageId;
		
	}
	
	function addArticlePage($params){

		$params['type'] = 1;
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_cardpages ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = "SELECT cardpageId FROM rt_cardpages ORDER BY cardpageid DESC LIMIT 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$cardpageId = $rs->fields['cardpageId'];
		
		return $cardpageId;
		
	}
	
	function addVersion($params){
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_pagedetails ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function updateVersion($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_pagedetails set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where cardpageId = " . _q($id) . " AND pageDetailVersion = " . _q($params['pageDetailVersion']);
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 
	}
	
	function getPagesByCategory($shortName, $siteId, $type){
		$sql = "SELECT categoryId FROM rt_categories WHERE type = "._q($type)." AND shortName = " . _q($shortName);
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo $sql . "<br>";
		$categoryId = $rs->fields['categoryId'];
		//$sql = "SELECT * FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d, rt_categories as cat WHERE d.deleted != 1 AND (d.cardpageId = c.cardpageid)  AND m.categoryId = " . _q($rs->fields['categoryId']) . " AND (c.cardpageId = m.cardpageId) AND (d.pageDetailVersion = -1 OR d.pageDetailVersion = " ._q($siteId) . ") AND c.active = 1 AND c.deleted != 1 GROUP by d.cardpageId ORDER by d.pageDetailVersion DESC, m.rank ASC";

		
		// first we get ids of this site's page versions
		$sql = "SELECT *
				FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d
				WHERE d.deleted != '1' AND c.type = "._q($type)."
				AND (d.cardpageId = c.cardpageid) 
				AND (d.pageDetailVersion = "._q($siteId).") 
				AND m.categoryId = "._q($categoryId)." 
				AND (c.cardpageId = m.cardpageId) 
				AND c.active = '1' 
				AND c.deleted != '1'";
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo "<b>" . $sql ."</b><br><br>";
		while(!$rs->EOF){
			$version[] = $rs->fields['id'];	
			$alreadyUsedCardpages[] = $rs->fields['cardpageId'];
			$rs->MoveNext();
		}
		
		if(is_array($alreadyUsedCardpages))
			$sqlVersion = "('" . implode("','", $alreadyUsedCardpages ) . "')";
		else
			$sqlVersion = "('')";
		
		$sql = "SELECT * FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d 
				WHERE d.deleted != 1 AND c.type = "._q($type)."
				AND (d.cardpageId = c.cardpageid) 
				AND m.categoryId = "._q($categoryId)." 
				AND (c.cardpageId = m.cardpageId) 
				AND (d.pageDetailVersion = -1) 
				AND c.cardpageId NOT IN " . $sqlVersion . "
				AND c.active = 1 
				AND c.deleted != 1 
				GROUP BY c.cardpageId
				ORDER BY m.rank ASC, d.pageDetailVersion";
		//echo $sql . "<br><br>";
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
		
		while(!$rs->EOF){
			$default[] = $rs->fields['id'];	
			$rs->MoveNext();
		}
		
		$combArray = array_merge($default, $version);
		
		if(is_array($combArray))
			$sqlIds = "('" . implode("','", $combArray) . "')";
		else
			$sqlIds = "('')";
		$sql = "SELECT * FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d
				WHERE d.deleted != 1 AND c.type = "._q($type)."
				AND (d.cardpageId = c.cardpageid) 
				AND (m.cardpageId = c.cardpageId) 
				AND d.id in " . $sqlIds . " GROUP BY c.cardpageId ORDER BY m.rank ASC";
		
		//echo $sql ."<br><br>";
		//QUnit_Messager::setErrorMessage($sql);
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}

	function getArticlePagesByCategory($shortName, $siteId, $type){
		
		//Nasty logic to find correct page without SQL nested selects.		
		
		$sql = "SELECT categoryId FROM rt_categories WHERE type = "._q($type)." AND shortName = " . _q($shortName);
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo $sql . "<br>";
		$categoryId = $rs->fields['categoryId'];
		//$sql = "SELECT * FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d, rt_categories as cat WHERE d.deleted != 1 AND (d.cardpageId = c.cardpageid)  AND m.categoryId = " . _q($rs->fields['categoryId']) . " AND (c.cardpageId = m.cardpageId) AND (d.pageDetailVersion = -1 OR d.pageDetailVersion = " ._q($siteId) . ") AND c.active = 1 AND c.deleted != 1 GROUP by d.cardpageId ORDER by d.pageDetailVersion DESC, m.rank ASC";

		
		// first we get ids of this site's page versions
		$sql = "SELECT *
				FROM rt_cardpages as c, rt_articlepagecategorymap as m, rt_pagedetails as d
				WHERE d.deleted != '1' AND c.type = "._q($type)."
				AND (d.cardpageId = c.cardpageid) 
				AND (d.pageDetailVersion = 2) 
				AND m.categoryId = "._q($categoryId)." 
				AND (c.cardpageId = m.cardpageId) 
				AND c.active = '1' 
				AND c.deleted != '1'";
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo "<b>" . $sql ."</b><br><br>";
		while(!$rs->EOF){
			$version[] = $rs->fields['id'];	
			$alreadyUsedCardpages[] = $rs->fields['cardpageId'];
			$rs->MoveNext();
		}
		
		if(is_array($alreadyUsedCardpages))
			$sqlVersion = "('" . implode("','", $alreadyUsedCardpages ) . "')";
		else
			$sqlVersion = "('')";
		
		$sql = "SELECT * FROM rt_cardpages as c, rt_articlepagecategorymap as m, rt_pagedetails as d 
				WHERE d.deleted != 1 AND c.type = "._q($type)."
				AND (d.cardpageId = c.cardpageid) 
				AND m.categoryId = "._q($categoryId)." 
				AND (c.cardpageId = m.cardpageId) 
				AND (d.pageDetailVersion = -1) 
				AND c.cardpageId NOT IN " . $sqlVersion . "
				AND c.active = 1 
				AND c.deleted != 1 
				GROUP BY c.cardpageId
				ORDER BY m.rank ASC, d.pageDetailVersion";
		//echo $sql . "<br><br>";
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);		
		
		while(!$rs->EOF){
			$default[] = $rs->fields['id'];	
			$rs->MoveNext();
		}
		
		$combArray = array_merge($default, $version);
		
		if(is_array($combArray))
			$sqlIds = "('" . implode("','", $combArray) . "')";
		else
			$sqlIds = "('')";
		$sql = "SELECT * FROM rt_cardpages as c, rt_articlepagecategorymap as m, rt_pagedetails as d
				WHERE d.deleted != 1 AND c.type = "._q($type)."
				AND (d.cardpageId = c.cardpageid) 
				AND (m.cardpageId = c.cardpageId) 
				AND d.id in " . $sqlIds . " GROUP BY c.cardpageId ORDER BY m.rank ASC";
		
		//echo $sql ."<br><br>";
		//QUnit_Messager::setErrorMessage($sql);
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}	
	
    function getSiteLabel($siteId){
    	$sql = "SELECT siteTitle FROM rt_sites WHERE siteId = " . _q($siteId);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 
    	return $rs->fields['siteTitle'];	
    }
    
    function getUnusedVersions($cardpageId){
    	$sql = "SELECT * FROM rt_sites as s, rt_pagedetails as d WHERE  (d.cardpageId != " . _q($cardpageId). ") AND s.deleted != 1 GROUP by s.siteName";
    	//echo $sql;
    	return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    }
}
?>