<?php

class CMS_libs_DefaultNetworkKeys {

	/**
	 * Get a default network key
	 *
	 * @param $networkId
	 * @param $accountType
	 * @return string
	 */
	public static function getKey($networkId, $accountType){

		$networkId = _q($networkId);
		$accountType = _q($accountType);

		$sql = "
			SELECT default_network_key
			FROM default_network_keys
			WHERE network_id = {$networkId}
			AND account_type = {$accountType}";

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);


		$retData = array();
		while($rs && !$rs->EOF){
			$retData[] = $rs->fields;
			$rs->MoveNext();
		}

		$row = $retData[0];
		$key = $row['default_network_key'];

		return $key;
	}
}
