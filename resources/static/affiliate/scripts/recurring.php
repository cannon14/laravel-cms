<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');

$recComm = new RecurringCommissions();

$count = $recComm->generateTransactions();

if($count == false)
    $count = 0;

print 'Generated '.$count.' recurring transactions';
?>
