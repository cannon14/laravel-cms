<?php

/**
 *
 * ClickSuccess, L.P.
 * March 28, 2006
 *
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 *
 * @package CMS_Lib
 */
class CMS_libs_Cards {

	var $property;

	/**
	 * Insert card data into the cs_cardhistory to track changes in card rates, etc.
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @static
	 */
	function addHistory($id) {

		$sql = 'SELECT * FROM cs_carddata WHERE cardId = ' . _q($id);
		//echo $sql . '<br />';

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$params = $rs->fields;


		$date = date('Y-m-d h:i:s');
		$sql = 'INSERT INTO cs_cardhistory ';
		$sql .= '(cardid, introApr, introAprPeriod, regularApr, monthlyFee, annualFee, date)';
		$sql .= ' VALUES ';
		$sql .= '(' . _q($params['cardId']) . ', ' . _q($params['introApr']) . ', ' . _q($params['introAprPeriod']) . ', ' . _q($params['regularApr']) . ', ' . _q($params['monthlyFee']) . ', ' . _q($params['annualFee']) . ', ' . _q($date) . ')';

		//echo $sql . '<br/>';

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	/**
	 * Select all the sites that do not have a specific version of the card
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @return ResultSet sites
	 * @static
	 */
	function getUnusedVersions($cardId) {
		$sql = "SELECT * FROM rt_sites
				WHERE siteId NOT IN (
					SELECT cardDetailVersion
					FROM rt_carddetails
					WHERE cardId = " . _q($cardId) . ")
				AND deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	/**
	 * Change a card's active field to active in the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int 1/0 if Active/Inactive
	 * @param int Card ID
	 * @static
	 */
	function activate($value, $id) {
		$sql = "UPDATE rt_cards set active = " . _q($value) . " where id=" . _q($id);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	/**
	 * Get a card's data by its id number
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param Card ID
	 * @return ResultSet card data
	 * @static
	 */
	function getCard($id) {
		$sql = "SELECT c.*, d.introApr as d_introApr, d.introAprPeriod as d_introAprPeriod,
				d.regularApr as d_regularApr, d.creditNeeded as d_creditNeeded, d.monthlyFee as d_monthlyFee,
				d.annualFee as d_annualFee, d.balanceTransfers
				as d_balanceTransfers, d.balanceTransferIntroApr as d_balanceTransferIntroApr,
				d.balanceTransferIntroAprPeriod as d_balanceTransferIntroAprPeriod, d.balanceTransferFee as d_balanceTransferFee
				FROM cs_carddata as d, rt_cards as c
				WHERE id = " . _q($id) . "
				AND	c.cardId = d.cardId
				AND c.deleted != 1";
		//echo $sql . "<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Get the details of a card by its id number
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param id Card ID
	 * @return ResultSet card version data
	 * @static
	 */
	function getVersion($id) {
		$sql = "SELECT *
				FROM rt_carddetails
				WHERE id = " . _q($id) . "
				AND deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	/**
	 * Get the default details for a card
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @return ResultSet default version data
	 * @static
	 */
	function getDefaultVersion($cardpageId) {
		$sql = "SELECT *
				FROM rt_cards as c, rt_carddetails as d
				WHERE c.cardId = d.cardId
				AND c.id = " . _q($cardpageId) . "
				AND d.cardDetailVersion = -1";
		//echo $sql;
		return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	/**
	 * Get the data for all cards in the database
	 * @author Patrick Mizer
	 * @version 1.0
	 * @return Array all card's data
	 * @static
	 */
	function getAllCards() {
		$siteArray = array();
		$sql = "SELECT *
				FROM rt_cards as c
				LEFT JOIN cs_carddata as cd USING (cardId)
				WHERE deleted != 1
				ORDER BY c.cardTitle";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while (!$rs->EOF) {
			$siteArray[] = $rs->fields;
			$rs->MoveNext();
		}

		return $siteArray;
	}

	/**
	 * Delete all the cards defined in an array of ids
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array array of Card IDs
	 * @static
	 */
	function deleteCards($ids) {
		$sql = 'UPDATE rt_cards SET deleted = 1 WHERE cardId IN ' . $ids;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Deleted Cards: $ids<br>SQL: $sql");

		if (!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

		$versionSQL = 'UPDATE rt_carddetails SET deleted = 1 WHERE cardId in ' . $ids;
		// echo $versionSQL;
		$rs = _sqlQuery($versionSQL, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

		$pagemapSQL = 'DELETE FROM ' . self::getCardPageTableName($siteId) . ' WHERE cardId IN ' . $ids;
		$rs = _sqlQuery($versionSQL, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

		$cardrankSQL = 'DELETE FROM card_ranks WHERE card_id IN ' . $ids;
		$rs = _sqlQuery($versionSQL, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

		$cardXSQL = 'DELETE FROM cs_pagecardexclusionmap WHERE cardid IN ' . $ids;
		$rs = _sqlQuery($versionSQL, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}
	}

	/**
	 * Update a card's information
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateCard($id, $params) {
		if (!is_array($params))
			return;

		$sql = "UPDATE rt_cards SET ";

		foreach ($params as $col => $data) {
			$sql .= $col . " = " . _q($data) . ", ";
		}

		$sql .= " dateUpdated = " . _q(date("Y-m-d H:i:s")) . " WHERE cardId = " . _q($id);
		//QUnit_Messager::setErrorMessage($sql);
		//echo $sql.'<br>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Edited Card: $id<br>SQL: $sql");
	}

	/**
	 * Update a card's data
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateCardData($id, $params) {
		if (!is_array($params))
			return;
		$sql = "UPDATE cs_carddata SET ";
		foreach ($params as $col => $data) {
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .= " dateModified = " . _q(date("Y-m-d H:i:s")) . " WHERE cardId = " . _q($id);
		//QUnit_Messager::setErrorMessage($sql);
		//echo "SQL " . $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Edited Card: $id<br>SQL: $sql");
		//CMS_libs_Cards::addHistory($id);
	}

	/**
	 * Update a card's version data from an associated array of parameters
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function updateVersion($id, $params) {
		if (!is_array($params))
			return;
		$sql = "UPDATE rt_carddetails SET ";
		foreach ($params as $col => $data) {
			$sql .= $col . " = " . _q($data) . ", ";
		}
		$sql .= " dateUpdated = " . _q(date("Y-m-d H:i:s")) . " WHERE id = " . _q($id);
		//echo $sql;
		//QUnit_Messager::setErrorMessage($sql);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Edited Card Version: $id<br>SQL: $sql");

		CMS_libs_Cards::writeSiteCatalystDefaults($id, $params['cardLink']);

		CMS_libs_History::write($this->auth->username, "Edited SiteCatalyst data for Version: " . $id . "<br>SQL: $sql");
	}

	/**
	 * Add a card into the database and its data into the card data table
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Associative array (fieldName=>value)
	 * @static
	 * */
	function addCard($params) {

		$sql = "SELECT id, deleted FROM rt_cards WHERE id = " . _q($params['cardId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		if ($rs->fields['id'] == $params['cardId'] && $params['subCat'] != 1) {
			if ($rs->fields['deleted'] == 1) {
				$sql = "DELETE FROM rt_cards WHERE id = " . _q($rs->fields['id']);
				_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
				$sql = "DELETE FROM rt_carddetails WHERE cardId = " . _q($rs->fields['id']);
				_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
				$sql = "DELETE FROM cs_carddata WHERE cardId = " . _q($rs->fields['id']);
				_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
				_setMessage("Deleting card.");
			} else {
				_setMessage("The ID " . $params['cardId'] . " already exists.", true);
				return;
			}
		}

		$params['id'] = $params['cardId'];
		$sqlParams = "'" . implode("','", $params) . "'";
		foreach ($params as $col => $value) {
			$cols[] = $col;
		}

		$sqlCols = implode(",", $cols);

		$sql = "INSERT INTO rt_cards ( " . $sqlCols . ", dateCreated, dateUpdated) " .
			" VALUES (" . $sqlParams . ", " . _q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) . ")";

		//_printR($sql);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$sql = "INSERT INTO cs_carddata ( cardId) VALUES ('" . $params['id'] . "')";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Added Cards: " . $params['id'] . "<br>SQL: $sql");

		return;
	}

	function mapToCcx($params) {
		$sql = 'INSERT INTO ccx_cms_map
					(cms_card_id, ccx_card_id)
				VALUES
					(' . _q($params['cms_card_id']) . ', ' . _q($params['ccx_card_id']) . ')';
		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	/**
	 * Create an entry in the version table for a card from an associated array of parameters
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function addVersion($params) {
		$sql = "SELECT cardId FROM rt_carddetails WHERE cardId = " . _q($params['cardId']) . " AND cardDetailVersion = " . _q($params['cardDetailVersion']);
		//		print $sql.'<hr>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		if ($rs->fields['cardId'] == $params['cardId']) {
			QUnit_Messager::setErrorMessage("The ID " . $params['cardId'] . " already exists, can not instanciate version.");
			return;
		}


		$sql = "SELECT siteName FROM rt_sites WHERE siteId = " . _q($params['cardDetailVersion']);
		//		print $sql.'<hr>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$params['cardDetailLabel'] = $rs->fields['siteName'];


		$sql = "SELECT cardDetailText FROM rt_carddetails WHERE cardDetailVersion = -1 AND cardId = " . _q($params['cardId']);
		//		print $sql.'<hr>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$params['cardDetailText'] = addslashes($rs->fields['cardDetailText']);

		$sqlParams = "'" . implode("','", $params) . "'";
		foreach ($params as $col => $value) {
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);

		$sql = "INSERT INTO rt_carddetails ( " . $sqlCols . ", dateCreated, dateUpdated) " .
			" VALUES (" . $sqlParams . ", " . _q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) . ")";

		//		echo $sql . '<hr>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		//log action
		CMS_libs_History::write($this->auth->username, "Added Card Version: " . $params['cardId'] . "<br>SQL: $sql");

		// get the detail version we just inserted
		$sql = "select id, cardLink from rt_carddetails where cardId = " . _q($params['cardId']) . " and cardDetailVersion = '" . $params['cardDetailVersion'] . "'";
		//      echo $sql.'<hr>';

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$detailId = $rs->fields['id'];
		$cardLink = $rs->fields['cardLink'];

		CMS_libs_Cards::writeSiteCatalystDefaults($detailId, $cardLink);

		CMS_libs_History::write($this->auth->username, "Added SiteCatalyst data for Version: " . $params['cardId'] . "<br>SQL: $sql");
	}

	/**
	 * Add a default version for a card from its id and associated array of values<br>
	 * This function should only be called when the card is created.
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @param array Associative array (fieldName=>value)
	 * @static
	 */
	function addDefaultVersion($cardId, $params) {
		$sql = "SELECT cardId FROM rt_carddetails WHERE cardId = " . _q($cardId) . " AND cardDetailVersion = -1";
		//echo $sql . "<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		if ($rs->fields['cardId'] == $cardId) {
			_setMessage("The ID " . $params['cardId'] . " already exists, can not instanciate version.", true);
			return;
		}

		$sqlParams = "'" . implode("','", $params) . "'";
		foreach ($params as $col => $value) {
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);

		$sql = "INSERT INTO rt_carddetails ( " . $sqlCols . ", dateCreated, dateUpdated, cardDetailVersion, cardDetailLabel, cardId) " .
			" VALUES (" . $sqlParams . ", " . _q(date("Y-m-d H:i:s")) . ", " . _q(date("Y-m-d H:i:s")) . ", '-1', 'Default', " . _q($cardId) . ")";

		//echo $sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		// get the detail version we just inserted
		$sql = "select id, cardLink from rt_carddetails where cardId = " . _q($cardId) . " and cardDetailVersion = -1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$detailId = $rs->fields['id'];
		$cardLink = $rs->fields['cardLink'];

		CMS_libs_Cards::writeSiteCatalystDefaults($detailId, $cardLink);

		CMS_libs_History::write($this->auth->username, "Added SiteCatalyst data for Version: " . $params['cardId'] . "<br>SQL: $sql");
	}

	/**
	 * Reorder the sites
	 * @author Patrick Mizer
	 * @version 1.0
	 * @static
	 */
	function reOrder() {
		$sql = "SELECT * FROM rt_sites WHERE deleted != 1 ORDER BY rt_sites.order";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$count = 1;
		while (!$rs->EOF) {
			$sql = "UPDATE rt_sites set rt_sites.order= " . _q($count) . " WHERE siteId =" . _q($rs->fields['siteId']);
			_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			$count ++;
			$rs->MoveNext();
		}
	}

	/**
	 * Get all cards that belong to a site<br>
	 * This function will select the default version of the card unless a site specific version is defined
	 * @author Jason Huie
	 * @version 2.0
	 * @param int Page ID
	 * @param int Site ID
	 * @result ResultSet all cards associated with a page (with correct versions)
	 * @static
	 */
	function getCardsByPage($pageId, $siteId) {
		$sql = "";

		//print'<pre>';print_r($sql);print'</pre>';
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		return $rs;
	}

	function getCardByIdAndSite($cardId, $siteId) {
		$sql = <<<SQL
SELECT
	c.cardId,
	c.site_code,
	c.cardTitle,
	c.cardDescription,
	c.merchant,
	c.introApr,
	c.active_introApr,
	c.introAprPeriod,
	c.active_introAprPeriod,
	c.regularApr,
	c.active_regularApr,
	c.variable,
	c.annualFee,
	c.active_annualFee,
	c.monthlyFee,
	c.active_monthlyFee,
	c.balanceTransfers,
	c.active_balanceTransfers,
	c.balanceTransferFee,
	c.active_balanceTransferFee,
	c.balanceTransferIntroApr,
	c.active_balanceTransferIntroApr,
	c.balanceTransferIntroAprPeriod,
	c.active_balanceTransferIntroAprPeriod,
	c.creditNeeded,
	c.active_creditNeeded,
	c.imagePath,
	c.url,
	c.applyByPhoneNumber,
	c.active,
	c.active_epd_pages,
	c.active_show_epd_rates,
	c.show_verify,
	c.suppress_mobile,
	cd.id,
	cd.cardLink,
	cd.appLink,
	cd.cardPageMeta,
	cd.cardDetailText,
	cd.cardIntroDetail,
	REPLACE(cd.cardMoreDetail, "@@regularApr@@", cdat.regularApr) AS cardMoreDetail,
	cd.cardSeeDetails,
	cd.categoryImage,
	cd.categoryAltText,
	cd.cardIOImage,
	cd.cardIOAltText,
	cd.cardButtonImage,
	cd.cardButtonAltText,
	cd.cardIOButtonAltText,
	cd.fid,
	cd.cardListingString,
	cd.cardPageHeaderString,
	cd.imageAltText,
	cd.specialsDescription,
	cd.specialsAdditionalLink,
	cd.cardTeaserText,
	merch.merchantname,
	merch.merchantcardpage,
	merch.category_id
FROM
	rt_cards as c
	JOIN rt_carddetails as cd USING (cardId)
	JOIN cs_merchants as merch ON c.merchant=merch.merchantid
	JOIN cs_carddata as cdat USING (cardId)
WHERE
	c.cardId = '$cardId'
	AND c.deleted="0"
	AND cd.cardDetailVersion = IF( (
			SELECT
				cardId
			FROM
				rt_carddetails
			WHERE
				cardDetailVersion='$siteId'
			AND cardId=c.cardId
			AND deleted=0
		) IS NULL, "-1", '$siteId')
SQL;

		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		return $rs;
	}

	function getCardsBySite($siteId, $orderby = 'ORDER BY cardpageId, rank ASC') {
		// echo 'site id is '.$siteId;

		$sql = 'SELECT


	c.cardId,
	c.site_code,
	c.cardTitle,
	c.cardDescription,
	c.merchant,
	c.introApr,
	c.active_introApr,
	c.introAprPeriod,
	ccx.intro_apr as ccx_intro_apr,
	ccx.min_intro_period as ccx_min_intro_period,
	ccx.max_intro_period as ccx_max_intro_period,
	ccx.intro_period_end_date as ccx_intro_period_end_date,
	ccx.min_ongoing_apr as ccx_min_ongoing_apr,
	ccx.max_ongoing_apr as ccx_max_ongoing_apr,
	ccx.min_ongoing_apr_used_rate_type as ccx_used_rate_type,
	c.active_introAprPeriod,
	c.regularApr,
	ccx.min_ongoing_apr,
	ccx.max_ongoing_apr,
	ccx.min_ongoing_apr_used_rate_type,
	c.active_regularApr,
	c.variable,
	c.annualFee,
	c.active_annualFee,
	c.monthlyFee,
	c.active_monthlyFee,
	c.balanceTransfers,
	c.active_balanceTransfers,
	c.balanceTransferFee,
	c.active_balanceTransferFee,
	c.balanceTransferIntroApr,
	c.active_balanceTransferIntroApr,
	c.balanceTransferIntroAprPeriod,
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
	bt.min_ongoing_apr_used_rate_type as ccx_bt_used_rate_type,
	bt.fee_rate as ccx_bt_fee_rate,
	c.active_balanceTransferIntroAprPeriod,
	c.creditNeeded,
	c.active_creditNeeded,
	c.imagePath,
	c.url,
	c.applyByPhoneNumber,
	c.active,
	c.active_epd_pages,
	c.active_show_epd_rates,
	c.show_verify,
	c.suppress_mobile,
	cd.id,
	cd.cardLink,
	cd.appLink,
	cd.cardPageMeta,
	cd.cardDetailText,
	cd.cardIntroDetail,
	REPLACE(cd.cardMoreDetail, "@@regularApr@@", cdat.regularApr) AS cardMoreDetail,
	cd.cardSeeDetails,
	cd.categoryImage,
	cd.categoryAltText,
	cd.cardIOImage,
	cd.cardIOAltText,
	cd.cardButtonImage,
	cd.cardButtonAltText,
	cd.cardIOButtonAltText,
	cd.fid,
	cd.cardListingString,
	cd.cardPageHeaderString,
	cd.imageAltText,
	cd.specialsDescription,
	cd.specialsAdditionalLink,
	cd.cardTeaserText,
	merch.merchantname,
	merch.merchantcardpage,
	merch.category_id,
	cpm.cardpageId,
	cpm.rank,
	ccx.type,
	ccx.custom_prepaid_display_text,
	ppcf.replacement_card_fee,
	ppcf.atm_fee,
	ppcf.live_teller_withdrawal_fee,
	ppcf.atm_balance_inquiry_fee,
	ppcf.monthly_inactive_account_fee,
	ppcf.automated_telephone_inquiry_fee,
	ppcf.customer_service_live_call_fee,
	ppcf.activation_fee,
	ppcf.cancel_card_fee,
	ppcf.application_fee,
	ppcf.purchase_merchant_fee,
	ppcf.purchase_online_fee,
	ppcf.purchase_telephone_fee,
	ppcf.signature_transaction_fee,
	ppcf.pin_transaction_fee,
	ppcf.load_fee,
	terms_mobile.url AS terms_mobile_url
FROM
	rt_cards as c
	JOIN ' . self::getCardPageTableName($siteId) . ' as cpm USING (cardId)
	JOIN rt_carddetails as cd USING (cardId)
	JOIN cs_merchants as merch ON c.merchant=merch.merchantid
	JOIN cs_carddata as cdat USING (cardId)
	JOIN ccx_cms_map as map ON (map.cms_card_id = c.cardId)
	JOIN cards as ccx  ON (map.ccx_card_id = ccx.card_id)
	LEFT JOIN balance_transfers as bt ON (map.ccx_card_id = bt.card_id)
	LEFT JOIN prepaid_card_fees as ppcf on ccx.card_id = ppcf.card_id
	LEFT JOIN product_links AS terms_mobile ON terms_mobile.product_id = c.cardId AND terms_mobile.`link_type_id` = 4 AND terms_mobile.`device_type_id` = 2
WHERE
	c.deleted="0"
	AND cd.cardDetailVersion = IF( (
			SELECT
				cardId
			FROM
				rt_carddetails
			WHERE
				cardDetailVersion=' . _q($siteId) . '
			AND cardId=c.cardId
			AND deleted=0
		) IS NULL, "-1", ' . _q($siteId) . ')
	AND c.cardId NOT IN (
		SELECT
			cardid
		FROM
			cs_pagecardexclusionmap as ex
		WHERE
			ex.siteid = ' . _q($siteId) . '
			AND (pageid = cpm.cardpageId or pageid=-1)
	)';

		$rs = _sqlQuery($sql . $orderby, __LINE__, __FILE__);
		return $rs;
	}

	function getOrphanedCardsBySite($siteId) {
		// 24-Jan-2011 - michaelg - Updating SQL so that cards which have been
		// excluded from the site are not returned as orphaned cards.
		$sql = 'SELECT
	c.cardId,
	c.site_code,
	c.cardTitle,
	c.cardDescription,
	c.merchant,
	c.introApr,
	c.active_introApr,
	c.introAprPeriod,
	c.active_introAprPeriod,
	c.regularApr,
	c.active_regularApr,
	c.variable,
	c.annualFee,
	c.active_annualFee,
	c.monthlyFee,
	c.active_monthlyFee,
	c.balanceTransfers,
	c.active_balanceTransfers,
	c.balanceTransferFee,
	c.active_balanceTransferFee,
	c.balanceTransferIntroApr,
	c.active_balanceTransferIntroApr,
	c.balanceTransferIntroAprPeriod,
	c.active_balanceTransferIntroAprPeriod,
	c.creditNeeded,
	c.active_creditNeeded,
	c.imagePath,
	c.url,
	c.applyByPhoneNumber,
	c.active,
	c.active_epd_pages,
	c.active_show_epd_rates,
	c.show_verify,
	c.suppress_mobile,
	cd.id,
	cd.cardLink,
	cd.appLink,
	cd.cardPageMeta,
	cd.cardDetailText,
	cd.cardIntroDetail,
	REPLACE(cd.cardMoreDetail, "@@regularApr@@", cdat.regularApr) AS cardMoreDetail,
	cd.cardSeeDetails,
	cd.categoryImage,
	cd.categoryAltText,
	cd.cardIOImage,
	cd.cardIOAltText,
	cd.cardButtonImage,
	cd.cardButtonAltText,
	cd.cardIOButtonAltText,
	cd.fid,
	cd.cardListingString,
	cd.cardPageHeaderString,
	cd.imageAltText,
	cd.specialsDescription,
	cd.specialsAdditionalLink,
	cd.cardTeaserText,
	merch.merchantname,
	merch.merchantcardpage,
	merch.category_id,
	cpm.cardpageId,
	cpm.rank,
	GROUP_CONCAT(DISTINCT rt_cp.pageName) AS card_categories,
	terms_mobile.url AS terms_mobile_url
FROM
	rt_cards as c
	LEFT JOIN ' . self::getCardPageTableName($siteId) . ' as cpm USING (cardId)
	JOIN rt_carddetails as cd USING (cardId)
	JOIN cs_merchants as merch ON c.merchant=merch.merchantid
	JOIN cs_carddata as cdat USING (cardId)
	JOIN site_card_map as map ON (c.cardId = map.card_id AND map.site_id=' . _q($siteId) . ')
	LEFT JOIN rt_cardpages AS rt_cp ON cpm.cardpageId = rt_cp.cardpageId
	LEFT JOIN product_links AS terms_mobile ON terms_mobile.product_id = c.cardId AND terms_mobile.`link_type_id` = 4 AND terms_mobile.`device_type_id` = 2
WHERE
	c.deleted="0"
AND
	c.active = "1"
AND cd.cardDetailVersion = IF( (
			SELECT
				cardId
			FROM
				rt_carddetails
			WHERE
				cardDetailVersion=' . _q($siteId) . '
			AND cardId=c.cardId
			AND deleted=0
		) IS NULL, "-1", ' . _q($siteId) . ')
AND
	cpm.cardpageId IS NULL
AND
	c.cardId NOT IN (
		SELECT
			cardid
		FROM
			cs_pagecardexclusionmap as ex
		WHERE
			ex.siteid = ' . _q($siteId) . '
			AND pageid = -1
	)
GROUP BY c.cardId, cpm.cardpageId';

		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		return $rs;
	}

    /**
     * Get the list of card categories associated with a card ID
     *
     * @param int Card ID
     * @return ResultSet quantitive card data
     * @static
     */
    function getCategoryListByCardId($id) {

        $sql = 'SELECT c.`cardId`, GROUP_CONCAT(DISTINCT rt_cp.pageName) AS card_categories
	              FROM rt_cards AS c
	              LEFT JOIN rt_cardpagemap AS cpm USING (cardId)
	              LEFT JOIN rt_cardpages AS rt_cp ON cpm.`cardpageId` = rt_cp.`cardpageId`
	            WHERE c.`cardId` = ' . _q($id) . '
                GROUP BY c.`cardId`';

        $rs = _sqlQuery($sql, __LINE__, __FILE__);
        return $rs;
    }

	/**
	 * Get the numerical data for a card
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param int Card ID
	 * @return ResultSet quantitive card data
	 * @static
	 */
	function getQuantitativeData($id) {
		$sql = "SELECT * FROM cs_carddata WHERE cardid = " . _q($id);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs->fields;
	}

	/**
	 * Get all the cards that have been excluded from a site<br>
	 * Exclusion refers to a card that has been added to the site but is not being shown via the CMS exclusion UI
	 * @author Jason Huie
	 * @version 1.0
	 * @param int Site ID
	 * @param int Page ID
	 * @return ResultSet excluded cards
	 * @static
	 */
	function getExcludedBySiteAndPage($site, $page) {
		$sql = "SELECT * FROM
				cs_pagecardexclusionmap	WHERE siteid = " . $site .
			" AND (pageid = " . $page . " or pageid=-1)";
		//echo "getExcludedCards: ".$sql ."<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		return $rs;
	}

	/**
	 * Get all site codes for site code select list
	 * @author mz
	 * @version 1.0
	 * @return ResultSet site codes (id and label)
	 * @static
	 */
	function getSiteCodes() {
		$sql = 'select site_code, site_description from site_codes order by site_description';

		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		return $rs;
	}

	/**
	 * Get the link (if available) to a card's Terms And Conditions
	 *
	 * @param string $cardId
	 */
	function getTermsAndConditionsLink($cardId) {
		$sql = '
SELECT url, affiliate_id, website_id
FROM alternate_links
WHERE
affiliate_id = '
			. _q(ALTERNATE_LINK_TERMS_SENTINEL_AID_VALUE) . '
AND website_id = ' .
			ALTERNATE_LINK_TERMS_SENTINEL_WEBSITEID_VALUE . '
AND
	clickable_id
	= ' .
			_q($cardId) . '
LIMIT 1'
		;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

// function getTermsAndConditionsLink

	/**
	 * Get Extended card data (card data + CCX card data)
	 *
	 * @param string $cardId
	 * @param int $siteId
	 */
	function getExtendedCard($cardId, $siteId = -1) {
		$sql = '
SELECT
	c.*,
	cd.*,
	cdata.*,    ccx.card_id as ccx_card_id,
	ccx.card_sku as ccx_card_sku,
	ccx.issuer as ccx_issuer,
	ccx.effective_date as ccx_effective_date,
	ccx.status as ccx_status,
	ccx.type as ccx_type,
	ccx.image as ccx_image,
	ccx.coissuing_organization as ccx_coissuing_organization,
	ccx.network as ccx_network,
	ccx.title as ccx_title,
	ccx.category as ccx_category,
	ccx.color as ccx_color,
	ccx.initial_setup_fee as ccx_initial_setup_fee,
	ccx.first_annual_fee as ccx_annual_fee,
	ccx.ongoing_annual_fee as ccx_ongoing_annual_fee,
	ccx.annual_fee_display_text as ccx_annual_fee_display_text,
	ccx.monthly_fee as ccx_monthly_fee,
	ccx.min_late_payment_fee as ccx_min_late_payment_fee,
	ccx.max_late_payment_fee as ccx_max_late_payment_fee,
	ccx.late_payment_fee_percent as ccx_late_payment_fee_percent,
	ccx.over_limit_fee as ccx_over_limit_fee,
	ccx.returned_payment_fee as ccx_returned_payment_fee,
	ccx.dishonored_convenience_check_fee as ccx_dishonored_convenience_check_fee,
	ccx.convenience_check_stop_payment_fee as ccx_convenience_check_stop_payment_fee,
	ccx.balance_transfer_cancellation_fee as ccx_balance_transfer_cancellation_fee,
	ccx.bank_wire_payment_fee as ccx_bank_wire_payment_fee,
	ccx.statement_copy_fee as ccx_statement_copy_fee,
	ccx.intro_apr as ccx_intro_apr,
	ccx.intro_apr_display_text as ccx_intro_apr_display_text,
	ccx.min_intro_period as ccx_min_intro_period,
	ccx.max_intro_period as ccx_max_intro_period,
	ccx.intro_period_display_text as ccx_intro_period_display_text,
	ccx.intro_period_end_date as ccx_intro_period_end_date,
	ccx.min_ongoing_apr as ccx_min_ongoing_apr,
	ccx.max_ongoing_apr as ccx_max_ongoing_apr,
	ccx.ongoing_apr_display_text as ccx_ongoing_apr_display_text,
	ccx.min_default_apr as ccx_min_default_apr,
	ccx.max_default_apr as ccx_max_default_apr,
	ccx.min_ongoing_apr_used_rate_type as ccx_used_rate_type,
	ccx.min_grace_period as ccx_min_grace_period,
	ccx.min_finance_charge as ccx_min_finance_charge,
	ccx.min_fixed_rate_period as ccx_min_fixed_rate_period,
	ccx.balance_compute_method as ccx_balance_compute_method,
	ccx.min_payment_amount as ccx_min_payment_amount,
	ccx.min_payment_percentage as ccx_min_payment_percentage,
	ccx.credit_needed as ccx_credit_needed,
	ccx.min_credit_line as ccx_min_credit_line,
	ccx.max_credit_line as ccx_max_credit_line,
	ccx.min_income as ccx_min_income,
	ccx.min_between_applications_period as ccx_min_between_applications_period,
	ccx.interest_rate_type as ccx_interest_rate_type,
	ccx.used_index_rate as ccx_used_index_rate,
	ccx.index_rate_definition as ccx_index_rate_definition,
	ccx.apply_payment as ccx_apply_payment,
	ccx.foreign_exchange_min_fee as ccx_foreign_exchange_min_fee,
	ccx.foreign_exchange_max_fee as ccx_foreign_exchange_max_fee,
	ccx.foreign_exchange_fee_rate as ccx_foreign_exchange_fee_rate,
	ccx.custom_prepaid_display_text as ccx_custom_prepaid_display_text,
	ccx.modified_date as ccx_modified_date,
	ccx.deleted as ccx_deleted,
	ccx_bt.card_id as ccx_bt_card_id,
	ccx_bt.accept_partial_balance_transfer as ccx_bt_accept_partial_balance_transfer,
	ccx_bt.intro_apr as ccx_bt_intro_apr,
	ccx_bt.min_intro_period as ccx_bt_min_intro_period,
	ccx_bt.max_intro_period as ccx_bt_max_intro_period,
	ccx_bt.intro_period_end_date as ccx_bt_intro_period_end_date,
	ccx_bt.min_ongoing_apr as ccx_bt_min_ongoing_apr,
	ccx_bt.max_ongoing_apr as ccx_bt_max_ongoing_apr,
	ccx_bt.min_default_apr as ccx_bt_min_default_apr,
	ccx_bt.max_default_apr as ccx_bt_max_default_apr,
	ccx_bt.min_ongoing_apr_used_rate_type as ccx_bt_used_rate_type,
	ccx_bt.min_grace_period as ccx_bt_min_grace_period,
	ccx_bt.min_finance_charge as ccx_bt_min_finance_charge,
	ccx_bt.min_fixed_rate_period as ccx_bt_min_fixed_rate_period,
	ccx_bt.min_fee as ccx_bt_min_fee,
	ccx_bt.max_fee as ccx_bt_max_fee,
	ccx_bt.fee_rate as ccx_bt_fee_rate,
	ccx_bt.min_transfer_amount as ccx_bt_min_transfer_amount,
	ccx_bt.max_transfer_amount as ccx_bt_max_transfer_amount,
	ccx_bt.min_payment_amount as ccx_bt_min_payment_amount,
	ccx_bt.min_payment_percentage as ccx_bt_min_payment_percentage,
	ccx_bt.display_text as ccx_bt_display_text,
	ccx_ca.card_id as ccx_ca_card_id,
	ccx_ca.intro_apr as ccx_ca_intro_apr,
	ccx_ca.min_intro_period as ccx_ca_min_intro_period,
	ccx_ca.max_intro_period as ccx_ca_max_intro_period,
	ccx_ca.intro_period_end_date as ccx_ca_intro_period_end_date,
	ccx_ca.min_ongoing_apr as ccx_ca_min_ongoing_apr,
	ccx_ca.max_ongoing_apr as ccx_ca_max_ongoing_apr,
	ccx_ca.min_default_apr as ccx_ca_min_default_apr,
	ccx_ca.max_default_apr as ccx_ca_max_default_apr,
	ccx_ca.min_ongoing_apr_used_rate_type as ccx_ca_used_rate_type,
	ccx_ca.min_grace_period as ccx_ca_min_grace_period,
	ccx_ca.min_finance_charge as ccx_ca_min_finance_charge,
	ccx_ca.min_fixed_rate_period as ccx_ca_min_fixed_rate_period,
	ccx_ca.min_fee as ccx_ca_min_fee,
	ccx_ca.max_fee as ccx_ca_max_fee,
	ccx_ca.fee_rate as ccx_ca_fee_rate,
	ccx_ca.max_convenience_check_fee as ccx_ca_max_convenience_check_fee,
	ccx_ca.min_payment_amount as ccx_ca_min_payment_amount,
	ccx_ca.min_payment_percentage as ccx_ca_min_payment_percentage,
	ccx_ca.cash_advance_limit as ccx_ca_cash_advance_limit,
	ccx_cb.card_id as ccx_cb_card_id,
	ccx_cb.base_reward_amount as ccx_cb_base_reward_amount,
	ccx_cb.special_reward_amount as ccx_cb_special_reward_amount,
	ccx_cb.special_reward_description as ccx_cb_special_reward_description,
	ccx_cb.first_round_bonus as ccx_cb_first_round_bonus,
	ccx_cb.annual_bonus as ccx_cb_annual_bonus,
	ccx_cb.other_bonus as ccx_cb_other_bonus,
	ccx_cb.intro_reward_period as ccx_cb_intro_reward_period,
	ccx_cb.intro_reward_amount as ccx_cb_intro_reward_amount,
	ccx_cb.intro_special_reward_amount as ccx_cb_intro_special_reward_amount,
	ccx_cb.max_annual_reward as ccx_cb_max_annual_reward,
	ccx_ff.card_id as ccx_ff_card_id,
	ccx_ff.base_reward_amount as ccx_ff_base_reward_amount,
	ccx_ff.special_reward_amount as ccx_ff_special_reward_amount,
	ccx_ff.special_reward_description as ccx_ff_special_reward_description,
	ccx_ff.which_airlines as ccx_ff_which_airlines,
	ccx_ff.subject_to_blackout_dates as ccx_ff_subject_to_blackout_dates,
	ccx_ff.first_purchase_bonus as ccx_ff_first_purchase_bonus,
	ccx_ff.other_bonus as ccx_ff_other_bonus,
	ccx_ff.intro_reward_period as ccx_ff_intro_reward_period,
	ccx_ff.intro_reward_amount as ccx_ff_intro_reward_amount,
	ccx_ff.intro_special_reward_amount as ccx_ff_intro_special_reward_amount,
	ccx_ff.max_annual_reward as ccx_ff_max_annual_reward,
	ccx_pr.card_id as ccx_pr_card_id,
	ccx_pr.base_reward_amount as ccx_pr_base_reward_amount,
	ccx_pr.special_reward_amount as ccx_pr_special_reward_amount,
	ccx_pr.special_reward_description as ccx_pr_special_reward_description,
	ccx_pr.where_points_redeemed as ccx_pr_where_points_redeemed,
	ccx_pr.value_of_points as ccx_pr_value_of_points,
	ccx_pr.first_purchase_bonus as ccx_pr_first_purchase_bonus,
	ccx_pr.other_bonus as ccx_pr_other_bonus,
	ccx_pr.intro_reward_period as ccx_pr_intro_reward_period,
	ccx_pr.intro_reward_amount as ccx_pr_intro_reward_amount,
	ccx_pr.intro_special_reward_amount as ccx_pr_intro_special_reward_amount,
	ccx_pr.max_annual_reward as ccx_pr_max_annual_reward,
	ccx_cf.card_id as ccx_cf_card_id,
	ccx_cf.reporting_features as ccx_cf_reporting_features,
	ccx_cf.travel_expense_management as ccx_cf_travel_expense_management,
	ccx_cf.purchasing_expense_management as ccx_cf_purchasing_expense_management,
	ccx_cf.fleet_expense_management as ccx_cf_fleet_expense_management,
	ccx_ob.card_id as ccx_ob_card_id,
	ccx_ob.insurance as ccx_ob_insurance,
	ccx_ob.retail_discounts as ccx_ob_retail_discounts,
	ccx_ob.extended_warranties as ccx_ob_extended_warranties,
	ccx_ob.roadside_assistance as ccx_ob_roadside_assistance,
	ccx_ob.security_identity_solution as ccx_ob_security_identity_solution,
	ccx_ob.account_protection as ccx_ob_account_protection,
	ccx_ob.consierge_service as ccx_ob_consierge_service,
	ccx_ob.card_design as ccx_ob_card_design,
	ccx_ob.mini_card as ccx_ob_mini_card,
	ccx_ob.photo_security as ccx_ob_photo_security,
	ccx_ob.personalization as ccx_ob_personalization,
	ccx_pp.atm_fee as ccx_pp_atm_fee,
	ccx_pp.activation_fee as ccx_pp_activation_fee,
	ccx_pp.monthly_inactive_account_fee as ccx_pp_monthly_inactive_account_fee,
	ccx_pp.application_fee as ccx_pp_application_fee,
	ccx_pp.purchase_merchant_fee as ccx_pp_purchase_merchant_fee,
	ccx_pp.signature_transaction_fee as ccx_pp_signature_transaction_fee,
	ccx_pp.pin_transaction_fee as ccx_pp_pin_transaction_fee,
	ccx_pp.load_fee as ccx_pp_load_fee,
	cdata.introApr as introAprQ,
	cdata.introAprPeriod as introAprPeriodQ,
	cdata.regularApr as regularAprQ,
	cdata.annualFee as annualFeeQ,
	cdata.monthlyFee as monthlyFeeQ,
	cdata.balanceTransferFee as balanceTransferFeeQ,
	cdata.balanceTransferIntroApr as balanceTransferIntroAprQ,
	cdata.balanceTransferIntroAprPeriod as balanceTransferIntroAprPeriodQ,
	REPLACE(c.introApr, "@@introApr@@", cdata.introApr) AS introApr,
	REPLACE(c.introAprPeriod, "@@introAprPeriod@@", cdata.introAprPeriod) AS introAprPeriod,
	REPLACE(c.regularApr, "@@regularApr@@", IF(cdata.regularApr = "999.00", "N/A", cdata.regularApr)) AS regularApr,
	REPLACE(c.annualFee, "@@annualFee@@", cdata.annualFee) AS annualFee,
	REPLACE(c.monthlyFee, "@@monthlyFee@@", cdata.monthlyFee) AS monthlyFee,
	IF( cdata.balanceTransfers = 1, REPLACE(c.balanceTransfers, "@@balanceTransfers@@", "Yes"), REPLACE(c.balanceTransfers, "@@balanceTransfers@@", "No" ) ) AS balanceTransfers,
	REPLACE(c.balanceTransferFee, "@@balanceTransferFee@@", cdata.balanceTransferFee) AS balanceTransferFee,

	REPLACE(c.balanceTransferIntroApr, "@@balanceTransferIntroApr@@", IF(cdata.balanceTransfers = 1 AND cdata.balanceTransferIntroApr != "999.00", cdata.balanceTransferIntroApr, "N/A")) AS balanceTransferIntroApr,
	REPLACE(c.balanceTransferIntroAprPeriod, "@@balanceTransferIntroAprPeriod@@", IF(cdata.balanceTransfers = 1 AND cdata.balanceTransferIntroApr != "999.00", cdata.balanceTransferIntroAprPeriod, "N/A")) AS balanceTransferIntroAprPeriod,

    REPLACE(c.creditNeeded, "@@creditNeeded@@", CASE cdata.creditNeeded
                WHEN 0 THEN CONVERT("No Credit Check" USING latin1)
                WHEN 1 THEN CONVERT("Bad Credit" USING latin1)
                WHEN 2 THEN CONVERT("Fair Credit" USING latin1)
                WHEN 3 THEN CONVERT("Good Credit" USING latin1)
                WHEN 4 THEN CONVERT("Excellent Credit" USING latin1)
            END) AS creditNeeded,
	merch.merchantname as merchantname,
	GROUP_CONCAT(DISTINCT rt_cp.pageName) AS card_categories,
	terms_mobile.url AS terms_mobile_url
FROM
    rt_cards AS c
    JOIN rt_carddetails AS cd USING ( cardId )
    JOIN cs_carddata AS cdata USING ( cardId )
	JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
    JOIN
                    (
                            SELECT
                                    c.cardId,
                                    MAX(cd.cardDetailVersion) AS max_id
                            FROM
                                    rt_cards AS c
                                    JOIN rt_carddetails AS cd USING (cardId)
                                    JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
                            WHERE
                                    c.deleted != 1
                                    AND c.active = 1
                                    AND (cd.cardDetailVersion = -1 OR cd.cardDetailVersion = "' . $siteId . '")
                            GROUP BY
                                    c.cardId
                    ) AS max_version USING (cardId)
    LEFT JOIN ccx_cms_map ON ( cardId = cms_card_id )
    LEFT JOIN cards AS ccx ON ( ccx_card_id = card_id )
    LEFT JOIN balance_transfers AS ccx_bt USING ( card_id )
    LEFT JOIN cash_advances AS ccx_ca USING ( card_id )
    LEFT JOIN cash_back AS ccx_cb USING ( card_id )
    LEFT JOIN point_rewards AS  ccx_pr USING ( card_id )
    LEFT JOIN frequent_flier AS ccx_ff USING ( card_id )
    LEFT JOIN commercial_features AS ccx_cf USING ( card_id )
    LEFT JOIN other_benefits AS ccx_ob USING ( card_id )
    LEFT JOIN prepaid_card_fees AS ccx_pp USING ( card_id )
    LEFT JOIN rt_cardpagemap AS rt_cpm USING (cardId)
    LEFT JOIN rt_cardpages AS rt_cp USING (cardpageId)
	LEFT JOIN product_links AS terms_mobile ON terms_mobile.product_id = c.cardId AND terms_mobile.`link_type_id` = 4 AND terms_mobile.`device_type_id` = 2
WHERE
	c.cardId = ' . _q($cardId) . '
	AND c.deleted != 1
	AND cd.cardDetailVersion = max_version.max_id
GROUP BY c.cardId';

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}

	function getTopCardsFromIssuerCategory($cardId, $categoryId, $contextId, $siteId) {

		$cardsArray = array();

		$sql = '
            SELECT
                DISTINCT(c.cardId),
                c.cardTitle,
                c.imagePath,
                cd.cardLink,
                cd.cardButtonAltText,
                cd.cardIOAltText,
                cb.boost,
				merch.merchantname
            FROM
                rt_cards AS c
                JOIN rt_carddetails AS cd USING (cardId)
                LEFT JOIN card_boost AS cb ON (c.cardId = cb.card_id)
                JOIN card_ranks AS cr ON (c.cardId = cr.card_id)
				JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
                JOIN
                    (
                            SELECT
                                    c.cardId,
                                    MAX(cd.cardDetailVersion) AS max_id
                            FROM
                                    rt_cards AS c
                                    JOIN rt_carddetails AS cd USING (cardId)
                                    JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
                            WHERE
                                    c.deleted != 1
                                    AND c.active = 1
                                    AND (cd.cardDetailVersion = -1 OR cd.cardDetailVersion = "' . $siteId . '")
                            GROUP BY
                                    c.cardId
                    ) AS max_version ON (max_version.cardId = c.cardId)

				WHERE
					c.deleted != 1
					AND c.active = 1
					AND cr.card_category_id = "' . $categoryId . '"
					AND c.cardId != "' . $cardId . '"
					AND c.site_code = "USEN"
					AND cd.cardDetailVersion = max_version.max_id
				ORDER BY
					boost desc
				LIMIT 5';

		//echo $sql . "<hr>";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while ($rs && !$rs->EOF) {
			$cardsArray[] = $rs->fields;
			$rs->MoveNext();
		}

		return $cardsArray;
	}

	function getTopCardsFromIssuer($cardId, $cardpageId, $siteId) {
		$cardsArray = array();

		$sql = 'SELECT * FROM
            (
            SELECT
                    c.cardId,
                    c.cardTitle,
                    c.imagePath,
                    cd.cardLink,
                cd.cardButtonAltText,
                cd.cardIOAltText,
                cb.boost,
				merch.merchantname
            FROM
                rt_cards AS c
                JOIN rt_carddetails AS cd USING (cardId)
                JOIN card_boost AS cb ON (c.cardId = cb.card_id)
                JOIN ' . self::getCardPageTableName($siteId) . ' AS cpm USING (cardId)
				JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
                JOIN
                    (
                            SELECT
                                    c.cardId,
                                    MAX(cd.cardDetailVersion) AS max_id
                            FROM
                                    rt_cards AS c
                                    JOIN rt_carddetails AS cd USING (cardId)
                                    JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
                            WHERE
                                    c.deleted != 1
                                    AND c.active = 1
                                    AND (cd.cardDetailVersion = -1 OR cd.cardDetailVersion = "' . $siteId . '")
                            GROUP BY
                                    c.cardId
                    ) AS max_version ON (max_version.cardId = c.cardId)

				WHERE
					c.deleted != 1
					AND c.active = 1
					AND cpm.cardpageId = "' . $cardpageId . '"
				GROUP BY cardId

			UNION

			SELECT
					c.cardId,
					c.cardTitle,
					c.imagePath,
					cd.cardLink,
				cd.cardButtonAltText,
				cd.cardIOAltText,
				cb.boost
			FROM
				rt_cards AS c
				JOIN rt_carddetails AS cd USING (cardId)
				JOIN card_boost AS cb ON (c.cardId = cb.card_id)
				JOIN ' . self::getCardPageTableName($siteId) . ' AS cpm USING (cardId)
				JOIN ' . self::getPageSubPageTableName($siteId) . ' AS pspm ON (cpm.cardpageId = pspm.subpageid)
				JOIN
					(
							SELECT
									c.cardId,
									MAX(cd.cardDetailVersion) AS max_id
							FROM
									rt_cards AS c
									JOIN rt_carddetails AS cd USING (cardId)
									JOIN cs_merchants as merch ON (c.merchant = merch.merchantid)
							WHERE
									c.deleted != 1
									AND c.active = 1
									AND (cd.cardDetailVersion = -1 OR cd.cardDetailVersion = "' . $siteId . '")
							GROUP BY
									c.cardId
					) AS max_version ON (max_version.cardId = c.cardId)
				WHERE
					c.deleted != 1
					AND c.active = 1
					AND pspm.siteId = "' . $siteId . '"
					AND pspm.masterpageid = "' . $cardpageId . '"
				GROUP BY cardId

			) AS cards
			WHERE
				cardId != "' . $cardId . '"
			ORDER BY
				boost desc
			LIMIT 4';

		//echo $cardId . " - " . $sql . "<hr>";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while (!$rs->EOF) {
			$cardsArray[] = $rs->fields;
			$rs->MoveNext();
		}

		return $cardsArray;
	}

	function getCardCategories($cardId) {
		$categories = array();

		$sql = "
			SELECT
				card_category_id
			FROM
				card_ranks
			WHERE
				card_id = '" . $cardId . "'
			AND
				card_category_context_id = 1
			;
		";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while ($rs && !$rs->EOF) {
			$categories[] = $rs->fields['card_category_id'];
			$rs->MoveNext();
		}

		return $categories;
	}

	function writeSiteCatalystDefaults($detailId, $cardLink) {
		/**
		 * channel = individual card page
		 * prop1 = card-link
		 * s.pageName = channel:prop1
		 * */
		if (empty($cardLink)) {
			trigger_error('Empty card link.', E_USER_ERROR);
		}

		$sql = "insert into sc_individual_card_page_data(card_details_id, var_name, var_value)
		select card_details_id, tmp_var_name, tmp_var_value
		from
		   (
			  select $detailId as card_details_id, var_name as tmp_var_name, 'individual card page' as tmp_var_value from sc_page_vars
			  where var_name like 'channel'
			  union all
			  select $detailId as card_details_id, var_name as tmp_var_name, '$cardLink' as tmp_var_value from sc_page_vars
			  where var_name like 'prop1'
			  union all
			  select $detailId as card_details_id, var_name as tmp_var_name, 'individual card page:" . $cardLink . "' as tmp_var_value
			  from sc_page_vars
			  where var_name like 'pageName'
		   ) as tmpValues
		on duplicate key update var_value = tmpValues.tmp_var_value
		";
		// echo $sql.'<br><br>';

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	function assignSites($cardId, $siteIds) {
		if (!is_array($siteIds) && $siteIds !== NULL)
			$siteIds = array($siteIds);

		foreach ($siteIds as $id) {
			$sqlInsert = "INSERT INTO site_card_map (site_id, card_id, insert_date) VALUES (" . _q($id) . "," . _q($cardId) . ", NOW())";
			_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
	}

	function removeSites($cardId, $siteIds) {
		if (!is_array($siteIds) && $siteIds !== NULL)
			$siteIds = array($siteIds);

		foreach ($siteIds as $id) {
			$sqlInsert = <<<SQL
DELETE FROM site_card_map
WHERE
	site_id = "$id"
	AND card_id = "$cardId"
SQL;
			_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
	}

	function assignExcludes($cardId, $siteIds) {
		if (!is_array($siteIds) && $siteIds !== NULL)
			$siteIds = array($siteIds);

		foreach ($siteIds as $id) {
			$sqlInsert = <<<SQL
INSERT INTO cs_pagecardexclusionmap
	(siteid, pageid, cardid)
VALUES
	("$id", "-1", "$cardId")
SQL;
			_sqlQuery($sqlInsert, __LINE__, __FILE__, DEBUG_MODE);
		}
	}

	function removeExcludes($cardId, $siteIds) {
		if (!is_array($siteIds) && $siteIds !== NULL)
			$siteIds = array($siteIds);

		foreach ($siteIds as $id) {
			$sqlDelete = <<<SQL
DELETE FROM cs_pagecardexclusionmap
WHERE
	siteid = "$id"
	AND cardid = "$cardId"
SQL;
			_sqlQuery($sqlDelete, __LINE__, __FILE__, DEBUG_MODE);
		}
	}

	function getSitesByCardIdAndDate($id, $date) {
		$sql = <<<SQL
SELECT
	s.siteId,
	s.siteName
FROM site_card_map as map
	JOIN rt_sites as s ON (map.site_id = s.siteId)
WHERE
	map.card_id = "$id"
	AND s.deleted != 1
	AND map.insert_date >= "$date"
	ORDER BY s.siteName
SQL;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$return = array();
		while (!$rs->EOF) {
			$return[] = $rs->fields;
			$rs->MoveNext();
		}

		return $return;
	}

	function getSitesByCardId($id) {
		$sql = <<<SQL
SELECT
	s.siteId,
	s.siteName
FROM site_card_map as map
	JOIN rt_sites as s ON (map.site_id = s.siteId)
WHERE
	map.card_id = "$id"
	AND s.deleted != 1
	ORDER BY s.siteName
SQL;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while (!$rs->EOF) {
			$return[] = $rs->fields;
			$rs->MoveNext();
		}

		return is_array($return) ? $return : array();
	}

	function getUnassignedSitesByCardId($id) {
		$sql = <<<SQL
SELECT
	s.siteId,
	s.siteName
FROM rt_sites as s
	LEFT JOIN site_card_map as map ON (map.site_id = s.siteId AND map.card_id = "$id")
WHERE s.deleted != 1
AND map.site_id IS NULL
ORDER BY s.siteName
SQL;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while (!$rs->EOF) {
			$return[] = $rs->fields;
			$rs->MoveNext();
		}

		return is_array($return) ? $return : array();
	}

	function getExcludedSites($id) {
		$sql = <<<SQL
SELECT
	siteId, siteName
FROM
	cs_pagecardexclusionmap as x
	JOIN rt_sites as s USING (siteid)
WHERE
	x.cardid = "$id"
	AND s.deleted = 0
GROUP BY s.siteid
ORDER BY siteName
SQL;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while (!$rs->EOF) {
			$return[] = $rs->fields;
			$rs->MoveNext();
		}

		return is_array($return) ? $return : array();
	}

	function getNonExcludedSites($id) {
		$sql = <<<SQL
SELECT siteId, siteName
FROM rt_sites
WHERE siteId NOT IN (
	SELECT siteid
	FROM cs_pagecardexclusionmap
	WHERE
		cardid = "$id"
)
AND deleted = 0
ORDER BY siteName
SQL;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		while (!$rs->EOF) {
			$return[] = $rs->fields;
			$rs->MoveNext();
		}

		return is_array($return) ? $return : array();
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
