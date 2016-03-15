<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleRegistrator');

DebugMsg("Sale registration: Start registering sale, params: ".getParams($_REQUEST), __FILE__, __LINE__);

$TotalCost = preg_replace('/[^0-9\.\,]/', '', $_REQUEST['TotalCost']);
$TotalCost = str_replace(',', '.', $TotalCost);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['OrderID']);
$ProductID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['ProductID']);
$AccountID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['AccountID']);
$Data1 = preg_replace('/[\'\"]/', '', $_REQUEST['data1']);
$Data2 = preg_replace('/[\'\"]/', '', $_REQUEST['data2']);
$Data3 = preg_replace('/[\'\"]/', '', $_REQUEST['data3']);

$saleReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_SaleRegistrator');

$saleReg->setAccountID($AccountID);

$saleReg->setP3PPolicy();

$saleReg->loadLanguage();

$saleReg->setExtraData($Data1, $Data2, $Data3);

// register sale
if($saleReg->decodeData($_COOKIE[COOKIE_NAME]))
    $saleReg->registerSale($TotalCost, $OrderID, $ProductID);
else
    DebugMsg("Sale registration: Data not decoded, failed to save sale", __FILE__, __LINE__);

DebugMsg("Sale registration: End registering sale", __FILE__, __LINE__);
?>
OK
