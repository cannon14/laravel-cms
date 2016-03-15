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
class CMS_libs_Pages {
	
	/**
	 * Get a page by its id and version
	 * 
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Page ID
	 * @param int Page Version
	 * @return ResultSet Page Information
	 * @static
	 */
	function getPage($id, $version){
		$sql = "SELECT *, p.active as active, d.active as version_active ".
			    "FROM rt_cardpages as p, " .
				"rt_pagedetails as d " .
				"WHERE (d.deleted != 1 AND p.deleted != 1) " .
				"AND (d.cardpageId = p.cardpageId) " .
				"AND d.pageDetailversion = " . _q($version) ." ". 
				"AND p.cardpageId = " . _q($id);
		//echo "<b>" . $sql . "<b/><br>"; 
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	function getPageById($id){
		$sql = "SELECT * ".
			    "FROM rt_cardpages " .
				"WHERE (deleted != 1) " .
				"AND cardpageId = " . _q($id);
		//echo "<b>" . $sql . "<b/><br>"; 
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	function getPageDetailsByIdAndVersion($id, $version){
		$sql = "SELECT *, d.active as version_active ".
			    "FROM rt_pagedetails as d " .
				"WHERE (d.deleted != 1) " .
				"AND d.pageDetailversion = " . _q($version) ." ". 
				"AND d.cardpageId = " . _q($id);
		//echo "<b>" . $sql . "<b/><br>"; 
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
	
	/**
	 * Update a page from an array of parameters
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Page ID
	 * @param array Parameters ($field=>$value)
	 * @static
	 */
	function updatePage($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_cardpages set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where cardpageId = " . _q($id);
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
		CMS_libs_History::write($this->auth->username, "Updated Page: ".$id."<br>SQL: $sql");
	}
	
	/**
	 * Remove a page from the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Page ID
	 * @return int Page Version
	 * @static
	 */
	function deletePages($ids){
		$sql = 'UPDATE rt_cardpages set deleted = 1 where cardpageId in ' . $ids;
        $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs)
        {
            _setMessage("SQL Error!", true);
            return;
        }
        _setMessage($sql);
        
        //log action
		CMS_libs_History::write($this->auth->username, "Deleted Pages: ".$ids."<br>SQL: $sql");
	}	
	
	/**
	 * Add a page to the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Parameters ($field=>$value)
	 * @static
	 */
	function addPage($params){
		$sqlParams =  "'" . implode("','", $params) . "'";
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_cardpages ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
		
		// echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "SELECT cardpageId FROM rt_cardpages ORDER BY cardpageid DESC LIMIT 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$cardpageId = $rs->fields['cardpageId'];
		
		//log action
		CMS_libs_History::write($this->auth->username, "Updated Page: ".$params['cardpageId']."<br>SQL: $sql");
		
		return $cardpageId;
		
	}
	
	/**
	 * Add an article page to the database
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Parameters ($field=>$value)
	 * @static
	 */
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
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$sql = "SELECT cardpageId FROM rt_cardpages ORDER BY cardpageid DESC LIMIT 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		$cardpageId = $rs->fields['cardpageId'];
		
		//log action
		CMS_libs_History::write($this->auth->username, "Added Article Page: ".$params['cardpageId']."<br>SQL: $sql");
          
		
		return $cardpageId;
		
	}
	
	/**
	 * Add a version to the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Parameters ($field=>$value)
	 * @static
	 */
	function addVersion($params){
		//$sqlParams =  "'" . implode("','", $params) . "'";
		$sqlParams = " ";
		foreach($params as $col=>$value) {
			$sqlParams .= _q($value) . ", ";
		}
		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);
		
		$sql = "INSERT INTO rt_pagedetails ( " . $sqlCols . ", dateCreated, dateUpdated) " . 
		" VALUES (" . $sqlParams  . " " ._q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) .  ")";
      
      //echo $sql;
		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
      // another undefined index ...  - mz      
		//CMS_libs_History::write($this->auth->username, "Added Page fVersion: ".$params['cardpageId']."<br>SQL: $sql");
      CMS_libs_History::write($this->auth->username, "Added Page fVersion: ".$params['cardPageId']."<br>SQL: $sql");
      
      $sql = 
      "
      select 
         id         
      from rt_pagedetails
      where cardPageId = "._q($params['cardPageId'])."
      and pageDetailVersion = "._q($params['pageDetailVersion']);
      
      // echo $sql.'<br><br>';
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      // print_R($params);
      $pageDetailId = $rs->fields['id'];            
      
