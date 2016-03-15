<?php
/**
 * Template Class
 * 
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 * @package cardsearch.util
 */

class Search_Util_Template
{
	/**
	 * Path to template html file
	 *
	 * @access private
	 * @var String
	 */
	var $_tplPath;
	
	/**
	 * Constructor
	 *
	 * @param String $path
	 *
	 * @return Search_Util_Template
	 */
	function Search_Util_Template($path)
	{
		$this->_tplPath = $path;
	}
	
	/**
	 * Assign key value pair to template
	 *
	 * @param String $key
	 * @param mixed $value
	 */
	function assign($key, $value)
	{
		$this->$key = $value;
	}
	
	/**
	 * Render Template
	 *
	 * @access publics
	 */
	function render()
	{
		require($this->_tplPath);
	}
}
?>
