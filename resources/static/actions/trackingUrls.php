<?php

require_once( dirname( __FILE__ ).'/global.php' );
QUnit_Global::includeClass('Affiliate_Scripts_Services_TrackingService');

include_once( dirname( __FILE__ ).'/thirdPartyTrackerDefs.php');
include_once( dirname( __FILE__ ).'/fidTrackerDefs.php');

if($fids[$_SESSION['fid']]) {
	$trackingPixelRenderer = new Affiliate_Scripts_Services_TrackingService( $fids[$_SESSION['fid']] );
	$trackingPixelRenderer->renderImageTags();
}
?>
