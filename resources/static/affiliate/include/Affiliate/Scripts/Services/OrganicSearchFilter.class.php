<?php
/**
 * OrganicSearchFilter
 * 
 * The purpose of the Organic search filter
 * is to change the traffic source id of the 
 * inbound traffic if it is determined that the 
 * traffic originated from a search engine.
 * 
 * @author Patrick J. Mizer
 */
class Affiliate_Scripts_Services_OrganicSearchFilter 
	extends Affiliate_Scripts_Services_TrafficServiceFilter

{
	/**
	 * Hash to hold information about organic
	 * search domain
	 * 
	 * @access public
	 */
	var $organics;
		
	/**
	 * OrganicSearchFilter constructor
	 * 
	 * @access public
	 */
	function Affiliate_Scripts_Services_OrganicSearchFilter()
	{
		$this->organics = array(
			array('id' => 1064, 'domain' => 'google.com', 		'query' => 'q'),
			array('id' => 1065, 'domain' => 'yahoo.com', 		'query' => 'p'),
			array('id' => 1066, 'domain' => 'msn.com', 			'query' => 'q'),
			array('id' => 1066, 'domain' => 'bing.com',			'query' => 'q'),
			array('id' => 1067, 'domain' => 'ask.com', 			'query' => 'q'),
			array('id' => 1068, 'domain' => 'aol.com', 			'query' => 'query'),
			array('id' => 1069, 'domain' => 'dogpile.com',		'query' => ''),
			array('id' => 1069, 'domain' => 'miva.com',			'query' => 'MT'),
			array('id' => 1069, 'domain' => 'altavista.com',	'query' => 'q'),
		);		
	}
	
	/**
	 * This derived method filters the trafficService.
	 * Will only consider change if the traffic source ID
	 * is ROOT.
	 * 
	 * @access public 
	 * @param reference to inbound traffic service instance
	 */
	function filter(&$trafficService)
	{
		if($trafficService->referer != null 
			&& $trafficService->trafficSourceRefId == TS_ROOT_TRAFFIC_SOURCE) {
			
			$this->_setOrganicSearchId($trafficService);
		}
	}
	
	/**
	 * Determines organic search traffic source ID given a refering url
	 * 
	 * @access public
	 * @param referrer url
	 * @return boolean changed ID
	 */
	function _setOrganicSearchId(&$trafficService)
	{	
		foreach($this->organics as $organic){
			if(strpos(strtolower($trafficService->referer), '.'.strtolower($organic['domain'])) !== false){
				$trafficService->trafficSourceRefId = $organic['id'];
				$trafficService->trafficSourceId = $trafficService->_validatateTrafficSourceId(
					$trafficService->trafficSourceRefId);
				return true;
			}
		}
		return false;
	}	
}
?>