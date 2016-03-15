<?php
/**
 * Affiliate Click Back Facade
 * 
 * This class conditionally loads  
 */
class Affiliate_Scripts_Bl_ClickBackFacade
{
	/**
	 * Get click back URL
	 * 
	 * @static
	 * @access public
	 * @param String $affiliateId
	 * @param String $bannerId
	 * @param String $productId
	 * @param int $exitPageId
	 * @return String
	 */  
	function getClickBackUrl($affiliateId, $bannerId, $productId, $exitPageId)
	{
		$replaceMap = array(
			'[BANNER_ID]'  		=> $bannerId,
			'[PRODUCT_ID]' 		=> $productId,
			'[EXIT_PAGE_ID]'	=> $exitPageId
		);		
		
		$url = Affiliate_Scripts_Bl_ClickBackFacade::_loadClickBackUrl($affiliateId);	
		
		return str_replace(array_keys($replaceMap), array_values($replaceMap), $url);
	}
	
	/**
	 * Load the click back URL from persistence 
	 * 
	 * @static
	 * @access private
	 * @param String $affiliateId
	 * @return String
	 */
	function _loadClickBackUrl($affiliateId)
	{
		$sql = 'SELECT url FROM affiliate_tracking_pixels WHERE affiliate_id = ' . _q($affiliateId) . ' AND deleted != 1';
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if($rs->EOF) {
			return false;
		}
		
		return $rs->fields['url'];
	}
}
?>