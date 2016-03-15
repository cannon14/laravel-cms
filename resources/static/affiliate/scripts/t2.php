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
$aid = $_REQUEST['a_aid'];
$bid = $_REQUEST['a_bid'];
$Data1 = $_REQUEST['data1'];
$Data2 = $_REQUEST['data2'];
$Data3 = $_REQUEST['data3'];

$referrer = $_REQUEST['referrer'];
if($aid == '')
{
  $errorMsg = "Click registration: Missing Affiliate ID when calling click registration";
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}

$affiliateID = preg_replace('/[\'\"]/', '', $aid);
$bannerID = preg_replace('/[\'\"]/', '', $bid);
$Data1 = preg_replace('/[\'\"]/', '', $Data1);
$Data2 = preg_replace('/[\'\"]/', '', $Data2);
$Data3 = preg_replace('/[\'\"]/', '', $Data3);

$clickReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_ClickRegistrator');

$clickReg->setExtraData($Data1, $Data2, $Data3);

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
  $errorMsg = "Click registration: Campaign with ID: $campaignID doesn't exist";
  LogError($errorMsg, __FILE__, __LINE__);
  return;
}
DebugMsg("Click registration: After check that product category exists, OK", __FILE__, __LINE__);

if(!$clickReg->checkUserInCampaign())
{
  $errorMsg = "Click registration: Affiliate ID: $affiliateID doesn't belong to the campaign ID: $campaignID";
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
$clickReg->saveClick($referrer);
DebugMsg("Click registration: End registering click", __FILE__, __LINE__);

?>
OK
