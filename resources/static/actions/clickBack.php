<?php
/**
 * Clickback Listener Script
 * 
 * This script is called by the loading page in an image tag 
 * and will load a trackback URL if one exists for the current
 * affiliate.
 * 
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 */
require 'global.php';
session_start();

QUnit_Global::includeClass('Affiliate_Scripts_Bl_ClickBackFacade');

$url = Affiliate_Scripts_Bl_ClickBackFacade::getClickBackUrl(
	$_SESSION['aid'], 
	$_SESSION['banner_id'], 
	$_SESSION['bid'] , 
	$_SESSION['fid']
);

if($url) {
	header('location: ' . $url);
}
?>