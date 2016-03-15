<?php
/**
 * Traffic Relay Service
 * 
 * @copyright 2008 CreditCards.com
 * @author Cesar Gonzalez <cg@creditcards.com>
 */ 

class Affiliate_Scripts_Services_TrafficRelayService
{
	/**
	 * Banner Redirect Url 
	 * 
	 * @access private
	 * @var String
	 */ 
	var $_redirectUrl;
	
	/**
	 * Constructor
	 * 
	 * @access public
	 * @return Affiliate_Services_BannerRedirectService
	 */
	function Affiliate_Scripts_Services_TrafficRelayService($pageId)
	{
		$this->_redirectUrl = $this->_getDestinationUrl($pageId); 
	}
	
	/**
	 * Redirect to banner's destination URL
	 * 
	 * @access public
	 */
	function redirect()
	{
		 header('Location: ' . $this->_redirectUrl);
	}
	
	/**
	 * Validate banner ID
	 *
	 * @access private
	 * @param $bannerId String
	 * @return String 
	 */ 
	function _getDestinationUrl($pageId)
	{
		
		$url = '';
			
		$pageName= $this->_loadPage($pageId);
		
		$url = 'http://www.creditcards.com/' . $pageName;
			
		$qs = $_SERVER['QUERY_STRING'];	
		
		$url .= (strpos($url, '?') === false ? '?' : '&');
		
		$url .= $qs;
		
		return $url;
	}
	
	/**
	 * Load banner from persistence
	 * 
	 * @access private
	 * @return ResultSet
	 */
	function _loadPage($pageId)
	{

		/** In the future this should be pulled from a DB		
		 $sql = ' 
			SELECT
		        page_id,
		        destination_url
			FROM
			        [[TABLE]]
			WHERE
			        page_id = ' . _q($pageId);
					    
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);*/
		
		$destinations = array (
				83 => "low-interest.php",
				105 => "balance-transfer.php",
				82 => "instant-approval.php",
				130 => "bad-credit.php",
				100 => "reward.php",
				101 => "cash-back.php",
				72 => "airline-miles.php",
				81 => "college-students.php"
		);
		
	    // return (array_key_exists($pageId, $destinations)? $destinations[$pageId] : $destinations[83]);
		
		return (isset($destinations[$pageId]) ? $destinations[$pageId] : $destinations[83]);
	}
	
}
?>