<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbCreate extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbCreate() {
        $this->init(); 
        $this->model =& QUnit_Global::newObj('Affiliate_Install_Bl_Install');
    }    
    
    function init() {
        parent::init();        
    }
            
    function getName() {
        return 'DbCreate';
    }     
    
    function getContent() {
        if($this->model->processDbCreation()) {
            $this->assign('check', 'ok');            
        } else {
            $this->assign('check', 'failed');                        
        }
        return $this->fetch('db_created');
    }
    
    function process() {
        if(isset($_POST['check']) && $_POST['check'] == 'ok') {
            return true;
        }
        return false;        
    }  
         
}
?>