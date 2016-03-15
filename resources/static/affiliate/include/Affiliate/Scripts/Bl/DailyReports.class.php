<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_Bl_Accounts');
QUnit_Global::includeClass('QCore_Bl_Users');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
QUnit_Global::includeClass('Affiliate_Merchants_Views_AffiliateManager');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TimerangeStatistics');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Scripts_Bl_DailyReports
{
    function sendDailyReports()
    {
        $countGenerated = 0;
        $countSent = 0;

        $accounts = QCore_Bl_Accounts::getAccountsAsArray();
        $account_settings = QCore_Settings::getAccountsSettings();

        foreach($accounts as $account)
        {
            $data = Affiliate_Scripts_Bl_TimerangeStatistics::getTimerangeStats('',
                         $d, $m, $y, $d, $m, $y, $account['accountid'],
                         $account_settings[$account['accountid']]);

            if($account_settings[$account['accountid']]['Aff_email_dailyreport'] == 1)
            {
                $countGenerated++;
            
                if($this->sendDailyReportToMerchant($data,
                        $acct_setting[$account['accountid']]['Aff_default_lang'],
                        $acct_setting[$account['accountid']]['Aff_notifications_email'],
                        $account['accountid']))
                    $countSent++;
            }

            $user_settings = QCore_Settings::getAccountUsersSettings($account['accountid']);
            $users = QCore_Bl_Users::getUsersUsernamesAsArray($account['accountid']);

            foreach($user_settings as $userid => $userdata)
            {
                if($userdata['Aff_email_affdailyreport'] == '1')
                {
                    $countGenerated++;
            
                    $userstats = Affiliate_Scripts_Bl_TimerangeStatistics::getTimerangeStats(
                         $userid, '',
                         $d, $m, $y, $d, $m, $y, $account['accountid'],
                         $account_settings[$account['accountid']]);

                    if($this->sendDailyReportToUser($userid, $users[$account['accountid']][$userid]['username'], $userstats, $userdata['Aff_aff_notificationlang'], $account['accountid']))
                    {
                        $countSent++;
                    }
                }
            }
        }
        
        // log it
        LogMsg("Daily reports - generated: $countGenerated reports, sent reports: $countSent, error sending reports: ".($countGenerated - $countSent), __FILE__, __LINE__);
        
        return $countGenerated;
    }
    
    //------------------------------------------------------------------------
    
    function sendDailyReportToMerchant(&$data, $default_lang, $notifications_email, $accountID)
    {
        $d = date("j");
        $m = date("n");
        $y = date("Y");
        
        QUnit_Global::includeClass('QCore_EmailTemplates');

        $emaildata = QCore_EmailTemplates::getFilledEmailMessage('', 'AFF_EMAIL_DAILY_REP', $default_lang, $data);
        if($emaildata != false)
        {
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => '',
                            'email' => $notifications_email
            );
            
            if(!QCore_Bl_Communications::sendEmail($params)) {
                $errorMsg = "Daily report: There was a problem sending daily report email to merchant '".$notifications_email."'";
                LogError($errorMsg, __FILE__, __LINE__);
            } else {
                LogMsg("Daily report was succesfully generated and sent to merchant '".$notifications_email."'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
          $errorMsg = "Daily report:  There was a problem generating merchant daily report email from template";
          LogError($errorMsg, __FILE__, __LINE__);
        }

        return false;
    }

    //------------------------------------------------------------------------
    
    function sendDailyReportToUser($userID, $email, &$data, $lang, $accountID)
    {
        $d = date("j");
        $m = date("n");
        $y = date("Y");
        
        QUnit_Global::includeClass('QCore_EmailTemplates');

        $emaildata = QCore_EmailTemplates::getFilledEmailMessage('', 'AFF_EMAIL_AF_DL_REP', $lang, $data);
        if($emaildata != false)
        {
            $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $userID,
                            'email' => $email
            );
            
            if(!QCore_Bl_Communications::sendEmail($params)) {
                $errorMsg = "Daily report: There was a problem sending daily report email to user '$email'";
                LogError($errorMsg, __FILE__, __LINE__);
            } else {
                LogMsg("Daily report was succesfully generated and sent to user '$email'", __FILE__, __LINE__);
                return true;
            }
        }
        else
        {
          $errorMsg = "Daily report:  There was a problem generating user daily report email from template";
          LogError($errorMsg, __FILE__, __LINE__);
        }

        return false;
    }
}
?>
