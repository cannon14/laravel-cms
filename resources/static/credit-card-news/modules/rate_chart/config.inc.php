<?php
$LINK_MAPPING = array (
	'Low Interest' 	   => 'low-interest.php',
	'Balance Transfer' => 'balance-transfer.php',
	'Instant Approval' => 'instant-approval.php',
	'Reward' 		   => 'reward.php',
	'Cash Back'		   => 'cash-back.php',
	'Airline' 		   => 'airline-miles.php',
	'Business' 		   => 'business.php',	
	'For Bad Credit'   => 'bad-credit.php',
	'Student' 		   => 'college-students.php',
	'National Average' => 'weekly-rate-report.php',
);

define('EHS_LINK', 'http://feeds.creditcards.com/ehs?aid=ed59a89f&module=rate_table&medium=xml');
define('REFRESH_THRESHOLD_MINUTES', 24*60);
?>