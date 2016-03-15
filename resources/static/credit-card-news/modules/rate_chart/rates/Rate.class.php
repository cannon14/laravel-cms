<?php
/**
 * Rate Model
 *
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer
 */
class Rate
{
	/**
	 * Category name
	 *
	 * @access private
	 * @var String
	 */
	var $_name;
	
	/**
	 * Link URL
	 *
	 * @access private
	 * @var String
	 */
	var $_link;
	
	/**
	 * Average APR
	 *
	 * @access private
	 * @var double
	 */
	var $_avgApr;
	
	/**
	 * Average APR Movement
	 *
	 * @access private
	 * @var String
	 */
	var $_movement;
	
	/**
	 * Rate Constructor
	 *
	 * @access public
	 * @return Rate
	 */
	function Rate()
	{
		
	}
	
	/**
	 * Set name
	 *
	 * @access public
	 * @param String $name
	 */
	function setName($name)
	{
		$this->_name= $name;
	}
	
	
	/**
	 * Get name
	 *
	 * @access public
	 * @return String
	 */
	function getName()
	{
		return $this->_name;
	}		
	
	/**
	 * Set link
	 *
	 * @access public
	 * @param String $link
	 */
	function setLink($link)
	{
		$this->_link= $link;
	}
	
	/**
	 * Get link
	 *
	 * @access public
	 * @return String
	 */
	function getLink()
	{
		return $this->_link;
	}

	/**
	 * Set Avg APR
	 *
	 * @access public
	 * @param double $avgApr
	 */
	function setAvgApr($avgApr)
	{
		$this->_avgApr= $avgApr;
	}
	
	/**
	 * Get Avg APR
	 *
	 * @access public
	 * @return double
	 */
	function getAvgApr()
	{
		return $this->_avgApr;
	}		
	
	/**
	 * Set movement
	 *
	 * @access public
	 * @param String $movement
	 */
	function setMovement($movement)
	{
		$this->_movement = $movement;
	}
	
	/**
	 * Get movement
	 *
	 * @access public
	 * @return String
	 */
	function getMovement()
	{
		return $this->_movement;
	}	
}
?>