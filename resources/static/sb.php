<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

DebugMsg("BannerViewer: Start registering impression, params: ".getParams($_REQUEST), __FILE__, __LINE__);

QUnit_Global::includeClass('Affiliate_Scripts_Bl_BannerViewer');

// check if it has correct parameters
if(!isset($_REQUEST['a_bid']) || $_REQUEST['a_bid'] == ''
	|| !isset($_REQUEST['a_aid']) || $_REQUEST['a_aid'] == '') {
	$errorMsg = "Show banner: Wrong parameters";
	LogError($errorMsg, __FILE__, __LINE__);
	return;
}

$bannerID = preg_replace('/[\'\"]/', '', $_REQUEST['a_bid']);
$affiliateID = preg_replace('/[\'\"]/', '', $_REQUEST['a_aid']);
$data1 = preg_replace('/[\'\"]/', '', $_REQUEST['data1']);

$bannerViewer = QUnit_Global::newObj('Affiliate_Scripts_Bl_BannerViewer');

$bannerViewer->setExtraData($data1);

// check if this affiliate and banner exist
// IMPORTANT! we have to check for affiliate first
if(!$bannerViewer->checkUserExists($affiliateID)) {
	$errorMsg = "Show banner: Affiliate with ID '$affiliateID' doesn't exist";
	LogError($errorMsg, __FILE__, __LINE__);
	return;
}
if(!$bannerViewer->checkBannerExists($bannerID)) {
	$errorMsg = "Show banner: Banner with ID '$bannerID' doesn't exist";
	LogError($errorMsg, __FILE__, __LINE__);
	return;
}

// redirect to destination page
$bannerViewer->redirect();
?>