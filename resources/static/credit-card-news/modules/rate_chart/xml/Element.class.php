<?php
/**
 * XML Element
 *
 * @copyright 2008 CreditCards.com
 * @author Patrick J, Mizer <patrick.mizer@creditcards.com>
 */
class Element
{
	/**
	 * Element name
	 *
	 * @access private
	 * @var String
	 */
	var $_name;
	
	/**
	 * Attributes array
	 *
	 * @access private
	 * @var array<String, String>
	 */
	var $_attributes;
	
	/**
	 * Element text
	 *
	 * @access private
	 * @var String
	 */
	var $_text;
	
	/**
	 * Number of children
	 *
	 * @access private
	 * @var int
	 */
	var $_numChildren;
	
	/**
	 * Element's children
	 * 
	 * @access private
	 * @var array <Element>
	 */
	var $_children;
	
	/**
	 * Element Constructor
	 *
	 * @access public
	 * @param String $name
	 * @return Element
	 */
	function Element($name)
	{
		$this->_name 		= $name;
		$this->_attributes 	= array();
		$this->_children 	= array();
		$this->_numChildren = 0;
	}
	
	/**
	 * Set element's text
	 *
	 * @param unknown_type $text
	 */
	function setText($text)
	{
		$this->_text = $text;
	}
	
	/**
	 * Get element's text
	 *
	 * @access public
	 * @return unknown
	 */
	function getText()
	{
		return $this->_text;
	}
	
	/**
	 * Add attribute to element
	 *
	 * @access public
	 * @param String $key
	 * @param String $value
	 */
	function addAttribute($key, $value)
	{
		$this->_attributes[$key] = $value;
	}
	
	/**
	 * Get attributes
	 *
	 * @access public
	 * @return array <String, String>
	 */
	function getAttributes()
	{
		return $this->_attributes;
	}
	
	/**
	 * Append child
	 *
	 * @access public
	 * @param Element $element
	 */
	function appendChild(&$element)
	{
		++ $this->_numChildren;
		$this->_children[] =& $element;
	}
	
	/**
	 * Has children
	 *
	 * @access public
	 * @return boolean
	 */
	function hasChildren()
	{
		return ($this->_numChildren > 0);
	}
	
	/**
	 * Get children
	 *
	 * @access public
	 * @return array<Element>
	 */
	function &getChildren()
	{
		return $this->_children;
	}
	
	/**
	 * Render Element
	 *
	 * @access public
	 * @return String
	 */
	function render()
	{
		$xml = '<' . $this->_name . ' ';
		
		foreach($this->_attributes as $key => $val) {
			$xml .= $key . '="'.$val.'" ';
		}
		
		if(!$this->hasChildren() && $this->_text == null) {
			$xml .= '/>';
			return $xml;
		}
		
		$xml .= '>' . $this->_text;
		foreach($this->_children as $child) {
			$xml .= $child->render();
		}
		
		$xml .= '</'.$this->_name.'>';
		
		return $xml;
	}
}

?>