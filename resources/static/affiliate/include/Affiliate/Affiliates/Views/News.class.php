<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_News extends QUnit_UI_TemplatePage
{
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'changestatus':
                    if($this->processChangeNewsStatus())
                        return;
                    break;
            }
        }

        $this->drawShowNews();    
    }

    //------------------------------------------------------------------------

    function processChangeNewsStatus()
    {
        $pmessagetouserid = preg_replace('/[\'\"]/', '', $_POST['nid']);
        $pview_old = preg_replace('/[\'\"]/', '', $_POST['view_old']);

        QCore_Bl_Communications::changeMessageStatus($pmessagetouserid, MESSAGESTATUS_NOT_SHOW);

        $this->redirect('Affiliate_Affiliates_Views_MainPage&view_old='.$pview_old);

        return true;
    }

    //------------------------------------------------------------------------

    function drawShowNews()
    {
        $nid = preg_replace('/[\'\"]/', '', $_REQUEST['nid']);

/*    
        $params = array(
                        'userid' => $GLOBALS['Auth']->getUserID(),
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );
    
        $user_news = QCore_Bl_Communications::getUserNews($params);
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($user_news[$GLOBALS['Auth']->getUserID()]);
        $this->assign('a_list_data', $list_data);

        $this->addContent('news_list');
*/
        $_POST['header'] = L_G_NEWS;
        $_POST['action'] = 'changestatus';
        $_POST['nid'] = $nid;

        $params = array('messagetouserid' => $nid,
                        'userid' => $GLOBALS['Auth']->getUserID(),
                        'accountid' => $GLOBALS['Auth']->getAccountID()
                       );

        $news = QCore_Bl_Communications::getNews($params);
        $this->assign('a_news_data', $news);

        if($news['status'] == MESSAGESTATUS_NOT_READED)
            QCore_Bl_Communications::changeMessageStatus($nid, MESSAGESTATUS_SHOW);

        $this->addContent('aff_news');

        return true;
    }

    //------------------------------------------------------------------------

}
?>
