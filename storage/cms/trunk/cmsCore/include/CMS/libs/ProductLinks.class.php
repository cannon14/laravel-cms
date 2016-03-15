<?php

/**
 * @package CMS_Lib
 */

define("PRODUCT_LINKS_TABLE", "product_links");
define("LINK_TYPES_TABLE", "link_types");
define("DEVICE_TYPES_TABLE", "device_types");

class CMS_libs_ProductLinks {

	/**
	 * Returns single product link by ID.
	 *
	 * @param	int		$productLinkId	Product Link ID
	 *
	 * @return	array	$productLinks	Associative array field=>value
	 *
	 * @static
	 */
	static function getProductLinkById($productLinkId) {
		$sql = "SELECT pl.*, lt.name as link_type_name, dt.name as device_type_name, cpw.name as website_name " .
				"FROM " . PRODUCT_LINKS_TABLE . " AS pl " .
				"INNER JOIN " . LINK_TYPES_TABLE . " as lt ON (pl.link_type_id = lt.link_type_id) " .
				"INNER JOIN " . DEVICE_TYPES_TABLE . " as dt ON (pl.device_type_id = dt.device_type_id) " .
				"LEFT JOIN cccomus_partner_websites as cpw ON (pl.website_id = cpw.website_id) " .
				"WHERE pl.link_id = " . _q($productLinkId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();
		}

		return $retData[0];
	}

	/**
	 * Returns all product links assigned to card defined by ID
	 *
	 * @param	int		$productId		Product ID
	 *
	 * @return	array	$productLinks	Associative array field=>value
	 *
	 * @static
	 */
	static function getProductLinksByProductId($productId) {
		$sql = 	"SELECT pl.*, dt.name as device_type_name, lt.name as link_type_name,
						cpat.account_type as account_type_name " .
					"FROM " . PRODUCT_LINKS_TABLE . " as pl " .
					"INNER JOIN " . LINK_TYPES_TABLE . " as lt ON (pl.link_type_id = lt.link_type_id) " .
					"INNER JOIN " . DEVICE_TYPES_TABLE . " as dt ON (pl.device_type_id = dt.device_type_id) " .
					"LEFT JOIN cccomus_partner_account_types as cpat " .
						"ON (pl.account_type_id = cpat.partner_account_type_id) " .
				"WHERE pl.product_id = " . _q($productId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();
		}

		return $retData;
	}

	/**
	 * Returns all product links with specified link type id and device type id assigned to a product
	 *
	 * @param   int 	$deviceTypeId 	Device Type ID
	 *
	 * @return	array	$productLinks	Associative array field=>value
	 *
	 * @static
	 */
	static function getProductLinksByLinkTypeIdAndDeviceTypeId($productId, $linkTypeId, $deviceTypeId) {
		$sql = "SELECT pl.* FROM " . PRODUCT_LINKS_TABLE . " as pl " .
				"WHERE pl.link_type_id = " . _q($linkTypeId) . " AND pl.device_type_id = " . _q($deviceTypeId) .
				" AND pl.product_id = " . _q($productId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();
		}

		return $retData;
	}

	/**
	 * Returns all account product links for a product (by link type/device type ID)
	 *
	 * @param 	int		$productId		Product ID
	 * @param 	int		$linkTypeId		Link Type ID
	 * @param 	int		$deviceTypeId	Device Type ID
	 * @param 	int		$accountTypeId	Account Type ID
	 *
	 * @return	array	$productLinks	Associative array field=>value
	 *
	 * @static
	 */
	static function getAccountProductLinks($productId, $linkTypeId, $deviceTypeId, $accountTypeId) {
		$sql = "SELECT pl.* FROM " . PRODUCT_LINKS_TABLE . " as pl " .
					"WHERE pl.product_id = " . _q($productId) . " AND " .
					"pl.link_type_id = " . _q($linkTypeId) . " AND " .
					"pl.device_type_id = " . _q($deviceTypeId) . " AND " .
					"pl.account_type_id = " . _q($accountTypeId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();
		}

		return $retData;
	}

