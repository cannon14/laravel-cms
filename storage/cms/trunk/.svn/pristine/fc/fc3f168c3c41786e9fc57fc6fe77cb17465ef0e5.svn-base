<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 30, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Lib
 */

define("PRODUCT_CATEGORY", "productCategory");
define("PRODUCT", "product");
define("AD_UNIT", "adUnit");


csCore_Import::importClass('CMS_libs_siteComponents');
csCore_Import::importClass('CMS_libs_SiteManipulator');
csCore_Import::importClass('CMS_libs_MergeFilter');
csCore_Import::importClass('CMS_libs_Cards');

class CMS_libs_SiteToXML2 extends CMS_libs_SiteManipulator
{
    
    var $cardsPerPage = 999999;
    var $xmlLoc;
    var $xml;
    var $categories;
    
    /**
     * Compile a site and create and XML document from that site
     * @author Patrick Mizer
     * @version 1.0
     */
    function build($includeInactive = false)
    {
    	
    	$this->xmlLoc = $this->settings->getSetting('CMS_xml_dir');
    	
    	$this->absolutePublishPath = $this->site->get('publishPath');
    	
    	$this->_exportToXML($this->site->get('siteId'), $includeInactive);
    	$xmlFile = str_replace(".", "", $this->site->get('siteName'));
    	$xmlFile = str_replace(" ", "_", $this->site->get('siteName'));

    	$xmlFile .= ".xml";	
    	$this->_writeFile($this->xmlLoc, $xmlFile);	
    }
    
