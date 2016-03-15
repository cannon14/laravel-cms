<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('Affiliate_Install_Bl_Scenario');

class Affiliate_Install_Bl_ScenarioInstall extends Affiliate_Install_Bl_Scenario 
{
    
    var $steps = array();
    
    function Affiliate_Install_Bl_ScenarioInstall() {
        $this->init();
    }    
    
    function init() {
        parent::init(); 
        $this->addStep('Start', L_G_START);
        $this->addStep('Authorization', L_G_AUTHORIZATION);
        $this->addStep('DbConfig', L_G_DBCONFIG);
        $this->addStep('DbCreate', L_G_DBCREATION);        
        $this->addStep('MerchantConfig', L_G_MERCHANTCONFIGURATION);
        $this->addStep('Settings', L_G_SETTINGS);
        $this->addStep('Finish', L_G_FINISH);
    }
            
}
?>