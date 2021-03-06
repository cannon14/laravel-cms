<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickRegistrator');

DebugMsg("Click registration: Start registering click, params: ".getParams($_REQUEST), __FILE__, __LINE__);

// check if it has correct parameters
if(!isset($_REQUEST['a_aid']) || $_REQUEST['a_aid'] == '')
{
  $errorMsg = "Click registration: Missing Affiliate ID when calling click registration";
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}

$affiliateID = preg_replace('/[\'\"]/', '', $_REQUEST['a_aid']);
$bannerID = preg_replace('/[\'\"]/', '', $_REQUEST['a_bid']);
$data1 = preg_replace('/[\'\"]/', '', $_REQUEST['data1']);
$data2 = preg_replace('/[\'\"]/', '', $_REQUEST['data2']);
$data3 = preg_replace('/[\'\"]/', '', $_REQUEST['data3']);

$clickReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');

$clickReg->setExtraData($data1, $data2, $data3);

// check if this affiliate and campaign exist
if(!$clickReg->checkUserExists($affiliateID))
{
  $errorMsg = "Click registration: Affiliate with ID: $affiliateID doesn't exist";
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}
DebugMsg("Click registration: After check that affiliate exists, OK", __FILE__, __LINE__);

if(!$clickReg->checkBannerExists($bannerID, true))
{
  $errorMsg = "Click registration: Banner with ID: $bannerID doesn't exist and cannot find any campaign for affiliate with ID: $affiliateID";
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}
DebugMsg("Click registration: After check that banner exists, OK", __FILE__, __LINE__);

if(!$clickReg->checkCampaignExists())
{
  $errorMsg = "Click registration: Campaign with ID: ".$clickReg->campaignID." doesn't exist";
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}
DebugMsg("Click registration: After check that product category exists, OK", __FILE__, __LINE__);

if(!$clickReg->checkUserInCampaign())
{
  $errorMsg = "Click registration: Affiliate ID: $affiliateID doesn't belong to the campaign ID: ".$clickReg->campaignID;
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}
DebugMsg("Click registration: After check that affiliate is in this product category, OK", __FILE__, __LINE__);

// this script should:
//  1. set cookie
//  2. save transaction to the DB
//  3. redirect to destination page

// setting cookie
$clickReg->setCookie();
DebugMsg("Click registration: After setting cookie, OK", __FILE__, __LINE__);

// saving transaction to DB
$clickReg->saveClick();

DebugMsg("Click registration: End registering click", __FILE__, __LINE__);

// redirect to destination page
$clickReg->redirect($_REQUEST['desturl']);

if($clickReg->CampaignID == null){
	header('Location: http://www.google.com');
}else{
	
	print_r('<pre>'.$clickReg.'</pre>');
	$clickReg->redirect($_REQUEST['desturl']);
}
?>
