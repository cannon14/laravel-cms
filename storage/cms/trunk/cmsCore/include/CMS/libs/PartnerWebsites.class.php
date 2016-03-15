<?php

/**
 * @package CMS_Lib
 */

define("PARTNER_WEBSITES_TABLE", "cccomus_partner_websites");

class CMS_libs_PartnerWebsites {

	/**
	 * Get the information for a site
	 *
	 * @param int Site ID
	 *
	 * @return ResultSet Site information
	 * @static
	 */
	static function getSite($id){
		$sql = "SELECT * FROM " . PARTNER_WEBSITES_TABLE . " WHERE website_id = " . _q($id) . " AND deleted != 1";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Get websites by name
	 *
	 * @param $name
	 *
	 * @return ResultSet Site information
	 * @static
	 */
	static function getSitesByName($name) {
		$name = "%" . $name . "%";
		$sql = "SELECT * FROM " . PARTNER_WEBSITES_TABLE . " WHERE name LIKE " . _q($name) . " AND deleted != 1";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}
}
