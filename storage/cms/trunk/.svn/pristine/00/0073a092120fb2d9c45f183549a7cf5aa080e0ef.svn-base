<?php
/**
 * ClickSuccess, L.P.
 * March 31, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Lib
 */
class CMS_libs_Sites {
	
	/**
	 * Get the information for a site
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Site ID
	 * @return ResultSet Site information
	 * @static
	 */
	function getSite($id){
		$sql = "SELECT * FROM rt_sites WHERE siteId = " . _q($id) . " AND deleted != 1";
	
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Get website by name
	 *
	 * @param $name
	 *
	 * @return ResultSet Site information
	 * @static
	 */
	function getSiteByName($name) {
		$sql = "SELECT * FROM rt_sites WHERE siteName LIKE " . _q($name) . " AND deleted != 1";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Get website list by name - for use in creating new product links (autocomplete search).
	 *
	 * @param $name
	 *
	 * @return ResultSet Website Names
	 * @static
	 */
	function getSitesByName($name) {
		$name = "%" . $name . "%";
		$sql = "SELECT siteId, siteName FROM rt_sites " .
					"WHERE (siteName LIKE " . _q($name) .
					" OR siteTitle LIKE " . _q($name) .
					") AND deleted != 1";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	/**
	 * Get the information for all sites
	 * @author Patrick Mizer
	 * @version 1.0
	 * @return array Information for all sites in an array
	 * @static
	 */
	function getAllSites(){
		$siteArray = array();
		$sql = "SELECT * 
				FROM rt_sites 
				WHERE deleted != 1
				ORDER BY siteName";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		while(!$rs->EOF){
			$siteArray[] = clone $rs;
			$rs->MoveNext();
		}
		
		return $siteArray;
	}
	
	/**
	 * Get the information for all sites that publish to ccbuild
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Information for sites in an array
	 * @static
	 */
	function getCcbuildSites(){
		$siteArray = array();
		$sql = "SELECT * 
				FROM rt_sites 
				WHERE deleted != 1 
				AND ccbuildPublish=1
				ORDER BY siteTitle";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		while(!$rs->EOF){
			$siteArray[] = clone $rs;
			$rs->MoveNext();
		}
		
		return $siteArray;
	}
	
	/**
	 * Remove a set of sites from the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Site IDs
	 * @static
	 */
	function deleteSites($ids){
		$sql = 'UPDATE rt_sites set deleted = 1, rt_sites.order=0 where siteId in ' . $ids;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
  		
		//log action
		CMS_libs_History::write($this->auth->username, "Deleted Sites: ".$ids."<br>SQL: $sql");
	}
	
	/**
	 * Update site information
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Site ID
	 * @static
	 */
	function updateSite($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_sites set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where siteId = " . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
		CMS_libs_History::write($this->auth->username, "Updated Site: ".$id."<br>SQL: $sql");
	}
	
	/**
	 * Set the published date for a site
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site ID
	 * @static
	 */
	function setPublishedDate($id){
		$sql = "UPDATE rt_sites SET dateLastBuilt=NOW() WHERE siteId=$id";
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Add a site to the database
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Site information ($field=>$value)
	 * @static
	 */
	function addSite($params){

		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_sites ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$siteId = mysql_insert_id();
		
		//log action
		CMS_libs_History::write($this->auth->username, "Added Site: ".$params['siteName']."<br>SQL: $sql");
		return $siteId;
	}
	
	/**
	 * Reorder the sites in the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @static
	 */
	function reOrder(){
		$sql = "SELECT * FROM rt_sites WHERE deleted != 1 ORDER BY rt_sites.order";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$count = 1;
		while(!$rs->EOF){
			$sql = "UPDATE rt_sites set rt_sites.order= " ._q($count) . " WHERE siteId =" ._q($rs->fields['siteId']);
			_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			$count ++;
			$rs->MoveNext();
		}
	}
	
    function assignCards($siteId, $cardIds){
        if(!is_array($cardIds) && $cardIds !== NULL) $cardIds = array($cardIds);	
        
		foreach($cardIds as $id){
			$sqlInsert = 
<<<SQL
INSERT INTO site_card_map 
    (site_id, card_id, insert_date) 
VALUES 
	("$siteId","$id", NOW())
SQL;
			_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
    }
    
    function removeCards($siteId, $cardIds){
        if(!is_array($cardIds) && $cardIds !== NULL) $cardIds = array($cardIds);	
        
		foreach($cardIds as $id){
			$sqlInsert = 
<<<SQL
DELETE FROM site_card_map 
WHERE 
    site_id = "$siteId"
    AND card_id = "$id"
SQL;
			_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
    }
    
    function getCardsBySiteIdAndDate($id, $date){
        $sql = 
<<<SQL
SELECT 
	c.cardId, 
	c.cardTitle
FROM site_card_map as map
	JOIN rt_cards as c ON (map.card_id = c.cardId)
WHERE
	map.site_id = "$id"
	AND map.insert_date >= "$date"
	ORDER BY c.cardTitle
SQL;
        
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
        
        while(!$rs->EOF){
            $return[] = $rs->fields;
            $rs->MoveNext();
        }
        
        return is_array($return) ? $return : array();
    }
    
    function getCardsBySiteId($id){
        $sql = 
<<<SQL
SELECT 
	c.cardId, 
	c.cardTitle,
	d.cardLink,
	d.cardDetailVersion,
	m.merchantcardpage
FROM site_card_map as map
	INNER JOIN rt_cards as c ON (map.card_id = c.cardId)
	INNER JOIN rt_carddetails as d USING (cardId)
	INNER JOIN cs_merchants as m ON (c.merchant = m.merchantid)
	INNER JOIN (
			SELECT
				c2.cardId,
			        MAX(d2.cardDetailVersion) AS max_id
			FROM
				rt_cards AS c2
			        JOIN rt_carddetails AS d2 USING (cardId)
			WHERE
				(d2.cardDetailVersion = -1 OR d2.cardDetailVersion = $id)
			GROUP BY
				c2.cardId
		) AS max_version ON (c.cardId = max_version.cardId AND d.cardDetailVersion = max_version.max_id)
WHERE
	map.site_id = $id
	ORDER BY c.cardTitle
SQL;
        
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
        
        while(!$rs->EOF){
            $return[] = $rs->fields;
            $rs->MoveNext();
        }
        
        return is_array($return) ? $return : array();
    }
    
    function getUnassignedCardsBySiteId($id){
        $sql = 
<<<SQL
SELECT 
	c.cardId, 
	c.cardTitle
FROM rt_cards as c
	LEFT JOIN site_card_map as map ON (map.card_id = c.cardId AND map.site_id = "$id")
WHERE map.site_id IS NULL
ORDER BY c.cardTitle
SQL;
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
        
        while(!$rs->EOF){
            $return[] = $rs->fields;
            $rs->MoveNext();
        }
        
        return is_array($return) ? $return : array();
    }
    
    function getExcludedCards($id){
        $sql = 
<<<SQL
SELECT 
	c.cardId, c.cardTitle
FROM 
	cs_pagecardexclusionmap as x
	JOIN rt_cards as c ON (x.cardid = c.cardId) 
WHERE 
	x.siteid = "$id"
        and x.pageid=-1
	AND c.deleted = 0 
GROUP BY c.cardId
ORDER BY c.cardTitle
SQL;
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
        
        while(!$rs->EOF){
            $return[] = $rs->fields;
            $rs->MoveNext();
        }
        
        return is_array($return) ? $return : array();
    }
    
    function getNonExcludedCards($id){
        $sql = 
<<<SQL
SELECT c.cardId, c.cardTitle
FROM rt_cards as c
WHERE c.cardId NOT IN (
	SELECT cardid
	FROM cs_pagecardexclusionmap
	WHERE
		siteid = "$id"
                and pageid=-1
)
AND c.deleted = 0
ORDER BY cardTitle
SQL;
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
        
        while(!$rs->EOF){
            $return[] = $rs->fields;
            $rs->MoveNext();
        }
        
        return is_array($return) ? $return : array();
    }
    
    
    function assignExcludes($siteId, $cardIds){
        if(!is_array($cardIds) && $cardIds !== NULL) $cardIds = array($cardIds);
	
		foreach($cardIds as $id){
			$sqlInsert = 
<<<SQL
INSERT INTO cs_pagecardexclusionmap
	(siteid, pageid, cardid)
VALUES
	("$siteId", "-1", "$id")
SQL;
		_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
    }
    
    function removeExcludes($siteId, $cardIds){
        if(!is_array($cardIds) && $cardIds !== NULL) $cardIds = array($cardIds);
	
		foreach($cardIds as $id){
			$sqlDelete = 
<<<SQL
DELETE FROM cs_pagecardexclusionmap
WHERE
	siteid = "$siteId"
	AND cardid = "$id"
SQL;
		_sqlQuery($sqlDelete, __LINE__, __FILE__, DEBUG_MODE);
		}
    }
}
?>
