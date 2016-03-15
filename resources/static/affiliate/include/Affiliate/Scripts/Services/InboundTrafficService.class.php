<?php

/**
 * Encapsulates behaviors needed for storing information from
 * inbound click (external vist).
 *
 * @author Patrick J. Mizer <patrick@creditcards.com>
 */
class Affiliate_Scripts_Services_InboundTrafficService extends Affiliate_Scripts_Services_TrafficService {

	var $externalVisitId;
	var $trafficSourceId;
	var $trafficSourceRefId;
	var $adId;
	var $externalCampaignId;
	var $keywordId;
	var $landingPageId;
	var $tokenId;
	var $newVisitor;
	var $ip;
	var $referer;
	var $userAgent;
	var $forwardingIp;
	var $cccid;
	var $curref;
	var $prevref;
	var $thirdref;
	var $refInceptionDate;
	var $externalAdId;

	/**
	 * InboundClickService Constructor.
	 *
	 * @author Patrick J. Mizer
	 * @access public
	 * @param aid Traffic source refid.
	 * @param bid Advertisement ID.
	 * @param cid External Campaign ID.
	 * @param did Keyword ID.
	 * @param fid Landing page ID.
	 * @param tid Token ID.
	 *
	 */
	function Affiliate_Scripts_Services_InboundTrafficService($aid, $bid, $cid, $did, $fid, $tid, $ip, $referer, $userAgent, $forwardedFor, $trueIp, $externalAdId) {
		parent::Affiliate_Scripts_Services_TrafficService();

		if ($forwardedFor) {
			$ipParts = explode(',', $forwardedFor);
			$this->ip = (count($ipParts) > 1 ? $ipParts[0] : $forwardedFor);
			$this->forwardingIp = $ip;
		} else {
			$this->ip = $ip;
		}

		/* If we are provided with a true client IP this trumps any other derived IP address */
		if ($trueIp) {
			$this->ip = $trueIp;
		}

		$this->referer = $referer;
		$this->userAgent = $userAgent;

		$this->externalVisitId = $this->_createExternalVisitId();
		$this->trafficSourceRefId = $this->_assignTrafficSourceRef($aid);
		$this->trafficSourceId = $this->_validatateTrafficSourceId($this->trafficSourceRefId);
		$this->adId = $this->_validateAdvertisementId($bid);
		$this->externalCampaignId = $this->_getExternalCampaignId($cid);
		$this->keywordId = $did;
		$this->landingPageId = $fid;
		$this->tokenId = $tid;
		$this->externalAdId = $externalAdId;

		$this->newVisitor = $this->_isNewVisitor();

		$this->_setPersistentAffiliateCookie();

	}

	function _getExternalCampaignId($cid) {
		if (isset($_COOKIE['p_cid']) && $_COOKIE['p_cid'] == DART_CAMPAIGN_ID) {
			return DART_CAMPAIGN_ID;
		}

		return $cid;
	}

	function _setPersistentAffiliateCookie() {
		if ($this->externalCampaignId == DART_CAMPAIGN_ID) {
			setcookie("p_cid", $this->externalCampaignId, time() + (60 * 60 * 24 * 30));
		}
	}

	function _assignTrafficSourceRef($aid) {
		// If AID is set then just return it.
		if ($aid != "") {
			$sql = '
SELECT IF(affiliate_id IS NULL, ' . TS_INVALID_TRAFFIC_SOURCE . ', IF(ref_id IS NULL, affiliate_id, ref_id)) AS ref_id
FROM
	( SELECT ' . _q($aid) . ' AS aid ) AS _aid
LEFT JOIN
	partner_affiliates AS pa
ON
	((_aid.aid = pa.ref_id OR _aid.aid = pa.affiliate_id) AND pa.deleted != 1 AND pa.status = "ACTIVE")
	';


			if (!($rs = $this->_query($sql))) {
				$this->_throwError('There was an SQL error while validating traffic source: ' . $sql);
				return null;
			}


			$oldAid = $aid;
			$aid = $rs->fields['ref_id'];


			if ($aid == TS_INVALID_TRAFFIC_SOURCE) {
				$this->log('Invalid Affiliate: ' . $oldAid);
			}

			return $aid;

			// IF AID is not set and neither is REFERER then we have
			// a direct type.
		} else if ($aid == "" && $this->referer == '') {
			return TS_DIRECT_TYPE_TRAFFIC_SOURCE;
			// Otherwise we have ROOT.
		} else {
			return TS_ROOT_TRAFFIC_SOURCE;
		}
	}

