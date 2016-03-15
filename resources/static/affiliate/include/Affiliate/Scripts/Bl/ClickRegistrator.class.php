<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Scripts_Bl_Registrator');

class Affiliate_Scripts_Bl_ClickRegistrator extends Affiliate_Scripts_Bl_Registrator {

	const TRANSFER_METHOD_DIRECT = 1;
	const TRANSFER_METHOD_SHORT_REDIRECT = 2;
	const TRANSFER_METHOD_DIRECT_WITH_TRACKING = 3;

	var $multiTierCommissionsCounter = 0;

	/* Purchase ID for omniture */
	var $_purchaseId;

	//--------------------------------------------------------------------------

	function setCookie()
	{
		$this->setP3PPolicy('0');

		$data = $this->decodeValue($_COOKIE[COOKIE_NAME]);

		$cookieUserID = $data[0];
		$cookieCampaignID = $data[1];

		if ($this->UserID == '') {
			$errorMsg = "Click registration: UserID is Null";
			LogError($errorMsg, __FILE__, __LINE__);

			return false;
		}

		if ($this->CampaignID == '') {
			$errorMsg = "Click registration: CampaignID is Null";
			LogError($errorMsg . ": refer[" . $_SERVER['HTTP_REFERER'] . "]", __FILE__, __LINE__);

			return false;
		}

		if ($data != false && ($this->UserID != $cookieUserID || $this->CampaignID != $cookieCampaignID) && $this->settings['Aff_overwrite_cookie'] != '1')
			return true;

		if ($this->cookieLifetime == '')
			$this->cookieLifetime = 0;

		if ($this->cookieLifetime != 0)
			$this->cookieLifetime = time() + $this->cookieLifetime * 86400;
		else
			$this->cookieLifetime = time() + 3650 * 86400;

		$value = $this->UserID . '_' . $this->CampaignID;

		$this->cookieSetReturn = setcookie(COOKIE_NAME, $value, $this->cookieLifetime, '/');

		if ($this->settings['Aff_track_by_session'] == 1) {
			if (!headers_sent())
				session_start();

			$_SESSION[COOKIE_NAME] = $value;
		}

		if (!$this->cookieSetReturn) {
			$errorMsg = "Click registration: setcookie returned false";
			QCore_History::writeHistory(WLOG_ERROR, $errorMsg, __FILE__, __LINE__);
			LogError($errorMsg, __FILE__, __LINE__);

			return false;
		}
	}

	//--------------------------------------------------------------------------

	function saveClick($referrer = '')
	{
		if ($this->settings['Aff_support_click_commissions'] != 1 && $this->settings['Aff_dont_save_click_transaction'] == 1) {
			QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Don't save click - setting disabled in Settings", __FILE__, __LINE__);

			return true;
		}

		$params = $this->checkBeforeSaveClick($referrer);
		if ($params == false) return false;

		$status = $params['status'];
		$ip = $params['ip'];
		$remoteAddr = $params['remoteAddr'];

		// If forwarded for is set, use it as IP.
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipParts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = (count($ipParts) > 1 ? $ipParts[0] : $_SERVER['HTTP_X_FORWARDED_FOR']);
		}

		//------------------------------------------
		// register normal commission
		if (($commission = $this->getCommission()) === false) return false;

