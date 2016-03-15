<?
//============================================================================
// Copyright (c) Jennifer Semtner, rapidotech.com 2005
// All rights reserved
//
// For support contact support@rapidotech.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
class Affiliate_Affiliates_Views_StaticPage extends QUnit_UI_TemplatePage
{
	function process()
    {
        if(!empty($_REQUEST['page']))
        {
            switch($_REQUEST['page'])
            {
                case 'newsandarticles':
                	$this->addContent('newsandarticles');
                	return;
            }
        }
        
        if($GLOBALS['Auth']->getSetting('Aff_display_news') == '1')
        {
            $this->processNews();
        }
        
		$this->addContent('staticpage');
    }

    //------------------------------------------------------------------------

    function processNews()
    {
        $params = array(
            'userid' => $GLOBALS['Auth']->getUserID(),
            'accountid' => $GLOBALS['Auth']->getAccountID(),
            'view_old' => $_REQUEST['view_old']
        );

        $user_news = QCore_Bl_Communications::getUserNews($params);
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($user_news[$GLOBALS['Auth']->getUserID()]);
        $this->assign('a_list_data', $list_data);

        $this->assign('a_news_count', count($user_news[$GLOBALS['Auth']->getUserID()]));

        $this->assign('a_old_news_exist', QCore_Bl_Communications::checkOldNewsExist($params));
    }
    
}