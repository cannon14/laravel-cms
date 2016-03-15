<?php

$LINK_MAPPING = array (
    'Low Interest Credit Cards'        => '/low-interest.php',
    'Balance Transfer Credit Cards' => '/balance-transfer.php',
    'Instant Approval Credit Cards' => '/instant-approval.php',
    'Reward Credit Cards'          => '/reward.php',
    'Cash Back Credit Cards'           => '/cash-back.php',
    'Airline Credit Cards'         => '/airline-miles.php',
    'Business Credit Cards'            => '/business.php',   
    'Credit Cards For Bad Credit'   => '/bad-credit.php',
    'Student Credit Cards'         => '/college-students.php',
    'National Average'				=> '/weekly-rate-report.php',
);

define('EHS_LINK',                  'http://feeds.creditcards.com/widget/?aid=ed59a89f&widget=rate_table&medium=xml&show_nat_avg=1&show_logo=&num_rates=&ext_win=&cobrandPage=');
define('REFRESH_THRESHOLD_MINUTES', 24*60);
define('RATE_REPORT_LINK',          '/rate-report');
?>