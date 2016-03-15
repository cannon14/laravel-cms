<?php
/**
 *
 * ClickSuccess, L.P.
 * March 28, 2006
 *
 * Authors:
 * Lawrence Behar
 * <lawrence.behar@creditcards.com>
 *
 * @package CMS_Lib
 */


class CMS_libs_Networks {
	/**
	 * Get list of networks
	 * @author Lawrence Behar
	 * @version 1.0
	 * @return ResultSet card data
	 * @static
	 */
	function getAllNetworks(){
		$sql = "SELECT network_id, name 
		FROM networks 
		WHERE `deleted` = 0";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return $rs;
	}
}
