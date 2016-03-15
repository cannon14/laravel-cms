<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_ProgressBar extends QUnit_UI_TemplatePage
{
    
    function Affiliate_Install_Views_ProgressBar() {
        $this->init(); 
    }    
    
    function init() {
        parent::init();        
    }
    //------------------------------------------------------------------------
    
    function process($scenario, $action) { 
        $scenario->setCurrentStep($action);
        $this->assign('model', $scenario);
        return $this->fetch('progressbar');                
    }  
            
}
?>