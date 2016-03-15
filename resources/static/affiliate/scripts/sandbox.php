<?php
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

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
$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);

if ($fp) 
{
    fputs ($fp, $header.$req);
    while (!feof($fp)) 
    {
        $res = fgets ($fp, 1024);
        
        if (strcmp ($res, "VERIFIED") != 0 && strcmp ($res, "INVALID") != 0)
            continue;
        
        if($handle = fopen('./sandbox.txt', 'a'))
        {
            fwrite($handle, "\n----------------------------------------------------------------\n\n");
            fwrite($handle, "\nRESULT: $res");
            fwrite($handle, "\nPOSTED: ");
            
            foreach ($_POST as $key => $value) 
                fwrite($handle, "\n    $key: $value");

            fwrite($handle, "\n----------------------------------------------------------------\n\n");
            
            fclose($handle);
        }
        else
            echo 'canot open file';
    }
    
    fclose ($fp);
}
?>
