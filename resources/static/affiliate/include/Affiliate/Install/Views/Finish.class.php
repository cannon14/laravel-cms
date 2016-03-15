<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_Finish extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_Finish() {
        $this->init(); 
    }    
    
    function init() {
        parent::init();        
    }
            
    function getName() {
        return 'Finish';
    }     
    
    function getContent() {
        $this->assign('msgHeader', L_G_INSTALLATIONFINISHED);
        $this->assign('msgFinished', L_G_INSTFINISHED);
        $this->assign('msgNextSteps', L_G_NEXTSTEPS);        
        return $this->fetch('finish');        
    }
    
    function process() { 
        return false;
    }  
        
}
?>