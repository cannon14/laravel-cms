<?php

class Affiliate_Merchants_Bl_Cards {
	
	var $property;
	
	function getUnusedVersions($cardId){
		//$sql = "SELECT c.* FROM rt_cardpages as c, rt_cardpagemap as m WHERE (c.cardpageId = m.cardpageId) AND m.cardpageId != " . _q($cardId) . " AND c.deleted != 1 GROUP BY c.cardpageId ORDER BY c.pageName ASC ";
		//echo $sql;
		//$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$sql = "SELECT cardDetailVersion as siteId FROM rt_carddetails WHERE cardId = " ._q($cardId);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		while(!$rs->EOF){
			$idArray[] = $rs->fields['pageId'];
			$rs->MoveNext();	
		}
		if(is_array($idArray))
			$sqlIds =  "('". implode("','", $idArray) . "')";
		else 
			$sqlIds = "('')";
		$sql = "SELECT * FROM rt_sites WHERE siteId NOT IN " . $sqlIds . " AND deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs;
	}
	
	
	
	function activate($value, $id){
		$sql = "UPDATE rt_cards set active = " . _q($value) . " where id=" . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function getCard($id){
		$sql = "SELECT * FROM rt_cards WHERE id = " . _q($id) . " AND deleted != 1";
		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		return $rs;
	}
	
	function getVersion($id){
		$sql = "SELECT * FROM rt_carddetails WHERE id = " . _q($id) . " AND deleted != 1";		
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return $rs;
	}
	
	function getDefaultVersion($cardpageId){
		$sql = "SELECT * FROM rt_cards as c, rt_carddetails as d WHERE c.cardId = d.cardId AND c.id = " . _q($cardpageId) . " AND d.cardDetailVersion = -1";
		//echo $sql;
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function getAllCards(){
		$siteArray = array();
		$sql = "SELECT * FROM rt_cards WHERE deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		while(!$rs->EOF){
			$siteArray[] = $rs;
			$rs->MoveNext();
		}
		
		return $siteArray;
	}
	
	function deleteCards($ids){
		$sql = 'UPDATE rt_cards set deleted = 1 where id in ' . $ids;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
	}
	
	function updateCard($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_cards set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where id = " . _q($id);
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function updateVersion($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_carddetails set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where id = " . _q($id);
		//echo $sql;
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function addCard($params){

		$sql = "SELECT id FROM rt_cards WHERE id = " . _q($params['cardId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if($rs->fields['id'] == $params['cardId'] && $params['subCat'] != 1){
			QUnit_Messager::setErrorMessage("The ID " . $params['cardId'] . " already exists.");
			return;
		}
		
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_cards ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$sql = "SELECT id FROM rt_cards ORDER BY id DESC LIMIT 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		$cardId = $rs->fields['id'];
		
		$sql = "UPDATE rt_cards SET cardId = " . _q($cardId) . " WHERE id = " . _q($cardId);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		return $cardId;
	}
	
	function addVersion($params){
		$sql = "SELECT id FROM rt_carddetails WHERE cardId = " . _q($params['cardId']) . " AND cardDetailVersion = " . _q($params['cardDetailVersion']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if($rs->fields['cardId'] == $params['cardId'] ){
			QUnit_Messager::setErrorMessage("The ID " . $params['cardId'] . " already exists, can not instanciate version.");
			return;
		}
		
		
		$sql = "SELECT siteName FROM rt_sites WHERE siteId = " . _q($params['cardDetailVersion']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$params['cardDetailLabel'] = $rs->fields['siteName'];
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_carddetails ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	function addDefaultVersion($cardId, $params){
		$sql = "SELECT cardId FROM rt_carddetails WHERE cardId = " . _q($cardId) . " AND cardDetailVersion = -1";
		echo $sql . "<br><br>";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if($rs->fields['cardId'] == $cardId){
			QUnit_Messager::setErrorMessage("The ID " . $params['cardId'] . " already exists, can not instanciate version.");
			return;
		}
		
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_carddetails ( " . $sqlCols . ", dateCreated, dateUpdated, cardDetailVersion, cardDetailLabel, cardId) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ", '-1', 'Default', " . _q($cardId) . ")";
		
		//echo $sql;
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
	
	function getCardsByPage($pageId, $siteId){
		
		//Nasty logic to find correct card without SQL nested selects.		
		
		// first we get ids of this site's page versions
		$sql = "SELECT *
				FROM rt_cards as c, rt_cardpagemap as m, rt_carddetails as d
				WHERE d.deleted != '1' 
				AND (d.cardId = c.cardid) 
				AND (d.cardDetailVersion = "._q($siteId).") 
				AND m.cardpageId = "._q($pageId)." 
				AND (c.cardId = m.cardId) 
				AND c.active = '1' 
				AND c.deleted != '1' ORDER BY m.rank ASC";
		//QUnit_Messager::setErrorMessage($sql);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//echo "<b>" . $sql ."</b><br><br>";
		while(!$rs->EOF){
			$version[] = $rs->fields['id'];	
			$alreadyUsedCards[] = $rs->fields['cardId'];
			$rs->MoveNext();
		}
		
		if(is_array($alreadyUsedCards))
			$sqlVersion = "('" . implode("','", $alreadyUsedCards ) . "')";
		else
			$sqlVersion = "('')";
		
		$sql = "SELECT * FROM rt_cards as c, rt_cardpagemap as m, rt_carddetails as d 
				WHERE d.deleted != 1 
				AND (d.cardId = c.cardId) 
				AND m.cardpageId = "._q($pageId)." 
				AND (c.cardId = m.cardId) 
				AND (d.cardDetailVersion = -1) 
				AND c.cardId NOT IN " . $sqlVersion . "
				AND c.active = 1 
				AND c.deleted != 1 
				GROUP BY c.cardId
				ORDER BY m.rank ASC";
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
		$sql = "SELECT * FROM rt_cards as c, rt_cardpagemap as m, rt_carddetails as d
				WHERE d.deleted != 1
				AND (d.cardId = c.cardId) 
				AND (m.cardId = c.cardId) 
				AND (m.cardpageId = "._q($pageId).")
				AND d.id in " . $sqlIds . " GROUP BY c.cardId ORDER BY m.rank ASC";
		
		//echo $sql ."<br><br>";
		QUnit_Messager::setErrorMessage($sql);
		return QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
}
?>