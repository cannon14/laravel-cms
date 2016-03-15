<?php
/**
 * Encapsulates behaviors needed for redirecting user to offer.
 * 
 * @author Patrick J. Mizer <patrick@creditcards.com>
 */
class Affiliate_Scripts_Services_OutboundTrafficService extends Affiliate_Scripts_Services_TrafficService
{
	var $transactionId;
    var $externalVisitId;
    var $productId;
    var $campaignCategoryId;
    var $exitPageId;
    var $redirectUrl;
    var $bankRule;
    
    /**
     * OutboundTrafficService Constructor.
     * 
     * @author Patrick J. Mizer
     * @access public
     * @param external visit ID
     * @param product ID
     * @param exit page ID
     * 
     */    
    function Affiliate_Scripts_Services_OutboundTrafficService($externalVisitId, $productId, $exitPageId) 
    {
    	parent::Affiliate_Scripts_Services_TrafficService(); 
    	
    	$this->transactionId 	= QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');
    	$this->externalVisitId 	= $externalVisitId;
    	$this->exitPageId 		= $exitPageId;
    	
    	$this->_validateProductId($productId);
    }
    
    /**
     * Saves the member data to the transactions table.
     * 
     * @author Patrick J. Mizer
     * @access public
     */    
    function registerOutboundClick()
    {
    	
    	$sql = 'INSERT INTO transactions ' .
    			'(`transaction_id`, `external_visit_id`, `time_inserted`, `product_id`, ' .
    			'`campaign_category_id`, `exit_page_id`) VALUES ('._q($this->transactionId).', ' .  
    			_q($this->externalVisitId).', NOW(), '._q($this->productId).', '._q($this->campaignCategoryId).','.
    			_q($this->exitPageId).')';
    			
    	
    	if(!$this->_query($sql)){
    		$this->_throwError('There was an error saving outbound click, SQL: ' . $sql);
    	}		    		
    }
    
    /**
     * Apply bank rule to redirect URL.
     * 
     * @author Patrick J. Mizer
     * @access private
     */
    function getOfferURL()
    {
    	switch($this->bankRule){
			case TS_SEND_WITH_TRANS_ID:
				$url = $this->redirectUrl . $this->transactionId;
			break;
			case TS_SEND_WITHOUT_TRANS_ID:
				$url = $this->redirectUrl;
			break;
			case TS_SEND_WITH_TRANS_ID_AND_SLASH:
				$url = $this->redirectUrl . $this->transactionId.'/';
			break;
			case TS_SEND_OFFER_WITH_TRANS_ID:
				$url = $this->redirectUrl . $this->transactionId;
			break;
			case TS_SEND_OFFER_WITH_NO_TRANS_ID:
				$url = $this->redirectUrl;
			break;
			default:
				// This should never happen.  If it does we need to find out why.
				$this->_throwError('No bank rule associated with: ' . $this->bankRule);
				$url = $this->redirectUrl;
			break;
    	}
    	return $url;
    }
    
    /**
     * Get information pertaining to product ID from DB.  Validate all data.
     * No matter what we're redirecting after this call, so make sure all
     * member data is set, if something is unexpected throw an error but do not die.
     * 
     * @author Patrick J. Mizer
     * @access private
     * @param bid, product ID
     */
    function _validateProductId($bid)
    {

   		$sql = 'SELECT b.bannerid, b.destinationurl, c.campcategoryid, m.bank_rule 
				FROM wd_pa_banners AS b 
				LEFT JOIN wd_pa_campaigncategories AS c USING (campaignid) 
				LEFT JOIN wd_pa_campaigns AS ca USING (campaignid) 
				LEFT JOIN merchants AS m USING (merchant_id) 
				WHERE b.bannerid = ' . _q($bid);
			
		$rs = $this->_query($sql);		
		
    	if(!$rs){
    		$this->_throwError('There was an SQL error while validating product ID. SQL: ' . $sql);
    	}		   
    	
    	$this->productId 			= $rs->fields['bannerid'];
    	$this->redirectUrl 			= $rs->fields['destinationurl'];
    	$this->campaignCategoryId 	= $rs->fields['campcategoryid'];
    	$this->bankRule 			= $rs->fields['bank_rule'];
    	
    	if($this->productId == null){
			$this->_noProductId();
    	}	
    	 		
    	if($this->redirectUrl == null){
			$this->_noRedirectUrl();
    	}
    		
    	if($this->campaignCategoryId == null)
    	{	
  			$this->_noCampaignCategoryId();
    	}
    	
    	if($this->bankRule == null)
    	{
    		$this->_noBankRule();
    	}
	}
	
	/**
	 * If we don't have a bank rule, let's be safe and just send them to their
     * destination without a transid.  We will whine about it though.
     * 
     * @author Patrick J. Mizer
     * @access private
	 */
	function _noProductId()
	{
    	$this->redirectUrl = TS_REDIRECT_RELIEF;
    	$this->productId = INVALID_PRODUCT_ID;
    	// We should think about dying silently here.
  		$this->_throwError('No product ID sent in.');		
	}
	
	/**
	 * If we don't have destination URL then will redirect to the relief page.
     * 
     * @author Patrick J. Mizer
     * @access private
	 */	
	function _noRedirectUrl()
	{
    	$this->redirectUrl = TS_REDIRECT_RELIEF;
    	$this->_throwError('Redirect URL for product ID: ' . $this->productId . ' does not exist!');		
	}
	
	/**
	 * If we don't have campCategoryId then we will assign the default invalid campcategoryid.   	
     * 
     * @author Patrick J. Mizer
     * @access private
	 */	
	function _noCampaignCategoryId()
	{
		$this->campaignCategoryId = TS_INVALID_CAMPAIGN_CATEGORY;
    	$this->_throwError('Campaign category does not exist for product ID: ' . $this->productId . '!'); 
	}
	
	/**
	 * If we don't have a bank rule, let's be safe and just send them to their
     * destination without a transid.  We will whine about it though.
     * 
     * @author Patrick J. Mizer
     * @access private
	 */	
	function _noBankRule()
	{
		$this->bankRule = TS_SEND_WITHOUT_TRANS_ID;
    	$this->_throwError('No bank rule assigned for product ID: ' . $this->productId . '!');		
	}
}
?>