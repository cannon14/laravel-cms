<?php
/**
 * Inbound Relay Gateway
 * 
 * This program takes an inbound request to a page on the site via 
 * a page id (FID) and will mark the request and take the user to that page.
 * All acceptable pages setup for relay need to be explicitly defined
 * 
 * @copyright 2008 CreditCards.com
 * @author Cesar Gonzalez <cg@creditcards.com>
 */

require_once('global.php');
$DEFAULTPAGE = 83;

QUnit_Global::includeClass('Affiliate_Scripts_Services_TrafficService');
QUnit_Global::includeClass('Affiliate_Scripts_Services_TrafficRelayService');


/* Look for ccid, if not set we'll use default. */
$pageId = (isset($_GET['ccid']) ? $_GET['ccid'] : $DEFAULT_PAGE);

$trafficRelayService = new Affiliate_Scripts_Services_TrafficRelayService($pageId);

/* Redirect to destination URL. */
$trafficRelayService->redirect();
?>