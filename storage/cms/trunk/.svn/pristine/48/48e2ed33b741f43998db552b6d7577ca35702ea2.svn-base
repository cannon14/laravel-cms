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

class CMS_libs_Profiles {

	/**
	* Get the profile data for a given profile id
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function getProfileById($profilePageId){
		$sql = 'SELECT p.* FROM profiles_data as p
				WHERE p.profile_id = '._q($profilePageId).';';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	function getProfilesDataForIndexPage(){
		$sql = 'SELECT p.profile_id, p.title, p.sub_title, p.profile_description,
					   p.profile_card_types, p.background_color_code_light, p.background_color_code_dark,
					   p.image_path, pd.pageLink
				FROM profiles_data as p
				JOIN rt_pagedetails as pd ON p.profile_id=pd.cardpageId
				JOIN rt_cardpages as cp ON p.profile_id=cp.cardpageId
				WHERE cp.contentType="profile"
				AND cp.active = 1
				AND cp.deleted = 0
				ORDER BY rank ASC;';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	/**
	* Get the profile data for a given profile id
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function getProfileByIdAndSite($profilePageId, $siteId){
		$sql = 'SELECT p.* FROM profiles_data as p
				WHERE p.profile_id = '._q($profilePageId).';';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	function getCardCategories() {
		$sql = 'SELECT c.* FROM rt_cardpages as c
				WHERE c.deleted = "0"
				AND c.active = "1"
				AND (c.pageType="TYPE" OR c.pageType="CREDIT")
				AND c.contentType="card"
				ORDER BY c.pageName ASC';

		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	function getTagCategories() {
		$sql = "SELECT
					*
				FROM
					card_categories
				WHERE
					deleted = 0
				;";

		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	function getCardCategoryDetails($categoryId) {
		$sql = 'SELECT pd.pageTitle, pd.primaryNavString, pd.pageSmallImage, pd.pageHeaderImage, pd.pageLink FROM rt_pagedetails as pd
				WHERE pd.cardpageId = '._q($categoryId).'
				AND pd.deleted = "0"
				AND pd.active = "1"
				AND pd.pageDetailVersion = "-1"';
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	function getTopCardByProfileIdAndSite($profilePageId, $siteId){
		$sql ="SELECT
				`cards`.`cardId` ,
				`cards`.`cardTitle` ,
				`card_details`.`cardDetailText` ,
				`cards`.`imagePath` ,
				`cards`.`url` ,
				`card_details`.`cardIntroDetail`,
				`card_details`.`cardLink`,
				DATE(`cards`.`dateCreated`) as dateCreated,
				cards.active_introApr,
				cards.active_balanceTransferIntroApr,
				cards.active_balanceTransferFee,
				cards.active_introAprPeriod,
				cards.active_regularApr,
				cards.active_annualFee,
				cards.active_monthlyFee,
				cards.active_balanceTransfers,
				cards.active_balanceTransferIntroAprPeriod,
				cards.active_creditNeeded,
				cards.introApr AS introApr,
				cards.regularApr AS regularApr ,
				cards.introAprPeriod AS introAprPeriod ,
				cards.annualFee AS annualFee ,
				cards.monthlyFee AS monthlyFee ,
				cards.balanceTransfers AS balanceTransfers ,
				cards.balanceTransferFee AS balanceTransferFee ,
				cards.creditNeeded AS creditNeeded,
				cards.balanceTransferIntroApr AS balanceTransferIntroApr,
				cards.balanceTransferIntroAprPeriod AS balanceTransferIntroAprPeriod,

				subpage_heirarchy.`rank`,
				page_map.`rank`,
				
				ccx.intro_apr as ccx_intro_apr,
				ccx.min_intro_period as ccx_min_intro_period,
				ccx.max_intro_period as ccx_max_intro_period,
				ccx.intro_period_end_date as ccx_intro_period_end_date,
				ccx.min_ongoing_apr as ccx_min_ongoing_apr,
				ccx.max_ongoing_apr as ccx_max_ongoing_apr,
				ccx.min_ongoing_apr_used_rate_type as ccx_used_rate_type,
				bt.min_intro_period as bt_min_intro_period,
				bt.max_intro_period as bt_max_intro_period,
				bt.intro_apr as ccx_bt_intro_apr,
				bt.min_intro_period as ccx_bt_min_intro_period,
				bt.max_intro_period as ccx_bt_max_intro_period,
				bt.intro_period_end_date as ccx_bt_intro_period_end_date,
				bt.min_ongoing_apr as ccx_bt_min_ongoing_apr,
				bt.max_ongoing_apr as ccx_bt_max_ongoing_apr,
				bt.min_default_apr as ccx_bt_min_default_apr,
				bt.max_default_apr as ccx_bt_max_default_apr,
				bt.min_ongoing_apr_used_rate_type as ccx_bt_used_rate_type
				
				FROM
				        (
				                SELECT
				                        masterpageid AS parent,
				                        subpageid AS child, `rank` AS `rank`
				                FROM ".self::getPageSubPageTableName($siteId)."
				                WHERE siteid = ". _q($siteId) ."

				                UNION

				                SELECT
				                        cardpageId AS parent,
				                        cardpageId AS child,
				                        -1 AS `rank`
				                FROM rt_pagecategorymap
				                WHERE categoryId = ". _q($siteId) ."
				        ) AS subpage_heirarchy

				        INNER JOIN rt_cardpages AS sub_pages ON (sub_pages.cardpageId =
				subpage_heirarchy.child)
				        INNER JOIN rt_cardpages AS parent_pages ON (parent_pages.cardpageId =
				subpage_heirarchy.parent)
				        INNER JOIN ".self::getCardPageTableName($siteId)." AS page_map ON (page_map.cardpageId =
				subpage_heirarchy.child)
				        INNER JOIN rt_cards AS cards USING (cardId)
				        INNER JOIN rt_carddetails AS card_details USING (cardId)
				        INNER JOIN cs_carddata AS card_data USING (cardId)
						
						JOIN ccx_cms_map as map ON (map.cms_card_id = cards.cardId)
						JOIN cards as ccx  ON (map.ccx_card_id = ccx.card_id)
						LEFT JOIN balance_transfers as bt ON (map.ccx_card_id = bt.card_id)
						LEFT JOIN prepaid_card_fees as ppcf on ccx.card_id = ppcf.card_id

				WHERE
				        parent = ". _q($profilePageId) ."
				        AND cards.active = 1
				        AND cards.deleted != 1
				        AND card_details.cardDetailVersion = -1
				GROUP BY cardId
				ORDER BY
				        subpage_heirarchy.`rank`,
				        page_map.`rank`
						";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	function getPopularCardsByTags($categoryId1, $categoryId2, $categoryId3){
		$sql ="SELECT
				        `cards`.`cardId` ,
				        `cards`.`cardTitle` ,
				        `card_details`.`cardDetailText` ,
				        `cards`.`imagePath` ,
				        `cards`.`url` ,
				        `card_details`.`cardIntroDetail`,
				        `card_details`.`cardLink`,
				        DATE(`cards`.`dateCreated`) as dateCreated,
		                cards.active_introApr,
				        cards.active_balanceTransferIntroApr,
				        cards.active_balanceTransferFee,
				        cards.active_introAprPeriod,
				        cards.active_regularApr,
				        cards.active_annualFee,
				        cards.active_monthlyFee,
				        cards.active_balanceTransfers,
				        cards.active_balanceTransferIntroAprPeriod,
				        cards.active_creditNeeded,


				        REPLACE(cards.introApr, '@@introApr@@', card_data.introApr) AS
				introApr,
				        `card_data`.`introApr` AS q_introApr,
				        REPLACE(cards.regularApr, '@@regularApr@@', card_data.regularApr) AS
				regularApr,
				        `card_data`.regularApr AS q_regularApr ,
				        REPLACE(cards.introAprPeriod, '@@introAprPeriod@@',
				card_data.introAprPeriod) AS introAprPeriod,
				        `card_data`.introAprPeriod AS q_introAprPeriod ,
				        REPLACE(cards.annualFee, '@@annualFee@@', card_data.annualFee) AS
				annualFee,
				        `card_data`.annualFee AS q_annualFee ,
				        REPLACE(cards.monthlyFee, '@@monthlyFee@@', card_data.monthlyFee) AS
				monthlyFee,
				        `card_data`.monthlyFee AS q_monthlyFee ,
				        REPLACE(cards.balanceTransfers, '@@balanceTransfers@@',
				IF(card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransfers,
				        `card_data`.balanceTransfers AS q_balanceTransfers ,
				        REPLACE(cards.balanceTransfers, '@@balanceTransfers@@',
				IF(card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransferFee,
				        `card_data`.balanceTransferFee AS q_balanceTransferFee ,

				REPLACE(cards.balanceTransferIntroApr, '@@balanceTransferIntroApr@@', IF(card_data.balanceTransfers = 1 AND card_data.balanceTransferIntroApr != '999.00', card_data.balanceTransferIntroApr, 'N/A')) AS balanceTransferIntroApr,
				REPLACE(cards.balanceTransferIntroAprPeriod, '@@balanceTransferIntroAprPeriod@@', IF(card_data.balanceTransfers = 1 AND card_data.balanceTransferIntroApr != '999.00', card_data.balanceTransferIntroAprPeriod, 'N/A')) AS balanceTransferIntroAprPeriod,

					REPLACE(cards.creditNeeded, '@@creditNeeded@@', CASE card_data.creditNeeded

					WHEN 0 THEN 'No Credit Check'

					WHEN 1 THEN 'Bad Credit'

					WHEN 2 THEN 'Fair Credit'

					WHEN 3 THEN 'Good Credit'

					WHEN 4 THEN 'Excellent Credit'

     			END) AS creditNeeded,
				        `card_data`.creditNeeded AS `q_creditNeeded`
				FROM
				      	(
							SELECT
								card_id AS cardId
							FROM
								card_ranks
							WHERE
								card_category_id IN ($categoryId1, $categoryId2, $categoryId3)
				        ) AS card_categories
				        INNER JOIN rt_cards AS cards USING (cardId)
				        INNER JOIN rt_carddetails AS card_details USING (cardId)
				        INNER JOIN cs_carddata AS card_data USING (cardId)
				        INNER JOIN card_boost AS card_boost ON (card_data.cardId = card_boost.card_id)

				WHERE
				        cards.active = 1
				        AND cards.deleted != 1
				        AND card_details.cardDetailVersion = -1
				GROUP BY cardId
				ORDER BY
				        card_boost.boost DESC
						";

		//echo "<pre>".$sql."</pre><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		//echo "<br/>Dumping RS: (Site: $siteId) (Profile: $categorypageId)<br/>";
		//echo var_dump($rs);
		return $rs;
	}

	function getPopularCardsByCategoryAndSite($categorypageId1, $categorypageId2, $categorypageId3, $siteId){
		$sql ="SELECT
				        `cards`.`cardId` ,
				        `cards`.`cardTitle` ,
				        `card_details`.`cardDetailText` ,
				        `cards`.`imagePath` ,
				        `cards`.`url` ,
				        `card_details`.`cardIntroDetail`,
				        `card_details`.`cardLink`,
				        DATE(`cards`.`dateCreated`) as dateCreated,
		                cards.active_introApr,
				        cards.active_balanceTransferIntroApr,
				        cards.active_balanceTransferFee,
				        cards.active_introAprPeriod,
				        cards.active_regularApr,
				        cards.active_annualFee,
				        cards.active_monthlyFee,
				        cards.active_balanceTransfers,
				        cards.active_balanceTransferIntroAprPeriod,
				        cards.active_creditNeeded,


				        REPLACE(cards.introApr, '@@introApr@@', card_data.introApr) AS
				introApr,
				        `card_data`.`introApr` AS q_introApr,
				        REPLACE(cards.regularApr, '@@regularApr@@', card_data.regularApr) AS
				regularApr,
				        `card_data`.regularApr AS q_regularApr ,
				        REPLACE(cards.introAprPeriod, '@@introAprPeriod@@',
				card_data.introAprPeriod) AS introAprPeriod,
				        `card_data`.introAprPeriod AS q_introAprPeriod ,
				        REPLACE(cards.annualFee, '@@annualFee@@', card_data.annualFee) AS
				annualFee,
				        `card_data`.annualFee AS q_annualFee ,
				        REPLACE(cards.monthlyFee, '@@monthlyFee@@', card_data.monthlyFee) AS
				monthlyFee,
				        `card_data`.monthlyFee AS q_monthlyFee ,
				        REPLACE(cards.balanceTransfers, '@@balanceTransfers@@',
				IF(card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransfers,
				        `card_data`.balanceTransfers AS q_balanceTransfers ,
				        REPLACE(cards.balanceTransfers, '@@balanceTransfers@@',
				IF(card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransferFee,
				        `card_data`.balanceTransferFee AS q_balanceTransferFee ,

				REPLACE(cards.balanceTransferIntroApr, '@@balanceTransferIntroApr@@', IF(card_data.balanceTransfers = 1 AND card_data.balanceTransferIntroApr != '999.00', card_data.balanceTransferIntroApr, 'N/A')) AS balanceTransferIntroApr,
				REPLACE(cards.balanceTransferIntroAprPeriod, '@@balanceTransferIntroAprPeriod@@', IF(card_data.balanceTransfers = 1 AND card_data.balanceTransferIntroApr != '999.00', card_data.balanceTransferIntroAprPeriod, 'N/A')) AS balanceTransferIntroAprPeriod,

					REPLACE(cards.creditNeeded, '@@creditNeeded@@', CASE card_data.creditNeeded

					WHEN 0 THEN 'No Credit Check'

					WHEN 1 THEN 'Bad Credit'

					WHEN 2 THEN 'Fair Credit'

					WHEN 3 THEN 'Good Credit'

					WHEN 4 THEN 'Excellent Credit'

     			END) AS creditNeeded,
				        `card_data`.creditNeeded AS `q_creditNeeded`,
				subpage_heirarchy.`rank`,
				page_map.`rank`
				FROM
				        (
				                SELECT
				                        masterpageid AS parent,
				                        subpageid AS child, `rank` AS `rank`
				                FROM ".self::getPageSubPageTableName($siteId)."
				                WHERE siteid = ". _q($siteId) ."

				                UNION

				                SELECT
				                        cardpageId AS parent,
				                        cardpageId AS child,
				                        -1 AS `rank`
				                FROM rt_pagecategorymap
				                WHERE categoryId = ". _q($siteId) ."
				        ) AS subpage_heirarchy

				        INNER JOIN rt_cardpages AS sub_pages ON (sub_pages.cardpageId =
				subpage_heirarchy.child)
				        INNER JOIN rt_cardpages AS parent_pages ON (parent_pages.cardpageId =
				subpage_heirarchy.parent)
				        INNER JOIN ".self::getCardPageTableName($siteId)." AS page_map ON (page_map.cardpageId =
				subpage_heirarchy.child)
				        INNER JOIN rt_cards AS cards USING (cardId)
				        INNER JOIN rt_carddetails AS card_details USING (cardId)
				        INNER JOIN cs_carddata AS card_data USING (cardId)
				        INNER JOIN card_boost AS card_boost ON (card_data.cardId = card_boost.card_id)

				WHERE
				        (parent = ". _q($categorypageId1) ."
				        OR parent = ". _q($categorypageId2) ."
				        OR parent = ". _q($categorypageId3) .")
				        AND cards.active = 1
				        AND cards.deleted != 1
				        AND card_details.cardDetailVersion = -1
				GROUP BY cardId
				ORDER BY
				        card_boost.boost
						";

		//echo "<pre>".$sql."</pre><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		//echo "<br/>Dumping RS: (Site: $siteId) (Profile: $categorypageId)<br/>";
		//echo var_dump($rs);
		return $rs;
	}

	function getCardsByProfileId($profilePageId){
				$sql = 'SELECT c.*, cd.*, p.pageName, pd.pageLink, s.rank FROM specials_page_map as s
				JOIN rt_cardpages as p ON s.pageid=p.cardpageId
				JOIN rt_pagedetails as pd ON (p.cardpageId=pd.cardpageId)
				JOIN '.self::getCardPageTableName($siteId).' as cpm ON p.cardpageId=cpm.cardpageId
				JOIN rt_cards as c ON cpm.cardId=c.cardId
				JOIN rt_carddetails as cd ON c.cardId=cd.cardId
				WHERE s.specialspageid='._q($specialsPageId).'
				AND cpm.rank="1"
				AND p.deleted="0"
				AND pd.pageDetailVersion = IF((SELECT cardpageId FROM rt_pagedetails WHERE pageDetailVersion='._q($siteId).' AND cardpageId=p.cardpageId) IS NULL, "-1", '._q($siteId).')
				AND pd.deleted="0"
				AND c.deleted="0"
				AND cd.deleted="0"
				AND c.active="1"
				AND cd.active="1"
				AND cd.cardDetailVersion = IF((SELECT cardId FROM rt_carddetails WHERE cardDetailVersion='._q($siteId).' AND cardId=c.cardId) IS NULL, "-1", '._q($siteId).')
				ORDER BY rank ASC';

		//echo $sql."<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	/**
	* Get the profile data for a given profile id
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function updateProfile($profilePageId, $params){

		//Check if a profile with this Id exists already
		$sql = "SELECT profile_id FROM profiles_data WHERE profile_id = " . $profilePageId;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//If no records are returned for this profileId, create a new one
		if ($rs->EOF) {
			CMS_libs_Profiles::addProfile($profilePageId, $params);
		} else {

			//otherwise, Update record
			if(!is_array($params))
				return;
			$sql = "UPDATE profiles_data set ";
			foreach($params as $col=>$data) {
				$sql .= $col . " = " . _q($data) . ", ";
			}
			$sql .= " update_time = " . _q(date("Y-m-d H:i:s")). " WHERE profile_id = " . $profilePageId;
			//echo $sql;
			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		}
	}

	/**
	* Get the profile data for a given profile id
	* @author Jason Huie
	* @version 1.0
	* @param int Site ID
	* @return ResultSet
	* @static
	*/
	function addProfile($profilePageId, $params){
		$sql = "INSERT INTO profiles_data ";

		$columns = '';
		$values = '';
		foreach($params as $col=>$data){
			$columns .= $col . ', ';
			$values .= _q($data). ', ';
		}
		$sql .= '(' . $columns . 'insert_time, profile_id) VALUES (';
		$sql .= $values . _q(date("Y-m-d H:i:s")) . ', ' . $profilePageId . ')';

		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	function removeProfileById($profilePageId) {
		$sql = "DELETE FROM profiles_data WHERE profile_id = " . $profilePageId;
		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}
	
	/**
	 * Gets the appropriate cardpage table name for a given SQL statement.
	 * @param int $siteId
	 */
	private static function getCardPageTableName($siteId) {
		//If site id is equal to CCCOM_MOBILE, which is id 47, use this table.
		if ($siteId == 47) {
			return 'rt_cardpagemap_mobile ';
		} else { //use this table for all others
			return 'rt_cardpagemap ';
		}
	}

	/**
	 * Gets the appropriate pagesubpage table name for a given SQL statement.
	 * @param int $siteId
	 */
	private static function getPageSubPageTableName($siteId) {
		//If site id is equal to CCCOM_MOBILE, which is id 47, use this table.
		if ($siteId == 47) {
			return 'rt_pagesubpagemap_mobile ';
		} else { //use this table for all others
			return 'rt_pagesubpagemap ';
		}
	}

}
?>