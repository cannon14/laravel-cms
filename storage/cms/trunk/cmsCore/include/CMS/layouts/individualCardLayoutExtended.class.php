<?php
/**
 * 
 * ClickSuccess, L.P.
 * August 18, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Layouts
 */
csCore_Import::importClass('csCore_UI_template');
class CMS_layouts_IndividualCardLayoutExtended 
{

	var $tpl;
	var $headerTemplate;
	var $footerTemplate;
	var $cardTemplate;
    
    function CMS_layouts_IndividualCardLayoutExtended() 
    {
    	$this->outputBuffer = "";
    	$this->tpl = new csCore_UI_template(); 	
    }
    
    function writeHeader($page)
    {
    	$this->assignValue('rootPath', '../');
    	$this->assignValue('page', $page);
    	$this->bufferContent($this->headerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
    }
    
    function writeBody($card, $cardData, $cardPage=null) 
    {
        $this->assignValue('card', $card);
        $this->assignValue('cardData', $cardData);
        if($cardPage==null)echo$card->get('cardTitle');
        $this->assignValue('cardpage', $cardPage);
        $this->bufferContent($this->bodyTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
   
    } 
    
    function writeFooter($card) 
    {
        $this->assignValue('page', $card);
        $this->assignValue(SITECATALYST_TEMPLATE_IDENTIFIER, $card->get(SITECATALYST_VAR_IDENTIFIER));
        $this->bufferContent($this->footerTemplate, $GLOBALS['RootPath']."/cmsCore/include/CMS/layouts/templates");
   
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
?>