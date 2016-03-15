<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_CustomPage extends QUnit_UI_TemplatePage
{
    function process()
    {
        if($_REQUEST['p'] == '')
            QUnit_Messager::setErrorMessage('No page');
        else
            $this->addContent($_REQUEST['p']);
    }  
}
?>
