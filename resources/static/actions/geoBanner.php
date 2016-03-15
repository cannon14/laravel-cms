<?php
/**
 * GEO IP Banner Service
 * 
 * This script will load a banner based on the user's
 * location as determined by GEO IP.
 * 
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 */

session_start();
require_once('global.php');
QUnit_Global::includeClass('Affiliate_Scripts_Services_GeoIpBannerService');

/* Number of times to show geo IP banner per impression */
define('MAX_GEO_BANNER_IMPRESSIONS', 3);

/* Define country code to banner and URL mapping. */
$BANNER_MAPPING = array(
	'UK' => '<a href="http://uk.creditcards.com?a_aid=4a9eef0a"><img border="0" src="/images/uk_banner.gif"/></a>',
	'GB' => '<a href="http://uk.creditcards.com?a_aid=4a9eef0a"><img border="0" src="/images/uk_banner.gif"/></a>',
	'AU' => '<a href="http://australia.creditcards.com?a_aid=6c8cb2a4"><img border="0" src="/images/au_banner.gif"/></a>',
	'CA' => '<a href="http://canada.creditcards.com?a_aid=f1e36cf1"><img border="0" src="/images/ca_banner.gif"/></a>'
);

if(!isset($_SESSION['NUM_GEO_BANNER_IMPRESSIONS'])) {
	$_SESSION['NUM_GEO_BANNER_IMPRESSIONS'] = 0;
}

if($_SESSION['NUM_GEO_BANNER_IMPRESSIONS'] < MAX_GEO_BANNER_IMPRESSIONS) {
	
	++ $_SESSION['NUM_GEO_BANNER_IMPRESSIONS'];
	$geoBannerService = new Affiliate_Scripts_Services_GeoIpBannerService($BANNER_MAPPING);
	
	echo $geoBannerService->getBanner();
}

?>