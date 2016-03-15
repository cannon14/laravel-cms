<?php
/**
 * Chameleon Gateway
 * 
 * The chameleon project is designed to give an independent view of click data on a page by page basis.
 * This file sets the Chameleon cookie and loads data into that cookie.  The cookie will be read again
 * at click time to insert its data into persistance.
 * 
 * @author Jason Huie <jasonh@creditcards.com>
 */

if($_GET['aid'] == CHAMELEON_AFFILIATE || $_GET['a_aid'] == CHAMELEON_AFFILIATE){
	QUnit_Global::includeClass('Affiliate_Scripts_Bl_Chameleon');
	
	$chameleon = new Affiliate_Scripts_Bl_Chameleon();
	$chameleon->setAffiliate(isset($_GET['aid']) ? $_GET['aid'] : $_GET['a_aid']);
	$chameleon->setBanner(isset($_GET['bid']) ? $_GET['bid'] : $_GET['a_bid']);
	$chameleon->setLandingPage($_SESSION['fid']);
	
	$chameleon->sendCookie();
}
?>