	/**
	 * Saves the member data to theexternal_visits table.
	 *
	 * @author Patrick J. Mizer
	 */
	public function registerInboundClick() {

		$sql = 'INSERT INTO external_visits (`external_visit_id`, `affiliate_id`, `ad_id`, ' .
			'`external_campaign_id`, `keyword_id`, `landing_page_id`, `ip`, ' .
			'`referer`,`cccid`, `curref`, `prevref`, `thirdref`, `ref_inception_date`, `new_visitor`, `insert_time`, `user_agent`, `forwarding_ip`, `external_ad_id`) VALUES ' .
			'(' . _q($this->externalVisitId) . ', ' . _q($this->trafficSourceId) . ', ' . _q($this->adId) . ', ' .
			_q($this->externalCampaignId) . ', ' . _q($this->keywordId) . ', ' . _q($this->landingPageId) . ', ' .
			_q($this->ip) . ', ' . _q($this->referer) . ', ' . _q($this->cccid) . ', ' .
			_q($this->curref) . ', ' . _q($this->prevref) . ', ' . _q($this->thirdref) . ', ' . _q($this->refInceptionDate) . ', ' .
			_q($this->newVisitor) . ', NOW(), ' . _q($this->userAgent) . ', ' . _q($this->forwardingIp) . ', ' . _q($this->externalAdId) . ')';


		if (!$this->_query($sql)) {
			$this->_throwError('There was an error saving inbound click, SQL: ' . $sql);
		}

		$this->_logExternalVisitDebug();

	}

	/**
	 * Saves the member data to the external_visits_debug table.
	 *
	 * @author Patrick J. Mizer
	 * @access public
	 */
	function _logExternalVisitDebug() {
		$sql = 'INSERT INTO ' . EXTERNAL_VISITS_DEBUG_TABLE
			. '(`external_visit_id`, `keyword_id`, `external_campaign_id`, `insert_time`) '
			. 'VALUES (' . _q($this->externalVisitId) . ', '
			. _q($this->keywordId) . ', ' . _q($this->externalCampaignId) . ', NOW())';

		if (!$this->_query($sql)) {
			$this->_throwError('There was an error saving inbound click, SQL: ' . $sql);
		}
	}

