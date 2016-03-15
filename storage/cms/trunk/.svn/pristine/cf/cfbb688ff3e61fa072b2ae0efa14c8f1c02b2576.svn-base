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

csCore_Import::importClass('CMS_libs_siteComponents');
csCore_Import::importClass('CMS_libs_SiteManipulator');
csCore_Import::importClass('CMS_libs_MergeFilter');
csCore_Import::importClass('CMS_libs_Cards');

class CMS_libs_SiteToXML extends CMS_libs_SiteManipulator
{
	
    var $nameSpace = "nffeed";
    var $nameSpaceLink = "http://rss.netfiniti.com";
    
    var $channelTitle = "Netfiniti - ";
    var $channelLink = "http://www.netfiniti.com";
    
    var $channelData = array(	"title" => "CreditCards.com Wrapper Program - Powered By Netfinti",
    							"link" => "http://www.creditcards.com",
    							"description" => "Shop and compare Credit Cards",
    							"webMaster" => "support@netfiniti.com",
    							);
    							
    var $imageData = array(		"title" => "CreditCards.com",
    							"link" => "http://www.creditcards.com",
    							"url" => "http://www.creditcards.com/images/cccom_logo_114x44.gif",
    							"width" => "114",
    							"height" => "144",
    							"description" => "Shop and compare credit cards online!"
    							);
    
    var $tranUrl = 'http://tran1.netfiniti.com/';
    var $impUrl = 'http://imp1.netfiniti.com/';
    var $imageBase = 'http://www.creditcards.com/images/';
    var $linkBase = 'http://www.creditcards.com/t_thru.php';
    
    var $cardsPerPage = 999999;
    var $xmlLoc;
    var $xml;
    var $categories;
    
    /**
     * Create an XML File from a compiled site
     * @author Patrick Mizer
     * @version 1.0
     */
    function build()
    {
    	
    	$this->xmlLoc = $this->settings->getSetting('CMS_xml_dir');
    	
    	$this->absolutePublishPath = $this->site->get('publishPath');
    	
    	$this->_exportToXML($this->site->get('siteId'));
    	$xmlFile = str_replace(".", "", $this->site->get('siteName'));
    	$xmlFile = str_replace(" ", "_", $this->site->get('siteName'));

    	$xmlFile .= ".xml";	
    	$this->_writeFile($this->xmlLoc, $xmlFile);	
    }
    
