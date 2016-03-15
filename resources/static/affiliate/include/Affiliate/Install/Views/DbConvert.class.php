<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Install_Views_DbConvert extends QUnit_UI_TemplatePage
{
    
    var $model;
    
    function Affiliate_Install_Views_DbConvert() {
        $this->init(); 
    }    
    
    function init() {
        parent::init();        
    }
    
    function getContent() {
        return $this->fetch('db_convert');        
    }
    
    function process() { 
        if(isset($_POST['submit'])) {
            return true;
        }
        return false;
    }  
        
}
?>