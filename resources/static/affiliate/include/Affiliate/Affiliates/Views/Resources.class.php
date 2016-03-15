<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_ResourcesPage');

class Affiliate_Affiliates_Views_Resources extends QUnit_UI_ResourcesPage
{
    function process()
    {
        $this->drawPage();
    }

    //------------------------------------------------------------------------

    function drawPage()
    {
        $this->assign('a_content', $this->getContent());

        $this->addContent('resource_page');

        return true;
    }
    
    //------------------------------------------------------------------------

    function getContent()
    {
        if($_REQUEST['p'] != '')
            $page = $this->findPage($_REQUEST['p']);
        
        if($page == false)
            $page = $this->findPage($GLOBALS['defaultResourcesPage']);

        return $page;
    }
}
?>
