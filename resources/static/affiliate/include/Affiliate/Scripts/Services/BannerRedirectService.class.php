<?php
/**
 * Banner Redirection Service
 * 
 * @copyright 2008 CreditCards.com
 * @author Patrick J. MIzer <patrick.mizer@creditcards.com>
 */ 

class Affiliate_Scripts_Services_BannerRedirectService
{
	/**
	 * Banner Redirect Url 
	 * 
	 * @access private
	 * @var String
	 */ 
	var $_redirectUrl;


	/**
	 * @param $bannerId
	 */
	public function __construct($bannerId)
	{
		$this->_redirectUrl = $this->_getDestinationUrl($bannerId); 
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
	function _getDestinationUrl($bannerId)
	{
		
		$url = '';
			
		$bannerRs = $this->_loadBanner($bannerId);
		
		$url = ( $bannerRs->fields['destination_url'] 
			? $bannerRs->fields['destination_url'] 
			: 'http://www.creditcards.com' );
			
		$qs = $_SERVER['QUERY_STRING'];	
		
		$url .= (strpos($url, '?') === false ? '?' : '&');
		
		$url .= $qs;
		
		return $url;
	}
	
	/**
	 * Load banner from persistence
	 *
	 * @param $bannerId
	 *
	 * @return mixed
	 */
	private function _loadBanner($bannerId)
	{
		$sql = ' 
			SELECT
		        banner_id,
		        destination_url
			FROM
			        partner_banners
			WHERE
			        banner_id = ' . _q($bannerId);
			    
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		
	    return $rs;
	}
	
}