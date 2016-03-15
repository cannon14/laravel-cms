<?php

/**
 * @package CMS_Lib
 */

class CMS_libs_LinkTypes {

	/**
	 * Returns all link types
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getAllLinkTypes() {
		$sql = "SELECT * FROM link_types";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Returns link type defined by name
	 *
	 * @param	string	$linkTypeName		Link Type Name
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getLinkTypeByName($linkTypeName) {
		$sql = 	"SELECT * FROM " . LINK_TYPES_TABLE . " as lt" .
			" WHERE lt.name LIKE " . _q($linkTypeName);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

}
