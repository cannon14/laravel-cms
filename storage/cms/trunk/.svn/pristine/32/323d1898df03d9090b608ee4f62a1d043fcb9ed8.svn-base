<?php
/**
 * 
 * CreditCards.com
 * December 21, 2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */

define("PRODUCT_CATEGORY", "productCategory");
define("PRODUCT_SUB_CATEGORY", "productSubCategory");
define("PRODUCT", "product");
define("SUB_CATEGORY_MAP", "productSubCategoryMap");
define("PRODUCT_MAP", "productMap");

csCore_Import::importClass('CMS_libs_siteComponents');
csCore_Import::importClass('CMS_libs_SiteManipulator');
csCore_Import::importClass('CMS_libs_MergeFilter');
csCore_Import::importClass('CMS_libs_Cards');
csCore_Import::importClass('CMS_libs_Affiliates');

class CMS_libs_SiteToXML3 extends CMS_libs_SiteManipulator
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
        //get affiliates and products for XML creation
        $rs = CMS_libs_Affiliates::getXMLAffiliatesWithProducts(NFDB_HOST, NFDB_UN, NFDB_PW, NFDB_NAME);
        
        $available = array();
        while($rs && !$rs->EOF){
        	$currentUser = $rs->fields['userid'];
        	$available[] = $rs->fields['campaignid'];
        	$nfCards[$rs->fields['campaignid']] = $rs->fields;
        	
        	$rs->MoveNext();
        	if($rs->fields['userid'] != $currentUser){
        		$this->xmlLoc = $this->settings->getSetting('CMS_xml_dir');
                $this->absolutePublishPath = $this->site->get('publishPath');
                
                //get affiliate's pages
                $rs2 = CMS_libs_Affiliates::getAffiliatePages(NFDB_HOST, NFDB_UN, NFDB_PW, NFDB_NAME, $currentUser);
                while($rs2 && !$rs2->EOF){
                	$availablePages[] = $rs2->fields['campaigntypeid'];
                	$rs2->MoveNext();
                }
		        $this->_exportToXML($available, $availablePages, $nfCards);
		        $xmlFile = str_replace(".", "", $this->site->get('siteName'));
		        $xmlFile = str_replace(" ", "_", $this->site->get('siteName'));	
		        $xmlFile .= "_full_structure_".$currentUser.".xml"; 
		        $this->_writeFile($this->xmlLoc, $xmlFile);
		        $available = array(); 
        	}
        }
    }
    
    function _exportToXML($availableCards, $availablePages, $nfCards){
    	//echo'<pre>';print_r($nfCards);echo'</pre>';
    	$url = CMS_libs_Affiliates::getAffTransURL(NFDB_HOST, NFDB_UN, NFDB_PW, NFDB_NAME);

    	//needed vars
    	$cards = array();
        $merger = new CMS_libs_MergeFilter();
      
        //setup document
        $doc = domxml_new_doc('1.0'); 
        $data = 'data';
        
        //begin document
        $root = $doc->create_element($data);
        $root = $doc->append_child($root);
        
        //create sections
        $products = $doc->create_element('products');
        // $productSubCategories = $doc->create_element('productSubCategories');
        $productCategories = $doc->create_element('productCategories');
        
        
        //add sections
        $products = $root->append_child($products);
        // $productSubCategories = $root->append_child($productSubCategories);
        $productCategories = $root->append_child($productCategories);
        

        
        $pages = $this->site->getCardPages();
        foreach ($pages as $page) {
            $productCategory = $doc->create_element(PRODUCT_CATEGORY);
            
            // Set all attributes needed for product categories here.
            $productCategory->set_attribute("id", $page->get('cardpageId'));
            $productCategory->set_attribute("name", $page->get('pageName'));
            $productCategory->set_attribute("description", $page->get('pageDescription'));
            $productCategory->set_attribute("pageType", $page->get('pageType'));
            $productCategory->set_attribute("disclaimer", $page->get('pageDisclaimer'));

            //run through subpages
            $subPages = $page->getSubPages();
            $subPageMap = 0;
            foreach($subPages as $subPage){
            	//add the subPage
            	$productSubCategory = $doc->create_element(PRODUCT_CATEGORY);
            	
            	//make sure the subPage has at least 1 available card
            	$tmpCards = $subPage->getCards();
            	
            	foreach($tmpCards as $crd){
            		if(in_array($crd->get('cardId'), $availableCards)){
                        //add the subPage reference
                        $subCatMap = $doc->create_element(SUB_CATEGORY_MAP);
                        $subCatMap->set_attribute("displayOrder", ++$subPageMap);
                        $subCatMap->set_content($subPage->get('cardpageId'));
                        $productCategory->append_child($subCatMap);
                        break;            			
            		}
            	}
            	
            	// Set all attributes needed for subpages here.
	            $productSubCategory->set_attribute("id", $subPage->get('cardpageId'));
	            $productSubCategory->set_attribute("name", $subPage->get('pageName'));
	            $productSubCategory->set_attribute("description", $subPage->get('pageDescription'));
	            $productSubCategory->set_attribute("pageType", $page->get('pageType'));
            	$productSubCategory->set_attribute("disclaimer", $page->get('pageDisclaimer'));          
	            
	            //now we run through the cards for the subPage
	            $subPageCards = $subPage->getCards();
	            $productCount = 0;
	            foreach($subPageCards as $card) {
	            	$qData = CMS_libs_Cards::getQuantitativeData($card->get('cardId'));
	                $product = $doc->create_element(PRODUCT);
	                $productMap = $doc->create_element(PRODUCT_MAP);
	                
	                if(in_array($card->get('cardId'), $availableCards)){
	                   //create map
	                   $productMap->set_content($card->get('cardId'));
	                   $productMap->set_attribute('displayOrder', ++$productCount);
	                   $productSubCategory->append_child($productMap);
	                   
	                   //Set all attributes needed for products here.
		               $product->set_attribute("id", $card->get('cardId'));
		               $product->set_attribute("name", textScrub($card->get('cardTitle')));
		               $product->set_attribute("description", $card->get('cardDetailText'));
		               $product->set_attribute("shortDescription", $card->get('cardIntroDetail'));
		               $product->set_attribute("imagePath", $card->get('imagePath'));
		               $product->set_attribute("url", $url->fields['value'].
		                                              '?a_aid='.$nfCards[$card->get('cardId')]['userid'].
		                                              '&a_bid='.$nfCards[$card->get('cardId')]['bannerid'].
		                                              '&tid=');
	                   $cardData = array( "introApr", 
                                            "introAprPeriod", 
                                            "regularApr", 
                                            "annualFee", 
                                            "monthlyFee", 
                                            "creditNeeded", 
                                            "balanceTransfers",
                                            );
                        foreach($cardData as $data){
                            if($card->get('active_'.$data)){ 
                                $product->set_attribute($data, $merger->translate($card->get($data), $card->get('cardId')));
                                $product->set_attribute('q_'.$data, $qData[$data]);
                            }
                        }
		               $pArray[$card->get('cardId')] = $product;
	                }
	            }
	            if(in_array($page->get('cardpageId'), $availablePages))
	               $pscArray[$subPage->get('cardpageId')] = $productSubCategory;
            }
            
            //now we run through the cards for the subPage
            $pageCards = $page->getCards();
            $productCount = 0;
            foreach($pageCards as $card) {
            	$qData = CMS_libs_Cards::getQuantitativeData($card->get('cardId'));
                $product = $doc->create_element(PRODUCT);
                $productMap = $doc->create_element(PRODUCT_MAP);
                    
                if(in_array($card->get('cardId'), $availableCards)){
                    //create map
                    $productMap->set_content($card->get('cardId'));
                    $productMap->set_attribute('displayOrder', ++$productCount);
                    $productCategory->append_child($productMap);
                       
                    //Set all attributes needed for products here.
                    $product->set_attribute("id", $card->get('cardId'));
                    $product->set_attribute("name", textScrub($card->get('cardTitle')));
                    $product->set_attribute("description", $card->get('cardDetailText'));
                    $product->set_attribute("shortDescription", $card->get('cardIntroDetail'));
                    $product->set_attribute("imagePath", $card->get('imagePath'));
                    $product->set_attribute("url", $url->fields['value'].
                                                   '?a_aid='.$nfCards[$card->get('cardId')]['userid'].
                                                   '&a_bid='.$nfCards[$card->get('cardId')]['bannerid'].
                                                   '&tid=');
                    $cardData = array(  "introApr", 
                                            "introAprPeriod", 
                                            "regularApr", 
                                            "annualFee", 
                                            "monthlyFee", 
                                            "creditNeeded", 
                                            "balanceTransfers",
                                            );
                        foreach($cardData as $data){
                            if($card->get('active_'.$data)){ 
                                $product->set_attribute($data, $merger->translate($card->get($data), $card->get('cardId')));
                                $product->set_attribute('q_'.$data, $qData[$data]);
                            }
                        }
                        $pArray[$card->get('cardId')] = $product;
                 }
             }
           if(in_array($page->get('cardpageId'), $availablePages))
            $pcArray[$page->get('cardpageId')] = $productCategory;  
        }
        
        foreach($pArray as $productNode){
        	$products->append_child($productNode);
        }
        
        foreach($pscArray as $productSubCategoryNode){
        	if($productSubCategoryNode->has_child_nodes())
                $productCategories->append_child($productSubCategoryNode);
        }
        
        foreach($pcArray as $productCategoryNode){
        	$children = $productCategoryNode->child_nodes();
        	foreach($children as $child){
        	   if($child->tagname == PRODUCT_MAP){
                 $productCategories->append_child($productCategoryNode);
                 break;
        	   }
        	}
        }

        $xml = $doc->dump_mem(true, 'UTF-8'); 
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