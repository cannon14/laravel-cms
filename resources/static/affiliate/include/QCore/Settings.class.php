<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class QCore_Settings {
	function getAvailableLangs() {
		if ($handle = opendir(LANG_PATH)) {
			$files = array();
			while (false !== ($file = readdir($handle))) {
				if (is_file(LANG_PATH . '/' . $file)) {
					$file = str_replace('.php', '', $file);
					$files[] = $file;
				}
			}

			closedir($handle);

			return $files;
		} else
			return array();
	}

	//--------------------------------------------------------------------------
	/*
		function getSettings()
		{
			$sql = 'select * from wd_g_settings where rtype = "0"';
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if (!$rs)
				return -1;

			$settings = array();
			while(!$rs->EOF)
			{
				$settings[$rs->fields['code']] = $rs->fields['value'];
				$rs->MoveNext();
			}

			return $settings;
		}

		//--------------------------------------------------------------------------

		function getSetting($code)
		{
			$sql = 'select value from wd_g_settings where code='._q($code).' and rtype = 0';
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if (!$rs || $rs->EOF)
				return false;

			return $rs->fields['value'];
		}
	*/
	//--------------------------------------------------------------------------

	function saveTransactionInfo($datas, $customerProductID) {
		foreach ($datas as $key => $value)
			QCore_Settings::update($key, $value, 0, '', '', $customerProductID, '');
	}

	//--------------------------------------------------------------------------

	function loadTransactionInfo($customerProductID) {
		$sql = 'select * from wd_g_settings where textid1=' . _q($customerProductID) . ' and rtype = \'0\'';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
			return -1;

		$settings = array();
		while (!$rs->EOF) {
			$settings[$rs->fields['code']] = $rs->fields['value'];
			$rs->MoveNext();
		}

		return $settings;
	}

	//--------------------------------------------------------------------------

	function _update($code, $value, $type, $accountID = '', $userID = '', $id1 = '', $id2 = '') {
		$value = myslashes($value);

		// check if this setting is created
		$sql = 'select * from wd_g_settings ';
		$where = ' where code=' . _q($code) .
			'  and rtype=' . _q($type);
		if ($accountID != '') $where .= ' and accountid=' . _q($accountID);
		if ($userID != '') $where .= ' and userid=' . _q($userID);
		if ($id1 != '') $where .= ' and id1=' . _q($id1);
		if ($id2 != '') $where .= ' and id2=' . _q($id2);

		$rs = QCore_Sql_DBUnit::execute($sql . $where, __FILE__, __LINE__);
		if (!$rs) {
			showMsg(L_G_DBERROR, 'error');
			return false;
		}

		if ($rs->EOF) {
			$settingsid = QCore_Sql_DBUnit::createUniqueID('wd_g_settings', 'settingsid');

			// insert
			$sql = 'insert into wd_g_settings(settingsid, code, value, rtype';
			if ($accountID != '') $sql .= ', accountid';
			if ($userID != '') $sql .= ', userid';
			if ($id1 != '') $sql .= ', id1';
			if ($id2 != '') $sql .= ', id2';
			$sql .= ') values(' . _q($settingsid) . ',' . _q($code) . ',' . _q($value) . ',' . _q($type);
			if ($accountID != '') $sql .= ',' . _q($accountID);
			if ($userID != '') $sql .= ',' . _q($userID);
			if ($id1 != '') $sql .= ',' . _q($id1);
			if ($id2 != '') $sql .= ',' . _q($id2);
			$sql .= ')';

			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if (!$rs) {
				showMsg(L_G_DBERROR, 'error');
				return false;
			}

			QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
		} else {
			$sql = 'update wd_g_settings ' .
				'set value=' . _q($value);

			$rs = QCore_Sql_DBUnit::execute($sql . $where, __FILE__, __LINE__);
			if (!$rs) {
				showMsg(L_G_DBERROR, 'error');
				return false;
			}

			QCore_History::DebugMsg(WLOG_ACTIONS, $sql . $where, __FILE__, __LINE__);
		}

		return true;
	}

	//--------------------------------------------------------------------------

	static function _getSettings($type, $accountID = '', $userID = '', $id1 = '', $id2 = '') {
		/* Deprecated */
		return array();
	}

	//--------------------------------------------------------------------------

	function _getSettingsForMultipleUsers($type, $accountID = '', $userID = '', $id1 = '', $id2 = '') {
		$sql = 'select userid, code, value from wd_g_settings ' .
			'where rtype=' . _q($type);
		if ($accountID != '') {
			$sql .= ' and accountid=' . _q($accountID);
		}

		if ($userID != '') {
			if (!is_array($userID)) {
				$sql .= ' and userid=' . _q($userID);
			} else if (is_array($userID) && count($userID) > 0) {
				$sql .= ' and userid in ' . "('" . implode("','", $userID) . "')";
			}
		}

		if ($id1 != '') {
			$sql .= ' and id1=' . _q($id1);
		}

		if ($id2 != '') {
			$sql .= ' and id2=' . _q($id2);
		}

		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
			return array();

		$settings = array();
		while (!$rs->EOF) {
			$settings[$rs->fields['userid']][$rs->fields['code']] = $rs->fields['value'];
			$rs->MoveNext();
		}

		return $settings;
	}

	//--------------------------------------------------------------------------

	function getGlobalSettings($type = SETTINGTYPE_GLOBAL) {
		return QCore_Settings::_getSettings($type);
	}

	//--------------------------------------------------------------------------

	static function getAccountSettings($type, $accountID) {
		return QCore_Settings::_getSettings($type, $accountID);
	}

	//--------------------------------------------------------------------------

	function getAdminSettings($type, $accountID, $userID) {
		return QCore_Settings::_getSettings($type, $accountID, $userID);
	}

	//--------------------------------------------------------------------------

	function getUserSetting($code, $type, $accountID, $userID) {
		$settings = QCore_Settings::_getSettings($type, $accountID, $userID);

		return $settings[$code];
	}

	//--------------------------------------------------------------------------

	function getUserSettings($type, $accountID, $userID) {
		return QCore_Settings::_getSettings($type, $accountID, $userID);
	}

	//--------------------------------------------------------------------------

	function getAccountUsersSettings($accountID) {
		$sql = 'select userid, code, value from wd_g_settings ' .
			'where rtype=' . _q(SETTINGTYPE_USER) .
			'  and accountid=' . _q($accountID) .
			' order by userid';

		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
			return array();

		$settings = array();
		while (!$rs->EOF) {
			$settings[$rs->fields['userid']][$rs->fields['code']] = $rs->fields['value'];
			$rs->MoveNext();
		}

		return $settings;
	}

	//--------------------------------------------------------------------------

	function getAccountsSettings() {
		$sql = 'select accountid, code, value from wd_g_settings ' .
			'where rtype=' . _q(SETTINGTYPE_ACCOUNT) .
			' order by accountid';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs)
			return array();

		$settings = array();
		while (!$rs->EOF) {
			$settings[$rs->fields['accountid']][$rs->fields['code']] = $rs->fields['value'];
			$rs->MoveNext();
		}

		return $settings;

	}

	//--------------------------------------------------------------------------

	function getMinPayoutsAsArray() {
		$sql = 'select * from wd_g_settings ' .
			'where code=' . _q('Aff_min_payout_options') .
			'  and accountid=' . _q($GLOBALS['Auth']->getAccountID());
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$rs) {
			showMsg(L_G_DBERROR, 'error');
			return false;
		}

		$temp = explode(";", $rs->fields['value']);
		$minPayouts = array();
		foreach ($temp as $numb) {
			$numb = trim($numb);
			if ($numb == '' || $numb == ' ')
				continue;

			$minPayouts[] = $numb;
		}

		return $minPayouts;
	}
}
