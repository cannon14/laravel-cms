<?php
/**
 * 
 * CreditCards.com
 * July 10, 2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */

class CMS_libs_Specials {
	/**
	* Get the pageIds for a given site
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function getPageIdsById($specialsPageId){
		$sql = 'SELECT s.pageid FROM specials_page_map as s
				WHERE s.specialsPageId = '._q($specialsPageId).'
				ORDER BY s.rank ASC';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	* Get the pages assigned to the specials page for a site
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function getSpecialsPagesById($specialsPageId){
		$sql = 'SELECT p.pageName, s.rank, d.* FROM rt_cardpages as p
				JOIN specials_page_map as s ON p.cardpageId = s.pageid
				JOIN rt_pagedetails as d ON p.cardpageId = d.cardpageId
				WHERE s.specialsPageId = '._q($specialsPageId).'
				AND  d.pageDetailVersion=s.specialsPageId OR d.pageDetailVersion="-1"
				AND p.deleted = 0
				AND d.deleted = 0
				GROUP BY cardpageId HAVING MAX(d.pageDetailVersion)
				ORDER BY s.rank ASC';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	* Get the pages not assigned to the specials page for a site
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function getSpecialsPagesUnassignedById($specialsPageId){
		$sql = 'SELECT p.* FROM rt_cardpages as p
				WHERE p.cardpageId NOT IN (
					SELECT s.pageid from specials_page_map as s WHERE s.specialsPageId='.$specialsPageId.'
				) 
				AND p.deleted = 0
				ORDER BY p.pageName ASC';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
	
	/**
	* Add a page to a site's specials page
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @param int Page ID
	* @static
	*/
	function addSpecialsPageToPage($specialsPageId, $pageId){
		$sql = 'INSERT INTO specials_page_map 
				(specialspageid, pageid, rank) 
				(SELECT '._q($specialsPageId).','._q($pageId).', IF(MAX(s.rank) IS NULL, 1, MAX(s.rank)+1) FROM specials_page_map as s WHERE s.specialsPageId='._q($specialsPageId).')';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	* Remove all pages from a site's specials page
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @static
	*/
	function removePagesById($specialsPageId){
		$sql = 'DELETE FROM specials_page_map WHERE specialsPageId='._q($specialsPageId);
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	function getSpecialsCardsByIdAndSite($specialsPageId, $siteId){
		
		$table = (($siteId==47) ? 'rt_cardpagemap_mobile' : 'rt_cardpagemap');
		
		$sql = 'SELECT 
					c.*, 
					cd.*, 
					p.pageName, 
					pd.pageLink, 
					s.rank ,
					merch.merchantname,
					terms_mobile.url AS terms_mobile_url
				FROM specials_page_map as s
					JOIN rt_cardpages as p ON s.pageid=p.cardpageId
					JOIN rt_pagedetails as pd ON (p.cardpageId=pd.cardpageId)
					JOIN '.$table.' as cpm ON p.cardpageId=cpm.cardpageId
					JOIN rt_cards as c ON cpm.cardId=c.cardId
					JOIN rt_carddetails as cd ON c.cardId=cd.cardId
					JOIN cs_merchants as merch ON c.merchant=merch.merchantid
					LEFT JOIN product_links AS terms_mobile ON terms_mobile.product_id = c.cardId AND terms_mobile.`link_type_id` = 4 AND terms_mobile.`device_type_id` = 2

				WHERE s.specialspageid='._q($specialsPageId).'
					AND cpm.rank = (
                		SELECT
                			MIN(cpm2.rank)
                		FROM 
                			'.$table.' as cpm2
                			LEFT JOIN cs_pagecardexclusionmap as x
                                        ON (cpm2.cardId = x.cardid
                                            AND (cpm2.cardpageId=x.pageid or x.pageid=-1)
                                            AND x.siteid=' . _q($siteId) . ')
                		WHERE
                			x.mapid IS NULL
                			AND cpm2.cardpageId = cpm.cardpageId
                		ORDER BY cpm2.cardpageId, cpm2.rank 
                	)
					AND p.deleted="0"
					AND pd.pageDetailVersion = IF ( ( 
														SELECT cardpageId 
														FROM rt_pagedetails 
														WHERE 
															pageDetailVersion='._q($siteId).' 
															AND cardpageId=p.cardpageId
													) IS NULL, "-1", '._q($siteId).')
					AND pd.deleted="0"
					AND c.deleted="0"
					AND cd.deleted="0"
					AND c.active="1"
					AND cd.active="1"
					AND cd.cardDetailVersion = IF ( ( 
														SELECT cardId 
														FROM rt_carddetails 
														WHERE 
															cardDetailVersion='._q($siteId).' 
															AND cardId=c.cardId
													) IS NULL, "-1", '._q($siteId).')
				ORDER BY rank ASC';
		
		//echo $sql."<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
        
        /**
         * Function is called when Top Credit Cards needs to be populated by
         * manually selected cards instead of just pulling the top ranked card
         * from the database for each category.
         * 
         * @date 21 May 14
         * @param int $specialsPageId
         * @param int $siteId
         * @return ResultSet
         */
        function getManuallyAddedSpecialsCardsByIdAndSite($specialsPageId, $siteId) {
      
			$cpmtable = (($siteId==47) ? 'rt_cardpagemap_mobile' : 'rt_cardpagemap');
			$pspmtable = (($siteId==47) ? 'rt_pagesubpagemap_mobile' : 'rt_pagesubpagemap');
			
            $sql = 'SELECT c.*, cd.*, p.pageName, pd.pageLink, merch.merchantname, terms_mobile.url AS terms_mobile_url 
                FROM '.$pspmtable.' as pspm 
                JOIN rt_cardpages as p ON pspm.subpageid=p.cardpageId
                JOIN rt_pagedetails as pd ON (p.cardpageId=pd.cardpageId)
                JOIN '.$cpmtable.' as cpm ON p.cardpageId=cpm.cardpageId
                JOIN rt_cards as c ON cpm.cardId=c.cardId
                JOIN rt_carddetails as cd ON c.cardId=cd.cardId
                JOIN cs_merchants as merch ON c.merchant=merch.merchantid
                LEFT JOIN product_links AS terms_mobile 
                    ON terms_mobile.product_id = c.cardId 
                        AND terms_mobile.`link_type_id` = 4 
                        AND terms_mobile.`device_type_id` = 2 
                WHERE pspm.masterpageid='._q($specialsPageId).'
                AND p.deleted="0"
                AND pd.pageDetailVersion = IF ( ( 
                    SELECT cardpageId 
                    FROM rt_pagedetails 
                    WHERE pageDetailVersion='._q($siteId).' AND cardpageId=p.cardpageId
                        ) IS NULL, "-1", '._q($siteId).')
                    AND pd.deleted="0"
                    AND c.deleted="0"
                    AND cd.deleted="0"
                    AND c.active="1"
                    AND cd.active="1"
                    AND cd.cardDetailVersion = IF ( ( 
                        SELECT cardId 
                        FROM rt_carddetails 
                        WHERE 
                        cardDetailVersion='._q($siteId).' 
                        AND cardId=c.cardId
                        ) IS NULL, "-1", '._q($siteId).')
				ORDER BY pspm.rank ASC';
			
            $rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
                        
            return $rs;
	}
}
?>