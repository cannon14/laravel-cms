<?php
/**
 * 
 * ClickSuccess, L.P.
 * May 3, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */
csCore_Import::importClass('CMS_layouts_seoLayout');
class CMS_layouts_seolayouts_yahoo_magYahooSearchMonkeySeoLayout extends CMS_layouts_seoLayout {
	var $subHeaderTemplate = 'cccom/yahoo_static_pages';
	
	function writeHeader() 
    {	
		$curdate = date("Y-m-d\TH:i:s-06:00");
		$data = <<< ENDDATA
<?profile http://search.yahoo.com/searchmonkey-profile ?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:y="http://search.yahoo.com/datarss/">
  <id>http://www.merchantaccountguide.com/feedspec</id>
  <author><name>MerchantAccountGuide.com</name></author>
  <title>MerchantAccountGuide.com Feed for Yahoo!</title>
  <updated>$curdate</updated>
ENDDATA;
    	$this->bufferString($data);
    }
    
    
    function writeStaticData() 
    {	
    	$updated = date("Y-m-d\TH:i:s-06:00");
    	
    	$data = <<< ENDDATA
  <entry>
    <title>Compare Merchant Services Offers at MerchantAccountGuide.com</title>
    <updated>$updated</updated>
    <id>http://www.merchantaccountguide.com/index.php</id>
    <y:adjunct version="1.0" name="com.merchantaccountguide.listing">
      <y:item rel="rel:Listing">
	    <y:meta property="dc:title">Compare Merchant Services Offers at MerchantAccountGuide.com</y:meta>
	    <y:meta property="dc:description">Search for the merchant service that is right for you. Compare merchnat services offers side-by-side. Detailed information on merchant services offers. Apply online.</y:meta>
        <y:item rel="rel:Image" resource="http://www.creditcards.com/images/Credit-Cards-Logo-small.gif">
		  <y:meta property="dc:title">MerchantAccountGuide.com</y:meta>
		</y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/low-interest.php">
          <y:meta property="context:position">1</y:meta>
		  <y:meta property="dc:title">Low Interest</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/balance-transfer.php">
          <y:meta property="context:position">2</y:meta>
		  <y:meta property="dc:title">Balance Transfer</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/bad-credit.php">
          <y:meta property="context:position">3</y:meta>
		  <y:meta property="dc:title">Bad Credit</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/cash-back.php">
          <y:meta property="context:position">4</y:meta>
		  <y:meta property="dc:title">Cash Back</y:meta>
        </y:item>
      </y:item>
    </y:adjunct>
  </entry>
  <entry>
    <title>Compare Credit Card Offers at CreditCards.com</title>
    <updated>$updated</updated>
    <id>http://www.creditcards.com/</id>
    <y:adjunct version="1.0" name="com.creditcards.listing">
      <y:item rel="rel:Listing">
	    <y:meta property="dc:title">Compare Credit Card Offers at CreditCards.com</y:meta>
	    <y:meta property="dc:description">Search for the credit card that is right for you. Compare credit card offers side-by-side. Detailed information on credit card offers. Apply online.</y:meta>
        <y:item rel="rel:Image" resource="http://www.creditcards.com/images/Credit-Cards-Logo-small.gif">
		  <y:meta property="dc:title">CreditCards.com</y:meta>
		</y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/low-interest.php">
          <y:meta property="context:position">1</y:meta>
		  <y:meta property="dc:title">Low Interest</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/balance-transfer.php">
          <y:meta property="context:position">2</y:meta>
		  <y:meta property="dc:title">Balance Transfer</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/bad-credit.php">
          <y:meta property="context:position">3</y:meta>
		  <y:meta property="dc:title">Bad Credit</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/cash-back.php">
          <y:meta property="context:position">4</y:meta>
		  <y:meta property="dc:title">Cash Back</y:meta>
        </y:item>
      </y:item>
    </y:adjunct>
  </entry>

ENDDATA;
    	$this->bufferString($data);
    }
    
    
    function writeFooter() 
    {
    	$data = '</feed>';
    	$this->bufferString($data);
    }
    
    
	function writeEntry($pageUrl, $changeFreq, $priority)
    {
		$data = <<< ENDDATA
  <entry>
    <title>Capital One Platinum for Students</title>
    <updated>2008-03-14T15:09:26.53-05:00</updated>
    <id>http://www.creditcards.com/credit-cards/CapitalOne-Platinum-for-Studentsv2.php</id>
    <y:adjunct version="1.0" name="com.creditcards.listing">
      <y:item rel="rel:Listing">
	    <y:meta property="dc:title">Capital One Platinum for Students</y:meta>
        <y:item rel="rel:Image" resource="http://www.creditcards.com/images/capital-one-platinum-for-students.gif">
		  <y:meta property="dc:title">Capital One Platinum for Students</y:meta>
		</y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/credit-cards/CapitalOne-Platinum-for-Studentsv2.php">
          <y:meta property="context:position">1</y:meta>
		  <y:meta property="dc:title">Card Details</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/Capital-One.php">
          <y:meta property="context:position">2</y:meta>
		  <y:meta property="dc:title">More Capital One Cards</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="http://www.creditcards.com/college-students.php">
          <y:meta property="context:position">3</y:meta>
		  <y:meta property="dc:title">More Student Cards</y:meta>
        </y:item>
        <y:item rel="rel:Text">
          <y:meta property="context:position">1</y:meta>
		  <y:meta property="dc:title">Intro APR</y:meta>
		  <y:meta property="dc:description">0%</y:meta>
        </y:item>
        <y:item rel="rel:Text">
          <y:meta property="context:position">2</y:meta>
		  <y:meta property="dc:title">Annual Fee</y:meta>
		  <y:meta property="dc:description">None</y:meta>
        </y:item>
        <y:item rel="rel:Text">
          <y:meta property="context:position">3</y:meta>
		  <y:meta property="dc:title">Credit Needed</y:meta>
		  <y:meta property="dc:description">Average/Limited History</y:meta>
        </y:item>
        <y:item rel="rel:Text">
          <y:meta property="context:position">4</y:meta>
		  <y:meta property="dc:title">Rewards</y:meta>
		  <y:meta property="dc:description">Up to 5% cash back, unlimited cash rewards</y:meta>
        </y:item>
      </y:item>
    </y:adjunct>
  </entry>
ENDDATA;
		$this->bufferString($data);
    }
    
    
	function writeCardEntry($pageUrl, $card, $cardData, $cardpage, $cardCat)
    {
    	$updated = date("Y-m-d\TH:i:s-06:00");
    	$domain = 'http://www.creditcards.com';
    	
    	$title = $this->clean($card->get('cardListingString'));
    	if (!$title)
    		$title = $this->clean($card->get('cardTitle'));
    	if (!$title)
    		return;  // we NEED a title
    	$image = $card->get('imagePath'); //$card->get('categoryImage');
    	$pageLink = $cardpage->get('pageLink').'.php';
    	$pageName = $this->clean($cardpage->get('pageName'));
    	$catUrl = $cardCat['url'];
    	$catName = ($cardCat['name']=='') ? 'Credit Cards' : $this->clean($cardCat['name']);
    	$introApr = $this->clean($cardData['Intro APR']);
    	$annualFee = $this->clean($cardData['Annual Fee']);
    	$creditNeeded = $this->clean($cardData['Credit Needed']);
    	$balanceTransfers = $this->clean($cardData['Balance Transfers']);
    	
		$data = <<< ENDDATA
  <entry>
    <title>{$title}</title>
    <updated>$updated</updated>
    <id>$pageUrl</id>
    <y:adjunct version="1.0" name="com.creditcards.listing">
      <y:item rel="rel:Listing">
	    <y:meta property="dc:title">{$title}</y:meta>
        <y:item rel="rel:Image" resource="{$domain}/images/{$image}">
		  <y:meta property="dc:title">{$title}</y:meta>
		</y:item>

ENDDATA;

		// Add link elements
		$lc = 0;
		$this->_addLink($data, ++$lc, 'Card Details', $pageUrl);
		if ($pageLink)
			$this->_addLink($data, ++$lc, "More $pageName Cards", $domain.'/'.$pageLink);
		if ($catUrl && $catName)
			$this->_addLink($data, ++$lc, "More $catName", $domain.'/'.$catUrl);
		
		// Add text elements
		$tc = 0;
		if ($introApr)
			$this->_addText($data, ++$tc, 'Intro APR', $introApr);
		if ($annualFee)
			$this->_addText($data, ++$tc, 'Annual Fee', $annualFee);
		if ($creditNeeded)
			$this->_addText($data, ++$tc, 'Credit Needed', $creditNeeded);
		if ($balanceTransfers)
			$this->_addText($data, ++$tc, 'Balance Transfers', $balanceTransfers);

		$data .= <<< ENDDATA
      </y:item>
    </y:adjunct>
  </entry>

ENDDATA;
		$this->bufferString($data);
    }
    
    
	function writeCategoryEntry($pageUrl, $page, $cardLink)
    {
    	$updated = date("Y-m-d\TH:i:s-06:00");
    	$domain = 'http://www.creditcards.com';
    	
    	$title = $this->clean($page->getTitle());
    	$image = $page->get('pageHeaderImage');
    	$alttext = $this->clean($page->get('pageHeaderImageAltText'));
    	$cardLink = $cardLink.".php";//$card->get('cardLink').'.php';
    	
		$data = <<< ENDDATA
  <entry>
    <title>{$title}</title>
    <updated>$updated</updated>
    <id>$pageUrl</id>
    <y:adjunct version="1.0" name="com.creditcards.listing">
      <y:item rel="rel:Listing">
	    <y:meta property="dc:title">{$title}</y:meta>
        <y:item rel="rel:Image" resource="$domain/images/{$image}">
		  <y:meta property="dc:title">{$alttext}</y:meta>
		</y:item>
        <y:item rel="rel:Link" resource="$pageUrl">
          <y:meta property="context:position">1</y:meta>
		  <y:meta property="dc:title">Compare cards</y:meta>
        </y:item>
        <y:item rel="rel:Link" resource="$domain/credit-cards/{$cardLink}">
          <y:meta property="context:position">2</y:meta>
		  <y:meta property="dc:title">Top card</y:meta>
        </y:item>
      </y:item>
    </y:adjunct>
  </entry>

ENDDATA;
		$this->bufferString($data);
    }
    
