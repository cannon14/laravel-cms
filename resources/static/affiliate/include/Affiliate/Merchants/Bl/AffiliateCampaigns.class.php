<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rules');
QUnit_Global::includeClass('QCore_EmailTemplates');
QUnit_Global::includeClass('QCore_Bl_Communications');

class Affiliate_Merchants_Bl_AffiliateCampaigns
{
    function updateDeclineReason($params)
    {
        $sql = 'update wd_pa_affiliatescampaigns '.
               'set rstatus='._q(AFFSTATUS_SUPPRESSED).
               '   ,declinereason='._q($params['decline_reason']).
               ' where affcampid='._q($params['affcampid']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function getCampCats($params)
    {
        $sql = 'select c.campaignid, c.name '.
               'from wd_g_users a, wd_pa_campaigns c, wd_pa_affiliatescampaigns ac';

        $rs = QCore_Sql_DBUnit::execute($sql.' '.$params['where'], __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $camp_cats = array();
        while(!$rs->EOF)
        {
            $camp_cats[$rs->fields['campaignid']]['campaignid'] = $rs->fields['campaignid'];
            $camp_cats[$rs->fields['campaignid']]['name'] = $rs->fields['name'];

            $rs->MoveNext();
        }

        return $camp_cats;
    }

    //--------------------------------------------------------------------------

    function insertAffCampTrans($params)
    {
        QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

        $campInfo = Affiliate_Merchants_Bl_Settings::getCampaignInfo(array('campaignid' => $params['campaignid']));

        if($campInfo == false) return false;

        $TransID = QCore_Sql_DBUnit::createUniqueID('wd_pa_transactions', 'transid');

        $sql = 'insert into wd_pa_transactions ('.
               'transid, accountid, rstatus, dateinserted, transtype, payoutstatus,'.
               'transkind,affiliateid,commission'.
               ') values ('.
               _q($TransID).','._q($params['accountID']).','._q(AFFSTATUS_APPROVED).
               ','.sqlNow().','._q(TRANSTYPE_SIGNUP).','._q('1').','._q(TRANSKIND_NORMAL).
               ','._q($params['userid']).','._q($campInfo[SETTINGTYPEPREFIX_AFF_CAMP.'signup_bonus']).')';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $pr_params = array('users' => array($params['userid']),
                           'AccountID' => $params['accountID'],
                           'decimal_places' => $params['decimal_places']
                          );

        if(($rules = Affiliate_Merchants_Bl_Rules::getRulesAsArray($pr_params)) !== false)
            Affiliate_Merchants_Bl_Rules::checkPerformanceRules($pr_params, $rules);

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function changeState($params)
    {
        $AccountID = $params['AccountID'];
        $affCampIDs = $params['affCampIDs'];
        $state = $params['state'];
        $decline_reason = $params['decline_reason'];
        $round_numbers = $params['round_numbers'];

        if(!is_array($affCampIDs) || count($affCampIDs) < 1)
            return false;

        if($state != AFFSTATUS_APPROVED && $state != AFFSTATUS_SUPPRESSED)
            return false;

        $chunkedAffCampIDs = array_chunk($affCampIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedAffCampIDs as $affCampIDsArray)
        {
            $affCampIDSql = "('".implode("','", $affCampIDsArray)."')";
            
            $acs_params = array('accountID' => $AccountID,
                                'affcampidsql' => $affCampIDSql
                               );
            if(($old_affCamp_datas = Affiliate_Merchants_Bl_AffiliateCampaigns::getAffCampStatus($acs_params)) === false) continue;
            
            if(!is_array($old_affCamp_datas) || count($old_affCamp_datas) < 1) continue;
            
            $acs_params = array('state' => $state,
                                'affcampidsql' => $affCampIDSql,
                                'decline_reason' => $decline_reason
                               );
            
            $ret = Affiliate_Merchants_Bl_AffiliateCampaigns::updateAffCampStatus($acs_params);
            
            if($ret == false) continue;
            
            foreach($old_affCamp_datas as $affCampID => $affCampData)
            {
                if($affCampData['oldstate'] == AFFSTATUS_NOTAPPROVED && $state == AFFSTATUS_APPROVED)
                {
                    $ftaac_params = array('accountID' => $AccountID,
                                          'decimal_places' => $round_numbers,
                                          'affcampid' => $affCampID,
                                          'userid' => $affCampData['userid'],
                                          'campaignid' => $affCampData['campaignid'],
                                          'email' => $affCampData['email'],
                                          'camp_name' => $affCampData['camp_name']
                                         );

                    Affiliate_Merchants_Bl_AffiliateCampaigns::firstTimeApproveAffCamp($ftaac_params);
                }
            }
        }
    }

    //--------------------------------------------------------------------------

    function getAffCampStatus($params)
    {
        $sql = 'select a.userid, a.username, ac.rstatus, ac.affcampid, c.campaignid, c.name '.
               'from wd_g_users a, wd_pa_affiliatescampaigns ac, wd_pa_campaigns c '.
               'where ac.affcampid in '.($params['affcampidsql']).
               '  and ac.affiliateid=a.userid'.
               '  and ac.campaignid=c.campaignid'.
               '  and a.accountid='._q($params['accountID']);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $acs = array();

        while(!$rs->EOF)
        {
            $acs[$rs->fields['affcampid']]['oldstate'] = $rs->fields['rstatus'];
            $acs[$rs->fields['affcampid']]['userid'] = $rs->fields['userid'];
            $acs[$rs->fields['affcampid']]['campaignid'] = $rs->fields['campaignid'];
            $acs[$rs->fields['affcampid']]['email'] = $rs->fields['username'];
            $acs[$rs->fields['affcampid']]['camp_name'] = $rs->fields['name'];
            
            $rs->MoveNext();
        }

        return $acs;
    }

    //--------------------------------------------------------------------------

    function updateAffCampStatus($params)
    {
        $sql = 'update wd_pa_affiliatescampaigns '.
               'set rstatus='._q($params['state']).
               '   ,declinereason='._q($params['decline_reason']).
               ' where affcampid in '.$params['affcampidsql'];
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function firstTimeApproveAffCamp($params)
    {
        $ret = Affiliate_Merchants_Bl_AffiliateCampaigns::insertAffCampTrans($params);

        if($ret == false) return false;

        // send email to affiliate about the approval
        $emaildata = QCore_EmailTemplates::getFilledEmailMessage($params['userid'], 'AFF_EMAIL_AFF_CAMP_APPROVE', $_SESSION[SESSION_PREFIX.'lang'], $params);
        $password_sent = false;
        if($emaildata != false)
        {
            $email_params = array('accountid' => $params['AccountID'],
                                  'subject' => $emaildata['subject'],
                                  'text' => $emaildata['text'],
                                  'message_type' => MESSAGETYPE_EMAIL,
                                  'userid' => $params['userid'],
                                  'email' => $params['email']
                                 );
                       
            if(QCore_Bl_Communications::sendEmail($email_params)) {
                QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSEND.' To user: '.$params['userid'], __FILE__, __LINE__);
                return false;
            }
        }
        else {
            QCore_History::DebugMsg(WLOG_ACTIONS, 'First time approve affiliate campaign: '.L_G_EMAILTEMPERR.' To user: '.$params['userid'], __FILE__, __LINE__);
        }
    }
}
?>
