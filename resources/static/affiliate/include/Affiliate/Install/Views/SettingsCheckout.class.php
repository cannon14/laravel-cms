<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_SettingsCheckout extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_SettingsCheckout() {
        $this->init(); 
    }    
    
    function init() {
        parent::init();      
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');  
    }
    
    function getName() {
        return 'SettingsCheckout';
    }
    
    function getContent() {
        if($this->checkSettings()) {
            $this->assign('check', 'ok');            
        } else {
            $this->assign('check', 'failed');                        
        }
        return $this->fetch('settings_checkout');        
    }
    
    function process() { 
        if(isset($_POST['check']) && $_POST['check'] == 'ok') {
            return true;
        }
        return false;
    }  
    
    function checkSettings() {
        if($this->model->checkDbConnection(DB_TYPE, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) === false) {
            return false;
        } else {
            $_SESSION[SESSION_PREFIX.'dbtype'] = DB_TYPE;
            $_SESSION[SESSION_PREFIX.'dbhostname'] = DB_HOSTNAME;
            $_SESSION[SESSION_PREFIX.'dbusername'] = DB_USERNAME;
            $_SESSION[SESSION_PREFIX.'dbpwd'] = DB_PASSWORD;
            $_SESSION[SESSION_PREFIX.'dbname'] = DB_DATABASE;
        }     
        if($this->model->writeSettingsFile() === false) {
            return false;
        }                           
        return true;
    }
        
}
?>