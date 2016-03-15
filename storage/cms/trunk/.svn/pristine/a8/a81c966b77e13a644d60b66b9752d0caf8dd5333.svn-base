<?php

/**
 * @package CMS_Lib
 */

define("PARTNER_ACCOUNT_TYPES_TABLE", "cccomus_partner_account_types");

class CMS_libs_PartnerAccountTypes {

	/**
	 * Returns all account types
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getAllAccountTypes() {
		$sql = "SELECT * FROM " . PARTNER_ACCOUNT_TYPES_TABLE;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Returns account type defined by id
	 *
	 * @param	string	$accountTypeId		Account Type ID
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getAccountTypeById($accountTypeId) {
		$sql = "SELECT * FROM " . PARTNER_ACCOUNT_TYPES_TABLE .
					" WHERE partner_account_type_id = " . _q($accountTypeId);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Returns account type defined by name
	 *
	 * @param	string	$accountTypeName		Account Type Name
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getAccountTypeByName($accountTypeName) {
		$sql = 	"SELECT * FROM " . PARTNER_ACCOUNT_TYPES_TABLE .
			" WHERE account_type LIKE " . _q($accountTypeName);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

}
