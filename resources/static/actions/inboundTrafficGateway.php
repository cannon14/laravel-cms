<?php
/**
 * Inbound Traffic Gateway.
 *
 * The purpose of this script is to set all tracker variables and
 * initialize state variables (including cookies) which must be set
 * when a click comes inbound to CCDC.
 *
 * @author Patrick J. Mizer <patrick@creditcards.com>
 */

QUnit_Global::includeClass('Affiliate_Scripts_Services_TrafficService');
QUnit_Global::includeClass('Affiliate_Scripts_Services_InboundTrafficService');
QUnit_Global::includeClass('Affiliate_Scripts_Services_TrafficServiceFilter');
QUnit_Global::includeClass('Affiliate_Scripts_Services_OrganicSearchFilter');

// We only instantiate a new InboundClickService if there is no external_visit_id session
// (this means that the user's previous session expired or they are a new visitor) or
// there is a a_aid in the QS (this means that they have come in as a different traffic source).
// We also check to make sure that the a_aid != the contents of the CURRREF cookie.

if(isset($_GET['aid'])) {
	$_GET['a_aid'] = $_GET['aid'];
}

// Check the currref == a_aid logic.
if(!isset($_SESSION['external_visit_id']) || isset($_GET['a_aid']) || isset($_GET['aid'])){
			//&& $_GET['a_aid'] != $_COOKIE['CURRREF']){

	// Unset is landing page
	$_SESSION['landing_page_set'] = false;

	$badCharsExpression = '/[\'\"\@\%\;]/';
	$replacementChars = '';
	// Set QS data.
	$aid 	= ( isset( $_GET['aid'] ) ? preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['aid'])) : preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['a_aid'])) );
	$bid 	= ( isset( $_GET['bid'] ) ? preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['bid'])) : preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['a_bid'])) );
	$cid 	= ( isset( $_GET['cid'] ) ? preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['cid'])) : preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['a_cid'])) );
	$did 	= ( isset( $_GET['did'] ) ? preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['did'])) : preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['a_did'])) );
	$fid	= $_SESSION['fid'];
	$tid	= preg_replace($badCharsExpression,$replacementChars,urldecode($_GET['tid']));


	$ad_services = array(
	       "adused", //Google
	       "ADID",   //MSN
           "adid"
	);

	$external_ad_id = "";

	foreach($ad_services as $ad_var)
	{
	   if(isset($_GET[$ad_var]))
	   {
	       $external_ad_id = preg_replace($badCharsExpression,$replacementChars,urldecode($_GET[$ad_var]));
	       break;
	   }
	}


	// Instantiate service.
	$inboundService = new Affiliate_Scripts_Services_InboundTrafficService(
		$aid,
		$bid,
		$cid,
		$did,
		$fid,
		$tid,
		$_SERVER['REMOTE_ADDR'],
		$_SERVER['HTTP_REFERER'],
		$_SERVER['HTTP_USER_AGENT'],
		$_SERVER['HTTP_X_FORWARDED_FOR'],
		$_SERVER['HTTP_TRUE_CLIENT_IP'],
		$external_ad_id
	);

	if($inboundService->isAffiliateIdInBlackList($aid) == true) {
		header("Location: " . BLACKLIST_OTHER_OFFERS_REDIRECT);
		exit;
	}

	// Register organic search filter.
	$inboundService->registerFilter(new Affiliate_Scripts_Services_OrganicSearchFilter());

	// Run filters.
	$inboundService->executeFilters();

	// Debug.
	// echo '<div style="border : solid 1px #ff0000; background : #ffffff"><pre>' . print_r($inboundService, 1). '</pre></div>';

	// Set cookies.
	$inboundService->setCookies();

	// Register click.
	$inboundService->registerInboundClick();

   // Temporary transition code
   if(isset($_GET['a_aid']) || isset($_GET['aid'])){
   		unset($_COOKIE['ACTREF']);
   }

	$_SESSION['new_visitor'] = ($_COOKIE['CCCID'] ? 0 : 1);

	$_SESSION['aid'] 		= $inboundService->trafficSourceRefId;
	$_SESSION['bid'] 		= $inboundService->adId;
	/* This 2nd ad ID assignment is necessary because $_SESSION['bid'] is overwritten in oc.php (sigh)*/
	$_SESSION['banner_id']          = $inboundService->adId;
	$_SESSION['cid'] 		= $inboundService->externalCampaignId;
	$_SESSION['did'] 		= $inboundService->keywordId;
	$_SESSION['tid'] 		= $inboundService->tokenId;

	$_SESSION['hid'] = 36;
	///////////////////////////////

	// Set external visit ID.  This will link all subsequent actions to the, now stored, external_visit_data.
	$_SESSION['external_visit_id'] = $inboundService->externalVisitId;

}