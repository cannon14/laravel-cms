<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('Affiliate_Install_Bl_Scenario');

class Affiliate_Install_Bl_ScenarioUpgradeFree extends Affiliate_Install_Bl_Scenario 
{
    
    var $steps = array();
    
    function Affiliate_Install_Bl_ScenarioUpgradeFree() {
        $this->init(); 
    }    
    
    function init() {
        parent::init(); 
        $this->addStep('Start', L_G_START);
        $this->addStep('Authorization', L_G_AUTHORIZATION);        
        $this->addStep('SettingsConvertFree', L_G_SETTINGSCONVERT);
        $this->addStep('DbConvertFree', L_G_DBCONVERT);
        $this->addStep('FinishConvert', L_G_FINISHCONVERT);
    }
            
}
?>