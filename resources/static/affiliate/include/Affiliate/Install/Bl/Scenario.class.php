<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class Affiliate_Install_Bl_Scenario
{
    
    var $steps = array();
    
    function Affiliate_Install_Bl_Scenario() {
        $this->init(); 
    }    
    
    function init() {
        $this->addStep('Start', L_G_INSTALLATIONPROGRESSBAR);
    }
    
    function addStep($name, $caption) {
        $this->steps[$name] = array('name' => $name, 'caption' => $caption, 'done' => false);        
    }
    
    function setCurrentStep($action) {
        foreach($this->steps as $name => $step) {
            $this->steps[$name]['done'] = true;
            if($name == $action) {
                break;                
            }
        }
    }
    
    function getNextStep($step) {
        while(list($name, $arr) = each($this->steps)) {
            if($name == $step) {
                list($name, $arr) = each($this->steps);
                return $name;
            }
        }        
    }
    
    function getStep() {
        $step = each($this->steps);      
        return $step['value'];
    }
        
}
?>