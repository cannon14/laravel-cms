<?php
/**
 * Rate Chart Render
 * 
 * This class parses EHS XML and renders
 * and HTML reprpesentation of the rate table.
 *
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 */
class RateChart
{
	/**
	 * EHS XML Document
	 *
	 * @access private
	 * @var Document
	 */
	var $_xmlDocument;
	
	
	/**
	 * Is module valid
	 *
	 * @access private
	 * @var boolean
	 */
	var $_isValid;
	
	/**
	 * Rates
	 *
	 * @access private
	 * @var array<Rate>
	 */
	var $_rates;
	
	/**
	 * RateChart Constructor
	 *
	 * @param Document $xmlDocument
	 * @return RateChart
	 */
	function RateChart($xmlDocument)
	{
		$this->_xmlDocument = $xmlDocument;
		$this->_isValid = true;
		
		$this->_initRates();
	}
	
	/**
	 * Init rates from DOM document
	 * 
	 * @access public
	 */
	function _initRates()
	{
		global $LINK_MAPPING;
		
		$ehsFeed =& $this->_xmlDocument->getRoot();
		
		$categories = $ehsFeed->getChildren();
		$categories = $categories[0];
		
		$categoryArray = $categories->getChildren();
		
		foreach($categoryArray as $category) {
			
			$attributes = $category->getAttributes();
			
			$rate = new Rate();
			
			$rate->setName(trim($attributes['NAME']));
			$rate->setLink($LINK_MAPPING[$rate->getName()]);
			$rate->setAvgApr($attributes['AVGAPR']);
			$rate->setMovement($attributes['MOVEMENT']);
			
			
			
			if($rate->getLink() != '') {
				$this->_rates[$rate->getName()] = $rate;
			}
			
		}
	}
	
	/**
	 * Is module valid
	 * 
	 * @access public
	 * @boolean
	 */
	function isValid()
	{
		return false;
	}
	
	/**
	 * Render Rate Chart
	 *
	 * @access public
	 * @return String
	 */
	function render()
	{
		ob_start();
		require('credit-card-news/modules/rate_chart/rate_chart.tpl.php');	
		return ob_get_clean();
	}
}
?>