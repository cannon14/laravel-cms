<?php

/**
 * WS-security XML request manipulation
 *
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cccom_Xmlsec_XmlRequest {

	/**
	 * @var DOMDocument
	 */
	protected $_dom;

	/**
	 * @var DOMXPath
	 */
	protected $_xpath;

	protected $_refId;

	/**
	 * @param string $xml Intercepted soap XML request
	 * @param boolean $insertHeaderTemplate
	 */
	public function __construct($xml, $insertHeaderTemplate = true) {

		$dom = new DOMDocument();
		$dom->loadXML($xml);

		$this->_dom = $dom;

		if($insertHeaderTemplate) {
			$template = $this->_getHeaderTemplate();
			$this->_insertHeaderTemplate($template);
		}

		$this->_initXpath();

	}


	public function getXml() {

		$xml = $this->_dom->saveXML();
		//$xml = $this->_dom->C14N(true);

		return $xml;
	}


	public function setRefId($id) {
		$this->_refId = $id;
		$this->_setBodyRefId($id);

//		$newDom = new DOMDocument();
//		$newDom->loadXML($this->_dom->saveXML());
//		$this->_dom = $newDom;
	}


	/**
	 * @param string $digest
	 *
	 * @return string Xml
	 */
	public function setDigest($digest) {

		$node = $this->_getDigestNode();
		$node->nodeValue = $digest;
	}

	public function getDigest() {

		$node = $this->_getDigestNode();
		return $node->nodeValue;
	}

	protected function _getDigestNode() {

		$query = "//ds:SignedInfo/ds:Reference/ds:DigestValue";
		$node = $this->_xpath->query($query)->item(0);
		return $node;
	}




	/**
	 * @param string $certificate
	 *
	 * @return SimpleXMLElement
	 */
	public function setCertificate($certificate) {

		$query = "//wsse:BinarySecurityToken";
		$node = $this->_xpath->query($query)->item(0);
		$node->nodeValue = $certificate;
	}


	/**
	 * @return string
	 */
	public function getCertificate() {

		$query = "//wsse:BinarySecurityToken";
		$node = $this->_xpath->query($query)->item(0);
		return $node->nodeValue;
	}


	/**
	 * @param string $signature
	 *
	 * @return SimpleXMLElement
	 */
	public function setSignature($signature) {

		$node = $this->_getSignatureNode();
		$node->nodeValue = $signature;
	}

	/**
	 * @return string
	 */
	public function getSignature() {
		$node = $this->_getSignatureNode();
		$signature = $node->nodeValue;
		return $signature;
	}

	/**
	 * @return DOMNode
	 */
	protected function _getSignatureNode() {
		$query = "//ds:SignatureValue";
		$node = $this->_xpath->query($query)->item(0);
		return $node;
	}


	/**
	 * @return DOMNode
	 */
	public function getRefNodeXml() {

		$node = $this->_getBodyNode();

		// Exclusive, no comments
		$xml = $node->C14N(true, false);

		//echo "Refnode: \n------------------\n". $xml; exit;

		return $xml;

	}


	public function getSignedInfoXml() {

		$query = "//ds:SignedInfo";
		$node = $this->_xpath->query($query)->item(0);

		// Non-exclusive, with comments
		$xml = $node->C14N(false, true);

		return $xml;

	}


	/**
	 * We're using an XML template that has all the stuff
	 * the header needs, we just need to set the values
	 * for certain nodes
	 *
	 * @return SimpleXMLElement
	 */
	protected function _getHeaderTemplate() {

		$xmlTemplate = dirname(__FILE__).'/xmlsec-header.txt';

		$xml = file_get_contents($xmlTemplate);

		return $xml;
	}



	/**
	 *
	 * Insert security header at the top of the request
	 *
	 * @param string $securityHeaderTemplate
	 */
	protected function _insertHeaderTemplate($securityHeaderTemplate) {

		$securityDom = new DOMDocument();
		$securityDom->loadXML($securityHeaderTemplate);
		$headerNode = $securityDom->firstChild;

		$newNode = $this->_dom->importNode($headerNode, true);

		$envelope = $this->_dom->firstChild;

		$envelope->insertBefore($newNode, $envelope->firstChild);

	}

	/**
	 * Add a wsu:id attribute to the body node
	 *
	 * @param string $id
	 *
	 * @return SimpleXMLElement XML string with modified body
	 */
	protected function _setBodyRefId($id) {

		$node = $this->_getBodyNode();

		if($node) {
			$ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd';
			$node->setAttributeNS("http://www.w3.org/2000/xmlns/", 'xmlns:wsu', $ns);
			$node->setAttributeNS($ns,'wsu:Id', $id);

		}

	}

	protected function _getBodyNode() {

		$query = "//*[local-name() = 'Body']";
		try {
			$node = $this->_xpath->query($query)->item(0);
		} catch(Exception $e) {
			return false;
		}
		return $node;
	}

	protected function _initXpath()
	{
		$xpath = new DOMXPath($this->_dom);

		$xpath->registerNamespace(
			'ds',
			'http://www.w3.org/2000/09/xmldsig#'
		);

		$xpath->registerNamespace(
			'wsu',
			'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd'
		);

		$xpath->registerNamespace(
			'wsse',
			'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd'
		);

		$this->_xpath = $xpath;
	}



}