    function _exportToXML($siteId){
    	
    	$merger = new CMS_libs_MergeFilter();
    	
    	$doc = domxml_new_doc('1.0'); 
     	$data = 'rss';
		$root = $doc->create_element($data);
		$root = $doc->append_child($root);
		$root->set_attribute("version", "2.0");
		
		$root->set_attribute("xmlns:".$this->nameSpace, $this->nameSpaceLink);
		
		// Set Channel data.
		$channel = $doc->create_element("channel");
		$channel = $root->append_child($channel);
		foreach($this->channelData as $col => $data){
			$node = $doc->create_element($col);
			$node = $channel->append_child($node);
			$value = $doc->create_text_node($data);
			$value = $node->append_child($value);
		}
		
		// Set Image Data.
		$image = $doc->create_element("image");
		$image = $channel->append_child($image);
		foreach($this->imageData as $col => $data){
			$node = $doc->create_element($col);
			$node = $image->append_child($node);
			$value = $doc->create_text_node($data);
			$value = $node->append_child($value);
		}
		
		$pagenum = 0;
		$this->pages = $this->site->getPages();
		foreach ($this->pages as $currPage) {			
				
				// This is start of a new Page
				// So we'll define a category here...
				$currentCategory = $currPage->get('cardpageId');
				$currentPageTitle = $currPage->get('pageTitle');
				$cardArray = $currPage->getCards();
				_setMessage("Starting node " . $currPage->get('pageName') . " has " .count($cardArray) . " cards");
				if(is_array($cardArray)){
					$numCards = count($cardArray);
					if (($numCards % $this->cardsPerPage) == 0) 
						$numPages = $numCards/$this->cardsPerPage;
					else $numPages = ($numCards/$this->cardsPerPage)+1;
						for ($pageNum=1; $pageNum<=$numPages; $pageNum++) {
							
							// Once paging is defined, if ever, this is the begining of a new page...
							// so maybe this would be CategoryA1, CategoryA2, ... , CategoryAn
							
							for ($j=0; ($j<=$this->cardsPerPage) && ($j < $numCards) && ($j < 10);  $j++) {	
				
								
								// This conditional assures us we're looking at a card, not a sub category
								// which we will ignore.
								if($cardArray[$j]->get('subCat') == 0 && $cardArray[$j]->get('syndicate') == 1){
								
								// We will attatch the card node here...
								$prod = $doc->create_element('item'); 
		        				$prod = $channel->append_child($prod);
		        				
		        				// Now we populate the attributes...

								
								$link = $cardArray[$j]->get('url');
								
								$attributes = array("title" => $cardArray[$j]->get('cardTitle'),
													"link" => $link,
													"category" => $currentCategory,
													$this->nameSpace.":"."categoryname" => $currentPageTitle,
													$this->nameSpace.":"."bannerid" => $cardArray[$j]->get('cardId'),
													$this->nameSpace.":"."image" => strip_tags($this->imageBase.$cardArray[$j]->get('imagePath')),
													
													"description" => $cardArray[$j]->get('cardDetailText'),
								);
								
								$qData = CMS_libs_Cards::getQuantitativeData($cardArray[$j]->get('cardId'));
								$optAttributes = array( "regularApr", 
														"introApr", 
														"introAprPeriod",
														"annualFee", 
														"monthlyFee",
														"balanceTransfers", 
														"creditNeeded");
								
								foreach($optAttributes as $attribute){
						
									if($cardArray[$j]->get("active_".$attribute) == 1)
										$attributes[$this->nameSpace.":".$attribute] = strip_tags($cardArray[$j]->get($attribute));
										$attributes[$this->nameSpace.":q_".$attribute] = strip_tags($qData[$attribute]);
									}
								
								foreach($attributes as $col => $data){
									
									$child = $doc->create_element($col);
				           	   		$child = $prod->append_child($child);			           	
					           		if($col == "description" || $col == "title" || $col == "link"){
					           			// Here we're going to do some some text replacing
					           			// per Christian's request.  This will add some
					           			// functionality within the xslt/css <li>/<ul> classes.
					 					$data = str_replace("<ul>", "<ul class=\"nf_ul\">", $data);
					 					$data = str_replace("<li>", "<li class=\"nf_li\">", $data);
					 					$data = str_replace("<UL>", "<ul class=\"nf_ul\">", $data);
					 					$data = str_replace("<LI>", "<li class=\"nf_li\">", $data);		 					
					           			$data = str_replace("\n", "", $data);
					           			$data = str_replace("\r", "", $data);
					           		
					           			if(!($value = $doc->create_cdata_section( $data)))
					         				echo $data . "<br>";
					           		}
					           		else{
					           			$data = str_replace("\n", "", $data);
					           			$data = str_replace("\r", "", $data);
					           			
					           			$data = $merger->translate($data, $cardArray[$j]->get('cardId')); 
					           			
					           			$value = $doc->create_text_node( strip_tags($data)); 
					           		}
					           		$value = $child->append_child($value);
								}
				           				           					         		           		  				 
								}
							}
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
		   _setSuccess("Successfully wrote $filename <br><a href='".$this->settings->getSetting('CMS_xml_url')."/$partialfilename'>(Click here to download it)</a>");
		   
		   fclose($handle);
		
		} else {
		   //echo "The file $filename is not writable";
		   _setMessage("The file $filename is not writable", true);
		}		
	}
}

?>