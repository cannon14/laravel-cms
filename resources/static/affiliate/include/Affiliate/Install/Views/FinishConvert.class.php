<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_FinishConvert extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_FinishConvert() {
        $this->init(); 
    }    
    
    function init() {
        parent::init();        
    }
    
    function getName() {
        return 'FinishConvert';
    }
    
    function getContent() {
        $this->assign('msgHeader', L_G_UPGRADEFINISHED);
        $this->assign('msgFinished', L_G_UPGFINISHED);
        $this->assign('msgNextSteps', L_G_UPGNEXTSTEPS);
        return $this->fetch('finish');
    }
    
    function process() { 
        return false;
    }  
        
}
?>