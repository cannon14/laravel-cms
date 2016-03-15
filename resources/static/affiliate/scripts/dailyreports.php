<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

// include files
require_once('global.php');


$dailyReports = new DailyReports();

$count = $dailyReports->sendDailyReports();

if($count == false)
    $count = 0;

print 'Generated '.$count.' daily reports';
?>
