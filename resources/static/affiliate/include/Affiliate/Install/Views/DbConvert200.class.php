<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConvert200 extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbConvert200() {
        $this->init();        
    }    
    
    function init() {
        parent::init();        
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }
    
    function getName() {
        return 'DbConvert200';
    }    
    
    function getContent() {
        if($this->convert()) {
            $this->assign('check', 'ok');            
        } else {
            $this->assign('check', 'failed');                        
        }
        $this->assign('action', 'DbConvert200');
        return $this->fetch('db_convert');        
    }
    
    function process() { 
        if(isset($_POST['check']) && $_POST['check'] == 'ok') {
            return true;
        }
        return false;    
    }  
    
    function convert() {
        if(!$this->model->executeSqlFile('./sql/create_pap_200_mysql.sql')) {
            QUnit_Messager::setErrorMessage(L_G_CREATINGNEWDBFAILED);
            return false;
        }
        if(!$this->model->executeSqlFile('./sql/update_pap_14_200_mysql.sql')) {
            QUnit_Messager::setErrorMessage(L_G_CONVERTFAILED);
            return false;
        }
        return true;
    }    
        
}
?>