<?php
/**
 * XML Document Parser 
 *
 * @copyright 2008 CreditCards.com
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 */
class DocumentParser
{
	/**
	 * XML
	 *
	 * @access private
	 * @var String
	 */
	var $_xml;
	
	/**
	 * XML SAX Parser
	 *
	 * @access private
	 * @var resource
	 */
	var $_parser;
	
	/**
	 * XML Document
	 *
	 * @access private
	 * @var Document
	 */
	var $_document;
	
	/**
	 * Element stack
	 *
	 * @access private
	 * @var array <Element>
	 */
	var $_elementStack;
	
	/**
	 * Document Parser Constructor
	 *
	 * @access public
	 * @param String $xml
	 * @return DocumentParser
	 */
	function DocumentParser($xml)
	{
		$this->_xml = $xml;
		$this->_parser = xml_parser_create();
		$this->_document = new Document();
		$this->_elementStack = array();
		
		xml_set_object($this->_parser, $this);
		xml_set_element_handler($this->_parser, "_openTag", "_closeTag");
		xml_set_character_data_handler($this->_parser, "_cdata");
	}
	
	/**
	 * Parse XML
	 *
	 * @access public
	 * @return Document
	 */
	function parse()
	{
		if (xml_parse($this->_parser, $this->_xml)) {
		
			return $this->_document;
		} else {
			return false;
		}
	}
	
	/**
	 * Open tag handler
	 *
	 * @access private
	 * @param resource $parser
	 * @param String $elementName
	 * @param array $attributes
	 */
	function _openTag($parser, $elementName, $attributes)
	{
		$element = new Element($elementName);
		
		foreach($attributes as $key => $val) {
			$element->addAttribute($key, $val);
		}
		
		if(count($this->_elementStack) == 0) {
			$this->_document->setRoot($element);
		}
		$this->_elementStack[] =& $element;
	}
	
	/**
	 * CDATA Handler
	 *
	 * @access private
	 * @param resource $parser
	 * @param String $cdata
	 */
	function _cdata($parser, $cdata)
	{
		$currentElement =& $this->_elementStack[count($this->_elementStack) - 1];
		$currentElement->setText($cdata);
	}
	
	/**
	 * Close tag handler
	 * 
	 * @access private
	 * @param resource $parser
	 * @param String $elementName
	 */
	function _closeTag($parser, $elementName)
	{
		$childElement =& array_pop($this->_elementStack);
		$parentElement =& $this->_elementStack[count($this->_elementStack) - 1];
		
		if($parentElement)
			$parentElement->appendChild($childElement);
	}
}
?>