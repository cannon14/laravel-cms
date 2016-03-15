<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_Install extends QUnit_UI_TemplatePage
{
    var $className = "Install";
    var $model;
    
    function Affiliate_Install_Views_Install() {
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    //------------------------------------------------------------------------
    
//    function process() {
//        if(!isset($_SESSION[SESSION_PREFIX.'installmethod'])) {
//            QUnit_Messager::setErrorMessage(L_G_SESSIONNOTWORKING);                
//        }
        
//    }  
    
    function &getView($action) {                
        $viewClass = 'Affiliate_Install_Views_'.$action;
        if(!QUnit_Global::existsClass($viewClass)) {            
            return $this->getView('Start');
        }
        return QUnit_Global::newObj($viewClass);
        
    }
    
    function process() {
        $action = $_POST['action'];
        if(empty($action)) {
           $scenario =& $this->getScenario('');
           $view =& $this->getView('Start');
           $this->showPage($view, $scenario);
        } else {
            $view =& $this->getView($action);
            $scenario =& $this->getScenario($_SESSION[SESSION_PREFIX.'installmethod']);
            if($view->process()) {
                $scenario =& $this->getScenario($_SESSION[SESSION_PREFIX.'installmethod']);
                $view = $this->getView($scenario->getNextStep($action));
            }                                                    
           $this->showPage($view, $scenario);
        }    
    }
    
    function showPage(&$view, &$scenario) {
        $this->temp_content = $view->getContent();
        $progressBar =& QUnit_Global::newObj('Affiliate_Install_Views_ProgressBar');
        $this->temp_content .= $progressBar->process($scenario, $view->getName());        
    }
    
   function &getScenario($method) {       
        $scClass = 'Affiliate_Install_Bl_Scenario'.$method;
        if(!QUnit_Global::existsClass($scClass)) {
            return $this->getScenario('');
        }
        return QUnit_Global::newObj($scClass);        
    }     
}
?>