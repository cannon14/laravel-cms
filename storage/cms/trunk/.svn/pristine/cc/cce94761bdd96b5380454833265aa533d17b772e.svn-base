<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 17, 2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Lib
 */
 
 class CMS_libs_PageComponents {
	
	/**
	 * Get all component names from the database based on a page id 
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Page id
	 * @param String page type (defaults to 'cardpage')
	 * @return ResultSet Names of the page's components
	 * @static
	 */	
	function getComponentsByPage($cardpageId, $pageType='cardpage'){
		$sql = "SELECT item from cs_pagecomponents " .
				"WHERE pageid = "._q($cardpageId).
				" AND pagetype="._q($pageType);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Get all information for a component based on the component id 
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Component id
	 * @return ResultSet Component information
	 * @static
	 */	
	function getComponent($id){
		$sql = 'SELECT item, render FROM cs_pagecomponents WHERE itemid='.$id;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Add a component to the database 
	 * @author Jason Huie
	 * @version 1.0
	 * @param String Component Name
	 * @param String Component HTML for rendering
	 * @static
	 */	
	function addComponent($item, $render){
		$sql = 'INSERT INTO cs_pagecomponents (item, render) VALUES ('._q($item).','._q($render).')';
		if($rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE))
			return true;
		else
			return false;
			
	}
	
	/**
	 * Delete a component from the database
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Page id
	 * @static
	 */	
	function deleteComponent($id){
		$sql = 'UPDATE cs_pagecomponents SET deleted=1 WHERE itemid='.$id;
		if($rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE))
			return true;
		else
			return false;
	}
	
	/**
	 * Remove an association between a page and a component 
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site id
	 * @param int Page id
	 * @param int Component id
	 * @static
	 */	
	function deleteAssociation($siteId, $pageId, $itemId){
		$sql = 'DELETE FROM cs_pagecomponentmap WHERE siteid='.$siteId.' AND pageid='.$pageId.' AND itemid='.$itemId;
		if($rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE))
			return true;
		else
			return false;
	}
	
	/**
	 * Update a component 
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Page id
	 * @param String Component name
	 * @param String HTML to render the component
	 * @static
	 */	
	function updateComponent($id, $item, $render){
		$sql = 'UPDATE cs_pagecomponents SET item='._q($item).', render='._q($render).' WHERE itemid='.$id;
		if($rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE))
			return true;
		else
			return false;
	}
	
	/**
	 * Get all components 
	 * @author Jason Huie
	 * @version 1.0
	 * @return ResultSet Information for all components
	 * @static
	 */	
	function getAllComponents(){
		$sql='SELECT * 
			  FROM cs_pagecomponents
			  WHERE deleted != 1
			  ORDER BY item';	 
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Get all components for a page based on the site
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site id
	 * @param String Page type (defaults to cardpage)
	 * @return ResultSet Information for all components for the site
	 * @static
	 */	
	function getComponentsBySite($siteId, $pageType='cardpage'){
		$sql = 'SELECT c.*, m.pageid, m.rank FROM cs_pagecomponents as c
				JOIN cs_pagecomponentmap as m USING (itemid)
				WHERE m.siteid = '._q($siteId).'
				AND c.deleted != 1
				AND m.pagetype='._q($pageType).'
				ORDER BY m.pageid, m.rank ASC';
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	 * Get all components for a page based on the page and site
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site id
	 * @param int Page id
	 * @param String Page type (defaults to cardpage)
	 * @return ResultSet Information for all components for the site and page
	 * @static
	 */	
	function getAssignedComponentsBySiteAndPage($siteId, $pageId, $pageType='cardpage'){
		$sql='SELECT * FROM cs_pagecomponentmap'.
			 ' WHERE pageid='._q($pageId).
			 ' AND siteid='._q($siteId).
			 ' AND pagetype='._q($pageType).
			 ' GROUP BY itemid'.
			 ' ORDER BY itemid';
			 
		$rs_assigned = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		//echo "$sql<hr>";	 
		
		while($rs_assigned and !$rs_assigned->EOF){
			$assigned[] = $rs_assigned->fields['itemid'];
			$rs_assigned->MoveNext();
		}
		
		if(sizeof($assigned) >= 1){
			$sql = 'SELECT * FROM cs_pagecomponents as c, cs_pagecomponentmap as m'.
						' WHERE c.itemid in ('.implode(',',$assigned).')' .
						' AND m.pageid = '.$pageId.
						' AND m.itemid = c.itemid'.
						' AND m.siteid = '.$siteId.
						' AND c.deleted != 1'.
						' ORDER BY m.rank ASC';
						
			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		}
		
		//echo $sql.'<br>';
		
		return $rs;
	}
	
	/**
	 * Get all components that do not have an association with a page and site 
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site id
	 * @param int Page id
	 * @param String Page type (Defaults to cardpage)
	 * @return ResultSet Information for all components that are not currently assigned to the page and site
	 * @static
	 */	
	function getUnassignedComponentsBySiteAndPage($siteId, $pageId, $pageType='cardpage'){
		//first get all assigned components
		$sql='SELECT * FROM cs_pagecomponentmap'.
			 ' WHERE pageid='._q($pageId).
			 ' AND siteid='._q($siteId).
			 ' AND pagetype='._q($pageType);
			 
		$rs_assigned = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			 
		while($rs_assigned and !$rs_assigned->EOF){
			$assigned[] = $rs_assigned->fields['itemid'];
			$rs_assigned->MoveNext();
		}
		
		//now get all sites except those already assigned
		if(sizeof($assigned) >= 1)
			$sql = 'SELECT * FROM cs_pagecomponents'.
					' WHERE !(itemId in ('.implode(',',$assigned).'))' .
					' AND deleted != 1'.
					' AND pagetype='._q($pageType);
		else
			$sql = 'SELECT * FROM cs_pagecomponents' .
					' WHERE deleted != 1';
				
		//echo $sql.'<br>';
				
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		return $rs;
    }
    
    /**
	 * Get the number of components assigned to a page 
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Page id
	 * @param String Page type (defaults to cardpage)
	 * @return ResultSet count of components on a page
	 * @static
	 */	
    function getNumberOfCompontentsByPage($id, $pageType='cardpage'){
    	$sql = 'SELECT count(*) FROM cs_pagecomponentmap WHERE pageid='.$id.' AND pagetype='.$pageType;
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		
		return $rs;	
    }
    
     /**
	 * Assign a component to a page and site
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site id
	 * @param int Page id
	 * @param
	 * @param String Page type (defaults to cardpage)
	 * @return ResultSet count of components on a page
	 * @static
	 */	
    function insertAssociation($siteId, $pageId, $itemId, $rank, $pageType='cardPage')
    {
    	$sql = 'INSERT INTO cs_pagecomponentmap (siteid, pagetype, pageid, itemid, rank) VALUES (' .
    			_q($siteId).','._q($pageType).','._q($pageId).','._q($itemId).','.$rank.')';
    	$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		echo $sql.'<br>';		
		return $rs;
    }
		
 }
?>
