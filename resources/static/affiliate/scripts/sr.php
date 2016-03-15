<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// save referrer
$ref = $_REQUEST['ref'];

$uselessReferrers = array
(
    '127.0.0.1',
    'webradev.com',
    'postaffiliate.com',
    'postaffiliatepro.com'
);

// if it contains useless referrer, exit
foreach($uselessReferrers as $key)
{
    if(strpos($ref, $key) !== false)
    {
        print 'OOK';
        exit;
    }
}

// check for first available cookie
$freeIndex = -1;
for($i=0; $i<10; $i++)
{
    $oldref = $_COOKIE['PAPR_'.$i];
    
    // check if referrer is not the same
    if($oldref == $ref)
    {
        print 'SOK';
        exit;
    }
    
    if($oldref == '')
    {
        $freeIndex = $i;
        break;
    }
}

if($freeIndex != -1)
{
    // save referrer to this cookie
    setcookie('PAPR_'.$freeIndex, $ref, time() + 3650*86400, '/');
}
?>
OK
