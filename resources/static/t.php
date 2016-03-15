<?php

//global connection file
require_once('global.php');

$all = $_SERVER['QUERY_STRING'];
list ($a_bid, $directTransfer) = split ('-', $all);

QUnit_Global::includeClass('Affiliate_Scripts_Bl_CookieManager');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_Chameleon');
QUnit_Global::includeClass('QCore_Settings');

$clickReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');

session_start();

$_SESSION['bid'] = $a_bid;

$settings = QCore_Settings::_getSettings(3);

if ($settings['Aff_csCookie'] == 1) {
		
	// [Begin Session Fix and Activity Tracking]
	// Here we will check to make sure Session is valid, if not
	// we will try to reload them from cookies.
	$scManager = new SessionCookieManager();
	
	if (!$scManager->validateSessionData()) {
		if ($_SESSION['aid'] == '' && $_SESSION['bid'] == '') {	 
			$vCookie = $a_aid = 1099;
			$_SESSION['aid'] = $a_aid;
		}
		
		if ($_SESSION['aid'] == '' && $_SESSION['bid'] != '') {   
			$vCookie = $a_aid = 998;
			$_SESSION['aid'] = $a_aid;
		}
		include_once('affiliate/scripts/cccomCookie.php');
	}
	
	// Next we set additional tracking data
	$scManager->prepareClickData();
	// ... and pass them along to registrator so that ClickRegistrator has access.
	
	if ($vCookie != null) {
		
		if (($ccid = $scManager->getClickData("CCCID")) == null) {
			$ccid = $_SESSION['CCCID'];
		}
		
		$clickReg->setCookieData(
			$vCookie,
			$scManager->getClickData("CURRREF"),
			$scManager->getClickData("PREVREF"),
			$ccid,
			$scManager->getInceptionDate()
		);
	} else {
		$clickReg->setCookieData(
			$scManager->getClickData("CURRREF"),
			$scManager->getClickData("PREVREF"),
			$scManager->getClickData("THIRDREF"),
			$scManager->getClickData("CCCID"),
			$scManager->getInceptionDate()
		);		
	}
	// [End Session Fix and Activity Tracking]
}

				
if ($_SESSION['aid'] == '' && $_SESSION['bid'] == '') {
	$a_aid = 1099;
	$_SESSION['aid'] = $a_aid;
}

if ($_SESSION['aid'] == '' && $_SESSION['bid'] != '') {
	$a_aid = 998;
	$_SESSION['aid'] = $a_aid;
}
		 
// This code is to handle if any of the vars are not set 
//		 *** SHOULD BE REVIEWED ***
if ($_SESSION['cid'] == '') {
	$_SESSION['cid'] = '9999';
}
if ($_SESSION['eid'] == '') {
	$_SESSION['eid'] = '99';
}
if ($_SESSION['did'] == '') {
	$_SESSION['did'] = '9999';
}
if ($_SESSION['fid'] == '') {
	$_SESSION['fid'] = '98';
}

// check if it has correct parameters
if (!isset($_SESSION['aid']) || $_SESSION['aid'] == '') {
	$errorMsg = "Click registration: Missing Affiliate ID when calling click registration";
	LogError($errorMsg, __FILE__, __LINE__);
	return;
}

$affiliateID = preg_replace('/[\'\"]/', '', $_SESSION['aid']);
$bannerID = preg_replace('/[\'\"]/', '', $_SESSION['bid']);
$data1 = preg_replace('/[\'\"]/', '', $_SESSION['tid']);
$data2 = preg_replace('/[\'\"]/', '', $_REQUEST['data2']);
$data3 = preg_replace('/[\'\"]/', '', $_REQUEST['data3']);


$clickReg->setExtraData($data1, $data2, $data3);


// check if this affiliate and campaign exist

if(!$clickReg->checkUserExists($affiliateID)) {
	$errorMsg = "Click registration: Affiliate with ID: $affiliateID doesn't exist";
	LogError($errorMsg, __FILE__, __LINE__);
	require_once('invalid-card-level.php');
}

/*
if(!$clickReg->checkBannerExists($bannerID, true))
{
  $errorMsg = "Click registration: Banner with ID: $bannerID doesn't exist and cannot find any campaign for affiliate with ID: $affiliateID";
  LogError($errorMsg, __FILE__, __LINE__);
  require_once('invalid-banner-level.php');
}

if(!$clickReg->checkCampaignExists())
{
  $errorMsg = "Click registration: Campaign with ID: ".$clickReg->campaignID." doesn't exist";
  LogError($errorMsg, __FILE__, __LINE__);
 require_once('invalid-campaign-level.php');
}

if(!$clickReg->checkUserInCampaign())
{
  $errorMsg = "Click registration: Affiliate ID: $affiliateID doesn't belong to the campaign ID: ".$clickReg->campaignID;
  LogError($errorMsg, __FILE__, __LINE__);
  require_once('invalid-campaign-cat-level.php');
}
*/

//CHAMELEON CODE----------------------------------------------------------------------------------------
if (isset($_COOKIE['chameleon'])) {
	$chameleon = new Affiliate_Scripts_Bl_Chameleon($_COOKIE['chameleon']);
	$chameleon->setCard($a_bid);
	$chameleon->setExitPage($_SESSION['fid']);
	$chameleon->setDate(date('Y-m-d H:i:s'));
	
	$chameleon->sendCookie();
	$chameleon->saveCookie();
}
//END CHAMELEON CODE------------------------------------------------------------------------------------

// this script should:
//  1. set cookie
//  2. save transaction to the DB
//  3. redirect to destination page

// setting cookie
$clickReg->setCookie();

/* New redirect code */
$clickReg->redirect();
?>