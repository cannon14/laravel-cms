<?php
/**
 * Banner Redirect Gateway
 * 
 * Lookup banner id and redirect accordingly.
 * 
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 */

require_once('global.php');

QUnit_Global::includeClass('Affiliate_Scripts_Services_TrafficService');
QUnit_Global::includeClass('Affiliate_Scripts_Services_BannerRedirectService');


/* Look for a_bid, if not set we'll use bid. */
$bannerId = (isset($_GET['a_bid']) ? $_GET['a_bid'] : $_GET['bid']);

$bannerService = new Affiliate_Scripts_Services_BannerRedirectService($bannerId);

/* Redirect to destination URL. */
$bannerService->redirect();