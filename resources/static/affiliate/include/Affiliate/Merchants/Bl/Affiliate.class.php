<?php
//============================================================================
// Copyright (c) Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QCore_History');
QUnit_Global::includeClass('QCore_Bl_Communications');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_CampaignCategories');

class Affiliate_Merchants_Bl_Affiliate
{
    //--------------------------------------------------------------------------

    function decline($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";
            
            $sql = 'update wd_g_users set rstatus='._q(AFFSTATUS_SUPPRESSED).
                   ' where userid in '.$userIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function approve($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";
            
            // first send confirmation emails
            // check what was the last state
            $sql = 'select userid, username, rstatus, rpassword from wd_g_users '.
                   'where userid in '.$userIDSql.
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            while(!$rs->EOF)
            {
                if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED)
                {
                    // send email to affiliate about the approval
                    $params = array();
                    $params['pwd'] = $rs->fields['rpassword'];
                    
                    QUnit_Global::includeClass('QCore_EmailTemplates');
                    
                    $emaildata = QCore_EmailTemplates::getFilledEmailMessage($rs->fields['userid'], 'AFF_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $params);
                    $password_sent = false;
                    if($emaildata != false)
                    {
                        $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $rs->fields['userid'],
                            'email' => $rs->fields['username']
                           );
                           
                        if(QCore_Bl_Communications::sendEmail($params)) {
                            QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSEND, __FILE__, __LINE__);
                        }
                    }
                    else {
                        QCore_History::DebugMsg(WLOG_ACTIONS, L_G_EMAILTEMPERR, __FILE__, __LINE__);
                    }
                }
                
                $rs->MoveNext();
            }
            
            // now change status
            $sql = 'update wd_g_users set rstatus='._q(AFFSTATUS_APPROVED).
                   ' where userid in '.$userIDSql.
                   '   and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function delete($params)
    {
        $userIDs = $params['userids'];
        if(!is_array($userIDs) || count($userIDs) < 1)
            return false;

        $chunkedUserIDs = array_chunk($userIDs, WD_MAX_PROCESSED_IDS);
        
        foreach($chunkedUserIDs as $userIDsArray)
        {
            $userIDSql = "('".implode("','", $userIDsArray)."')";
            
            $sql = 'update wd_g_users set deleted=1 '.
                   ' where userid in '.$userIDSql.
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
        }

        return true;
    }
    
    //--------------------------------------------------------------------------

    function checkData($params)
    {
        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);

        // protect against script injection
        $params['refid'] = preg_replace('/[^0-9a-zA-Z_-]/', '', $_POST['refid']);
        $params['uname'] = preg_replace('/[\'\"]/', '', $_POST['uname']);
        $params['pwd1'] = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $params['pwd2'] = preg_replace('/[\'\"]/', '', $_POST['pwd2']);
        $params['weburl'] = preg_replace('/[\'\"]/', '', $_POST['weburl']);
        $params['name'] = preg_replace('/[\'\"]/', '', $_POST['name']);
        $params['surname'] = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $params['payout_type'] = preg_replace('/[\'\"]/', '', $_POST['payout_type']);
        $params['tax_ssn'] = preg_replace('/[\'\"]/', '', $_POST['tax_ssn']);
        $params['company_name'] = preg_replace('/[\'\"]/', '', $_POST['company_name']);
        $params['street'] = preg_replace('/[\'\"]/', '', $_POST['street']);
        $params['city'] = preg_replace('/[\'\"]/', '', $_POST['city']);
        $params['state'] = preg_replace('/[\'\"]/', '', $_POST['state']);
        $params['country'] = preg_replace('/[\'\"]/', '', $_POST['country']);
        $params['zipcode'] = preg_replace('/[\'\"]/', '', $_POST['zipcode']);
        $params['phone'] = preg_replace('/[\'\"]/', '', $_POST['phone']);
        $params['fax'] = preg_replace('/[\'\"]/', '', $_POST['fax']);
        $params['minpayout'] = preg_replace('/[^0-9]/', '', $_POST['minpayout']);
        $params['userid'] = preg_replace('/[\'\"]/', '', $_POST['aid']);
        $params['parentuserid'] = preg_replace('/[\'\"]/', '', $_POST['parentuserid']);

