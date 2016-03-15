<?php

/**
 * 
 * ClickSuccess, L.P.
 * March 31, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */
class CMS_libs_SubPages {

	/**
	 * Get all sub pages associated with a page
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Master ID (page ID of the parent page)
	 * @param int Site ID (used to get the proper version)
	 * @return ResultSet Pages associated to the master page
	 * @static
	 */
	function getSubPagesByPage($masterId, $siteId) {
		
		$table = self::getTableName($siteId);
			
		$sql = 'SELECT * 
				FROM rt_pagedetails as d, '.$table.
				' as m, rt_cardpages as p
				WHERE d.cardpageId = p.cardpageId
				AND p.cardpageId = m.subpageid
				AND d.pageDetailVersion = ' . $siteId . '
				AND m.masterpageid = ' . $masterId . '
				AND m.siteid = ' . $siteId . '

				UNION
				
				SELECT * 
				FROM rt_pagedetails as d, '.$table.' as m, rt_cardpages as p
				WHERE d.cardpageId = p.cardpageId
				AND p.cardpageId = m.subpageid
				AND d.pageDetailVersion = -1
				AND m.masterpageid = ' . $masterId . '
				AND m.siteid = ' . $siteId . '
				AND p.cardpageId NOT IN
				(
					SELECT p.cardpageId
					FROM rt_pagedetails as d, '.$table.' as m, rt_cardpages as p
					WHERE d.cardpageId = p.cardpageId
					AND p.cardpageId = m.subpageid
					AND d.pageDetailVersion = ' . $siteId . '
					AND m.masterpageid = ' . $masterId . '
					AND m.siteid = ' . $siteId . '
				)
				ORDER BY rank';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	/**
	 * Get assigned sub pages associated with a page
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Master ID (page ID of the parent page)
	 * @param int Site ID (used to get the proper version)
	 * @return ResultSet Pages associated to the master page
	 * @static
	 */
	function getAssignedSubPagesBySiteAndMaster($siteId, $masterId) {
		//get Assigned SubPages
		$assignedSet = array();
		$rs = $this->_lookupSubPageMap($siteId, $masterId);
		while ($rs && !$rs->EOF) {
			$assignedSet[] = $rs->fields['subpageid'];
			$rs->MoveNext();
		}

		//new get information on assigned pages
		if (sizeof($assignedSet) >= 1) {
			$sql = 'SELECT * FROM rt_cardpages' .
				' WHERE (cardpageId in (' . implode(',', $assignedSet) . '))' .
				' AND deleted != 1 ';
			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		}

		//echo $sql.'<br>';

		return $rs;
	}

	/**
	 * Get unassigned sub pages associated with a page
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Master ID (page ID of the parent page)
	 * @param int Site ID (used to get the proper version)
	 * @return ResultSet Pages not associated to the master page
	 * @static
	 */
	function getUnassignedSubPagesBySiteAndMaster($siteId, $masterId) {
		//get Assigned SubPages
		$assignedSet = array();
		$rs = $this->_lookupSubPageMap($siteId, $masterId);
		while ($rs && !$rs->EOF) {
			$assignedSet[] = $rs->fields['subpageid'];
			$rs->MoveNext();
		}

		//now get all sites except those already assigned
		if (sizeof($assignedSet) >= 1) {
			$sql = 'SELECT * FROM rt_cardpages' .
				' WHERE !(cardpageId in (' . implode(',', $assignedSet) . '))' .
				' AND deleted != 1' .
				' ORDER BY pageName';
		} else {
			$sql = 'SELECT * FROM rt_cardpages' .
				' WHERE deleted != 1' .
				' ORDER BY pageName';
		}
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	function _lookupSubPageMap($siteId, $masterId) {
		//get subpages
			$sql = 'SELECT subpageid FROM '.self::getTableName($siteId).
				' WHERE siteid=' . $siteId .
				' AND masterpageid=' . $masterId;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	function hidePage($siteId, $masterId, $subPageId) {

		$sql = 'SELECT hide 
    	        FROM ' . self::getTableName($siteId) .
    	        ' WHERE siteid = ' . $siteId . ' 
    	        AND masterpageid = ' . $masterId . ' 
    	        AND subpageid = ' . $subPageId;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$sql = 'UPDATE ' . self::getTableName($siteId) .
    	        ' SET hide = ' . ($rs->fields['hide'] ? 0 : 1) . ' 
    	        WHERE siteid = ' . $siteId . ' 
                AND masterpageid = ' . $masterId . ' 
                AND subpageid = ' . $subPageId;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	/**
	 * Gets the appropriate table name for a given SQL statement.
	 * @param int $siteId
	 */
	private static function getTableName($siteId) {
		//If site id is equal to CCCOM_MOBILE, which is id 47, use this table.
		if ($siteId == 47) {
			return 'rt_pagesubpagemap_mobile ';
		} else { //use this table for all others
			return 'rt_pagesubpagemap ';
		}
	}

}

?>