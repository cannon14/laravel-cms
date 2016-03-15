<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Install_Bl_ChooseScenario
{
    
    var $scenarios = array();
    
    function Affiliate_Install_Bl_ChooseScenario() {
        $this->init(); 
    }    
    
    function init() {
        $this->add('Install');
        $this->add('Upgrade200');
    }
    
    function add($name) {
        $this->scenarios[$name] =& $this->getNewScenario($name);        
    }

    function getScenarioObj($scenario) {
        $scClass = 'Affiliate_Install_Bl_Scenario'.$scenario;
        if(!QUnit_Global::existsClass($scClass)) {
            return $this->getScenario('');
        }
        return QUnit_Global::newObj($scClass);        
    }
    
    function getNextScenario() {
        
    }
        
}
?>