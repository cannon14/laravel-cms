<?php

class Affiliate_Merchants_Bl_Sites {
	
	function getSite($id){
		$sql = "SELECT * FROM rt_sites WHERE siteId = " . _q($id) . " AND deleted != 1";
	
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		return $rs;
	}
	
	function getAllSites(){
		$siteArray = array();
		$sql = "SELECT * FROM rt_sites WHERE deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		while(!$rs->EOF){
			$siteArray[] = $rs;
			$rs->MoveNext();
		}
		
		return $siteArray;
	}
	
	function deleteSites($ids){
		$sql = 'UPDATE rt_sites set deleted = 1, rt_sites.order=0 where siteId in ' . $ids;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	}
	
	function updateSite($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_sites set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where siteId = " . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function addSite($params){

		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_sites ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
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
	
}
?>