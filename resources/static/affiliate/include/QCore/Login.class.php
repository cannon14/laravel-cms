<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_History');

class QCore_Login extends QUnit_UI_TemplatePage
{
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

    //------------------------------------------------------------------------

    function showLogin()
    {
        $_POST['action'] = 'login';

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS(QCore_Settings::getAvailableLangs());

        $this->assign('a_list_data', $list_data);

        $this->addContent('login');
    }

    //------------------------------------------------------------------------

    function processLogin()
    {
        if($_POST['commited'] == 'yes')
        {
            if(($uid = $GLOBALS['Auth']->checkLogon($_POST['username'], $_POST['rpassword'], $this->user_type)) != false)
            {
                $GLOBALS['Auth']->logUser($uid, $_POST['username'], $this->user_type);
                $_REQUEST['md'] = '';
                unset($_REQUEST['md']);
                // pmizer added to log logins.
                QCore_History::systemNotify("Logged In.");
                //Redirect_nomsg('index.php');
            }
            else
            {
                QUnit_Messager::setErrorMessage(L_G_INVALIDUNAMEPWD);
            }
        }

        return false;
    }
    
    //------------------------------------------------------------------------

    function isLoginPage()
    {
        return true;
    }
}
?>
