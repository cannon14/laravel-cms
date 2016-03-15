<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Views_BroadcastMessage extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['broadcast'] = 'aff_comm_broadcast_email_use';
        $this->modulePermissions['view'] = 'aff_comm_broadcast_email_use';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'broadcast':
                    if($this->processBroadcastEmail())
                        return;
                break;
            }
        }
    
        $this->showForm();
    }  

    //--------------------------------------------------------------------------
  
    function processBroadcastEmail()
    {
        if(get_magic_quotes_gpc())
        {
            $_POST['emailsubject'] = stripslashes($_POST['emailsubject']);
            $_POST['emailtext'] = stripslashes($_POST['emailtext']);
        }
        
        $users = explode(",", $_POST['selectedusers']);
        $subject = $_POST['emailsubject'];
        $text = $_POST['emailtext'];

        $chunkedUserIDs = array_chunk($users, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userid_str = "('".implode("','", $userIDsArray)."')";

            if($userid_str == '') return false;

            $params = array('AccountID' => $GLOBALS['Auth']->getAccountID(),
                            'userid_str' => $userid_str
                           );

            $users = QCore_Bl_Users::getUsersToBroadcastMessage($params);

            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $subject,
                            'text' => $text,
                            'message_type' => $_POST['message_type'],
                            'users' => $users
                           );

            if(($mus = QCore_Bl_Communications::insert($params)) == false) return false;

            if($_POST['message_type'] == MESSAGETYPE_EMAIL)
            {
                $this->sendMessageByEmail($users, $mus, $subject, $text);
            }
        }
        
        if($_POST['message_type'] != MESSAGETYPE_EMAIL) {
            QUnit_Messager::setOkMessage(L_G_SAVE_OK);
        }
        
        return false;
    }

    //--------------------------------------------------------------------------
    
    function sendMessageByEmail($users, $mus, $tmplSubject, $tmplText)
    {
        foreach($users as $user)
        {
            $subject = $tmplSubject;
            $text = $tmplText;
            
            $strs = array('title' => $subject, 'text' => $text);

            $strs = QCore_Bl_Communications::replaceInNews($user, $strs);
            
            $subject = $strs['title'];
            $text = $strs['text'];

            $print_message =  L_G_SENDING.$user['name'].' '.$user['surname'].' ';
  
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                'subject' => $subject,
                'text' => $text,
                'message_type' => MESSAGETYPE_EMAIL,
                'userid' => $userid,
                'email' => $user['username']
            );
            
            $handle = fopen('emailtest2.txt', 'a');
            
            if(QCore_Bl_Communications::sendEmailDirect($params)) {
                QUnit_Messager::setOkMessage($print_message.L_G_SENTOK);
            }
            else {
                QUnit_Messager::setErrorMessage($print_message.L_G_SENTFAILED);
            }
        }
    }

    //--------------------------------------------------------------------------

    function showForm()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'broadcast';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'broadcast';

        if(!isset($_POST['header']))
            $_POST['header'] = L_G_BROADCAST_MESSAGE;

        $users = QCore_Bl_Users::getUsersShort($GLOBALS['Auth']->getAccountID());

        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($users);
        $this->assign('a_list_data1', $list_data1);

        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($users);
        $this->assign('a_list_data2', $list_data2);

        $this->addContent('broademail_show');
    }
}
?>
