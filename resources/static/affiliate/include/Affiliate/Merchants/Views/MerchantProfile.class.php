<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QUnit_Graphics_HtmlGraph');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TimerangeStatistics');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_TrendStatistics');

class Affiliate_Merchants_Views_MerchantProfile extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['showcodes'] = 'aff_tool_integration_view';
        $this->modulePermissions['view'] = '';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'editcontactinfo':
                    if($this->processEditContactInfo())
                        return;
                    break;

                case 'editaccountinfo':
                    if($this->processEditAccountInfo())
                        return;
                    break;

                case 'editcustomization':
                    if($this->processEditCustomization())
                        return;
                    break;
            }
        }

        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'editcontactinfo':
                    if($this->drawFormEditContactInfo())
                        return;
                    break;

                case 'editaccountinfo':
                    if($this->drawFormEditAccountInfo())
                        return;
                    break;

                case 'showcodes':
                    if($this->drawFormShowCodes())
                        return;
                    break;
            }
        }

        $this->showProfile();
    }

    //--------------------------------------------------------------------------

    function processEditContactInfo()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $psurname = preg_replace('/[\'\"]/', '', $_POST['surname']);
        $pusername = preg_replace('/[\'\"]/', '', $_POST['email']);
        $pcontact_person = preg_replace('/[\'\"]/', '', $_POST['contact_person']);
        $pcompany_name = preg_replace('/[\'\"]/', '', $_POST['company_name']);
        $pemail = preg_replace('/[\'\"]/', '', $_POST['email']);
        $pweburl = preg_replace('/[\'\"]/', '', $_POST['weburl']);
        $pstreet = preg_replace('/[\'\"]/', '', $_POST['street']);
        $pcity = preg_replace('/[\'\"]/', '', $_POST['city']);
        $pstate = preg_replace('/[\'\"]/', '', $_POST['state']);
        $pcountry = preg_replace('/[\'\"]/', '', $_POST['country']);
        $pzipcode = preg_replace('/[\'\"]/', '', $_POST['zipcode']);
        $pphone = preg_replace('/[\'\"]/', '', $_POST['phone']);
        $pfax = preg_replace('/[\'\"]/', '', $_POST['fax']);
    
        // check correctness of the fields
        checkCorrectness($_POST['email'], $pusername, L_G_EMAIL, CHECK_EMPTYALLOWED);
        
        if($_POST['email'] != '' && $this->checkMerchantExists($_POST['email'], $GLOBALS['Auth']->getUserID()))
            QUnit_Messager::setErrorMessage(L_G_EMAILEXISTS);
        
        checkCorrectness($_POST['weburl'], $pweburl, L_G_WEBURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['name'], $pname, L_G_CONTACT_FIRST_NAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['surname'], $psurname, L_G_CONTACT_SURNAME, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['street'], $pstreet, L_G_STREET, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['city'], $pcity, L_G_CITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['country'], $pcountry, L_G_COUNTRY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['zipcode'], $pzipcode, L_G_ZIPCODE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['phone'], $pphone, L_G_PHONE, CHECK_EMPTYALLOWED);
    
        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            // save changes of user to db
            $sql = 'update wd_g_users '.
                   'set name='._q($pname).
                   '   ,surname='._q($psurname).
                   '   ,username='._q($pusername).
                   '   ,company_name='._q($pcompany_name).
                   '   ,weburl='._q($pweburl).
                   '   ,street='._q($pstreet).
                   '   ,city='._q($pcity).
                   '   ,state='._q($pstate).
                   '   ,country='._q($pcountry).
                   '   ,zipcode='._q($pzipcode).
                   '   ,phone='._q($pphone).
                   '   ,fax='._q($pfax).
                   ' where userid='._q($GLOBALS['Auth']->getUserID()).
                   '   and rtype='._q(USERTYPE_ADMIN);
            $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if(!$ret) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
