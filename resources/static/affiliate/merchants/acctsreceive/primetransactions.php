<?php
include_once('global.php');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Transactions');

$tacc = new Affiliate_Merchants_Bl_Transactions();
$tacc->_prime_clicks();

?>
