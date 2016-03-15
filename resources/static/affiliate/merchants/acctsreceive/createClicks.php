<?php
include_once('global.php');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');

$tacc = new Affiliate_Merchants_Bl_Transactions();
for($i = 1; $i <= 1350; $i++){
	$tacc->_create_clicks(10000);
	echo $i * 10000 . " clicks created.\n";
}

?>