      CMS_libs_Pages::writeSiteCatalystDefaults($pageDetailId);
	}
	
	/**
	 * Update a version
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Page ID
	 * @param array Parameters ($field=>$value)
	 * @return int Page Version
	 * @static
	 */
	function updateVersion($id, $params){
		if(!is_array($params))
			return;
		$sql = "UPDATE rt_pagedetails set ";
		foreach($params as $col=>$data){
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .=  " dateUpdated = " . _q(date("Y-m-d H:i:s")). " where cardpageId = " . _q($id) . " AND pageDetailVersion = " . _q($params['pageDetailVersion']);
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//log action
		CMS_libs_History::write($this->auth->username, "Updated Version: ".$id."<br>SQL: $sql");
      
      // get the detail id
      $sql=
      "
      select id from rt_pagedetails
      where cardpageId = " . _q($id) . "
      and pageDetailVersion = " . _q($params['pageDetailVersion']);
      
      //echo $sql;
      
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      $detailId = $rs->fields['id'];
      
      //echo $sql;
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      CMS_libs_Pages::writeSiteCatalystDefaults($detailId);
	}
	
	/**
	 * Get all the pages associated with a site
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Site ID
	 * @return ResultSet All the pages associated with a site with correct versions
	 * @static
	 */
	function getPagesBySite($siteId){      
		$version = array();
		$default = array();
		
		// first we get ids of this site's page versions
		$sql = "-- Pages that will use the site version
				SELECT
				        cp.*,
				        pd.*
				FROM rt_sites as s
				        JOIN rt_pagecategorymap as pcm ON ( s.siteId = pcm.categoryId )
				        JOIN rt_cardpages as cp USING ( cardpageId )
				        JOIN rt_pagedetails as pd ON ( cp.cardpageId = pd.cardpageId AND
				pd.pageDetailVersion = s.version_id )
				WHERE
				        siteId = (@site := " . _q($siteId) . ")
				
				UNION
				
				-- Pages that will use the default version
				SELECT
				        cp.*,
				        pd.*
				FROM rt_sites as s
				        JOIN rt_pagecategorymap as pcm ON ( s.siteId = pcm.categoryId )
				        JOIN rt_cardpages as cp USING ( cardpageId )
				        JOIN rt_pagedetails as pd ON ( cp.cardpageId = pd.cardpageId AND
				pd.pageDetailVersion = -1 )
				WHERE
				        siteId = @site
				        AND cp.cardpageId NOT IN (
				                SELECT cardpageId
				                FROM rt_pagedetails as pd2
				                WHERE pd2.pageDetailVersion = s.version_id
				        )";
		
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		//echo "<b>" . $sql ."</b><br><br>";
		
		$alreadyUsedCardpages = array();
		while(!$rs->EOF){
			$version[] = $rs->fields['id'];	
			$alreadyUsedCardpages[] = $rs->fields['cardpageId'];
			$rs->MoveNext();
		}
		
		$sqlVersion = "('" . implode("','", $alreadyUsedCardpages ) . "')";
		
		$sql = "SELECT * FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d 
				WHERE d.deleted != 1 AND c.type = 0
				AND (d.cardpageId = c.cardpageid) 
				AND m.categoryId = "._q($siteId)." 
				AND (c.cardpageId = m.cardpageId) 
				AND (d.pageDetailVersion = -1) 
				AND c.cardpageId NOT IN " . $sqlVersion . "
				AND c.active = 1 
				AND c.deleted != 1 
				GROUP BY c.cardpageId
				ORDER BY m.rank ASC, d.pageDetailVersion";
		//echo $sql . "<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		while(!$rs->EOF){
			$default[] = $rs->fields['id'];	
			$rs->MoveNext();
		}
		
		$combArray = array_merge($default, $version);
		
		if(is_array($combArray))
			$sqlIds = "('" . implode("','", $combArray) . "')";
		else
			$sqlIds = "('')";
         
      /*
		$sql = "SELECT * FROM rt_cardpages as c, rt_pagecategorymap as m, rt_pagedetails as d
				WHERE d.deleted != 1 AND c.type = 0
				AND (d.cardpageId = c.cardpageid) 
				AND (m.cardpageId = c.cardpageId) 
				AND d.id in " . $sqlIds . " GROUP BY c.cardpageId ORDER BY m.rank ASC";
       */
       
      $sql = 
      "
      select * from rt_cardpages as c
      inner join rt_pagecategorymap as m on m.cardpageId = c.cardpageId
         and c.type = 0
      inner join rt_pagedetails as d on d.cardpageId = c.cardpageid
         and d.deleted != 1
         and d.id in " . $sqlIds . "      
      group by c.cardpageId 
      order by m.rank asc";
		
		//echo $sql ."<br><br>";
		return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Get the title of a site
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Site ID
	 * @return String Site Title
	 * @static
	 */
    function getSiteLabel($siteId){
    	$sql = "SELECT siteTitle FROM rt_sites WHERE siteId = " . _q($siteId);
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    	return $rs->fields['siteTitle'];	
    }
    
    /**
	 * Get the sites that do not have a specific version of a page
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Page ID
	 * @return ResultSet Sites that do not have a version of the page
	 * @static
	 */
    function getUnusedVersions($cardpageId){
    	$sql = "SELECT * 
    			FROM rt_sites as s, rt_pagedetails as d 
    			WHERE  (d.cardpageId != " . _q($cardpageId). ") 
    			AND s.deleted != 1 
    			GROUP by s.siteName
    			ORDER BY s.siteName";
    	//echo $sql;
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
    /**
	 * Get all pages (different versions not included)
	 * @author Patrick Mizer
	 * @version 1.0
	 * @return ResutlSet All Pages
	 * @static
	 */
    function getAllDistinctPages(){
    	$sql = "SELECT * 
    			FROM rt_cardpages 
    			WHERE deleted != 1 
    			ORDER BY pageName";
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }    
    
    /**
     * Get a page associated with a merchant and a site
     * @author Jason Huie
	 * @version 1.0
	 * @return ResutlSet Page
	 * @static
	 */
    function getPageByIdAndSite($merchantPageId, $siteId){
    	$sql = 'SELECT * FROM rt_cardpages as p 
				LEFT JOIN rt_pagedetails as pd USING (cardpageId)
				WHERE p.cardpageId = '._q($merchantPageId).' 
				AND (pd.pageDetailVersion = -1 OR pd.pageDetailVersion = '._q($siteId).')
				ORDER BY pd.pageDetailVersion DESC
				LIMIT 1';
		//echo $sql.'<hr>';
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }
    
   /**
    * Get issuer pages associated with a site
    * @author mz
    * @version 1.0
    * @return Result set of page ids and their page names
    * @static
    */
    function getSiteCatalystIssuerPageAttributesBySite($siteId)
    {
      $sql = 
      "
      SELECT d.id, d.pageLink
      FROM rt_cardpages as c
      inner join rt_pagedetails as d on c.cardPageId = d.cardpageId
         and (d.pageDetailVersion = -1 OR d.pageDetailVersion = "._q($siteId).")
         and c.type = 0
         and d.deleted != 1
         and c.pageType = 'Bank'
      inner join rt_pagecategorymap m on c.cardpageId = m.cardpageId
         and m.categoryId = "._q($siteId)."
      order by d.pageTitle
      ";      
      
      // echo $sql.'<hr>';
      return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);      
    }    
    
   /**
    * Get category pages associated with a site
    * @author mz
    * @version 1.0
    * @return Result set of page ids and their page names
    * @static
    */
    function getSiteCatalystCategoryPageAttributesBySite($siteId)
    {
      $sql = 
      "
      SELECT d.id, d.pageLink
      FROM rt_cardpages as c
      inner join rt_pagedetails as d on c.cardPageId = d.cardpageId
         and (d.pageDetailVersion = -1 OR d.pageDetailVersion = "._q($siteId).")
         and c.type = 0
         and d.deleted != 1
         and c.pageType = 'Type'
      inner join rt_pagecategorymap m on c.cardpageId = m.cardpageId
         and m.categoryId = "._q($siteId)."
      order by d.pageTitle
      ";
      //echo $sql.'<hr>';
      return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    }     
    
   function writeSiteCatalystDefaults($pageDetailId)
   {
      // echo 'params are ... ';
      // print_R($params);      
      /**
       * channel = issuer | type | merchants => c.pageType
       * prop1 = pageLink
       * s.pageName = channel:prop1
       **/
      $sql = 
      "      
      SELECT 
         c.pageType, 
         d.pageLink         
      FROM rt_cardpages as c
      inner join rt_pagedetails as d on c.cardPageId = d.cardpageId
         and c.type = 0
         and d.deleted != 1         
         and d.id = ".$pageDetailId;
         
      // echo $sql.'<br><br>';
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
      
      $pageType = $rs->fields['pageType'];
      $pageLink = $rs->fields['pageLink'];      
      
      if(empty($pageType) || empty($pageLink))
      {
         trigger_error('Page attributes must be non-empty values.', E_USER_ERROR);
      }

      $sql =
      "
      insert into sc_card_page_data (page_details_id, var_name, var_value) 
      select page_details_id, tmp_var_name, tmp_var_value
      from
         (
            select $pageDetailId as page_details_id, var_name as tmp_var_name, '$pageLink' as tmp_var_value
            from sc_page_vars 
            where var_name like 'prop1' 
            union all
            select $pageDetailId as page_details_id, var_name as tmp_var_name, '$pageType' as tmp_var_value
            from sc_page_vars 
            where var_name like 'channel' 
            union all 
            select $pageDetailId as page_details_id, var_name as tmp_var_name, '".$pageType.":".$pageLink."' as tmp_var_value 
            from sc_page_vars 
            where var_name like 'pageName' 
         ) as tmpValues
      on duplicate key update var_value = tmpValues.tmp_var_value 
      ";
      // echo '<br><br>sql is '.$sql;
      $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);           
   }
   
    function getVersionByPageAndId($pageid, $versionId){
    	$sql = "SELECT pageDetailVersion
    			FROM rt_pagedetails 
    			WHERE deleted != 1 
    			AND pageDetailVersion = " . _q($versionId) . "
    			AND cardpageId = " . _q($pageid);
    	//echo $sql;
    	return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
    } 
}
?>