<?
//============================================================================
// Copyright (c) webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

include_once('global.php');

$page = QUnit_Global::newobj('QUnit_UI_MainPage');

#$page->setDefaultView('MerchantProfile');
$page->setDefaultView('KeywordsManager');
$page->user_type = USERTYPE_ADMIN;
$page->setFilePrefix('Affiliate_Merchants_Views_');
$_SESSION["TABSELECTED"]=0;
echo $page->process();
?>