/*
            QCore_Settings::_update('Aff_contactname', $pname.' '.$psurname, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_company_name', $pcompany_name, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_weburl', $pweburl, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_street', $pstreet, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_city', $pcity, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_state', $pstate, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_country', $pcountry, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_zipcode', $pzipcode, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_phone', $pphone, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
            QCore_Settings::_update('Aff_fax', $pfax, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
*/
            QCore_Settings::_update('Aff_contact_person', $pcontact_person, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID());
        
            QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
        
            QUnit_Messager::setOkMessage(L_G_MERCHANTEDITED);
        
            $this->closeWindow('Affiliate_Merchants_Bl_MerchantProfile');
            $this->addContent('closewindow');

//            echo "<center><input type=button class=formbutton value='".L_G_CLOSE."' onClick='javascript:window.opener.document.location.reload(); window.close();'></center>";

            return true;
        }

        return false;
    }  

    //--------------------------------------------------------------------------

    function processEditAccountInfo()
    {
        // protect against script injection
        $puname = preg_replace('/[\'\"]/', '', $_POST['uname']);
        $ppwd1 = preg_replace('/[\'\"]/', '', $_POST['pwd1']);
        $ppwd2 = preg_replace('/[\'\"]/', '', $_POST['pwd2']);

        // check correctness of the fields
        checkCorrectness($_POST['uname'], $puname, L_G_USERNAME, CHECK_EMPTYALLOWED);

        if($_POST['uname'] != '' && $this->checkMerchantExists($_POST['uname'], 1))
            QUnit_Messager::setErrorMessage(L_G_UNAMEEXISTS);

        if($_POST['pwd1']!='********' || $_POST['pwd2']!='********')
        {        
            checkCorrectness($_POST['pwd1'], $ppwd1, L_G_PWD1, CHECK_EMPTYALLOWED);
            checkCorrectness($_POST['pwd2'], $ppwd2, L_G_PWD2, CHECK_EMPTYALLOWED);
      
            if($_POST['pwd1'] != $_POST['pwd2'])
                QUnit_Messager::setErrorMessage(L_G_PWDDONTMATCH);
        }
    
        if(QUnit_Messager::getErrorMessage() != '')
        {
        }
        else
        {
            // save changes of user to db
            $ppwd = md5($ppwd1);
            if($_POST['pwd1']!='********' || $_POST['pwd2']!='********')
                $sql = "update wd_g_users set username="._q($puname).", rpassword="._q($ppwd)." where userid="._q('1')." and rtype="._q(USERTYPE_ADMIN);
            else
                $sql = "update wd_g_users set username="._q($puname)." where userid="._q('1')." and rtype="._q(USERTYPE_ADMIN);

            if(AFF_DEMO != 1)
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            else
                $ret = true;
        
            if(!$ret)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            else
            {
                QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);

                QUnit_Messager::setOkMessage(L_G_MERCHANTEDITED);

                $this->closeWindow('Affiliate_Merchants_Bl_MerchantProfile');
                $this->addContent('closewindow');

                return true;
            }
        }

        return false;
    }

    //--------------------------------------------------------------------------

    function drawFormEditContactInfo()
    {
        if($_POST['commited'] != 'yes')
        {
            $userid = $GLOBALS['Auth']->userID;
            $userid = preg_replace('/[\'\"]/', '', $userid);

            $sql = 'select * from wd_g_users '.
                   'where userid='._q($userid).
                   '  and rstatus='._q(STATUS_ENABLE).
                   '  and accountid='._q($GLOBALS['Auth']->getAccountID());
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

            if (!$rs || $rs->EOF)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }

            $_POST['mid'] = $rs->fields['userid'];
            $_POST['name'] = $rs->fields['name'];
            $_POST['surname'] = $rs->fields['surname'];
            $_POST['company_name'] = $rs->fields['company_name'];
            $_POST['email'] = $rs->fields['username'];
            $_POST['weburl'] = $rs->fields['weburl'];
            $_POST['street'] = $rs->fields['street'];
            $_POST['city'] = $rs->fields['city'];
            $_POST['state'] = $rs->fields['state'];
            $_POST['country'] = $rs->fields['country'];      
            $_POST['zipcode'] = $rs->fields['zipcode'];
            $_POST['phone'] = $rs->fields['phone'];
            $_POST['fax'] = $rs->fields['fax'];

            $_POST['contact_person'] = $GLOBALS['Auth']->settings['Aff_contact_person'];
        }

        $account_admins = $this->getAccountAdminsAsArray($GLOBALS['Auth']->getAccountID());
        
        $_POST['action'] = 'editcontactinfo';
        $_POST['postaction'] = 'editcontactinfo';
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($account_admins);
        $this->assign('a_list_data', $list_data);
        
        $list_data2 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data2->setTemplateRS($GLOBALS['countries']);
        $this->assign('a_list_data2', $list_data2);
        
        $this->addContent('contact_edit');
        
        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormEditAccountInfo()
    {
        if($_POST['commited'] != 'yes')
        {
            $userid = $GLOBALS['Auth']->userID;
            $userid = preg_replace('/[\'\"]/', '', $userid);

            $sql = 'select * from wd_g_users where deleted=0 and userid='._q('1').' and rtype='._q(USERTYPE_ADMIN);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs || $rs->EOF)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }

            $_POST['mid'] = $rs->fields['userid'];
            $_POST['uname'] = $rs->fields['username'];
            $_POST['pwd1'] = '********';
            $_POST['pwd2'] = '********';
        }

        $_POST['action'] = 'editaccountinfo';
        $_POST['postaction'] = 'editaccountinfo';

        $this->addContent('account_edit');

        return true;
    }

    //--------------------------------------------------------------------------

    function drawFormShowCodes()
    {
        $this->addContent('integration');
    
        return true;
    }

    //--------------------------------------------------------------------------

    function showProfile()
    {
        $GLOBALS['Auth']->loadSettings($GLOBALS['Auth']->getAccountID(), $GLOBALS['Auth']->getUserID());
        $GLOBALS['Auth']->getFromSession();
        
        $this->getAffiliateStats();
        
        $this->getTrendStats();
        
        // get number of transactions waiting for approval
        $sql = 'select count(transid) as amount from wd_pa_transactions t, wd_g_users u '.
        'where u.userid=t.affiliateid '.
        '  and u.rtype='._q(USERTYPE_USER).
        '  and u.accountid='._q($GLOBALS['Auth']->getAccountID()).
        '  and t.rstatus='.AFFSTATUS_NOTAPPROVED.
        '  and u.deleted=0';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        $this->assign('a_trans_waiting', $rs->fields['amount']);
        
        // get statistics for today
        $d1 = date("j");
        $m1 = date("n");
        $y1 = date("Y");
        $d2 = date("j");
        $m2 = date("n");
        $y2 = date("Y");
        
        QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');
        
        $data = Affiliate_Scripts_Bl_TimerangeStatistics::getTimerangeStats(
                    '', '', $d1, $m1, $y1, $d2, $m2, $y2,
                    $GLOBALS['Auth']->getAccountID()
                    );
        
        $this->assign('a_data', $data);
        
        $this->addContent('m_profile');
    }
    
    //--------------------------------------------------------------------------

    function getAffiliateStats()
    {
        $sql = 'select count(*) as rcount, rstatus from wd_g_users '.
               'where rtype='._q(USERTYPE_USER).
               '  and accountid='._q($GLOBALS['Auth']->getAccountID()).
               '  and deleted=0'.
               ' group by rstatus';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs || $rs->EOF)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $approved = 0;
        $waiting = 0;
        $declined = 0;
        $all = 0;
        
        while(!$rs->EOF)
        {
            $status = $rs->fields['rstatus'];
            
            if($status == AFFSTATUS_APPROVED)
            {
                $approved = $rs->fields['rcount'];
            }
            else if($status == AFFSTATUS_NOTAPPROVED)
            {
                $waiting = $rs->fields['rcount'];
            }
            else if($status == AFFSTATUS_SUPPRESSED)
            {
                $declined = $rs->fields['rcount'];
            }
            
            $rs->MoveNext();
        }
        
        $all = $approved + $waiting + $declined;

        $this->assign('a_aff_all', $all);
        $this->assign('a_aff_waiting', $waiting);
        
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $labels = "<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_APPROVED."'>".L_G_APPROVED."</a>,";
        $labels .= "<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_NOTAPPROVED."'>".L_G_WAITINGAPPROVAL."</a>,";
        $labels .= "<a class=textlink href='index.php?md=Affiliate_Merchants_Views_AffiliateManager&fromprofile=1&umprof_status=".AFFSTATUS_SUPPRESSED."'>".L_G_SUPPRESSED."</a>";
        $graph->labels = $labels;
        $graph->values = $approved.','.$waiting.','.$declined;
        $graph->barColor = '#486B8F';
        $graph->barLength = 4.0;
        $gdata = $graph->create();
        
        $this->assign('a_affstats_graph', $gdata);
    }
    
    //--------------------------------------------------------------------------

    function getTrendStats()
    {
        $twoYearStats = false;
        if(Affiliate_Scripts_Bl_TrendStatistics::checkSomeTransImpsExistedLastYear(''))
        {

			$trendLastYear = Affiliate_Scripts_Bl_TrendStatistics::getTrendStats(
                                                         $_REQUEST['rt_affiliate'],
														 '',
                                                         $_REQUEST['rt_campaign'],
														 '',
                                                         $_REQUEST['rt_trackerId'],
                                                         $_REQUEST['rt_keywordId'],
                                                         $_REQUEST['rt_timeslotId'],
                                                         $_REQUEST['rt_pageId'],
                                                         'monthly',
                                                         1, 1, date('Y')-1,
                                                         31, 12, date('Y')-1
                                                         );
            $twoYearStats = true;
        }
        
        $trendThisYear = Affiliate_Scripts_Bl_TrendStatistics::getTrendStats(
                                                     $_REQUEST['rt_affiliate'],
													 '',
                                                     $_REQUEST['rt_campaign'],
													 '',
                                                     $_REQUEST['rt_trackerId'],
                                                     $_REQUEST['rt_keywordId'],
                                                     $_REQUEST['rt_timeslotId'],
                                                     $_REQUEST['rt_pageId'],
                                                     'monthly',
                                                     1, 1, date('Y'),
                                                     31, 12, date('Y')
                                                     );
        $labels = '';
        $valuesImps = '';
        $valuesCpm = '';
        $valuesClicks = '';
        $valuesSales = '';
        $valuesLeads = '';
        $valuesRevenue = '';

        for($i=1; $i<=12; $i++)
        {
            $labels .= ($labels != '' ? ',' : '').constant($GLOBALS['wd_monthname'][$i]);
            
            $valuesImps .= ($valuesImps != '' ? ',' : '').($twoYearStats ? $trendLastYear['imps'][$i]['unique'].';' : '').$trendThisYear['imps'][$i]['unique'];
            $valuesCpm .= ($valuesCpm != '' ? ',' : '').($twoYearStats ? $trendLastYear['cpm'][$i].';' : '').$trendThisYear['cpm'][$i];
            $valuesClicks .= ($valuesClicks != '' ? ',' : '').($twoYearStats ? $trendLastYear['clicks'][$i].';' : '').$trendThisYear['clicks'][$i];
            $valuesSales .= ($valuesSales != '' ? ',' : '').($twoYearStats ? $trendLastYear['sales'][$i].';' : '').$trendThisYear['sales'][$i];
            $valuesLeads .= ($valuesLeads != '' ? ',' : '').($twoYearStats ? $trendLastYear['leads'][$i].';' : '').$trendThisYear['leads'][$i];
            $valuesRevenue .= ($valuesRevenue != '' ? ',' : '').($twoYearStats ? $trendLastYear['revenue'][$i].';' : '').$trendThisYear['revenue'][$i];
        }

        // create graph
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $graph->type = 'vBar';
        
        $graph->labels = $labels;
        $graph->values = $valuesImps;
        $graph->legend = ($twoYearStats ? (date('Y')-1).','.date('Y') : '');
        $graph->barColor = ($twoYearStats ? '#AEC4D2,#486B8F' : '#486B8F') ;
        $graph->barBGColor = '';
        $graph->labelBGColor = '#E0E0E0';
        $graph->barLength = 0.7;
        $graph->barWidth = ($twoYearStats ? 25 : 45);
        $graph->percValuesSize = 10;
        $graph->absValuesSize = 10;
        $graph->showValues = 1;
        $gdata = $graph->create();
        $this->assign('a_impstrend_graph', $gdata);

        // cpm
        $graph->values = $valuesCpm;
        $gdata = $graph->create();
        $this->assign('a_cpmtrend_graph', $gdata);

        // clicks
        $graph->values = $valuesClicks;
        $gdata = $graph->create();
        $this->assign('a_clickstrend_graph', $gdata);
                                                    
        // sales
        $graph->values = $valuesSales;
        $gdata = $graph->create();
        $this->assign('a_salestrend_graph', $gdata);

        // leads
        $graph->values = $valuesLeads;
        $gdata = $graph->create();
        $this->assign('a_leadstrend_graph', $gdata);

        // revenue
        $graph->values = $valuesRevenue;
        $gdata = $graph->create();
        $this->assign('a_revenuetrend_graph', $gdata);
        
        $graph = QUnit_Global::newobj('QUnit_Graphics_HtmlGraph');
        $graph->type = 'vBar';
        
        if($GLOBALS['Auth']->getSetting('Aff_support_click_commissions') == 1)
        {
            $clickSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_cpm_commissions') == 1)
        {
            $cpmSupported = true;
        }
        
        if($GLOBALS['Auth']->getSetting('Aff_support_sale_commissions') == 1)
        {
            $saleSupported = true;
        }

        if($GLOBALS['Auth']->getSetting('Aff_support_lead_commissions') == 1)
        {
            $leadSupported = true;
        }

        $this->assign('a_clickSupported', $clickSupported);
        $this->assign('a_cpmSupported', $cpmSupported);
        $this->assign('a_saleSupported', $saleSupported);
        $this->assign('a_leadSupported', $leadSupported);        
    }
    
    //--------------------------------------------------------------------------

    function checkMerchantExists($username, $aid = '')
    {
        $sql = 'select * from wd_g_users '.
               'where username='._q($username).
               '  and rtype='._q(USERTYPE_ADMIN);
        if($aid != '')
            $sql .= ' and userid<>'._q($aid);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        if($rs->EOF)
            return false;

        return true;
    }

    //--------------------------------------------------------------------------

    function getAccountAdminsAsArray($accountid)
    {
        if($accountid == '') return array();
    
        $sql = 'select userid, name, surname from wd_g_users '.
               'where accountid='._q($accountid).
               '  and rstatus='._q(STATUS_ENABLE).
               '  and rtype='._q(USERTYPE_ADMIN).
               ' order by name, surname';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $account_admins = array();

        while(!$rs->EOF)
        {
            $temp = array();
            $temp['name'] = $rs->fields['name'];
            $temp['surname'] = $rs->fields['surname'];
            $temp['userid'] = $rs->fields['userid'];
        
            $account_admins[$rs->fields['userid']] = $temp;

            $rs->moveNext();
        }

        return $account_admins;
    }
}
?>
