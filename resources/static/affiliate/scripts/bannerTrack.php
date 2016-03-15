<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 28, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */ 


if(isset($_GET['a_aid'])){
	$params = array();
	$params['ip'] = $_SERVER['REMOTE_ADDR'];
	$params['aid'] = $_GET['a_aid'];
	$params['dateInserted'] = date("Y-m-d H:i:s");
	$params['referer'] = $_SERVER['HTTP_REFERER'];
	$params['cccid'] = $_SESSION['CCCID'];
	
	
	QUnit_Global::includeClass('Affiliate_Scripts_Bl_Registrator');
	$registrator =& new Affiliate_Scripts_Bl_Registrator();
	$registrator->saveBannerTrack($params);
}


?>
