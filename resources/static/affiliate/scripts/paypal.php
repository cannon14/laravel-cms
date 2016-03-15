<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

DebugMsg("PayPal callback: started", __FILE__, __LINE__);

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) 
{
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);

DebugMsg("PayPal callback: post back to PayPal", __FILE__, __LINE__);

if (!$fp) 
{
    // HTTP ERROR
    LogError("PayPal callback: HTTP error, cannot post back. Error number: $errno, Error msg: $errstr", __FILE__, __LINE__);
} 
else 
{
    fputs ($fp, $header.$req);
    while (!feof($fp)) 
    {
        // assign posted variables to local variables
        $item_name = $_POST['item_name'];
        $custom = $_POST['custom'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];
            
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "VERIFIED") == 0) 
        {
            DebugMsg("PayPal callback: returned VERIFIED", __FILE__, __LINE__);

            $postvars = '';
            foreach($_POST as $k=>$v)
                $postvars .= "$k=$v;";
            DebugMsg("PayPal callback: POST variables: $postvars", __FILE__, __LINE__);
                
            if($custom == '')
            {
                DebugMsg("PayPal callback: custom field is empty", __FILE__, __LINE__);                
            }
            else if($payment_status != "Completed")
            {
                DebugMsg("PayPal callback: payment status is not COMPLETED. Transaction: $txn_id, payer email: $payer_email", __FILE__, __LINE__);                
            }
            else
            {
                DebugMsg("PayPal callback: Start registering sale, custom field: $custom", __FILE__, __LINE__);
                
                $saleReg = new SaleRegistrator();
                
                // register sale
                if($saleReg->decodeData($custom))
                {
                    DebugMsg("PayPal callback: Start registering sale, params TotalCost='".$payment_amount."', OrderID='".$txn_id."', ProductID='".$item_number."'", __FILE__, __LINE__);
                    
                    $saleReg->registerSale($payment_amount, $txn_id, $item_number);
                    
                    DebugMsg("PayPal callback: End registering sale", __FILE__, __LINE__);
                }
                else
                {
                    DebugMsg("PayPal callback: SaleRegistrator->decodeData returned false", __FILE__, __LINE__);                
                }
                
                DebugMsg("PayPal callback: End registering sale", __FILE__, __LINE__);
            }
        }
        else if (strcmp ($res, "INVALID") == 0) 
        {
            // log for manual investigation
            LogError("PayPal callback: returned INVALID. Transaction: $txn_id, payer email: $payer_email", __FILE__, __LINE__);
        }
    }
    
    fclose ($fp);
}
?>