    function _addLink(&$data, $position, $title, $url)
    {
    	$data .= <<< ENDDATA
        <y:item rel="rel:Link" resource="$url">
          <y:meta property="context:position">$position</y:meta>
		  <y:meta property="dc:title">$title</y:meta>
        </y:item>
    	
ENDDATA;
    }
    
    function _addText(&$data, $position, $title, $description)
    {
    	$data .= <<< ENDDATA
        <y:item rel="rel:Text">
          <y:meta property="context:position">$position</y:meta>
		  <y:meta property="dc:title">$title</y:meta>
		  <y:meta property="dc:description">$description</y:meta>
        </y:item>
    	
ENDDATA;
    }
    
    function clean($string)
    {
    	return $this->_escapeEntities($this->_stripInvalidXmlChars(strip_tags($string)));
    }
    
    function _stripInvalidXmlChars($string)
	{
		$xmlstring = '';
		for ($i=0; $i<strlen($string); $i++)
		{
			$char = $string{$i};
			$hchar = ord($char);
			if (($hchar == 0x9) ||
			    ($hchar == 0xA) ||
			    ($hchar == 0xD) ||
			    (($hchar >= 0x20) && ($hchar <= 0xD7FF)) ||
			    (($hchar >= 0xE000) && ($hchar <= 0xFFFD)) ||
			    (($hchar >= 0x10000) && ($hchar <= 0x10FFFF))) {
			    $xmlstring .= $char;
			}
			else {
				$xmlstring .= ' ';
			}
		}
		
		return $xmlstring;
	}
	
	function _escapeEntities($string)
	{
		$map = array(
			'&' => '&amp;',
			"'" => '&apos;',
			'"' => '&quot;',
			'>' => '&gt;',
			'<' => '&lt;',
			'&amp;#' => '&#'
		);
		
		return str_replace(array_keys($map), $map, $string);
	}
}
?>