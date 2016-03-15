<?php
/**
 * 
 * CreditCards.com
 * 3/15/2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */
class CMS_libs_Versions {
	
	function getVersion($id){
		$sql = "SELECT * FROM versions " .
				"WHERE (deleted != 1) " .
				"AND (version_id = " . _q($id) . ")";
		//echo "<b>" . $sql . "<b/><br>"; 
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	function updateVersion($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE versions SET ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " update_time = " . _q(date("Y-m-d H:i:s")). " where version_id = " . _q($id);
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
		CMS_libs_History::write($this->auth->username, "Updated Version: ".$id."<br>SQL: $sql");
	}
	
	function deleteVersions($ids){
		$sql = 'UPDATE versions SET deleted = 1 where version_id in ' . $ids;
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs)
        {
            _setMessage("SQL Error!", true);
            return;
        }
        _setMessage($sql);
        
        //log action
		CMS_libs_History::write($this->auth->username, "Deleted Versions: ".$ids."<br>SQL: $sql");
	}	
	
	function addVersion($params){
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO versions ( " . $sqlCols . ", insert_time, update_time, deleted) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ", 0)";
		
		// echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "SELECT version_id FROM versions ORDER BY version_id DESC LIMIT 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$version_id = $rs->fields['version_id'];
		
		//log action
		CMS_libs_History::write($this->auth->username, "Updated Version: ".$params['version_id']."<br>SQL: $sql");
		
		return $cardpageId;
		
	}

    function getAllVersions(){
    	$sql = "SELECT * 
    			FROM versions 
    			WHERE deleted != 1 
    			ORDER BY version_id";
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }    
    
    function getVersionsOfPage($pageid) {
    	$sql = "SELECT * FROM
				(
				SELECT
				        version_id,
				        version_name,
				        IF(active = 1, 1, 0) as status
				FROM rt_pagedetails as pd
				JOIN versions as v ON (pageDetailVersion = version_id AND v.deleted != 1)
				WHERE pd.deleted != 1
				        AND pd.cardpageId = " . _q($pageid) . "			
				        	
				UNION
				
				SELECT
				        version_id,
				        version_name,
				        0 as status
				FROM versions as v
					WHERE v.deleted != 1
				) as result
				GROUP BY version_id
				ORDER BY version_id ASC";
    	//echo $sql;
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }

    function getVersionName($versionId){
    	$sql = "SELECT versions.version_name
    			FROM versions 
    			WHERE version_id = " . _q($versionId);
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }   
    
}
?>