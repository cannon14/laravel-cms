<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// Verisign callback script
//============================================================================

// include files
require_once('global.php');

DebugMsg("Verisign callback: started, params PNREF='".$_POST['PNREF']."', RESULT='".$_POST['RESULT']."', AMOUNT='".$_POST['AMOUNT']."', USER1='".$_POST['USER1']."'", __FILE__, __LINE__);
    
if($_POST['RESULT'] != 0)
{
    $errorMsg = "Verisign callback: transaction was not approved";
    LogError($errorMsg, __FILE__, __LINE__);    
    return; // transaction was not approved
}
    
if($_POST['USER1'] == '')
{
    DebugMsg("Verisign callback: no affiliate parameter given, customer was not referred by any affiliate, or error in passed parameters", __FILE__, __LINE__);
    return; // no affiliate parameter given, customer was not referred by any affilliate
}

$ABid = preg_replace('/[\'\"\ ]/', '', $_POST['USER1']);
$TotalCost = preg_replace('/[^0-9\.]/', '', $_POST['AMOUNT']);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_POST['PNREF']);

$saleReg = new SaleRegistrator();

// register sale
DebugMsg("Verisign callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$OrderID."', ProductID=''", __FILE__, __LINE__);
                
if($saleReg->decodeData($ABid))
    $saleReg->registerSale($TotalCost, $OrderID, '');
else
    DebugMsg("Verisign callback: Data not decoded, failed to save sale", __FILE__, __LINE__);

DebugMsg("Verisign callback: End registering sale", __FILE__, __LINE__);
?>