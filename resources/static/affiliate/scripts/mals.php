<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
// Mals callback script
//============================================================================

// include files
require_once('global.php');

DebugMsg("Mals callback: started, params username='".$_REQUEST['username']."',  subtotal='".$_REQUEST['subtotal']."', sd='".$_REQUEST['sd']."', voucher='".$_REQUEST['voucher']."', vval='".$_REQUEST['vval']."', cart='".$_REQUEST['cart']."'", __FILE__, __LINE__);
    
if($_REQUEST['sd'] == '')
{
    DebugMsg("Mals callback: no affiliate parameter given, customer was not referred by any affiliate, or error in passed parameters", __FILE__, __LINE__);
    return; // no affiliate parameter given, customer was not referred by any affilliate
}

$ABid = preg_replace('/[\'\"\ ]/', '', $_REQUEST['sd']);
$TotalCost = preg_replace('/[^0-9\.]/', '', $_REQUEST['subtotal']);
$OrderID = preg_replace('/[\'\"\ ]/', '', $_REQUEST['voucher']);
$IP = preg_replace('/[\'\"\ ]/', '', $_REQUEST['ip']);

$saleReg = new SaleRegistrator();

// register sale
DebugMsg("Mals callback: Start registering sale, params TotalCost='".$TotalCost."', OrderID='".$OrderID."', ProductID=''", __FILE__, __LINE__);
                
if($saleReg->decodeData($ABid))
    $saleReg->registerSale($TotalCost, $OrderID, '', $IP);
else
    DebugMsg("Mals callback: Data not decoded, failed to save sale", __FILE__, __LINE__);

DebugMsg("Mals callback: End registering sale", __FILE__, __LINE__);
?>
OK