    function _exportToXML($siteId, $includeInactive=false){
    	$merger = new CMS_libs_MergeFilter();
    	
    	$doc = domxml_new_doc('1.0'); 
    	
    	$data = 'data';
		$root = $doc->create_element($data);
		$root = $doc->append_child($root);

		$this->pages = $this->site->getCardPages();
		
		$merger = new CMS_libs_MergeFilter();
		foreach ($this->pages as $currPage) {
		
			$productCategory = $doc->create_element(PRODUCT_CATEGORY);
			$productCategory = $root->append_child($productCategory);
			
			// Set all attributes needed for product categories here.
			$productCategory->set_attribute("id", $currPage->get('cardpageId'));
			$productCategory->set_attribute("name", $currPage->get('pageName'));
			$productCategory->set_attribute("description", $currPage->get('pageDescription'));
			$productCategory->set_attribute("disclaimer", $currPage->get('pageDisclaimer'));
			$productCategory->set_attribute("displayorder", $currPage->get('rank'));
						
			$this->cards = $currPage->getCards();
			
			foreach($this->cards as $currCard) {
				if($currCard->get('syndicate')){
					if($includeInactive || $currCard->get('active')){
						$qData = CMS_libs_Cards::getQuantitativeData($currCard->get('cardId'));
						
						$product = $doc->create_element(PRODUCT);
						$product = $productCategory->append_child($product);
						
						// Set all attributes needed for products here.
						$product->set_attribute("id", $currCard->get('cardId'));
						$product->set_attribute("name", textScrub($currCard->get('cardTitle')));
						$product->set_attribute("description", $currCard->get('cardDetailText'));
						$product->set_attribute("shortDescription", $currCard->get('cardIntroDetail'));
						$product->set_attribute("imagePath", $currCard->get('imagePath'));
						$product->set_attribute("url", $this->site->get('publishurl').'/'.$currCard->get('cardLink').'.'.$this->site->get('pagetype'));
						
						if($currCard->get('private')){
							$product->set_attribute("private", 1);	
						}
						
						
						$cardData = array(	"introApr", 
											"introAprPeriod", 
											"regularApr", 
											"annualFee", 
											"monthlyFee", 
											"creditNeeded", 
											"balanceTransfers",
											);
						foreach($cardData as $data){
							if($currCard->get('active_'.$data)){ 
								$product->set_attribute($data, $merger->translate($currCard->get($data), $currCard->get('cardId')));
								$product->set_attribute('q_'.$data, $qData[$data]);
							}
						}
						$adUnit = $doc->create_element(AD_UNIT);
						$adUnit = $product->append_child($adUnit);
						$adUnit->set_attribute('id', $currCard->get('cardId'));
						$adUnit->set_attribute('type', '99');
						$adUnit->set_attribute('url', $currCard->get('url'));
					}else{echo $includeInactive;}	
				}			
			}

			//Add sub-page cards to the top level page
			$subPages = $currPage->getSubPages();
			foreach($subPages as $subPage){
				$subPageCards = $subPage->getCards();
				foreach($subPageCards as $spCard){
					if($spCard->get('syndicate')){
	                    if($includeInactive || $spCard->get('active')){
	                        $qData = CMS_libs_Cards::getQuantitativeData($spCard->get('cardId'));
	                        
	                        $product = $doc->create_element(PRODUCT);
	                        $product = $productCategory->append_child($product);
	                        
	                        // Set all attributes needed for products here.
	                        $product->set_attribute("id", $spCard->get('cardId'));
	                        $product->set_attribute("name", textScrub($spCard->get('cardTitle')));
	                        $product->set_attribute("description", $spCard->get('cardDetailText'));
	                        $product->set_attribute("shortDescription", $spCard->get('cardIntroDetail'));
	                        $product->set_attribute("imagePath", $spCard->get('imagePath'));
	                        $product->set_attribute("url", $this->site->get('publishurl').'/'.$spCard->get('cardLink').'.'.$this->site->get('pagetype'));
	                        
	                        if($spCard->get('private')){
	                            $product->set_attribute("private", 1);  
	                        }
	                        
	                        
	                        $cardData = array(  "introApr", 
	                                            "introAprPeriod", 
	                                            "regularApr", 
	                                            "annualFee", 
	                                            "monthlyFee", 
	                                            "creditNeeded", 
	                                            "balanceTransfers",
	                                            );
	                        foreach($cardData as $data){
	                            if($spCard->get('active_'.$data)){ 
	                                $product->set_attribute($data, $merger->translate($spCard->get($data), $spCard->get('cardId')));
	                                $product->set_attribute('q_'.$data, $qData[$data]);
	                            }
	                        }
	                        $adUnit = $doc->create_element(AD_UNIT);
	                        $adUnit = $product->append_child($adUnit);
	                        $adUnit->set_attribute('id', $spCard->get('cardId'));
	                        $adUnit->set_attribute('type', '99');
	                        $adUnit->set_attribute('url', $spCard->get('url'));
	                    }else{echo $includeInactive;}   
	                }           	
				}
			}
		}
		$xml = $doc->dump_mem(true, 'iso-8859-1'); 
	    $this->xml = $xml; 
		
		return true;		
		
    }

    
	function _writeFile($filepath, $partialfilename){
		$filename = $filepath . $partialfilename;
		
		$somecontent = $this->xml;
		
		// Let's make sure the file exists and is writable first.
		if (is_writable($filename) || !is_file($filename)) {
		
		   // In our example we're opening $filename in append mode.
		   // The file pointer is at the bottom of the file hence 
		   // that's where $somecontent will go when we fwrite() it.
		   if (!$handle = fopen($filename, 'w')) {
		         //echo "Cannot open file ($filename)";
		         _setMessage("Cannot open file ($filename)", true);
		         exit;
		   }
		
		   // Write $somecontent to our opened file.
		   if (fwrite($handle, $somecontent) === FALSE) {
		       //echo "Cannot write to file ($filename)";
		       _setMessage("Cannot write to file ($filename)", true);
		       exit;
		   }
		   
		   //echo "Success, wrote ($somecontent) to file ($filename)";
		   _setSuccess("Successfully wrote $filename <br><a href='".$this->settings->getSetting('CMS_xml_url')."/$partialfilename' TARGET='_BLANK'>(Click here to download it)</a>");
		   
		   fclose($handle);
		
		} else {
		   //echo "The file $filename is not writable";
		   _setMessage("The file $filename is not writable", true);
		}		
	}
}

?>