        foreach($payout_fields as $payfield)
        {
            foreach($payfield as $value)
            {   
                $params['field'.$value['payfieldid']] = preg_replace('/[\'\"]/', '', $_POST['field'.$value['payfieldid']]);
            }
        }

        // check correctness of the fields
        checkCorrectness($_POST['uname'], $params['uname'], L_G_USERNAME, CHECK_EMPTYALLOWED);
      
        if($_POST['uname'] != '' && Affiliate_Merchants_Bl_Affiliate::checkUserExists($_POST['uname'], $params['userid'], $GLOBALS['Auth']->getAccountID()))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);

        checkCorrectness($_POST['refid'], $params['refid'], L_G_REFID, CHECK_EMPTYALLOWED);
        
        if($_POST['refid'] != '' && Affiliate_Merchants_Bl_Affiliate::checkRefIDExists($_POST['refid'], $params['userid'], $GLOBALS['Auth']->getAccountID()))
            QUnit_Messager::setErrorMessage(L_G_REFIDEXISTS);

        if($_POST['pwd1']!='*****' || $_POST['pwd2']!='*****')
        {        
            checkCorrectness($_POST['pwd1'], $params['pwd1'], L_G_PWD1, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['pwd2'], $params['pwd2'], L_G_PWD2, CHECK_EMPTYALLOWED);
      
            if($_POST['pwd1'] != $_POST['pwd2'])
                QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);
        }

        checkCorrectness($_POST['weburl'], $params['weburl'], L_G_WEBURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $params['name'], L_G_NAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['surname'], $params['surname'], L_G_SURNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['street'], $params['street'], L_G_STREET, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['city'], $params['city'], L_G_CITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['country'], $params['country'], L_G_COUNTRY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['zipcode'], $params['zipcode'], L_G_ZIPCODE, CHECK_EMPTYALLOWED);
    
        if($GLOBALS['Auth']->getSetting('Aff_min_payout_options') != '')
            checkCorrectness($_POST['minpayout'], $params['minpayout'], L_G_MINPAYOUT, CHECK_EMPTYALLOWED, CHECK_NUMBER);      

        if($params['payout_type'] == '')
            QUnit_Messager::setErrorMessage(L_G_CHOOSEPAYOUTMETHOD);

        foreach($payout_methods as $method)
        {
            if($params['payout_type'] == $method['payoptid'])
            {
                foreach($payout_fields[$method['payoptid']] as $field)
                {
                    $check = CHECK_ALLOWED;
                    if($field['mandatory'] == STATUS_ENABLED)
                    {
                        $check = CHECK_EMPTYALLOWED;
                    }

                    checkCorrectness($_POST['field'.$field['payfieldid']], $params['field'.$field['payfieldid']],
                             (defined($field['langid']) ? constant($field['langid']) : $field['name']), $check);
                }
            }
        }

        // check if there is not the cross link of affiliates, such as A -> B, and B -> A
        if(Affiliate_Merchants_Bl_Affiliate::checkUserCrossLink($params['parentuserid'], array($params['userid'], $params['parentuserid'])))
        {
            QUnit_Messager::setErrorMessage(L_G_MERCHPARENTAFFILIATECREATESCHAIN);
        }
        
        return $params;
    }
    
    //------------------------------------------------------------------------

    function checkUserExists($username, $aid = '', $accountid)
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and username='._q($username).
               '  and accountid='._q($accountid);
        if($aid != '')
            $sql .= ' and userid<>'._q($aid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        if($rs->EOF)
            return false;

        return true;
    }

    //------------------------------------------------------------------------

    function checkRefIDExists($refID, $aid = '', $accountid)
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and (refid='._q($refID).' or userid='._q($refID).')'.
               '  and accountid='._q($accountid);
        if($aid != '')
            $sql .= ' and userid<>'._q($aid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        if($rs->EOF)
            return false;

        return true;
    }

    //------------------------------------------------------------------------
    
    function insert($params)
    {
        // save user to db
        $params['pwd1'] = $ppwd1;
        $UserID = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');
        $sql = 'insert into wd_g_users(userid, refid, parentuserid, accountid, username, '.
               'rpassword, rtype, dateinserted, name, surname, rstatus, userprofileid, '.
               'weburl, company_name, street, city, state, country, zipcode, phone, '.
               ' fax, tax_ssn, payoptid)'.

               ' values('._q($UserID).','._q($params['refid']).','._q($params['parentuserid']).','._q($GLOBALS['Auth']->getAccountID()).
               ','._q($params['uname']).','._q(MD5($params['pwd1'])).','._q(USERTYPE_USER).
               ','.sqlNow().','._q($params['name']).','._q($params['surname']).
               ','.AFFSTATUS_APPROVED.','._q(DEFAULT_USER_PROFILE).
               ','._q($params['weburl']).','._q($params['company_name']).','._q($params['street']).
               ','._q($params['city']).','._q($params['state']).','._q($params['country'])
               .','._q($params['zipcode']).','._q($params['phone']).','._q($params['fax'])
               .','._q($params['tax_ssn']).','._q($params['payout_type']).')';
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
        else
        {
            $params['userid'] = $UserID;
            Affiliate_Merchants_Bl_Affiliate::saveUserData($params);
            
            // send password by email
            $emailParams = array();
            $emailParams['pwd'] = $params['pwd1'];
            
            QUnit_Global::includeClass('QCore_EmailTemplates');
            
            $emaildata = QCore_EmailTemplates::getFilledEmailMessage($UserID, 'AFF_EMAIL_SIGNUP', $_SESSION[SESSION_PREFIX.'lang'], $emailParams);
            
            $password_sent = false;
            
            if($emaildata != false)
            {
                $params = array('accountid' => $GLOBALS['Auth']->getAccountID(),
                            'subject' => $emaildata['subject'],
                            'text' => $emaildata['text'],
                            'message_type' => MESSAGETYPE_EMAIL,
                            'userid' => $UserID,
                            'email' => $params['uname']
                );
                           
                if(QCore_Bl_Communications::sendEmail($params)) {
                    QCore_History::DebugMsg(WLOG_DBERROR, L_G_EMAILSEND, __FILE__, __LINE__);
                    return false;
                }
            }
            else
            {
                QCore_History::DebugMsg(WLOG_ACTIONS, L_G_EMAILTEMPERR, __FILE__, __LINE__);
            }
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------

    function saveUserData($params)
    {
        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);

        $sql = 'delete from wd_g_settings '.
               'where accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and rtype='._q(SETTINGTYPE_USER).
               '  and userid='._q($params['userid']).
               '  and code like \'%'._q_noendtags('Aff_payoptionfield_').'%\'';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        // save data into settings
        QCore_Settings::_update('Aff_payout_type', $params['payout_type'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $params['userid']);
        QCore_Settings::_update('Aff_min_payout', $params['minpayout'], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $params['userid']);

        if(is_array($payout_fields[$params['payout_type']])) 
        {
            foreach($payout_fields[$params['payout_type']] as $field)
            {
                QCore_Settings::_update('Aff_payoptionfield_'.$field['payfieldid'], $params['field'.$field['payfieldid']], SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $params['userid'], $field['payfieldid']);
            }
        }
    }
    
    //--------------------------------------------------------------------------

    function checkUserCrossLink($userID, $list = array(), $maxRecursion = 50)
    {
        if($userID == '' || $userID == 0 || $maxRecursion <=0)
            return false;

        // get parent affiliate of current aff
        $sql = "select parentuserid from wd_g_users where userid="._q($userID)." and parentuserid<>"._q($userID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if(in_array($rs->fields['parentuserid'], $list))
            return true;
        
        $list[] = $rs->fields['parentuserid'];

        return Affiliate_Merchants_Bl_Affiliate::checkUserCrossLink($rs->fields['parentuserid'], $list, $maxRecursion - 1);
    }
    
    //--------------------------------------------------------------------------

    function update($params)
    {
        if(AFF_DEMO == 1 && $params['userid'] == 2)
        {
            $sql = 'update wd_g_users '.
                   'set name='._q($params['name']).
                   '   ,surname='._q($params['surname']);
        }
        else
        {
            $sql = 'update wd_g_users '.
                   'set username='._q($params['uname']).
                   ', refid='._q($params['refid']).
                   ', surname='._q($params['surname']).
                   ', name='._q($params['name']).
                   ', parentuserid='._q($params['parentuserid']).
                   ', weburl='._q($params['weburl']).
                   ', company_name='._q($params['company_name']).
                   ', street='._q($params['street']).
                   ', city='._q($params['city']).
                   ', state='._q($params['state']).
                   ', country='._q($params['country']).
                   ', zipcode='._q($params['zipcode']).
                   ', phone='._q($params['phone']).
                   ', fax='._q($params['fax']).
                   ', tax_ssn='._q($params['tax_ssn']).
                   ', payoptid='._q($params['payout_type']);
                   
            if($params['pwd1']!='*****' || $params['pwd2']!='*****')
                $sql .=',rpassword='._q($params['pwd1']);
        }

        $sql .= ' where userid='._q($params['userid']).
                '   and accountid='._q($GLOBALS['Auth']->getAccountID());

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        Affiliate_Merchants_Bl_Affiliate::saveUserData($params);
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function insertAffiliatesCampaigns($params)
    {
        if(($campaigns_data=Affiliate_Merchants_Bl_CampaignCategories::getFirstCampaignsCategory($params)) === false) return false;

        $chunkedUserIDs = array_chunk($params['userIDs'], WD_MAX_PROCESSED_IDS);

        foreach($chunkedUserIDs as $userIDsArray)
        {
            foreach($userIDsArray as $UserID)
            {
                $temp_campaigns_data = $campaigns_data;
               
                foreach($temp_campaigns_data as $campaign_data)
                {
                    $sql = 'select affcampid from wd_pa_affiliatescampaigns '.
                           'where affiliateid='._q($UserID).
                           '  and campaignid='._q($campaign_data['campaignid']);
                    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                    if(!$rs) {
                        QUnit_Messager::setErrorMessage(L_G_DBERROR);
                        return false;
                    }

                    if($rs->EOF)
                    {
                        $AffCampID = QCore_Sql_DBUnit::createUniqueID('wd_pa_affiliatescampaigns', 'affcampid');

                        $sql = 'insert into wd_pa_affiliatescampaigns '.
                               '(affcampid, campcategoryid, affiliateid, campaignid, rstatus)'.
                               ' values '.
                               '('._q($AffCampID).','._q($campaign_data['campcategoryid']).
                               ','._q($UserID).','._q($campaign_data['campaignid']).
                               ','._q(AFFSTATUS_APPROVED).')';
                        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

                        if(!$ret) {
                            QUnit_Messager::setErrorMessage(L_G_DBERROR);
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function loadUserInfoToPost($userid)
    {
        $sql = 'select * from wd_g_users '.
               'where deleted=0 '.
               '  and userid='._q($userid).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED, $rs->fields['payoptid']);
        $userData = QCore_Settings::getUserSettings(SETTINGTYPE_USER, $GLOBALS['Auth']->getAccountID(), $rs->fields['userid']);

        $_POST['aid'] = $rs->fields['userid'];
        $_POST['refid'] = $rs->fields['refid'];
        if($_POST['refid'] == '')
            $_POST['refid'] = $rs->fields['userid'];
        $_POST['uname'] = $rs->fields['username'];
        $_POST['pwd1'] = '*****';
        $_POST['pwd2'] = '*****';
        $_POST['name'] = $rs->fields['name'];
        $_POST['surname'] = $rs->fields['surname'];
        $_POST['parentuserid'] = $rs->fields['parentuserid'];
        $_POST['weburl'] = $rs->fields['weburl'];
        $_POST['company_name'] = $rs->fields['company_name'];
        $_POST['street'] = $rs->fields['street'];
        $_POST['city'] = $rs->fields['city'];
        $_POST['state'] = $rs->fields['state'];
        $_POST['country'] = $rs->fields['country'];
        $_POST['zipcode'] = $rs->fields['zipcode'];
        $_POST['phone'] = $rs->fields['phone'];
        $_POST['fax'] = $rs->fields['fax'];
        $_POST['tax_ssn'] = $rs->fields['tax_ssn'];
        $_POST['payout_type'] = $rs->fields['payoptid'];
        $_POST['data1'] = $rs->fields['data1'];
        $_POST['data2'] = $rs->fields['data2'];
        $_POST['data3'] = $rs->fields['data3'];
        $_POST['data4'] = $rs->fields['data4'];
        $_POST['data5'] = $rs->fields['data5'];

        $_POST['minpayout'] = $userData['Aff_min_payout'];

        if(is_array($payout_fields[$rs->fields['payoptid']])) {
            foreach($payout_fields[$rs->fields['payoptid']] as $field)
            {
                $_POST['field'.$field['payfieldid']] = $userData['Aff_payoptionfield_'.$field['payfieldid']];
            }
        }

        return true;
    }
    
    function getTrafficSourceById($id)
    {
    	$sql = 'SELECT * FROM wd_g_users WHERE userid = ' . _q($id);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
    	
    	return $rs->fields;
    }

    //--------------------------------------------------------------------------

    function getUsersAsArray()
    {
        $sql =  'SELECT data5 FROM wd_g_users WHERE userid='._q($GLOBALS['Auth']->getUserID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if($rs->fields['data5'])
        	$sql = 'SELECT * FROM wd_g_users ' .
        		'		WHERE deleted=0 ' .
        		'		AND rtype='._q(USERTYPE_USER).' ' .
        		'		AND accountid='._q($GLOBALS['Auth']->getAccountID());
        else
			$sql = 'SELECT * FROM wd_g_users '.
                ' WHERE deleted=0 '.
                ' AND rtype='._q(USERTYPE_USER).
                ' AND accountid='._q($GLOBALS['Auth']->getAccountID()).
                ' AND userid IN ('.
                '  			SELECT affiliateid FROM cs_affiliateaccess ' .
                '			WHERE userid='._q($GLOBALS['Auth']->getUserID()).')'.
                ' ORDER BY name';
        
        //$sql . '<br>';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $user = array();
        while(!$rs->EOF)
        {
            $temp = array();

            $temp['userid'] = $rs->fields['userid'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['username'] = $rs->fields['username'];

            $user[$rs->fields['userid']] = $temp;

            $rs->MoveNext();
        }
        
        if(count($user) <= 0) {
            return array();
        }
        
        $user_str = '';
        foreach($user as $k => $v)
        {
            $user_str .= '\''.$k.'\',';
        }
        $user_str = substr($user_str, 0, -1);

        $sql = 'select userid, value '.
               'from wd_g_settings '.
               'where code='._q('Aff_payout_type').
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and userid in ('.$user_str.')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }        

        while(!$rs->EOF)
        {
            $user[$rs->fields['userid']]['payout_type'] = $rs->fields['value'];
            $rs->MoveNext();
        }

        return $user;
    }

    //--------------------------------------------------------------------------
    
	 function getUserIdsForSql()
    {
        $sql =  'SELECT data5 FROM wd_g_users WHERE userid='._q($GLOBALS['Auth']->getUserID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if($rs->fields['data5'])
        	$sql = 'SELECT userid FROM wd_g_users ' .
        		'		WHERE deleted=0 ' .
        		'		AND rtype='._q(USERTYPE_USER).' ' .
        		'		AND accountid='._q($GLOBALS['Auth']->getAccountID());
        else
			$sql = 'SELECT userid FROM wd_g_users '.
                ' WHERE deleted=0 '.
                ' AND rtype='._q(USERTYPE_USER).
                ' AND accountid='._q($GLOBALS['Auth']->getAccountID()).
                ' AND userid IN ('.
                '  			SELECT affiliateid FROM cs_affiliateaccess ' .
                '			WHERE userid='._q($GLOBALS['Auth']->getUserID()).')'.
                ' ORDER BY name';
        
        //$sql . '<br>';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $user = array();
        while(!$rs->EOF)
        {
            $user[] = _q($rs->fields['userid']);
            $rs->MoveNext();
        }
        if(sizeof($user) == 0)
        	return "('')";
        else
        	return "(".implode(',',$user).")";
    }
    
    //--------------------------------------------------------------------------
       
    function getTreeOfUsers($rootID, &$userTree, $tab, $tabLevel, $maxLevel)
    {
        if($maxLevel <= 0)
            return;

        $sql = 'select * from wd_g_users';
        if($rootID == '') {
            $sql .=' where rstatus='.AFFSTATUS_APPROVED.' and deleted=0 and rtype='._q(USERTYPE_USER).' and accountid='._q($GLOBALS['Auth']->getAccountID()).' and (parentuserid=\'\' or parentuserid is null or parentuserid=\'0\')';
        }
        else 
            $sql .=' where rstatus='.AFFSTATUS_APPROVED.' and deleted=0 and rtype='._q(USERTYPE_USER).' and accountid='._q($GLOBALS['Auth']->getAccountID()).' and parentuserid='._q($rootID);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['userid'] = $rs->fields['userid'];
            $temp['username'] = $rs->fields['username'];
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['tab'] = $tab;

            $userTree[] = $temp;

            // look for children
            Affiliate_Merchants_Bl_Affiliate::getTreeOfUsers($rs->fields['userid'], $userTree, $tab.$tabLevel, $tabLevel, $maxLevel-1);

            $rs->MoveNext();
        }
    }

    //--------------------------------------------------------------------------

    function getUsersAsRs()
    {
        $sql =  'SELECT data5 FROM wd_g_users WHERE userid='._q($GLOBALS['Auth']->getUserID());
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if($rs->fields['data5'])
        	$sql = 'SELECT * FROM wd_g_users ' .
        		'		WHERE deleted=0 ' .
        		'		AND rtype='._q(USERTYPE_USER).' ' .
        		'		AND accountid='._q($GLOBALS['Auth']->getAccountID());
        else
			$sql = 'SELECT * FROM wd_g_users '.
                ' WHERE deleted=0 '.
                ' AND rtype='._q(USERTYPE_USER).
                ' AND accountid='._q($GLOBALS['Auth']->getAccountID()).
                ' AND userid IN ('.
                '  			SELECT affiliateid FROM cs_affiliateaccess ' .
                '			WHERE userid='._q($GLOBALS['Auth']->getUserID()).')';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return $rs;
    }
    
    //--------------------------------------------------------------------------
    
    function getAssignedAffiliatesByAdmin($adminId)
    {
    	$sql = "SELECT * FROM wd_g_users " .
    			"WHERE userid IN (" .
    			"	SELECT affiliateid FROM" .
    			"	cs_affiliateaccess" .
    			"	WHERE userid="._q($adminId).") AND rtype = " ._q(USERTYPE_USER) . " AND deleted != 1";
    	//echo $sql.'<br>';
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs;    			
    }
    
    //--------------------------------------------------------------------------
    
    function getUnassignedAffiliatesByAdmin($adminId)
    {
    	$sql = "SELECT * FROM wd_g_users " .
    			"WHERE userid NOT IN (" .
    			"	SELECT affiliateid FROM" .
    			"	cs_affiliateaccess" .
    			"	WHERE userid= "._q($adminId).") AND rtype = " ._q(USERTYPE_USER). " AND deleted != 1";
    	//echo $sql.'<br>';
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	return $rs;  
    }
    
    function getAffiliateIdByRef($ref)
    {
    	$sql = 'SELECT userid FROM wd_g_users WHERE refid = ' . _q($ref);
    	$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
    	
    	return $rs->fields['userid'];	
    } 
}
?>
