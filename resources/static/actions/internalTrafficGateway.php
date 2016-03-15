<?php
/**
 * Internal Traffic Gateway.
 */

session_start(); 
 
QUnit_Global::includeClass('Affiliate_Scripts_Services_TrafficService');
QUnit_Global::includeClass('Affiliate_Scripts_Services_InternalTrafficService');

$externalVisitId 	= $_SESSION['external_visit_id'];
$pageId				= $_SESSION['fid'];
$isLandingPage 		= !$_SESSION['landing_page_set'];
	
$internalService = new Affiliate_Scripts_Services_InternalTrafficService($externalVisitId, $pageId, $isLandingPage);
// Debug	
// echo '<div style="border : solid 1px #ff0000; background : #ffffff"><pre>' . print_r($internalService, 1). '</pre></div>';

$internalService->registerInternalClick();

$_SESSION['landing_page_set'] = true;

/* Tell browser we're sending it a GIF */
header("Content-Type: image/gif");
echo "";
?>