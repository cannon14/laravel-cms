<?php
/**
 * Geo IP Banner Service
 * 
 * @copyright 2008 CreditCards.com
 * @author Patrick J. MIzer <patrick.mizer@creditcards.com>
 * @package affiliate.scripts.services
 */ 

class Affiliate_Scripts_Services_GeoIpBannerService
{
	var $_bannerMap;
	
	function Affiliate_Scripts_Services_GeoIpBannerService($bannerMap)
	{
		$this->_bannerMap = $bannerMap;
	}
	
	function getBanner()
	{
		return $this->_bannerMap[$this->_getCountryCode()];
	}
	
	function _getCountryCode()
	{
		/* Override if test sent in */
		if(isset($_REQUEST['geotest'])) {
			return strtoupper($_REQUEST['geotest']);
		}
		
		/* If geoip extension is not loaded, nothing we can do, return null */
		if(!extension_loaded('geoip')) {
			return null;
		}
		
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$ipParts = explode(',', $ip);
	    $finalIp = (count($ipParts) > 1 ? $ipParts[0] : $ip);
	    
	    if($finalIp == null) {
	    	$finalIp = $_SERVER['REMOTE_ADDR'];
	    }
	    
	    if(isset($_SERVER['HTTP_TRUE_CLIENT_IP'])){
	    	$finalIp = $_SERVER['HTTP_TRUE_CLIENT_IP'];
	    }
	    
	    return geoip_country_code_by_name($finalIp);		
	}
}
?>