<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');

class Affiliate_Affiliates_Views_Login extends QUnit_UI_TemplatePage
{
    var $UserType = '';

    function process()
    {
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'login':
                    if($this->processLogin())
                        return;
                break;
            }
        }

        $this->showLogin();
    }

    //==========================================================================
    // FORMS FUNCTIONS
    //==========================================================================

    function showLogin()
    {
        if($_POST['commited'] != 'yes')
        {
            $_POST['username'] = 'user';
            $_POST['rpassword'] = 'user';
        }

        $_POST['action'] = 'login';

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(QCore_Settings::getAvailableLangs());
    
        $this->assign('a_list_data', $list_data);

        $this->addContent('login');
    }

    //==========================================================================
    // PROCESSING FUNCTIONS
    //==========================================================================

    function processLogin()
    {
        if($_POST['commited'] == 'yes')
        {
            if(($uid = $GLOBALS['Auth']->checkLogon($_POST['username'], $_POST['rpassword'], USERTYPE_USER)) != false)
            {
                $GLOBALS['Auth']->logUser($uid, $_POST['username'], USERTYPE_USER);
                $this->redirect('Affiliate_Affiliates_Views_AffReports');
            }
            else
            {
                QUnit_Messager::setErrorMessage(L_G_INVALIDUNAMEPWD);
            }
        }

        return false;
    }
}
?>