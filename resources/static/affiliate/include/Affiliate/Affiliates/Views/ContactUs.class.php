<?
//============================================================================
// Copyright (c) webradev.com 2005
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_EmailTemplates');

class Affiliate_Affiliates_Views_ContactUs extends QUnit_UI_TemplatePage
{
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['action'])
            {
                case 'send':
                    if($this->processSendMail())
                        return;
                    break;
            }
        }

        $this->drawFormContactUs();    
    }

    //------------------------------------------------------------------------

    function processSendMail()
    {
        if(get_magic_quotes_gpc())
        {
            $_POST['emailsubject'] = stripslashes($_POST['emailsubject']);
            $_POST['emailtext'] = stripslashes($_POST['emailtext']);
        }

        $system_email = $GLOBALS['Auth']->getSetting('Aff_system_email');

        $params = array('UserID' => $GLOBALS['Auth']->getUserID(),
                        'title' => $_POST['emailsubject'],
                        'body' => $_POST['emailtext']);

        $emaildata = QCore_EmailTemplates::getFilledEmailMessage('', 'AFF_EMAIL_CONTACT_US', $GLOBALS['Auth']->getSetting('Aff_default_lang'), $params);
        if($emaildata != false)
        {
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $GLOBALS['Auth']->getUserID(),
                            'email' => $system_email
                           );
                           
            if(!QCore_Bl_Communications::sendEmail($params))
            {
                QUnit_Messager::setErrorMessage(L_G_EMAILSENDFAILED);
                QCore_History::DebugMsg(WLOG_DEBUG, L_G_EMAILSENDFAILED.' ('.L_G_TO.': '.$system_email.')', __FILE__, __LINE__);
            }
            else
            {
                QUnit_Messager::setOkMessage(L_G_EMAILSENDOK);
                QCore_History::DebugMsg(WLOG_ACTION, L_G_EMAILSENDOK.' ('.L_G_TO.': '.$system_email.')', __FILE__, __LINE__);
                return false;
            }
        }
        else
        {
            QUnit_Messager::setErrorMessage(L_G_EMAILSENDFAILED);
            QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSENDFAILED.' ('.L_G_TO.': '.$system_email.')', __FILE__, __LINE__);
        }

        return false;
    }

    //------------------------------------------------------------------------

    function drawFormContactUs()
    {
        $_POST['header'] = L_G_CONTACTUS;
        $_POST['action'] = 'send';

        $this->addContent('contact_us');

        return true;
    }

    //------------------------------------------------------------------------
}
?>