	/**
	 * Returns all website product links for a product (by link type/device type ID)
	 *
	 * @param 	int		$productId		Product ID
	 * @param 	int		$linkTypeId		Link Type ID
	 * @param 	int		$deviceTypeId	Device Type ID
	 * @param 	int		$websiteId		Website ID
	 *
	 * @return	array	$productLinks	Associative array field=>value
	 *
	 * @static
	 */
	static function getWebsiteProductLinks($productId, $linkTypeId, $deviceTypeId, $websiteId) {
		$sql = "SELECT pl.* FROM " . PRODUCT_LINKS_TABLE . " as pl " .
			"WHERE pl.product_id = " . _q($productId) . " AND " .
			"pl.link_type_id = " . _q($linkTypeId) . " AND " .
			"pl.device_type_id = " . _q($deviceTypeId) . " AND " .
			"pl.website_id = " . _q($websiteId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();
		}

		return $retData;
	}

	/**
	 * Add a product link to the database
	 *
	 * @param array product link information ($field=>$value)
	 *
	 * @return productLinkId
	 *
	 * @static
	 */
	function addProductLink($params){

		$params = array_filter($params);
		$sqlParams =  "'" . implode("','", $params) . "'";

		foreach($params as $col=>$value){
			$cols[] = $col;
		}
		$sqlCols = implode(",", $cols);

		$sql = "INSERT INTO product_links ( " . $sqlCols . ", date_created, date_updated) " .
			" VALUES (" . $sqlParams  . ", " ._q(date("Y-m-d H:i:s")) . ", " .
			_q(date("Y-m-d H:i:s")) .  ")";

		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$productLinkId = mysql_insert_id();

		return $productLinkId;
	}

	/**
	 * Update a product link's information
	 *
	 * @param	int		$linkId		product link id
	 * @param 	array 	$params		product link information ($field=>$value)
	 *
	 * @return productLinkId
	 *
	 * @static
	 */
	static function updateProductLink($linkId, $params) {

		if (!is_array($params))
			return;

		$sql = "UPDATE product_links SET ";
		$sql .= " product_id = " . _q($params['product_id']) . ", ";
		$sql .= " link_type_id = " . $params['link_type_id'] . ", ";
		$sql .= " device_type_id = " . $params['device_type_id'] . ", ";

		if ($params['website_id'] != null) {
			$sql .= " website_id = " . $params['website_id'] . ", ";
		}
		if ($params['account_type_id'] != null) {
			$sql .= " account_type_id = " . $params['account_type_id'] . ", ";
		}

		$sql .= " url = " . _q($params['url']) . ", ";
		$sql .= " updated_by = " . _q($params['updated_by']) . ", ";
		$sql .= " date_updated = " . _q(date("Y-m-d H:i:s")) . " WHERE link_id = " . _q($linkId);

		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$result = mysql_affected_rows();

		return $result;
	}

	/**
	 * Delete a product link from the database
	 *
	 * @param array product link information ($field=>$value)
	 *
	 * @return rs
	 *
	 * @static
	 */
	static function deleteProductLink($productLinkId) {

		$sql = "DELETE FROM " . PRODUCT_LINKS_TABLE .
					" WHERE link_id = " . _q($productLinkId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}


	public function getTestLink($productLinkId, $networkId, $accountType = 'CS') {


		$productLink = self::getProductLinkById($productLinkId);

		$url = $productLink['url'];
		$link_type = strtolower($productLink['link_type_name']);
		$affiliateId = '';
		$website_id = '';

		if($link_type == 'website') {
			$website_id = $productLink['website_id'];
			$website = CMS_libs_PartnerWebsites::getSite($website_id);
			$affiliateId = $website->fields['affiliate_id'];
		}


		$networkKey = CMS_libs_DefaultNetworkKeys::getKey($networkId, $accountType);

		$testLink = $this->parseLink($url, $affiliateId, $networkKey, $website_id);

		return $testLink;

	}

	public function parseLink($url, $affiliateId, $networkKey, $websiteId = '') {

		$url = str_replace('[AFFILIATE_ID]', $affiliateId, $url);
		$url = str_replace('[SITE_ID]', $websiteId, $url);
		$url = str_replace('[NETWORK_KEY]', $networkKey, $url);

		/* We're not able to get these values outside of the transnode, so we clear them instead */
		$url = str_replace('[TRANS_ID]', '', $url);
		$url = str_replace('[POSITION]', '', $url);
		$url = str_replace('[FID]', '', $url);


		return $url;

	}




}
