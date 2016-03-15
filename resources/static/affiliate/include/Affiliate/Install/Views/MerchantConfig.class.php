<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_MerchantConfig extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_MerchantConfig() {
        $this->init(); 
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }    
    
    function init() {
        parent::init();        
    }
                
    function getName() {
        return 'MerchantCreate';
    } 
        
    function getContent() {
        return $this->fetch('merchant_config');
    }    
    
    function process() {
        if(isset($_POST['submit'])) {
            if($this->processMerchantCreation() === true) { 
                return true;
            }
        }
        return false;            
    }  
    
    function processMerchantCreation()
    {
        $username = preg_replace('/[\'\"]/', '', $_POST['username']);
        $pwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $pwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        
        // check correctness of the fields
        checkCorrectness($_POST['username'], $username, L_G_MUSERNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd1'], $pwd1, L_G_MPWD, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['pwd2'], $pwd2, L_G_VERIFYMPWD, CHECK_EMPTYALLOWED);
        
        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        
        if($pwd1 != $pwd2) {
            QUnit_Messager::setErrorMessage(L_G_PASSWORDSDONTMATCH);
            return false;
        }
        
        if($this->model->createMerchantAccount($username, $pwd1) === false) {
            return false;
        }        
        return true;
    }       
}
?>