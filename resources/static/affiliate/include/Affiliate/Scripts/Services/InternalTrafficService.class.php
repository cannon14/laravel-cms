<?php
/**
 * Encapsulates behaviors needed for storing page views.
 * 
 * @author Patrick J. Mizer <patrick@creditcards.com>
 */
class Affiliate_Scripts_Services_InternalTrafficService extends Affiliate_Scripts_Services_TrafficService
{	
	var $externalVisitId;
	var $pageId;
	var $seed;
	var $isLandingPage;
	
	/**
	 * InternalTrafficSource cosntructor
	 * 
	 * @author Patrick J. Mizer
	 * @access @public
	 * @param external visit ID
	 * @param Page ID
	 */
    function Affiliate_Scripts_Services_InternalTrafficService($externalVisitId, $pageId, $isLandingPage) 
    {
 		parent::Affiliate_Scripts_Services_TrafficService(); 
 		
 		$this->externalVisitId 	= $externalVisitId;
 		$this->pageId 			= $pageId;   	
    	$this->seed				= $this->_generateSeed();
    	// $this->isLandingPage	= $this->_isLandingPage();
    	$this->isLandingPage 	= $isLandingPage;
    }
    
    /**
     * Saves the member data to the page_views table.
     * 
     * @author Patrick J. Mizer
     * @access public
     */
    function registerInternalClick()
    {
    	
    	$sql = 'INSERT INTO page_views (`page_id`, `external_visit_id`, `view_time`, `seed`, ' .
    			'`is_landing_page`) VALUES ('._q($this->pageId).' ,'._q($this->externalVisitId).', '.
    			'NOW(), '._q($this->seed).', '._q($this->isLandingPage).')';
    	
    	
    	if(!$this->_query($sql)){
    		$this->_throwError('There was an error saving internal click, SQL: ' . $sql);
    	}		
    }    
    
    /**
     * Random seed for PK
     * 
     * @author Patrick J. Mizer
     * @access private
     */
    function _generateSeed()
	{
		return substr(md5(uniqid(rand(), true)), 0, 5);	
	}
	
	/**
	 * Detrmines whether page is landing apge.
	 * 
	 * @author Patrick J. Mizer
	 * @access private
	 */
	function _isLandingPage()
	{
		return !isset($_COOKIE['ACTREF']);
	}
}
?>