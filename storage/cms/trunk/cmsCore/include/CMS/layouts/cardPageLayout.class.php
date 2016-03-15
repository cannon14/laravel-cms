<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 31, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */
csCore_Import::importClass('csCore_UI_template');
csCore_Import::importClass('CMS_libs_SortBar');
class CMS_layouts_cardPageLayout 
{

	var $tpl;
	var $headerTemplate;
	var $footerTemplate;
	var $cardTemplate;
	
	var $showTypeOfCardNav        = true;
	var $showCreditQualityNav     = true;
	var $showIssuerNav            = true;
	var $showEditorialNav         = true;
	var $showToolsNav             = true;
	var $showMerchantServicesNav  = true;
	
	var $robotsNoFollow	= false;
	
	var $useGeoIp         = true;
	var $showGeoIpBanner  = false;
    
    function CMS_layouts_cardPageLayout() 
    {
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template(); 	
    }
    
    function writeHeader($page, $pageNumber=0, $pagetype=".php", $rootPath='./', $prevNextLinks = '', $canonicalTag = '')
    {
    	$this->assignValue('page', $page);
    	$this->assignValue('pageNumber', $pageNumber);
    	$this->assignValue('pagetype', $pagetype);
    	$this->assignValue('rootPath', $rootPath);
		$this->assignValue('prevNextLinks', $prevNextLinks);
	    $this->assignValue('canonicalTag', $canonicalTag);
    	
    	$this->assignValue('useGeoIp', $this->useGeoIp);
        
        /* Show geoip banner */
        $this->assignValue('showGeoIpBanner', $this->showGeoIpBanner);
    	
    	$this->assignValue('showTypeOfCardNav', $this->showTypeOfCardNav );
    	$this->assignValue('showCreditQualityNav', $this->showCreditQualityNav );
    	$this->assignValue('showIssuerNav', $this->showIssuerNav );
    	$this->assignValue('showEditorialNav', $this->showEditorialNav );
    	$this->assignValue('showToolsNav', $this->showToolsNav );
    	$this->assignValue('showMerchantServicesNav', $this->showMerchantServicesNav );
    	
    	$this->assignValue('robotsNoFollow', $this->robotsNoFollow );
    	
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
        $this->bufferContent($this->preSubHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeSubHeader($page, $pageNav='', $subPageNav='', $isPageTop='true', $isFirstPage = FALSE)
    {   
        $this->assignvalue('pageNav', $pageNav);
        $this->assignValue('page', $page);
        $this->assignValue('isPageTop', $isPageTop);
        $this->assignValue('subPageNav', $subPageNav);
		$this->assignValue('isFirstPage', $isFirstPage);
        $this->bufferContent($this->subHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeLandingSubHeader($page, $pageNav='', $subPageNav='', $isPageTop='true')
    {   
        $this->assignvalue('pageNav', $pageNav);
        $this->assignValue('page', $page);
        $this->assignValue('isPageTop', $isPageTop);
        $this->assignValue('subPageNav', $subPageNav);
        $this->bufferContent($this->landingSubHeaderTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeSubFooter($page, $pageNav, $pageNumber=0, $articles=null) 
    {
        
        $this->assignValue('page', $page, $pageNumber);
        $this->assignValue('pageNav', $pageNav);
        $this->assignValue('pageNumber', $pageNumber);
        $this->assignValue('articles', $articles);
        $this->bufferContent($this->subFooterTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    // added pageNumber param.  The same pageNumber param
    // passed to assignValue was already there, not sure why.
    function writeFooter($page, $pageNumber = 0) 
    {
        $pageNumber = (int)$pageNumber;
        $this->assignValue('page', $page, $pageNumber);
        
        // added to push site catalyst variable data to the page template.  - mz 5/7/08
        $siteCatalystData = $page->get(SITECATALYST_VAR_IDENTIFIER);
        
        // if page number is > 1, added this to the prop2 and page name accordingly.
        if(!empty($pageNumber) && $pageNumber > 1 )
        {
            // if there isn't already a prop 2, create it using the convention
            // [prop1]:[page-N], else just append the page number.
            if(empty($siteCatalystData['prop2']))
            {
               $siteCatalystData['prop2'] = $siteCatalystData['prop1'].':page-'.$pageNumber;
            }
            else
            {
               $siteCatalystData['prop2'].= ':page-'.$pageNumber;   
            }
         
         $siteCatalystData['pageName'].= ':page-'.$pageNumber;                 
        }
        
        $this->assignValue(SITECATALYST_TEMPLATE_IDENTIFIER, $siteCatalystData);
                     
        $this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeLandingFooter($page, $pageNumber = 0) 
    {
        $pageNumber = (int)$pageNumber;
        $this->assignValue('page', $page, $pageNumber);
        
        $siteCatalystData = $page->get(SITECATALYST_VAR_IDENTIFIER);
        
        // if page number is > 1, added this to the prop2 and page name accordingly.
        if(!empty($pageNumber) && $pageNumber > 1 )
        {
            // if there isn't already a prop 2, create it using the convention
            // [prop1]:[page-N], else just append the page number.
            if(empty($siteCatalystData['prop2']))
            {
               $siteCatalystData['prop2'] = $siteCatalystData['prop1'].':page-'.$pageNumber;
            }
            else
            {
               $siteCatalystData['prop2'].= ':page-'.$pageNumber;   
            }
         
         $siteCatalystData['pageName'].= ':page-'.$pageNumber;                 
        }
        
        $this->assignValue(SITECATALYST_TEMPLATE_IDENTIFIER, $siteCatalystData);
        
        $this->bufferContent($this->landingFooterTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeCard($page, $card, $cardData, $cardNumber=0, $siteProp=null, $pageNumber = 0) 
    {
        if($cardData)
            $this->assignValue('cardData', $cardData);
        if($card)
            $this->assignValue('card', $card);
        if($cardNumber)
            $this->assignValue('cardNumber', $cardNumber);
        if($page)
            $this->assignValue('page', $page);
        if($siteProp){
            $this->assignValue('siteProp', $siteProp);
        }
        
        if($pageNumber){
            $this->assignValue('pageNumber', $pageNumber);
        }

        $this->bufferContent($this->cardTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");   
    }

    function writeLandingCard($page, $card, $cardData, $cardNumber=0, $siteProp=null) 
    {
        if($cardData)
            $this->assignValue('cardData', $cardData);
        if($card)
            $this->assignValue('card', $card);
        if($cardNumber)
            $this->assignValue('cardNumber', $cardNumber);
        if($page)
            $this->assignValue('page', $page);
        if($siteProp){
            $this->assignValue('siteProp', $siteProp);
        }
        $this->bufferContent($this->cardLandingTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
   
    }

    function bufferContent($name, $path = '')
    {
    	
    	if ($path == null){
    		$file = TEMPLATES_PATH.$name.TEMPLATE_SUFFIX;
    	}else{
    		$file = $path."/".$name.TEMPLATE_SUFFIX;
    	}
    	
    	if (is_file($file)){
    		$this->outputBuffer .= $this->tpl->getTemplate($file);
    	}else{
    		 _setMessage("Template " . $file . " not found!");
    		 $this->outputBuffer .= "Template " . $file . " not found! <br>";
    	}
    }
    
    function getBufferedOutput()
    {
    	return $this->outputBuffer;
    }
    
    function writeBufferedOutput($file)
    {
    	
    	$handle = fopen($file,"w");
    	if(!$handle){
    		return false;
    	}
    	if(!fwrite($handle, $this->outputBuffer)){
    		return false;
    	}
    	return true;
    }
    
    function assignValue($key, $val)
    {
    	$this->tpl->assign($key, $val);
    }
    
    function _getCardListingAsAssociativearray($cardObject){
		$listingArray = array();
		$listingArray['Intro APR'] = array($cardObject['active_introApr'], $cardObject['introApr']);
		$listingArray['Intro APR Period'] = array($cardObject['active_introAprPeriod'], $cardObject['introAprPeriod']);
		$listingArray['Regular APR'] = array($cardObject['active_regularApr'], $cardObject['regularApr']);
		$listingArray['Annual Fee'] = array($cardObject['active_annualFee'], $cardObject['annualFee']);
		$listingArray['Monthly Fee (up&nbsp;to)'] = array($cardObject['active_monthlyFee'], $cardObject['monthlyFee']);
		$listingArray['Balance Transfers'] = array($cardObject['active_balanceTransfers'], $cardObject['balanceTransfers']);
		$listingArray['Credit Needed'] = array($cardObject['active_creditNeeded'], $cardObject['creditNeeded']);
		
		return $listingArray;
	}    
}