	/**
	 * Sets cookies if needed and sets cccid, curref, prevref, thirref, refinceptiondate
	 * member data.
	 *
	 * @author Patrick J. Mizer
	 * @access public
	 */
	function setCookies() {
		QUnit_Global::includeClass('Affiliate_Scripts_Bl_CookieManager');

		// Grab the IP address, sessionid, aid, and did from the session.
		// These should all initially be set upon hitting settings2.php.
		$ip = $this->ip;
		$session = session_id();

		$aid = $this->trafficSourceRefId;
		$bid = $this->adId;

		if (trim($ip) == "") $ip = "";
		if (trim($session) == "") $session = "";
		if (trim($aid) == "") $aid = "";
		if (trim($bid) == "") $bid = "";

		$cookieManager = new Affiliate_Scripts_Bl_CookieManager();

		// 4.0 Session Fix and Activity Tracking Functional Specifications

		// 1. When a user first enters, or sequentially visits
		// the CCCOM site they will check for a CCCID.
		// If one exist it moves on. IF it does not exist, it creates the
		// CCCID cookie and sets it in the session and in a static cookie
		// for an infinite time period.
		if (!$cookieManager->cookieExists("CCCID")) {
			$this->cccid = $this->_createCCIDCookie($cookieManager, $ip);

		} else {
			$this->cccid = $_COOKIE['CCCID'];
			$scManager = new SessionCookieManager();
			$this->refInceptionDate = $scManager->getInceptionDate();
		}

		// 2. Then a user is checked for an ACTREF cookie to see if there is
		// an Active Reference for the visit.  If there is an ACTREF cookie it moves on.
		// IF it does not exist, an ACTREF is set by using the current session ID,
		// Affiliate ID, Banner ID, and the date (YYYYMMDDMMSS).  Then it will move the PREVREF
		// to THIRDREF, the CURREF to the PREVREF, and the ACTREF to the CURREF.
		if (!$cookieManager->cookieExists("ACTREF")) {

			$this->_createACTREFCookie($cookieManager, $session, $aid, $bid);

		} else {
			$ACTREF = $cookieManager->fetchCookie("ACTREF", "_");
			$ACTREF_aid = $ACTREF->getValue(1);

			// 3. If the ACTREF is different from the current A_ID in the $REQUEST, then the
			// ACTREF is overwritten and then it will move the PREVREF to THIRDREF, the CURREF
			// to the PREVREF, and the ACTREF to the CURREF.
			if ($_GET['a_aid'] != "") {
				$this->_createACTREFCookie($cookieManager, $session, $_GET['a_aid'], $_GET['a_bid']);
			}
		}

	}

	/**
	 * Returns the traffic source ID associated with the refid provided.
	 * Returns appropriate ID for missing or invalid refid.
	 *
	 * @access private
	 * @param aid Traffic source refid.
	 * @return Traffic source ID.
	 */
	function _validatateTrafficSourceId($aid) {
		if ($aid == null) {
			$trafficSourceId = $this->_getTrafficSourceIdFromRef(TS_ROOT_TRAFFIC_SOURCE);
		} else {
			$sql = 'SELECT affiliate_id FROM partner_affiliates WHERE ref_id = ' . _q($aid) . ' OR affiliate_id = ' . _q($aid) . ' AND deleted != 1 AND status = "ACTIVE"';

			if (!($rs = $this->_query($sql))) {
				$this->_throwError('There was an SQL error while validating traffic source: ' . $sql);
				return null;
			}

			$trafficSourceId = $rs->fields['affiliate_id'];

			if ($trafficSourceId == null) {
				$trafficSourceId = $this->_getTrafficSourceIdFromRef(TS_INVALID_TRAFFIC_SOURCE);
				$this->_throwError('Invalid traffic source ID: ' . $aid);
			}
		}

		return $trafficSourceId;
	}

	/**
	 * Returns the traffic source ID associated with the refid provided.
	 *
	 * @author Patrick J. Mizer
	 * @access private
	 * @param aid Traffic source refid.
	 * @return Traffic source ID.
	 */
	function _getTrafficSourceIdFromRef($aid) {
		$sql = 'SELECT affiliate_id FROM partner_affiliates WHERE ref_id = ' . _q($aid);

		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

		return $rs->fields['affiliate_id'];

	}

	/**
	 * Validates and returns the advertisment ID.  Handles the case where
	 * adid is missing or invalid.
	 *
	 * @author Patrick J. Mizer
	 * @access private
	 * @param adid Advertisment ID.
	 * @return valid Advertiement ID.
	 */
	function _validateAdvertisementId($adid) {
		if ($adid == null) {
			$advertisementId = null;
		} else {
			$sql = 'SELECT banner_id FROM partner_banners
					WHERE banner_id = ' . _q($adid);

			if (!($rs = $this->_query($sql))) {
				$this->_throwError('There was an SQL error while validating advertisement: ' . $sql);
			}

			$advertisementId = $rs->fields['banner_id'];

			if ($advertisementId == null) {
				$advertisementId = TS_INVALID_ADVERTISEMENT;
				$this->_throwError('Invalid advertisement ID: ' . $adid);
			}
		}

		return $advertisementId;
	}

