<?php



class Affiliate_Merchants_Bl_MapAccess {

	var $log;
	var $mapping_table;
	
	function Affiliate_Merchants_Bl_MapAccess(){
		$this->mapping_table = "custom_mapping";
	}
	
	function print_log(){ echo $this->log . "<br>"; }
	
	function select_all_mappings(){
		$sql = "SELECT distinct mapid FROM " . $this->mapping_table;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$result = array();
		$i = 0;
		while(!$rs->EOF){
			$result[$i] = $rs->fields['mapid'];
			$this->log .= "[select_all_mappngs] =: " . $rs->fields['mapid'] . " <br>";
			$rs->MoveNext();
			++ $i;
		}
		return $result;
	}
	
	function create_custom_map_from_array($mapid, $mapping){
		$mapid = strtolower($mapid);
		$sql = "SELECT * FROM " . $this->mapping_table . " WHERE mapid = '" . $mapid ."'";	
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$this->log .= "[create_custom_map] =: " . $sql . "<br>";
		if($rs->fields['mapid'] == $mapid){
			$this->log .= "[create_custom_map] =: mapid " . $mapid . " already exists.<br>";
			return null;	
		}
		for($i = 0; $i < count($mapping); ++ $i){
			if($mapping[$i] != null){
				$sql = "INSERT INTO " . $this->mapping_table . " (mapid, maporder, col) VALUES ('". $mapid ."','" . $i . "','". $mapping[$i] ."')";
				$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
				$this->log .= "[create_custom_map] =: " . $sql . "<br>";
			}
		}
		$this->log .= "[create_custom_map] =: " . $mapid . " succesffully created. <br>";
		return new Affiliate_Merchants_Bl_MapModel($mapping, $mapid);
	}
	
	function get_custom_map($mapid){
		$mapid = strtolower($mapid);
		$sql = "SELECT * FROM " . $this->mapping_table . " WHERE mapid = '" . $mapid . "' ORDER BY maporder ASC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$this->log .= "[get_custom_map] =: " . $sql . "<br>";
		
		if($rs->fields['mapid'] != $mapid){
			$this->log .= "[get_custom_map] =: mapid " . $mapid . " doesn't exist.<br>";
			return null;	
		}
		$mapping = array();
		while(!$rs->EOF){
			
			$maporder = $rs->fields['maporder'];
			$col = $rs->fields['col'];
			$mapping[$maporder] = $col;
			$this->log .= "[get_custom_map] =: " . $maporder . " " . $col . "<br>";
			$rs->MoveNext();
		}
		$this->log .= "[create_custom_map] =: " . $mapid . " succesfully fetched. <br>";
		$newMapping = new Affiliate_Merchants_Bl_MapModel($mapping, $mapid);
		return $newMapping;
	}	
	
	function delete_custom_map($mapid){
		$sql = "DELETE FROM " .  $this->mapping_table . " WHERE mapid = " . _q($mapid);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
	}
}
?>