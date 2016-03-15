<?php

class Affiliate_Merchants_Bl_Categories {
	
	
	
	function getPage($id){
		$sql = "SELECT * FROM rt_categories WHERE categoryId = " . _q($id) . " AND deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		return $rs;
	}
	function updatePage($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_categories set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where categoryId = " . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 
	}
	
	function deleteCategories($ids){
		$sql = 'UPDATE rt_categories set deleted = 1 where categoryId in ' . $ids;
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
		
		$sql = "INSERT INTO rt_categories ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = "SELECT cardpageId FROM rt_cardpages ORDER BY cardpageid DESC LIMIT 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$cardpageId = $rs->fields['cardpageId'];
		
		return $cardpageId;
		
	}
	
	function getPagesBySite($id){
		$sql = "SELECT * FROM rt_categories as c, rt_sitecategorymap as m WHERE m.siteId = " . _q($id) . " AND (c.categoryId = m.categoryId)  AND c.active = 1 AND c.deleted != 1 ORDER by m.rank ";
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
}
?>