	/**
	 * Checks for the CCCID cookie to see whether the visitor has been here before.
	 *
	 * @author Patrick J. Mizer
	 * @access private
	 * @return boolean
	 */
	function _isNewVisitor() {
		return !isset($_COOKIE['CCCID']);
	}

	/**
	 * Creates a pseudo random ID for the external_visists table.
	 *
	 * @author Patrick J. Mizer
	 * @access private
	 * @return String pseudo random ID.
	 */
	function _createExternalVisitId() {

		return substr(ENTITY_ID . date('ymdHis') . md5(uniqid(rand(), true)), 0, 32);
	}

	/**
	 * Creates CCCID cookie.
	 *
	 * @author Patrick J. Mizer
	 * @access private
	 * @param CookieManger instance
	 * @param String IP address.
	 */
	function _createCCIDCookie($cookieManager, $ip) {
		$cookieValue = $ip . "_" . date("YmdHis") . "_" . substr(md5($ip . date("YmdHis") . rand()), 0, 8);
		$cookieTTL = (TS_COOKIE_TTL / 3);
		$this->refInceptionDate = date('Y-m-d H:i:s');
		$CCID = new Cookie("CCCID", $cookieValue, null, $cookieTTL);
		$cookieManager->setCookie($CCID);

		return $cookieValue;
	}

	/**
	 * Creates Actref cookie, and shifts curref->prevref->thirdref
	 *
	 * @author Patrick J. Mizer
	 * @access private
	 * @param CookieManger instance
	 * @param String session id.
	 * @param String TrafficSource refid.
	 * @param String AdvertisemntId.
	 */
	function _createACTREFCookie($cookieManager, $session, $aid, $bid) {

		$cookieValue = $session . "_" . $aid . "_" . $bid . "_" . date("YmdHi");
		$cookieTTL = (TS_COOKIE_TTL / 3);
		$ACTREF = new Cookie("ACTREF", $cookieValue, "_");

		$cookieManager->setCookie($ACTREF);

		// Set CURREFF
		$cookieValue = $aid;
		$CURRREF = new Cookie("CURRREF", $cookieValue, null, $cookieTTL);
		$cookieManager->setCookie($CURRREF);

		$this->curref = $cookieValue;

		//THIRDREF gets PREVREF
		if ($cookieManager->cookieExists("PREVREF")) {
			$PREVREF = $cookieManager->fetchCookie("PREVREF");
			$cookieValue = $PREVREF->getValue();
			$THIRDREF = new Cookie("THIRDREF", $cookieValue, null, $cookieTTL);
			$cookieManager->setCookie($THIRDREF);

			$this->thirdref = $cookieValue;
		}

		// PREVREF gets CURREF
		if ($cookieManager->cookieExists("CURRREF")) {
			$CURRREF = $cookieManager->fetchCookie("CURRREF");
			$cookieValue = $CURRREF->getValue();
			$PREVREF = new Cookie("PREVREF", $cookieValue, null, $cookieTTL);
			$cookieManager->setCookie($PREVREF);

			$this->prevref = $cookieValue;
		}

	}

	/**
	 * check affiliate id in the partner_affiliate_banner_blacklist
	 *
	 * @param string $aid
	 * @return bool true: affiliate id exist in the table
	 */
	public function isAffiliateIdInBlackList($aid) {
		$sql = 'SELECT count(aid) AS n FROM partner_affiliate_referral_blacklist WHERE aid = ' . _q($aid);

		if (!($rs = $this->_query($sql))) {
			$this->_throwError('There was an SQL error while validating advertisement: ' . $sql);
		}

		return ($rs->fields['n'] == 1);
	}
}