		$TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
		$_SESSION['$TransID'] = "$TransID";
		$_SESSION['stripcid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['cid']);
		$_SESSION['stripdid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['did']);
		$_SESSION['stripeid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['eid']);
		$_SESSION['stripfid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['fid']);
		$_SESSION['striptid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['tid']);

		$sql = "insert into wd_pa_transactions " .
				"(transid, accountid, affiliateid, campcategoryid, bannerid," .
				" cookiestatus, dateinserted, transtype, transkind, refererurl," .
				" ip, rstatus, commission, data1, data2, data3," .
				" channel, episode, timeslot, `exit`, sid, currref, prevref, thirdref, external_visit_id, refinceptiondate)" .
				" values(" . _q($TransID) . "," . _q($this->AccountID) .
				"," . _q($this->UserID) . "," . _q($this->CampaignCategoryID) .
				"," . _q($this->BannerID) . "," . _q($this->cookieSetReturn) . "," . sqlNow() .
				"," . TRANSTYPE_CLICK . "," . TRANSKIND_NORMAL . "," . _q($remoteAddr) .
				"," . _q($ip) . "," . _q($status) . "," . _q($commission) . "," . _q($_SESSION['striptid']) .
				"," . _q($this->extraData2) . "," . _q($this->extraData3) . "," . _q($_SESSION['stripcid']) .
				"," . _q($_SESSION['stripdid']) . "," . _q($_SESSION['stripeid']) . "," . _q($_SESSION['stripfid']) .
				"," . _q(session_id()) . ", " . _q($this->cookieData1) . ", " . _q($this->cookieData2) . ", " . _q($this->cookieData3) . ", " . _q($_SESSION['external_visit_id'])
				. "," . _q($this->cookieInceptionDate) . ")";

		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$ret) {
			$errorMsg = "Click registration: Error saving click";
			LogError($errorMsg, __FILE__, __LINE__);

			return false;
		}

		QCore_History::writeHistory(WLOG_DEBUG, "Click registration: After saving click, Start registering multi tier commissions", __FILE__, __LINE__);

		//------------------------------------------
		// register multi tier commissions
		$this->registerMultiTierClickCommission($TransID, $remoteAddr, $ip, $status, $this->UserID, 2);

		QCore_History::writeHistory(WLOG_DEBUG, "Click registration: After registering multi tier commissions", __FILE__, __LINE__);

		return true;
	}

	//--------------------------------------------------------------------------

	function saveTransientClick($referrer = '')
	{
		$params = $this->checkBeforeSaveTransientClick($referrer);
		if ($params == false) return false;

		$status = $params['status'];
		$ip = $params['ip'];


		// If forwarded for is set, use it as IP.
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipParts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$ip = (count($ipParts) > 1 ? $ipParts[0] : $_SERVER['HTTP_X_FORWARDED_FOR']);
		}

		$remoteAddr = $params['remoteAddr'];

		//------------------------------------------
		// register normal commission
		if (($commission = $this->getCommission()) === false) return false;

		$TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
		$_SESSION['$TransID'] = "$TransID";
		$_SESSION['stripcid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['cid']);
		$_SESSION['stripdid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['did']);
		$_SESSION['stripeid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['eid']);
		$_SESSION['stripfid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['fid']);
		$_SESSION['striptid'] = preg_replace('![^a-zA-Z0-9\._\/-]!', '', $_SESSION['tid']);

		$sql = "insert into wd_pa_transactions " .
				"(transid, accountid, affiliateid, campcategoryid, bannerid," .
				" cookiestatus, dateinserted, transtype, transkind, refererurl," .
				" ip, rstatus, commission, data1, data2, data3," .
				" channel, episode, timeslot, `exit`, sid)" .
				" values(" . _q($TransID) . "," . _q($this->AccountID) .
				"," . _q($this->UserID) . "," . _q($this->CampaignCategoryID) .
				"," . _q($this->BannerID) . "," . _q($this->cookieSetReturn) . "," . sqlNow() .
				"," . -1 . "," . TRANSKIND_NORMAL . "," . _q($remoteAddr) .
				"," . _q($ip) . "," . _q($status) . "," . _q($commission) . "," . _q($_SESSION['striptid']) .
				"," . _q($this->extraData2) . "," . _q($this->extraData3) . "," . ($_SESSION['stripcid']) .
				",'" . ($_SESSION['stripdid']) . "'," . ($_SESSION['stripeid']) . "," . ($_SESSION['stripfid']) .
				",'" . (session_id()) . "')";

		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$ret) {
			$errorMsg = "Click registration: Error saving click";
			LogError($errorMsg, __FILE__, __LINE__);

			return false;
		}

		QCore_History::writeHistory(WLOG_DEBUG, "Click registration: After saving click, Start registering multi tier commissions", __FILE__, __LINE__);

		//------------------------------------------
		// register multi tier commissions
		$this->registerMultiTierClickCommission($TransID, $remoteAddr, $ip, $status, $this->UserID, 2);

		QCore_History::writeHistory(WLOG_DEBUG, "Click registration: After registering multi tier commissions", __FILE__, __LINE__);

		return true;
	}

	//--------------------------------------------------------------------------

	function registerMultiTierClickCommission($parentTransID, $remoteAddr, $ip, $status, $parentUserID, $tier, $maxRecursion = 50)
	{
		if ($maxRecursion <= 0) {
			QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Maximum recursion reached", __FILE__, __LINE__);

			return true;
		}

		if ($tier > $this->maxCommissionLevels) {
			QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Maximum tier levels reached", __FILE__, __LINE__);

			return true;
		}

		//----------------------------------------
		// get parent user for this child
		$params = array('parentUserID' => $parentUserID, 'status' => $status);

		if (($params = $this->getParentUser($params)) === false) return false;

		$userID = $params['userID'];
		$status = $params['status'];

		$params = array('userID' => $userID, 'tier' => $tier);

		if ($this->checkSpecialCommission($params) === false) return false;

		$commission = $this->getCommissionMultiTier(array('tier' => $tier));

		if ($commission === false) return false;

		if ($commission != 0) {
			//----------------------------------------
			// register commission
			$TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
			$sql = "insert into wd_pa_transactions " .
					"(transid,parenttransid,affiliateid,campcategoryid,bannerid," .
					"cookiestatus,dateinserted,transtype,transkind,refererurl,ip," .
					"rstatus,commission,accountid, data1, data2, data3)" .
					"values(" . _q($TransID) . "," . _qOrNull($parentTransID) .
					"," . _q($userID) . "," . _q($this->CampaignCategoryID) .
					"," . _q($this->BannerID) . "," . _q($this->cookieSetReturn) .
					"," . sqlNow() . "," . TRANSTYPE_CLICK . "," . (TRANSKIND_SECONDTIER + $tier) .
					"," . _q($remoteAddr) . "," . _q($ip) . ", " . _q($status) .
					"," . _q($commission) . "," . _q($this->AccountID) . "," . _q($this->extraData1) .
					"," . _q($this->extraData2) . "," . _q($this->extraData3) . ")";


			$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if (!$ret) {
				$errorMsg = "Click registration: Error saving $tier - tier click commission";
				LogError($errorMsg, __FILE__, __LINE__);

				return false;
			}

			$this->multiTierCommissionsCounter++;

			QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Saved multi tied commission, Transaction ID: $TransID", __FILE__, __LINE__);
		}

		//----------------------------------------
		// go recursively to the next tier
		if ($tier < $this->maxCommissionLevels) {
			$this->registerMultiTierClickCommission($TransID, $remoteAddr, $ip, $status, $userID, $tier + 1, $maxRecursion - 1);
		}

		return true;
	}

	//--------------------------------------------------------------------------

	function checkBeforeSaveClick($referrer = '')
	{
		if ($this->CampaignCategoryID == '') {
			$errorMsg = "Click registration: CampaignCategoryID is Null";
			LogError($errorMsg . ": refer[" . $_SERVER['HTTP_REFERER'] . "]", __FILE__, __LINE__);

			return false;
		}

		if ($this->BannerID == '') {
			$errorMsg = "Click registration: BannerID is Null";
			LogError($errorMsg, __FILE__, __LINE__);

			return false;
		}

		if ($this->cookieSetReturn == '')
			$this->cookieSetReturn = 99;

		if ($referrer != '')
			$remoteAddr = $referrer;
		else
			$remoteAddr = $_SERVER['HTTP_REFERER'];

		$ip = $_SERVER['REMOTE_ADDR'];

		if ($this->ClickTransactionApproval == APPROVE_MANUAL)
			$status = AFFSTATUS_NOTAPPROVED;
		else
			$status = AFFSTATUS_APPROVED;

		// check fraud protection
		if ($this->DeclineFrequentClicks == 1) {
			if (!$this->applyFraudProtection($ip, $status))
				return false;
		}

		QCore_History::writeHistory(WLOG_DEBUG, "Click registration: After fraud protection, OK", __FILE__, __LINE__);

		return array('status' => $status, 'ip' => $ip, 'remoteAddr' => $remoteAddr);
	}

	//--------------------------------------------------------------------------
	function checkBeforeSaveTransientClick($referrer = '')
	{
		if ($this->cookieSetReturn == '')
			$this->cookieSetReturn = 99;

		if ($referrer != '')
			$remoteAddr = $referrer;
		else
			$remoteAddr = $_SERVER['HTTP_REFERER'];

		$ip = $_SERVER['REMOTE_ADDR'];

		if ($this->ClickTransactionApproval == APPROVE_MANUAL) {
			$status = AFFSTATUS_NOTAPPROVED;
		} else {
			$status = AFFSTATUS_APPROVED;
		}

		// check fraud protection
		if ($this->DeclineFrequentClicks == 1
				&& !$this->applyFraudProtection($ip, $status)) {
				return false;
		}

		QCore_History::writeHistory(WLOG_DEBUG, "Click registration: After fraud protection, OK", __FILE__, __LINE__);

		return array('status' => $status, 'ip' => $ip, 'remoteAddr' => $remoteAddr);
	}


	function getCommission() {

		$commission = 0;

		if ($this->CampaignCommType == TRANSTYPE_CLICK) {
			// compute commission
			$commission = $this->ClickCommission;
			if ($commission == '') {
				$commission = 0;
			}

			if ($commission == 0) {
				QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Commission is zero", __FILE__, __LINE__);
			}
		}

		return $commission;
	}


	function getCommissionMultiTier($params) {

		if ($this->CampaignCommType != TRANSTYPE_CLICK) {
			QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Campaign type is not per click", __FILE__, __LINE__);

			return false;
		}

		// compute commission
		$commission = $this->STClickCommission[$params['tier']];

		if ($commission == '') {
			$commission = 0;
		}

		if ($commission == 0) {
			QCore_History::writeHistory(WLOG_DEBUG, "Click registration: Click commission is zero", __FILE__, __LINE__);
		}

		return $commission;
	}


	function checkSpecialCommission($params) {

		//---------------------------------------
		// check if this user is not assigned in some special user commission category for this product category
		$sql = 'select cc.* from wd_pa_affiliatescampaigns ac, wd_pa_campaigncategories cc ' .
				'where cc.campaignid=' . _q($this->CampaignID) .
				'  and cc.campcategoryid=ac.campcategoryid' .
				'  and ac.rstatus=' . _q(AFFSTATUS_APPROVED) .
				'  and ac.affiliateid=' . _q($params['userID']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		if (!$rs)
			return false;

		if (!$rs->EOF) {
			if ($this->CampaignCategoryID != $rs->fields['campcategoryid']) {
				// user is in different commission category, get the commission level
				$this->STClickCommission[$params['tier']] = $rs->fields['st' . $params['tier'] . 'clickcommission'];
				QCore_History::writeHistory(WLOG_DEBUG, "Click registration: User " . $params['userID'] . " has special commission category", __FILE__, __LINE__);
			}
		} else {
			// get commission from default commission category
			$sql = 'select * from wd_pa_campaigncategories ' .
					'where deleted=0 and campaignid=' . _q($this->CampaignID) .
					'  and name=' . _q(UNASSIGNED_USERS);
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			if (!$rs || $rs->EOF)
				return false;

			$this->STClickCommission[$params['tier']] = $rs->fields['st' . $params['tier'] . 'clickcommission'];
		}

		return true;
	}



	function redirect($destUrl = '', $transferMethod = false) {
		$a_bid = $_SESSION['bid'];

		//-------------------get T-Page Text and Image------------------------
		$useCardTPage = false;

		$sql = "SELECT * " .
				"FROM cms_cards " .
				"WHERE cardId = '$a_bid'";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		$card = $rs->fields;

		if ($card) {
			$tPageImage = $card['imagePath'];
			if (!$tPageImage) {
				// use default image ?
			}

			$tPageText = $card['tPageText'];
			if (!$tPageText) {

				// look up merchant name
				$mid = $card['merchant'];
				if ($mid) {
					$sql = "SELECT * FROM cms_merchants WHERE merchantid=" . intval($mid);
					$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
					$merchant = $rs->fields;

					if ($merchant) {
						$tPageText = "<p><span>Transferring you</span><br>to {$merchant['merchantname']}'" . (substr($merchant['merchantname'], strlen($merchant['merchantname']) - 1, 1) === 's' ? '' : 's') . " <i>secure</i> application</p>";
					}
				}

				if (!$tPageText) {
					$tPageText = "You are being directed to a secure application.";
				}
			}

			if ($tPageImage && $tPageText) {
				$useCardTPage = true;
			}
		} else {

			$sql = "SELECT merchant_service_image_path " .
					"FROM cms_merchant_service_details " .
					"WHERE merchant_service_id = '$a_bid'";
			$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
			$ms = $rs->fields;

			if ($ms) {
				$tPageImage = $ms['merchant_service_image_path'];
				$tPageText = "You are being directed to the Merchant Account Offer of your choice.";

				if ($tPageImage && $tPageText) {
					$useCardTPage = true;
				}
			}
		}

		// concatenate name and category or CCCOM-793 purpose
		//newloading.php uses $CardNameAndCategory variable
		$CardNameAndCategory = $card["id"]. "|" . $this->_getSessionParam('fid') ;

		$realRootPath = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));

		// Unique 25 digit number used for SiteCatalyst variable
		if (!empty($_SESSION['oid'])) {
			//mobile site sent purchaseid
			$this->_purchaseId = $_SESSION['oid'];
		} else {
			$purchaseId = ENTITY_ID . date('YmdHis') . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
			$this->_purchaseId = $purchaseId;
		}

		$this->_transfer($transferMethod);

		if ($transferMethod == self::TRANSFER_METHOD_DIRECT_WITH_TRACKING) {
			include $realRootPath . "/blankloading.php";
		} else if ($useCardTPage) {
			include($realRootPath . "/newloading.php");
		} else {
			include($realRootPath . "/loading.php");
		}
	}

	//--------------------------------------------------------------------------

	function applyFraudProtection($ip, &$status)
	{
		// find initial click (first non-declined within this day)
		$sql = "select dateinserted as aa from wd_pa_transactions " .
				"where transtype=" . TRANSTYPE_CLICK .
				"  and transkind=" . TRANSKIND_NORMAL . " and ip=" . _q($ip) .
				"  and rstatus<>" . AFFSTATUS_SUPPRESSED .
				"  and (" . sqlTimeToSec(sqlNow()) . " - " . sqlTimeToSec('dateinserted') . "<" . $this->ClickFrequency . ")";
		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		if (!$ret) {
			$errorMsg = "Click registration (fraud protection): Error saving click";
			LogError($errorMsg, __FILE__, __LINE__);

			return false;
		}

		if (!$ret->EOF) {
			if ($this->FrequentClicks == 2) {
				return false;
			}

			// decline the transaction
			$status = AFFSTATUS_SUPPRESSED;
		}

		return true;
	}

	function toString()
	{
		$resultArray = array("Affiliate ID: "   => $this->UserID,
		                     "Campaign ID"      => $this->CampaignID,
		                     "Banner ID: "      => $this->BannerID,
		                     "Destination URL " => $this->destinationURL,
		);
		$retString = "";
		foreach ($resultArray as $col => $val) {
			$retString .= "<tr><td><b>$col</b></td><td>$val</td></tr>";
		}

		return "<table>" . $retString . "</table>";
	}

	/**
	 * Transfer transaction to transaction server
	 *
	 * @param bool $transferMethod
	 */
	function _transfer($transferMethod = false)
	{
		$url = $this->_getTransferUrl();

		switch ($transferMethod) {
			case self::TRANSFER_METHOD_DIRECT:
				header('location: ' . $url);
				die();
				break;
			case self::TRANSFER_METHOD_SHORT_REDIRECT:
				header('refresh: 1; url=' . $url);
				break;
			case self::TRANSFER_METHOD_DIRECT_WITH_TRACKING:
				header('refresh: 0; url=' . $url);
				break;
			default :
				header('refresh: 2; url=' . $url);
				break;
		}
	}

	/**
	 * @return string
	 */
	protected function _getTransferUrl()
	{
		$badCharsExpression = '/[\'\"\@\%\;]/';
		$replacementChars = '';

		$aid = $this->_getSessionParam('aid');
		$sid = $this->_getSessionParam('sid');

		//Check to see if the aid or sid were passed in through the url.  If so, replace the values of sid and aid with the
		//url values.
		if (array_key_exists('aid', $_GET) && isset($_GET['aid'])) {
			$aid = preg_replace($badCharsExpression, $replacementChars, urldecode($_GET['aid']));
		}

		if (array_key_exists('sid', $_GET) && isset($_GET['sid'])) {
			$sid = preg_replace($badCharsExpression, $replacementChars, urldecode($_GET['sid']));
		}

		$ptv = array();
		if (isset($_GET['ptv'])) {
			$ptv = $_GET['ptv'];
		}

		/* Query string parameters to forward */
		$qsParams = array(
			'aid'   => CCCOM_DEFAULT_AID,
			'tsid'  => $aid, // Affiliate IDs are sent as traffic sources to the transnode
			'tid'   => $this->_getSessionParam('tid'),
			'cid'   => $this->_getSessionParam('cid'),
			'did'   => $this->_getSessionParam('did'),
			'fid'   => $this->_getSessionParam('fid'),
			'pos'   => $this->_getSessionParam('page_pos'),
			'evid'  => $this->_getSessionParam('external_visit_id'),
			'ref'   => "",
			'oid'   => $this->_purchaseId,
			'data3' => $this->_getSessionParam('data3'),
			'sid'   => $sid,
			'c'     => $this->_getSessionParam('bid'),
			'ptv'   => $ptv,
		);

		$urlParams = http_build_query($qsParams);

		$url = TRANSFER_URL . '?' . $urlParams;

		return $url;
	}

	protected function _getSessionParam($key, $default = '') {

		$value = $default;

		if(isset($_SESSION[$key])) {
			$value = $_SESSION[$key];
		}

		return $value;
	}
}
