<?php

// Patrick J. Mizer
// Rapido Technologies
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');

class Affiliate_Merchants_Bl_ChangeLog {

	var $log_table;
	var $username;
	var $transid;
	var $updates;
	var $filename;
    
    function Affiliate_Merchants_Bl_ChangeLog($transid, $filename = null){
    	$this->log_table = "trans_edit_log";
    	$this->username = $GLOBALS['Auth']->userName;
    	$this->transid = $transid;
    	$this->updates = array();
    	$this->filename = $filename;

    }
    
    function add_update($update = array()){

    	$this->updates[] = $update;
    }
    
    function commit_updates(){
    	$affiliateid = Affiliate_Merchants_Bl_Transactions::get_affiliate_id($this->transid);
    	foreach($this->updates as $change)
    		$this->_update_log($change, $affiliateid);
    	$this->updates = array();
    }
    
    function _update_log($change = array(), $affiliateid){
    	if(!is_array($change)){
    		return false;
    	}
    	$params = array("transid" => $this->transid,
    					"user" => $this->username);
    	$params = $change + $params;
    	$params[] = date("Y-m-d H:i:s");
    	$params[] = $affiliateid;
    	$values = "('" . implode("', '", $params) . "')";
    	$sql = "INSERT INTO " . $this->log_table . " (action, previous_value, new_value, transid, user, date, affiliateid) VALUES " . $values;
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	//echo $sql;
    	return true;
    }
    
    //temporary
	function print_log(){
		$sql = "SELECT * FROM " . $this->log_table . " ORDER BY date DESC";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		$result;
		while(!$rs->EOF){
			$result .= "<tr>";
			$result .= "<td>" . $rs->fields['date'] . "</td><td>" . $rs->fields['transid'] . "</td><td>" . $rs->fields['action'] . "</td><td>" . $rs->fields['previous_value'] . "</td><td>" . $rs->fields['new_value'] ."</td><td>" . $rs->fields['user'];
			$result .= "</tr>";
			$rs->MoveNext();
		}
		return $result;
	}
	
	function purge_log(){
		$sql = "DELETE FROM " . $this->log_table;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if(!$rs)
			return false;
		return true;
	}
}
?>