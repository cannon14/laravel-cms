<?php
/**
 * XML Document
 *
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 */
class Document
{
	/**
	 * Document root
	 *
	 * @access public
	 * @var Element
	 */
	var $_root;
	
	/**
	 * Set document root
	 *
	 * @access public
	 * @param Element $element
	 */
	function setRoot(&$element)
	{
		$this->_root =& $element;
	}
	
	/**
	 * Get document root
	 *
	 * @access public
	 * @return Element
	 */
	function &getRoot()
	{
		return $this->_root;
	}
	
	/**
	 * Render document
	 *
	 * @access public
	 * @return String
	 */
	function render()
	{
		return $this->_root->render();
	}
}
?>