<?php

/**
 * @package CMS_Lib
 */

class CMS_libs_DeviceTypes {

	/**
	 * Returns all device types
	 *
	 * @return array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getAllDeviceTypes() {
		$sql = "SELECT * FROM device_types";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Returns device type defined by id
	 *
	 * @param	string	$deviceTypeId	Device Type ID
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getDeviceTypeById($deviceTypeId) {
		$sql = "SELECT * FROM device_types WHERE device_type_id = " . $deviceTypeId;

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

	/**
	 * Returns device type defined by name
	 *
	 * @param	string	$deviceTypeName		Device Type Name
	 *
	 * @return	array	$rs		Associative array field=>value
	 *
	 * @static
	 */
	function getDeviceTypeByName($deviceTypeName) {
		$sql = 	"SELECT * FROM " . DEVICE_TYPES_TABLE . " as dt " .
			"WHERE dt.name LIKE " . _q($deviceTypeName);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		return $rs;
	}

}
