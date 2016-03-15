<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_Start extends QUnit_UI_TemplatePage
{
    function Affiliate_Install_Views_Start() {
        $this->init(); 
    }        
    
    function init() {
        parent::init();        
    }

    function getName() {
        return 'Start';
    }
    
    function getContent() {
        return $this->fetch('step0'); 
    }
    
    function process() {
        unset($_SESSION[SESSION_PREFIX.'installmethod']);
        if(isset($_POST['submit'])) {
            if($this->checkSession() && $this->getInstallMethod()) {
                return true;
            }
        }        
        return false;    
    }
    
    //------------------------------------------------------------------------
    
    function checkSession() {
        
        return true;
    }
    
    function getInstallMethod() {   
        if(isset($_POST['installmethod'])) {
            $_SESSION[SESSION_PREFIX.'installmethod'] = $_POST['installmethod'];
            return true;
        }        
        QUnit_Messager::setErrorMessage(L_G_CHOOSEINSTALLMETHOD);
        return false;
    }
}
?>