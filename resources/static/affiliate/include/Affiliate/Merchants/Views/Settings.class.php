<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Affiliate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PayoutOptions');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Settings');

class Affiliate_Merchants_Views_Settings extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['insert_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['update_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['insert_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['update_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['add_new_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['edit_payout_method'] = 'aff_tool_settings_modify';
        $this->modulePermissions['delete_payout_methods'] = 'aff_tool_settings_modify';
        $this->modulePermissions['add_new_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['edit_payout_field'] = 'aff_tool_settings_modify';
        $this->modulePermissions['delete_payout_fields'] = 'aff_tool_settings_modify';
        $this->modulePermissions['view'] = 'aff_tool_settings_view';
    }
    
    //--------------------------------------------------------------------------

    function process()
    {
        if(!empty($_POST['postaction']))
        {
            switch($_POST['postaction'])
            {              
                case 'insert_payout_method':
                    if($this->processInsertPayoutMethod())
                        return;
                    break;
    
                case 'update_payout_method':
                    if($this->processUpdatePayoutMethod())
                        return;
                    break;

                case 'insert_payout_field':
                    if($this->processInsertPayoutField())
                        return;
                    break;
    
                case 'update_payout_field':
                    if($this->processUpdatePayoutField())
                        return;
                    break;
            }
        }

        if(!empty($_REQUEST['action'])) //!empty($_POST['commited'])
        {
            switch($_REQUEST['action'])
            {
                case 'edit':
                    if($this->saveSettings())
                        return;
                    break;

                case 'add_new_payout_method':
                    if($this->drawFormAddPayoutMethod())
                        return;
                    break;

                case 'edit_payout_method':
                    if($this->drawFormEditPayoutMethod())
                        return;
                    break;

                case 'delete_payout_methods':
                    if($this->processDeletePayoutMethods())
                        return;
                    break;

                case 'add_new_payout_field':
                    if($this->drawFormAddPayoutField())
                        return;
                    break;

                case 'edit_payout_field':
                    if($this->drawFormEditPayoutField())
                        return;
                    break;

                case 'delete_payout_fields':
                    if($this->processDeletePayoutFields())
                        return;
                    break;
            }
        }
        
        $this->showSettings();    
    }

    //--------------------------------------------------------------------------

    function drawFormEditPayoutMethod()
    {
        if($_POST['commited'] != 'yes')
        {
            Affiliate_Merchants_Bl_PayoutOptions::loadPayoutOptionsInfo($_REQUEST['pid'], $GLOBALS['Auth']->getAccountID());
        }
        else
        {
            if(get_magic_quotes_gpc())
            {
                $_POST['exportformat'] = stripslashes($_POST['exportformat']);
                $_POST['buttonformat'] = stripslashes($_POST['buttonformat']);
            }
        }

        $_POST['header'] = L_G_EDIT_PAYOUT_METHOD;
        $_POST['action'] = 'edit_payout_method';
        $_POST['postaction'] = 'update_payout_method';
    
        $this->drawFormAddPayoutMethod();
    
        return true;
    }
  
    //------------------------------------------------------------------------
  
    function drawFormAddPayoutMethod()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new_payout_method';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert_payout_method';
    
        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_PAYOUT_METHOD;
    
        $this->addContent('payoutmethods_edit');

        return true;
    }

    //------------------------------------------------------------------------

    function drawFormEditPayoutField()
    {
        if($_POST['commited'] != 'yes')
        {
            Affiliate_Merchants_Bl_PayoutOptions::loadPayoutFieldsInfo($_REQUEST['fid'], $GLOBALS['Auth']->getAccountID());
        }

        $_POST['header'] = L_G_EDIT_PAYOUT_FIELD;
        $_POST['action'] = 'edit_payout_field';
        $_POST['postaction'] = 'update_payout_field';
    
        $this->drawFormAddPayoutField();
    
        return true;
    }
  
    //------------------------------------------------------------------------
  
    function drawFormAddPayoutField()
    {
        if(!isset($_POST['action']))
            $_POST['action'] = 'add_new_payout_field';
        if(!isset($_POST['postaction']))
            $_POST['postaction'] = 'insert_payout_field';

        if($_POST['pid'] == '') $_POST['pid'] = $_REQUEST['pid'];
    
        if(!isset($_POST['header']))
            $_POST['header'] = L_G_ADD_PAYOUT_FIELD;

        $this->addContent('payoutfields_edit');

        return true;
    }
    
    //------------------------------------------------------------------------

    function saveSettings()
    {
        if(is_array($GLOBALS['Auth']->permissions) && count($GLOBALS['Auth']->permissions) > 0)
        {
            if(!in_array('aff_tool_settings_modify', $GLOBALS['Auth']->permissions))
            {
                Affiliate_Merchants_Views_Settings::showSettings(true); 
                return true;
            }
        }

        $data = $this->protectData();
        
        switch($_POST['subact'])
        {
            case 'payoutmethods': $processedData = $this->processEditPayoutMethods($data); break;
            case 'commissions': $processedData = $this->processEditCommissions($data); break;
            case 'systemsettings': $processedData = $this->processEditSystemSettings($data); break;
            case 'troubleshooting': $processedData = $this->processEditTroubleshooting($data); break;
            case 'communications': $processedData = $this->processEditCommunications($data); break;
            case 'fraudprotection': $processedData = $this->processEditFraudProtection($data); break;
            case 'emailnotifications': $processedData = $this->processEditEmailNotifications($data); break;
            case 'affsettings': $processedData = $this->processEditAffSettings($data); break;
            case 'cookiestracking': $processedData = $this->processEditCookiesTracking($data); break;
            case 'affsignup': $processedData = $this->processEditAffSignup($data); break;
            case 'bannerformat': $processedData = $this->processEditBannerFormat($data); break;
        }

        if($processedData === false || QUnit_Messager::getErrorMessage() != '')
        {
            if(QUnit_Messager::getErrorMessage() == '')
                QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
                
            // stay in the same page
            $_REQUEST['sheet'] = $_POST['subact'];
            Affiliate_Merchants_Views_Settings::showSettings(); 
        }
        else
        {
            if(AFF_DEMO == 1) {
                switch($_POST['subact'])
                {
                    case 'payoutmethods': $processedData = array(); break;
                    case 'commissions': $processedData = array(); break;
                    case 'systemsettings': $processedData = array(); break;
                    case 'troubleshooting': $processedData = $this->processEditTroubleshooting($data); break;
                    case 'communications': $processedData = array(); break;
                    case 'fraudprotection': $processedData = $this->processEditFraudProtection($data); break;
                    case 'emailnotifications': $processedData = $this->processEditEmailNotifications($data); break;
                    case 'affsettings': $processedData = $this->processEditAffSettings($data); break;
                    case 'cookiestracking': $processedData = $this->processEditCookiesTracking($data); break;
                    case 'affsignup': $processedData = $this->processEditAffSignup($data); break;
                    case 'bannerformat': $processedData = $this->processEditBannerFormat($data); break;
                }
            }
            
            if(is_array($processedData) && count($processedData)>0)
            {
                // save change
                $error = false;
                foreach($processedData as $code => $value)
                {
                    if(!QCore_Settings::_update($code, $value, SETTINGTYPE_ACCOUNT, $GLOBALS['Auth']->getAccountID()))
                    {
                        $error = true;
                        return false;
                    }
                }
                
                if($error) {
                    QUnit_Messager::setErrorMessage(L_G_ERRORSAVESETTINGS);
                } else {
                    QUnit_Messager::setOkMessage(L_G_SETTINGSSAVED);
                }

                $GLOBALS['Auth']->loadSettings();
            }

            if($data['psheet'] != '') {
                $_REQUEST['sheet'] = $data['psheet'];
            }
            
            Affiliate_Merchants_Views_Settings::showSettings(true); 
        }
        
        return true;
    }
    
    //------------------------------------------------------------------------

    function processEditPayoutMethods($data)
    {
        $parts = explode(';', $data['min_payout_options']);
        $count = 0;
        $isOneOf = false;
        foreach($parts as $part)
        {
            $part = trim($part);
            if(is_numeric($part) && $part>0)
                $count++;
            
            if($data['initial_min_payout'] != '')
                if($data['initial_min_payout'] == $part)
                    $isOneOf = true;
        }
        
        checkCorrectness($_POST['min_payout_options'], $data['min_payout_options'], L_G_MINPAYOUTOPTIONS, CHECK_ALLOWED);
        checkCorrectness($_POST['initial_min_payout'], $data['initial_min_payout'], L_G_INITIALMINPAYOUT, CHECK_ALLOWED);

        if($data['initial_min_payout'] != '' && !$isOneOf)
            QUnit_Messager::setErrorMessage(L_G_INITIALPAYOUTMUSTBEFROMTHELIST);
            
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_apply_from_banner' => $data['apply_from_banner'],
                            'Aff_min_payout_options' => $data['min_payout_options'],
                            'Aff_initial_min_payout' => $data['initial_min_payout'],
                            );
        }

        return false;
    }

    //------------------------------------------------------------------------

    function processEditCommissions($data)
    {
        checkCorrectness($_POST['fixed_cost'], $data['fixed_cost'], L_G_FIXED_COST, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['program_signup_bonus'], $data['program_signup_bonus'], L_G_PROGRAM_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['program_referral_commission'], $data['program_referral_commission'], L_G_REFERRAL_COMMISSION, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['program_referral_commission'], $data['program_referral_commission'], L_G_REFERRAL_COMMISSION, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        if(!empty($data['program_signup_bonus']))
            checkCorrectness($_POST['program_signup_bonus'], $data['program_signup_bonus'], L_G_PROGRAM_SIGNUP_BONUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);

        $temp_array = array();
        for($i=2; $i<=$GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels'); $i++) 
        {
            if(!empty($data['st'.$i.'userbonuscommission']))
            {
                checkCorrectness($_POST['st'.$i.'userbonuscommission'], $data['st'.$i.'userbonuscommission'], $i.' - '.L_G_TIER, CHECK_EMPTYALLOWED | CHECK_NUMBER);
            }
            $temp_array['Aff_program_signup_bonus_'.$i.'tr'] = $data['st'.$i.'userbonuscommission'];
        }

        if($data['dont_save_click_transaction'] != '1')
            $data['dont_display_click_transaction'] = '1';
        else
            $data['dont_display_click_transaction'] = '0';

        $comm_type_count = 0;
//        if($data['support_signup_commissions'] == '1') $comm_type_count++;
//        if($data['support_referral_commissions'] == '1') $comm_type_count++;
        if($data['support_cpm_commissions'] == '1') $comm_type_count++;
        if($data['support_click_commissions'] == '1') $comm_type_count++;
        if($data['support_sale_commissions'] == '1') $comm_type_count++;
        if($data['support_lead_commissions'] == '1') $comm_type_count++;
//        if($data['support_recurring_commissions'] == '1') $comm_type_count++;

        if($comm_type_count < 1) QUnit_Messager::setErrorMessage(L_G_ATLEASTONECOMMISSIONTYPEMUSTBECHOOSEN);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array_merge($temp_array, 
                       array(
                            'Aff_support_signup_commissions' => $data['support_signup_commissions'],
                            'Aff_support_referral_commissions' => $data['support_referral_commissions'],
                            'Aff_support_cpm_commissions' => $data['support_cpm_commissions'],
                            'Aff_support_click_commissions' => $data['support_click_commissions'],
                            'Aff_support_sale_commissions' => $data['support_sale_commissions'],
                            'Aff_support_lead_commissions' => $data['support_lead_commissions'],
                            'Aff_support_recurring_commissions' => $data['support_recurring_commissions'],
                            'Aff_forcecommfromproductid' => $data['forcecommfromproductid'],
                            'Aff_maxcommissionlevels' => $data['maxcommissionlevels'],
                            'Aff_apply_from_banner' => $data['apply_from_banner'],
                            'Aff_fixed_cost' => $data['fixed_cost'],
                            'Aff_recurringrealcommissions' => $data['recurringrealcommissions'],
                            'Aff_program_signup_bonus' => $data['program_signup_bonus'],
                            'Aff_program_referral_commission' => $data['program_referral_commission'],
                            'Aff_dont_display_click_transaction' => $data['dont_display_click_transaction'],
                            'Aff_dont_save_click_transaction' => $data['dont_save_click_transaction']
                            ));
        }
        
        return false;            
    }
    
    //------------------------------------------------------------------------

    function processEditSystemSettings($data)
    {
        checkCorrectness($_POST['main_site_url'], $data['main_site_url'], L_G_URL_TO_MAIN_SITE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['export_dir'], $data['export_dir'], L_G_EXPORTDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_dir'], $data['banners_dir'], L_G_BANNERSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['banners_url'], $data['banners_url'], L_G_BANNERSURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['scripts_url'], $data['scripts_url'], L_G_URLTOSCRIPTSDIR, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['signup_url'], $data['signup_url'], L_G_SIGNUPURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['default_lang'], $data['default_lang'], L_G_SYSTEMLANGUAGE, CHECK_EMPTYALLOWED);

		$data['login_logging'] = $_POST['login_logging'];

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_scripts_url' => $data['scripts_url'], 
                            'Aff_signup_url' => $data['signup_url'],
                            'Aff_system_currency' => $data['system_currency'],
                            'Aff_main_site_url' => $data['main_site_url'],
                            'Aff_export_dir' => $data['export_dir'],
                            'Aff_export_url' => $data['export_url'],
                            'Aff_show_minihelp' => $data['show_minihelp'], 
                            'Aff_banners_dir' => $data['banners_dir'],
                            'Aff_banners_url' => $data['banners_url'],
                            'Aff_default_lang' => $data['default_lang'],
                            'Aff_allow_choose_lang' => $data['allow_choose_lang'],
                            'Aff_round_numbers' => $data['round_numbers'],
                            'Aff_currency_left_position' => $data['currency_left_position'],
                            'login_logging' => $data['login_logging'],
                            'reporting_url' => $data['reporting_url'],
                            );
        }
        
        return false;
    }
    
    //------------------------------------------------------------------------

    function processEditTroubleshooting($data)
    {
        checkCorrectness($_POST['log_level_element'], $data['log_level_element'], L_G_LOG_LEVEL, CHECK_ALLOWED);
        

        $log_level = 0;
        if(is_array($data['log_level_element']) && count($data['log_level_element']) > 0)
        {
            foreach($data['log_level_element'] as $value)
            {
                $log_level += $value;
            }
        }

        $_POST['log_level'] = $log_level;

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_debug_trans' => $data['debug_trans'],
                            'Aff_log_level' => $log_level,
                            );
        }

        return false;
    }

    //------------------------------------------------------------------------

    function processEditCommunications($data)
    {
        checkCorrectness($_POST['system_email'], $data['system_email'], L_G_SYSTEMEMAIL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['mail_send_type'], $data['mail_send_type'], L_G_MAIL_SEND_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMERIC);
        
        if($data['mail_send_type'] == EMAILBY_SMTP)
        {
            checkCorrectness($_POST['smtp_server'], $data['smtp_server'], L_G_SERVER, CHECK_EMPTY);
        }
        
        checkCorrectness($_POST['smtp_server'], $data['smtp_server'], L_G_SERVER, CHECK_ALLOWED);
        checkCorrectness($_POST['smtp_username'], $data['smtp_username'], L_G_USER_NAME, CHECK_ALLOWED);
        checkCorrectness($_POST['smtp_password'], $data['smtp_password'], L_G_PASSWORD, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                         'Aff_system_email' => $data['system_email'],
                         'Aff_mail_send_type' => $data['mail_send_type'],
                         'Aff_smtp_server' => $data['smtp_server'],
                         'Aff_smtp_username' => $data['smtp_username'],
                         'Aff_smtp_password' => $data['smtp_password']
                        );
        }
        
        return false;
    }

    //------------------------------------------------------------------------

    function processEditFraudProtection($data)
    {
        if($_POST['declinefrequentclicks'] == '')
            $_POST['declinefrequentclicks'] = '0';
        if($_POST['declinefrequentsales'] == '')
            $_POST['declinefrequentsales'] = '0';
        if($_POST['declinesameorderid'] == '')
            $_POST['declinesameorderid'] = '0';

        if($data['declinefrequentclicks'] == '')
            $data['declinefrequentclicks'] = '0';
        if($data['declinefrequentsales'] == '')
            $data['declinefrequentsales'] = '0';
        if($data['declinesameorderid'] == '')
            $data['declinesameorderid'] = '0';
            
        // check correctness of the fields
        checkCorrectness($_POST['frequentclicks'], $data['frequentclicks'], L_G_WHATTODO_REPEATING_CLICKS, CHECK_ALLOWED);
        checkCorrectness($_POST['declinefrequentclicks'], $data['declinefrequentclicks'], L_G_DECLINEFREQUENTCLICKS, CHECK_ALLOWED);
        if($data['declinefrequentclicks'] == 1)
            checkCorrectness($_POST['clickfrequency'], $data['clickfrequency'], L_G_SECONDSFIELD, CHECK_EMPTYALLOWED);
        else
        {
            $_POST['clickfrequency'] = 0;
            $data['clickfrequency'] = 0;
        }
        
        checkCorrectness($_POST['frequentsales'], $data['frequentsales'], L_G_WHATTODO_REPEATING_SALES, CHECK_ALLOWED);
        checkCorrectness($_POST['declinefrequentsales'], $data['declinefrequentsales'], L_G_DECLINEFREQUENTSALES, CHECK_ALLOWED);
        if($data['declinefrequentsales'] == 1)
            checkCorrectness($_POST['salefrequency'], $data['salefrequency'], L_G_SECONDSFIELD, CHECK_EMPTYALLOWED);
        else
        {
            $_POST['salefrequency'] = 0;
            $data['salefrequency'] = 0;
        }
            
        checkCorrectness($_POST['declinesameorderid'], $data['declinesameorderid'], L_G_DECLINESALESSAMEORDERID, CHECK_ALLOWED);
        
        checkCorrectness($_POST['login_protection_retries'], $data['login_protection_retries'], L_G_LOGINPROTECTIONRETRIES, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['login_protection_delay'], $data['login_protection_delay'], L_G_LOGINPROTECTIONDELAY, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_login_protection_retries' => $data['login_protection_retries'],
                            'Aff_login_protection_delay' => $data['login_protection_delay'],
                            'Aff_declinefrequentclicks' => $data['declinefrequentclicks'],
                            'Aff_frequentclicks' => $data['frequentclicks'],
                            'Aff_declinefrequentsales' => $data['declinefrequentsales'],
                            'Aff_frequentsales' => $data['frequentsales'],
                            'Aff_declinesameorderid' => $data['declinesameorderid'],
                            'Aff_clickfrequency' => $data['clickfrequency'],
                            'Aff_salefrequency' => $data['salefrequency'],
                        );
        }

        return false;
    }

    //------------------------------------------------------------------------

    function processEditEmailNotifications($data)
    {
        checkCorrectness($_POST['notifications_email'], $data['notifications_email'], L_G_EMAILFORSENDINGNOTIFICATIONS, CHECK_EMPTYALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_email_onaffsignup' => $data['email_onaffsignup'],
                            'Aff_email_onsale' => $data['email_onsale'],
                            'Aff_email_dailyreport' => $data['email_dailyreport'],
                            'Aff_email_recurringtrangenerated' => $data['email_recurringtrangenerated'],
                            'Aff_notifications_email' => $data['notifications_email'],
                            );
        }

        return false;
    }
    
    //------------------------------------------------------------------------

    function processEditAffSettings($data)
    {
        checkCorrectness($_POST['affpostsignupurl'], $data['affpostsignupurl'], L_G_POSTSIGNUPURL, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['join_campaign'], $data['join_campaign'], L_G_JOIN_CAMPAIGN, CHECK_ALLOWED);
        checkCorrectness($_POST['display_news'], $data['display_news'], L_G_DISPLAY_NEWS, CHECK_ALLOWED);
        checkCorrectness($_POST['display_resources'], $data['display_resources'], L_G_DISPLAY_RESOURCES, CHECK_ALLOWED);
        checkCorrectness($_POST['display_banner_stats_all'], $data['display_banner_stats_all'], L_G_DISPLAY_BANNER_STATISTICS_ALL, CHECK_ALLOWED);
        checkCorrectness($_POST['matrix_height'], $data['matrix_height'], L_G_MATRIX_HEIGHT, CHECK_ALLOWED);
        checkCorrectness($_POST['matrix_width'], $data['matrix_width'], L_G_MATRIX_WIDTH, CHECK_ALLOWED);
        checkCorrectness($_POST['use_forced_matrix'], $data['use_forced_matrix'], L_G_USE_FORCED_MATRIX, CHECK_ALLOWED);
        checkCorrectness($_POST['matrix_forced_user'], $data['matrix_forced_user'], L_G_CHOOSE_FORCED_AFFILIATE, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_affiliateapproval' => $data['affiliateapproval'],
                            'Aff_afflogouturl' => $data['afflogouturl'],
                            'Aff_affpostsignupurl' => $data['affpostsignupurl'],
                            'Aff_join_campaign' => $data['join_campaign'],
                            'Aff_display_news' => $data['display_news'],
                            'Aff_display_resources' => $data['display_resources'],
                            'Aff_display_banner_stats_all' => $data['display_banner_stats_all'],
                            'Aff_matrix_height' => $data['matrix_height'],
                            'Aff_matrix_width' => $data['matrix_width'],
                            'Aff_use_forced_matrix' => $data['use_forced_matrix'],
                            'Aff_matrix_forced_user' => $data['matrix_forced_user']
                            );
        }

        return false;
    }
    
    //------------------------------------------------------------------------
    
    function processEditCookiesTracking($data)
    {
        if($data['track_by_ip'] == 1)
            checkCorrectness($_POST['ip_validity'], $data['ip_validity'], L_G_IPADDRESSVALIDITY, CHECK_EMPTYALLOWED);
        
        if(QUnit_Messager::getErrorMessage() == '')
        {
            return array(
                            'Aff_link_style' => $data['link_style'],
                            'Aff_p3p_xml' => $data['p3p_xml'],
                            'Aff_p3p_compact' => $data['p3p_compact'],
                            'Aff_track_by_ip' => $data['track_by_ip'],
                            'Aff_ip_validity' => $data['ip_validity'],
                            'Aff_ip_validity_type' => $data['ip_validity_type'],
                            'Aff_track_by_session' => $data['track_by_session'],
                            'Aff_overwrite_cookie' => $data['overwrite_cookie'],
                            'Aff_delete_cookie' => $data['delete_cookie'],
                            'Aff_permanent_redirect' => $data['permanent_redirect'],
                            'Aff_referred_affiliate_allow' => $data['referred_affiliate_allow'],
                            'Aff_referred_affiliate' => $data['referred_affiliate'],
                            'Aff_csCookie' => $data['csCookie'],
                        );
        }
        
        return false;
    }

    //------------------------------------------------------------------------
    
    function processEditAffSignup($data) {
        if(QUnit_Messager::getErrorMessage() == '')
        {        
            return array(
                'Aff_signup_terms_conditions' => $data['signup_terms_conditions'],
                'Aff_signup_display_terms' => $data['signup_display_terms'],
                'Aff_signup_force_acceptance' => $data['signup_force_acceptance'],
                'Aff_signup_affect_editing' => $data['signup_affect_editing'],
                'Aff_signup_username' => "1",
                'Aff_signup_username_mandatory' => 'true',
                'Aff_signup_name' => "1",
                'Aff_signup_name_mandatory' => 'true',
                'Aff_signup_surname' => "1",
                'Aff_signup_surname_mandatory' => 'true',
                'Aff_signup_street' => $data['signup_street'],
                'Aff_signup_street_mandatory' => $data['signup_street_mandatory'],
                'Aff_signup_city' => $data['signup_city'],
                'Aff_signup_city_mandatory' => $data['signup_city_mandatory'],
                'Aff_signup_country' => "1",
                'Aff_signup_country_mandatory' => 'true',
                'Aff_signup_company_name' => $data['signup_company_name'],
                'Aff_signup_company_name_mandatory' => $data['signup_company_name_mandatory'],
                'Aff_signup_state' => $data['signup_state'],
                'Aff_signup_state_mandatory' => $data['signup_state_mandatory'],
                'Aff_signup_state' => $data['signup_state'],
                'Aff_signup_state_mandatory' => $data['signup_state_mandatory'],
                'Aff_signup_zipcode' => $data['signup_zipcode'],
                'Aff_signup_zipcode_mandatory' => $data['signup_zipcode_mandatory'],
                'Aff_signup_weburl' => $data['signup_weburl'],
                'Aff_signup_weburl_mandatory' => $data['signup_weburl_mandatory'],
                'Aff_signup_phone' => $data['signup_phone'],
                'Aff_signup_phone_mandatory' => $data['signup_phone_mandatory'],
                'Aff_signup_fax' => $data['signup_fax'],
                'Aff_signup_fax_mandatory' => $data['signup_fax_mandatory'],
                'Aff_signup_tax_ssn' => $data['signup_tax_ssn'],
                'Aff_signup_tax_ssn_mandatory' => $data['signup_tax_ssn_mandatory'],
                'Aff_signup_data1' => $data['signup_data1'],
                'Aff_signup_data1_mandatory' => $data['signup_data1_mandatory'],
                'Aff_signup_data1_name' => $data['signup_data1_name'],
                'Aff_signup_data2' => $data['signup_data2'],
                'Aff_signup_data2_mandatory' => $data['signup_data2_mandatory'],
                'Aff_signup_data2_name' => $data['signup_data2_name'],
                'Aff_signup_data3' => $data['signup_data3'],
                'Aff_signup_data3_mandatory' => $data['signup_data3_mandatory'],
                'Aff_signup_data3_name' => $data['signup_data3_name'],
                'Aff_signup_data4' => $data['signup_data4'],
                'Aff_signup_data4_mandatory' => $data['signup_data4_mandatory'],
                'Aff_signup_data4_name' => $data['signup_data4_name'],
                'Aff_signup_data5' => $data['signup_data5'],
                'Aff_signup_data5_mandatory' => $data['signup_data5_mandatory'],
                'Aff_signup_data5_name' => $data['signup_data5_name'],
            );
        }
        return false;
    }
    
    //------------------------------------------------------------------------
    
    function processEditBannerFormat($data) {
        if($data['bannerformat_textformat'] != '') 
        {
            $textFormat = $data['bannerformat_textformat'];
            if(!strstr($textFormat, '$TITLE')) {
                QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_TITLEEXISTS);
            }
            if(!strstr($textFormat, '$DESCRIPTION')) {
                QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_DESCEXISTS);
            }
            if(!strstr($textFormat, '$DESTINATION')) {
                QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_DESTEXISTS);
            }
            if(!strstr($textFormat, '$IMPRESSION_TRACK')) {
                QUnit_Messager::setErrorMessage(L_G_BANNERFORMAT_TRACKEXISTS);
            }
            
            if(QUnit_Messager::getErrorMessage() == '')
            {        
                return array(
                    'Aff_bannerformat_textformat' => $data['bannerformat_textformat'],
                );
            }
        } else {
            return array();
        }
        return false;
    }

    //------------------------------------------------------------------------
    
    function processDeletePayoutMethods()
    {
        $pid = preg_replace('/[\'\"]/', '', $_REQUEST['pid']);
        
        if(AFF_DEMO == 1 && in_array($pid, array('paypal01', 'moneyboo', 'check001', 'wiretran'))) {
            
        } else {
            Affiliate_Merchants_Bl_PayoutOptions::deletePayoutMethod($pid, $GLOBALS['Auth']->getAccountID());
        }
        
        $this->redirect('Affiliate_Merchants_Views_Settings&sheet=payoutmethods');
    }

    //------------------------------------------------------------------------
    
    function processDeletePayoutFields()
    {
        $fid = preg_replace('/[\'\"]/', '', $_REQUEST['fid']);

        if(AFF_DEMO == 1 && in_array($fid, array('paypal01', 'moneybo1', 'check001', 'wiretra1', 'wiretra2', 'wiretra3', 'wiretra4', 'wiretra5', 'wiretra6'))) {
            
        } else {
            Affiliate_Merchants_Bl_PayoutOptions::deletePayoutFields($fid);
        }
        
        $this->redirect('Affiliate_Merchants_Views_Settings&sheet=payoutmethods');
    }

    //------------------------------------------------------------------------

    function processInsertPayoutMethod()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $pexporttype = preg_replace('/[\'\"]/', '', $_POST['exporttype']);
        $pexportformat = $_POST['exportformat'];
        $pbuttonformat = $_POST['buttonformat'];
        $pdisabled = preg_replace('/[^0-9]/', '', $_POST['disabled']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $PayoptID = QCore_Sql_DBUnit::createUniqueID('wd_pa_payoutoptions', 'payoptid');

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
    
        if($_POST['name'] != '' && !Affiliate_Merchants_Bl_PayoutOptions::checkPayoutMethodExists($GLOBALS['Auth']->getAccountID(),$_POST['name']))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTS);
    
        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['exporttype'], $pexporttype, L_G_EXPORTTYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['exportformat'], $pexportformat, L_G_EXPORTFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['buttonformat'], $pbuttonformat, L_G_BUTTONFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['disabled'], $pdisabled, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'exporttype' => $pexporttype,
                            'exportformat' => $pexportformat,
                            'paybuttonformat' => $pbuttonformat,
                            'status' => $pdisabled,
                            'rorder' => $prorder,
                            'accountid' => $GLOBALS['Auth']->getAccountID(),
                            'payoptid' => $PayoptID);
        
            if(Affiliate_Merchants_Bl_PayoutOptions::insertPayoutMethod($params) == false) return false;
            
            QUnit_Messager::setOkMessage(L_G_PAYOUT_METHOD_ADDED);

            $this->closeWindow('Affiliate_Merchants_Views_Settings&sheet=payoutmethods');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function processInsertPayoutField()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $prtype = preg_replace('/[^0-9]/', '', $_POST['rtype']);
        $pmandatory = preg_replace('/[^0-9]/', '', $_POST['mandatory']);
        $pavailablevalues = preg_replace('/[\'\"]/', '', $_POST['availablevalues']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $pcode = preg_replace('/[^A-Za-z0-9_]/', '', $_POST['code']);
        $pvisible = preg_replace('/[^0-9]/', '', $_POST['visible']);
        $pvalue = preg_replace('/[\'\"]/', '', $_POST['value']);
        $PayoptID = preg_replace('/[\'\"]/', '', $_POST['pid']);
        $PayfieldID = QCore_Sql_DBUnit::createUniqueID('wd_pa_payoutfields', 'payfieldid');

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['name'] != '' && !Affiliate_Merchants_Bl_PayoutOptions::checkPayoutFieldExistsInPayoutMethod($_POST['name'],$PayoptID))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTSINTHISPAYOUTMETHOD);

        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['rtype'], $prtype, L_G_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['mandatory'], $pmandatory, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['availablevalues'], $pavailablevalues, L_G_AVAILABLE_VALUES, CHECK_ALLOWED);
        checkCorrectness($_POST['code'], $pcode, L_G_CODE_FOR_EXPORTFORMAT, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['visible'], $pvisible, L_G_VISIBILITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['value'], $pvalue, L_G_VALUE_FOR_EXPORTFORMAT, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'rtype' => $prtype,
                            'mandatory' => $pmandatory,
                            'rorder' => $prorder,
                            'availablevalues' => $pavailablevalues,
                            'code' => $pcode,
                            'visible' => $pvisible,
                            'value' => $pvalue,
                            'payoptid' => $PayoptID,
                            'payfieldid' => $PayfieldID);
        
            if(Affiliate_Merchants_Bl_PayoutOptions::insertPayoutField($params) == false) return false;
            
            QUnit_Messager::setOkMessage(L_G_PAYOUT_FIELD_ADDED);

            $this->closeWindow('Affiliate_Merchants_Views_Settings&sheet=payoutmethods');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function processUpdatePayoutMethod()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $pexporttype = preg_replace('/[\'\"]/', '', $_POST['exporttype']);
        $pexportformat = $_POST['exportformat'];
        $pbuttonformat = $_POST['buttonformat'];
        $pdisabled = preg_replace('/[^0-9]/', '', $_POST['disabled']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $PayoptID = preg_replace('/[\'\"]/', '', $_POST['pid']);

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
    
        if($_POST['name'] != '' && !Affiliate_Merchants_Bl_PayoutOptions::checkPayoutMethodExists($GLOBALS['Auth']->getAccountID(),$_POST['name'],$PayoptID,false))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTS);
    
        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['exporttype'], $pexporttype, L_G_EXPORTTYPE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['exportformat'], $pexportformat, L_G_EXPORTFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['buttonformat'], $pbuttonformat, L_G_BUTTONFORMAT, CHECK_ALLOWED);
        checkCorrectness($_POST['disabled'], $pdisabled, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'exporttype' => $pexporttype,
                            'exportformat' => $pexportformat,
                            'paybuttonformat' => $pbuttonformat,
                            'status' => $pdisabled,
                            'rorder' => $prorder,
                            'accountid' => $GLOBALS['Auth']->getAccountID(),
                            'payoptid' => $PayoptID);

            if(Affiliate_Merchants_Bl_PayoutOptions::updatePayoutMethod($params) == false) return false;
            
            QUnit_Messager::setOkMessage(L_G_PAYOUT_METHOD_EDITED);

            $this->closeWindow('Affiliate_Merchants_Views_Settings&sheet=payoutmethods');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function processUpdatePayoutField()
    {
        // protect against script injection
        $pname = preg_replace('/[\'\"]/', '', $_POST['name']);
        $plangid = preg_replace('/[\'\"]/', '', $_POST['langid']);
        $prtype = preg_replace('/[^0-9]/', '', $_POST['rtype']);
        $pmandatory = preg_replace('/[^0-9]/', '', $_POST['mandatory']);
        $pavailablevalues = preg_replace('/[\'\"]/', '', $_POST['availablevalues']);
        $prorder = preg_replace('/[^0-9]/', '', $_POST['rorder']);
        $pcode = preg_replace('/[^A-Za-z0-9_]/', '', $_POST['code']);
        $pvisible = preg_replace('/[^0-9]/', '', $_POST['visible']);
        $pvalue = preg_replace('/[\'\"]/', '', $_POST['value']);
        $PayoptID = preg_replace('/[\'\"]/', '', $_POST['pid']);
        $PayfieldID = preg_replace('/[\'\"]/', '', $_POST['fid']);

        // check correctness of the fields
        checkCorrectness($_POST['name'], $pname, L_G_NAME, CHECK_EMPTYALLOWED);
        if($_POST['name'] != '' && !Affiliate_Merchants_Bl_PayoutOptions::checkPayoutFieldExistsInPayoutMethod($_POST['name'],$PayoptID,$PayfieldID))
            QUnit_Messager::setErrorMessage(L_G_NAMEEXISTSINTHISPAYOUTMETHOD);

        checkCorrectness($_POST['langid'], $plangid, L_G_LANGUAGE_CODE, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['rtype'], $prtype, L_G_TYPE, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['mandatory'], $pmandatory, L_G_STATUS, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['rorder'], $prorder, L_G_ORDERID, CHECK_EMPTYALLOWED | CHECK_NUMBER);
        checkCorrectness($_POST['availablevalues'], $pavailablevalues, L_G_AVAILABLE_VALUES, CHECK_ALLOWED);
        checkCorrectness($_POST['code'], $pcode, L_G_CODE_FOR_EXPORTFORMAT, CHECK_EMPTYALLOWED);
        //checkCorrectness($_POST['visible'], $pvisible, L_G_VISIBILITY, CHECK_EMPTYALLOWED);
        checkCorrectness($_POST['value'], $pvalue, L_G_VALUE_FOR_EXPORTFORMAT, CHECK_ALLOWED);

        if(QUnit_Messager::getErrorMessage() != '') {
            return false;
        }
        else
        {
            $params = array('name' => $pname,
                            'langid' => $plangid,
                            'rtype' => $prtype,
                            'mandatory' => $pmandatory,
                            'rorder' => $prorder,
                            'availablevalues' => $pavailablevalues,
                            'code' => $pcode,
                            'visible' => $pvisible,
                            'value' => $pvalue,
                            'payoptid' => $PayoptID,
                            'payfieldid' => $PayfieldID);

            if(AFF_DEMO == 1 && in_array($PayfieldID, array('paypal01', 'moneybo1', 'check001', 'wiretra1', 'wiretra2', 'wiretra3', 'wiretra4', 'wiretra5', 'wiretra6'))) {
            
            } else {
                if(Affiliate_Merchants_Bl_PayoutOptions::updatePayoutField($params) == false) return false;
            }
            
            QUnit_Messager::setOkMessage(L_G_PAYOUT_FIELD_EDITED);

            $this->closeWindow('Affiliate_Merchants_Views_Settings&sheet=payoutmethods');
            $this->addContent('closewindow');

            return true;
        }
    }

    //------------------------------------------------------------------------

    function loadPayoutMethods()
    {
        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID());
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($payout_methods);
        $this->temporaryAssign('a_list_data1', $list_data1);
        
        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID());
        $this->temporaryAssign('a_list_data2', $payout_fields);
    }
    
    //------------------------------------------------------------------------

    function showSettings($reload = false)
    {
        if($reload == true || $_POST['commited'] != 'yes')
        {
            // get settings from Auth
            $this->loadSettings();
        }

        if($_REQUEST['sheet'] == '')
            $_REQUEST['sheet'] = 'systemsettings';
        
        $tabs = array(
            array('systemsettings' , "<a href=\"javascript:changeSheet('edit', 'systemsettings');\">".L_G_SYSTEMSETTINGS."</a>"),
            array('commissions' , "<a href=\"javascript:changeSheet('edit', 'commissions');\">".L_G_COMMISSIONS."</a>"),
            array('communications' , "<a href=\"javascript:changeSheet('edit', 'communications');\">".L_G_COMMUNICATION."</a>"),
            array('payoutmethods' , "<a href=\"javascript:changeSheet('edit', 'payoutmethods');\">".L_G_PAYOUTMETHODS."</a>"),
            array('troubleshooting' , "<a href=\"javascript:changeSheet('edit', 'troubleshooting');\">".L_G_TROUBLESHOOTING."</a>"),
            array('fraudprotection' , "<a href=\"javascript:changeSheet('edit', 'fraudprotection');\">".L_G_FRAUDPROTECTION."</a>"),
            array('emailnotifications' , "<a href=\"javascript:changeSheet('edit', 'emailnotifications');\">".L_G_EMAILNOTIFICATIONS."</a>"),
            array('affsettings' , "<a href=\"javascript:changeSheet('edit', 'affsettings');\">".L_G_EDITCUSTOMIZATION."</a>"),
            array('cookiestracking' , "<a href=\"javascript:changeSheet('edit', 'cookiestracking');\">".L_G_COOKIESANDTRACKING."</a>"),
            //array('affsignup' , "<a href=\"javascript:changeSheet('edit', 'affsignup');\">".L_G_AFFSIGNUPFORMAT."</a>"),
            array('bannerformat' , "<a href=\"javascript:changeSheet('edit', 'bannerformat');\">".L_G_BANNERFORMAT."</a>"),
        );
        
        $selectedTab = $_REQUEST['sheet'];
        
        $this->assign('a_tabs', $tabs);
        $this->assign('a_selectedTab', $selectedTab);
        
        $this->initTemporaryTE();
        
        switch($_REQUEST['sheet'])
        {
            case 'payoutmethods': 
                $this->loadPayoutMethods();
                $tabContent = $this->temporaryFetch('settings_payoutmethods');
                break;
            case 'commissions': $tabContent = $this->temporaryFetch('settings_commissions'); break;
            case 'systemsettings': 
                $list_data = QUnit_Global::newobj('QCore_RecordSet');
                $list_data->setTemplateRS(QCore_Settings::getAvailableLangs());
                $this->temporaryAssign('a_list_data', $list_data);
                $tabContent = $this->temporaryFetch('settings_systemsettings'); 
                break;
            case 'troubleshooting': $tabContent = $this->temporaryFetch('settings_troubleshooting'); break;
            case 'communications': $tabContent = $this->temporaryFetch('settings_communications'); break;
            case 'fraudprotection': $tabContent = $this->temporaryFetch('settings_fraudprotection'); break;
            case 'emailnotifications': $tabContent = $this->temporaryFetch('settings_emailnotifications'); break;
            case 'affsettings': 
                $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
                $list_data = QUnit_Global::newobj('QCore_RecordSet');
                $list_data->setTemplateRS($users);
                $this->temporaryAssign('a_list_data', $list_data);
            
                $tabContent = $this->temporaryFetch('settings_affsettings'); 
                break;
            case 'cookiestracking':
                $users = Affiliate_Merchants_Bl_Affiliate::getUsersAsArray();
                $list_data = QUnit_Global::newobj('QCore_RecordSet');
                $list_data->setTemplateRS($users);
                $this->temporaryAssign('a_list_data', $list_data);

                $tabContent = $this->temporaryFetch('settings_cookiestracking'); 
                break;
            case 'affsignup':
                $tabContent = $this->temporaryFetch('settings_affsignup');
                break;
            case 'bannerformat':
                $tabContent = $this->temporaryFetch('settings_bannerformat');
                break;
        }
      
        $this->assign('a_tabcontent', $tabContent);
        $this->addContent('settings_main');

        return true;
    }

    //------------------------------------------------------------------------

    function loadSettings()
    {
        $settings = $GLOBALS['Auth']->getSettings();
        
        $_POST['login_logging'] = $settings['login_logging'];
        $_POST['show_minihelp'] = $settings['Aff_show_minihelp'];
        $_POST['support_signup_commissions'] = $settings['Aff_support_signup_commissions'];
        $_POST['support_referral_commissions'] = $settings['Aff_support_referral_commissions'];
        $_POST['support_cpm_commissions'] = $settings['Aff_support_cpm_commissions'];
        $_POST['support_click_commissions'] = $settings['Aff_support_click_commissions'];
        $_POST['support_sale_commissions'] = $settings['Aff_support_sale_commissions'];
        $_POST['support_lead_commissions'] = $settings['Aff_support_lead_commissions'];
        $_POST['support_recurring_commissions'] = $settings['Aff_support_recurring_commissions'];
        $_POST['main_site_url'] = $settings['Aff_main_site_url'];
        $_POST['export_dir'] = myslashes($settings['Aff_export_dir']);
        $_POST['export_url'] = $settings['Aff_export_url'];
        $_POST['banners_dir'] = myslashes($settings['Aff_banners_dir']);
        $_POST['banners_url'] = $settings['Aff_banners_url'];
        $_POST['scripts_url'] = $settings['Aff_scripts_url'];
        $_POST['signup_url'] = $settings['Aff_signup_url'];
        $_POST['system_email'] = $settings['Aff_system_email'];
        $_POST['system_currency'] = $settings['Aff_system_currency'];
        $_POST['default_lang'] = $settings['Aff_default_lang'];
        $_POST['allow_choose_lang'] = $settings['Aff_allow_choose_lang'];
        $_POST['login_protection_retries'] = $settings['Aff_login_protection_retries'];
        $_POST['login_protection_delay'] = $settings['Aff_login_protection_delay'];
        $_POST['min_payout_options'] = $settings['Aff_min_payout_options'];
        $_POST['initial_min_payout'] = $settings['Aff_initial_min_payout'];
        $_POST['declinefrequentclicks'] = $settings['Aff_declinefrequentclicks'];
        $_POST['frequentclicks'] = $settings['Aff_frequentclicks'];
        $_POST['declinefrequentsales'] = $settings['Aff_declinefrequentsales'];
        $_POST['frequentsales'] = $settings['Aff_frequentsales'];
        $_POST['declinesameorderid'] = $settings['Aff_declinesameorderid'];
        $_POST['clickfrequency'] = $settings['Aff_clickfrequency'];
        $_POST['salefrequency'] = $settings['Aff_salefrequency'];
        $_POST['link_style'] = $settings['Aff_link_style'];
        $_POST['email_onaffsignup'] = $settings['Aff_email_onaffsignup'];
        $_POST['email_onsale'] = $settings['Aff_email_onsale'];
        $_POST['email_dailyreport'] = $settings['Aff_email_dailyreport'];
        $_POST['email_recurringtrangenerated'] = $settings['Aff_email_recurringtrangenerated'];
        $_POST['notifications_email'] = $settings['Aff_notifications_email'];
        $_POST['forcecommfromproductid'] = $settings['Aff_forcecommfromproductid'];
        $_POST['maxcommissionlevels'] = $settings['Aff_maxcommissionlevels'];
        $_POST['affiliateapproval'] = $settings['Aff_affiliateapproval'];
        $_POST['afflogouturl'] = $settings['Aff_afflogouturl'];
        $_POST['affpostsignupurl'] = $settings['Aff_affpostsignupurl'];
        $_POST['debug_trans'] = $settings['Aff_debug_trans'];
        $_POST['p3p_xml'] = $settings['Aff_p3p_xml'];
        $_POST['p3p_compact'] = $settings['Aff_p3p_compact'];
        $_POST['track_by_ip'] = $settings['Aff_track_by_ip'];
        $_POST['ip_validity'] = $settings['Aff_ip_validity'];
        $_POST['ip_validity_type'] = $settings['Aff_ip_validity_type'];
        $_POST['track_by_session'] = $settings['Aff_track_by_session'];
        $_POST['apply_from_banner'] = $settings['Aff_apply_from_banner'];
        $_POST['fixed_cost'] = $settings['Aff_fixed_cost'];
        $_POST['join_campaign'] = $settings['Aff_join_campaign'];
        $_POST['display_news'] = $settings['Aff_display_news'];
        $_POST['display_resources'] = $settings['Aff_display_resources'];
        $_POST['display_banner_stats_all'] = $settings['Aff_display_banner_stats_all'];
        $_POST['matrix_height'] = $settings['Aff_matrix_height'];
        $_POST['matrix_width'] = $settings['Aff_matrix_width'];
        $_POST['use_forced_matrix'] = $settings['Aff_use_forced_matrix'];
        $_POST['matrix_forced_user'] = $settings['Aff_matrix_forced_user'];
        $_POST['round_numbers'] = $settings['Aff_round_numbers'];
        $_POST['currency_left_position'] = $settings['Aff_currency_left_position'];
        $_POST['program_signup_bonus'] = $settings['Aff_program_signup_bonus'];
        $_POST['program_referral_commission'] = $settings['Aff_program_referral_commission'];
        $_POST['log_level'] = $settings['Aff_log_level'];
        $_POST['overwrite_cookie'] = $settings['Aff_overwrite_cookie'];
        $_POST['delete_cookie'] = $settings['Aff_delete_cookie'];
        $_POST['referred_affiliate_allow'] = $settings['Aff_referred_affiliate_allow'];
        $_POST['referred_affiliate'] = $settings['Aff_referred_affiliate'];
        $_POST['dont_display_click_transaction'] = $settings['Aff_dont_display_click_transaction'];
        $_POST['dont_save_click_transaction'] = $settings['Aff_dont_save_click_transaction'];
        $_POST['permanent_redirect'] = $settings['Aff_permanent_redirect'];
        $_POST['st2userbonuscommission'] = $settings['Aff_program_signup_bonus_2tr'];
        $_POST['st3userbonuscommission'] = $settings['Aff_program_signup_bonus_3tr'];
        $_POST['st4userbonuscommission'] = $settings['Aff_program_signup_bonus_4tr'];
        $_POST['st5userbonuscommission'] = $settings['Aff_program_signup_bonus_5tr'];
        $_POST['st6userbonuscommission'] = $settings['Aff_program_signup_bonus_6tr'];
        $_POST['st7userbonuscommission'] = $settings['Aff_program_signup_bonus_7tr'];
        $_POST['st8userbonuscommission'] = $settings['Aff_program_signup_bonus_8tr'];
        $_POST['st9userbonuscommission'] = $settings['Aff_program_signup_bonus_9tr'];
        $_POST['st10userbonuscommission'] = $settings['Aff_program_signup_bonus_10tr'];
        $_POST['mail_send_type'] = $settings['Aff_mail_send_type'];
        if($_POST['mail_send_type'] == '') $_POST['mail_send_type'] = EMAILBY_MAIL;
        $_POST['smtp_server'] = $settings['Aff_smtp_server'];
        $_POST['smtp_username'] = $settings['Aff_smtp_username'];
        $_POST['smtp_password'] = $settings['Aff_smtp_password'];
        $_POST['signup_terms_conditions'] = $settings['Aff_signup_terms_conditions'];
        $_POST['signup_force_acceptance'] = $settings['Aff_signup_force_acceptance'];
        $_POST['signup_affect_editing'] = $settings['Aff_signup_affect_editing'];
        $_POST['signup_display_terms'] = $settings['Aff_signup_display_terms'];
        $_POST['signup_username'] = $settings['Aff_signup_username'];
        $_POST['signup_name'] = $settings['Aff_signup_name'];
        $_POST['signup_surname'] = $settings['Aff_signup_surname'];
        $_POST['signup_street'] = $settings['Aff_signup_street'];
        $_POST['signup_street_mandatory'] = $settings['Aff_signup_street_mandatory'];
        $_POST['signup_city'] = $settings['Aff_signup_city'];
        $_POST['signup_city_mandatory'] = $settings['Aff_signup_city_mandatory'];
        $_POST['signup_country'] = $settings['Aff_signup_country'];
        $_POST['signup_company_name'] = $settings['Aff_signup_company_name'];
        $_POST['signup_company_name_mandatory'] = $settings['Aff_signup_company_name_mandatory'];
        $_POST['signup_state'] = $settings['Aff_signup_state'];
        $_POST['signup_state_mandatory'] = $settings['Aff_signup_state_mandatory'];
        $_POST['signup_zipcode'] = $settings['Aff_signup_zipcode'];
        $_POST['signup_zipcode_mandatory'] = $settings['Aff_signup_zipcode_mandatory'];
        $_POST['signup_weburl'] = $settings['Aff_signup_weburl'];
        $_POST['signup_weburl_mandatory'] = $settings['Aff_signup_weburl_mandatory'];
        $_POST['signup_phone'] = $settings['Aff_signup_phone'];
        $_POST['signup_phone_mandatory'] = $settings['Aff_signup_phone_mandatory'];
        $_POST['signup_fax'] = $settings['Aff_signup_fax'];
        $_POST['signup_fax_mandatory'] = $settings['Aff_signup_fax_mandatory'];
        $_POST['signup_tax_ssn'] = $settings['Aff_signup_tax_ssn'];
        $_POST['signup_tax_ssn_mandatory'] = $settings['Aff_signup_tax_ssn_mandatory'];
        $_POST['signup_data1'] = $settings['Aff_signup_data1'];
        $_POST['signup_data1_mandatory'] = $settings['Aff_signup_data1_mandatory'];
        $_POST['signup_data1_name'] = $settings['Aff_signup_data1_name'];
        $_POST['signup_data2'] = $settings['Aff_signup_data2'];
        $_POST['signup_data2_mandatory'] = $settings['Aff_signup_data2_mandatory'];
        $_POST['signup_data2_name'] = $settings['Aff_signup_data2_name'];
        $_POST['signup_data3'] = $settings['Aff_signup_data3'];
        $_POST['signup_data3_mandatory'] = $settings['Aff_signup_data3_mandatory'];
        $_POST['signup_data3_name'] = $settings['Aff_signup_data3_name'];
        $_POST['signup_data4'] = $settings['Aff_signup_data4'];
        $_POST['signup_data4_mandatory'] = $settings['Aff_signup_data4_mandatory'];
        $_POST['signup_data4_name'] = $settings['Aff_signup_data4_name'];
        $_POST['signup_data5'] = $settings['Aff_signup_data5'];
        $_POST['signup_data5_mandatory'] = $settings['Aff_signup_data5_mandatory'];
        $_POST['signup_data5_name'] = $settings['Aff_signup_data5_name'];
        $_POST['bannerformat_textformat'] = $settings['Aff_bannerformat_textformat'];
        $_POST['csCookie'] = $settings['Aff_csCookie'];
        $_POST['reporting_url'] = $settings['reporting_url'];
                
    }
    //------------------------------------------------------------------------

    function protectData()
    {
        // protect against script injection

        $data = array();
        
        $data['show_minihelp'] = preg_replace('/[^0-1]/', '', $_POST['show_minihelp']);
        $data['support_signup_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_signup_commissions']);
        $data['support_referral_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_referral_commissions']);
        $data['support_cpm_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_cpm_commissions']);
        $data['support_click_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_click_commissions']);
        $data['support_sale_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_sale_commissions']);
        $data['support_lead_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_lead_commissions']);
        $data['support_recurring_commissions'] = preg_replace('/[^0-1]/', '', $_POST['support_recurring_commissions']);
        $data['main_site_url'] = preg_replace('/[\"\']/', '', $_POST['main_site_url']);
        $data['export_dir'] = preg_replace('/[\"\']/', '', $_POST['export_dir']);
        $data['export_url'] = preg_replace('/[\"\']/', '', $_POST['export_url']);
        $data['banners_dir'] = preg_replace('/[\"\']/', '', $_POST['banners_dir']);
        $data['banners_url'] = preg_replace('/[\"\']/', '', $_POST['banners_url']);
        $data['scripts_url'] = preg_replace('/[\"\']/', '', $_POST['scripts_url']);
        $data['signup_url'] = preg_replace('/[\"\']/', '', $_POST['signup_url']);
        $data['system_email'] = preg_replace('/[\"\']/', '', $_POST['system_email']);
        $data['system_currency'] = preg_replace('/[\"\']/', '', $_POST['system_currency']);
        $data['default_lang'] = preg_replace('/[\"\']/', '', $_POST['default_lang']);
        $data['allow_choose_lang'] = preg_replace('/[\"\']/', '', $_POST['allow_choose_lang']);
        $data['login_protection_retries'] = preg_replace('/[^0-9]/', '', $_POST['login_protection_retries']);
        $data['login_protection_delay'] = preg_replace('/[^0-9]/', '', $_POST['login_protection_delay']);
        $data['min_payout_options'] = preg_replace('/[^0-9\; ]/', '', $_POST['min_payout_options']);
        $data['initial_min_payout'] = preg_replace('/[^0-9]/', '', $_POST['initial_min_payout']);
        $data['declinefrequentclicks'] = preg_replace('/[^0-1]/', '', $_POST['declinefrequentclicks']);
        $data['frequentclicks'] = preg_replace('/[^0-2]/', '', $_POST['frequentclicks']);
        $data['declinefrequentsales'] = preg_replace('/[^0-1]/', '', $_POST['declinefrequentsales']);
        $data['frequentsales'] = preg_replace('/[^0-2]/', '', $_POST['frequentsales']);
        $data['declinesameorderid'] = preg_replace('/[^0-1]/', '', $_POST['declinesameorderid']);
        $data['clickfrequency'] = preg_replace('/[^0-9]/', '', $_POST['clickfrequency']);
        $data['salefrequency'] = preg_replace('/[^0-9]/', '', $_POST['salefrequency']);
        $data['link_style'] = preg_replace('/[^0-9]/', '', $_POST['link_style']);
        $data['email_onaffsignup'] = preg_replace('/[^0-9]/', '', $_POST['email_onaffsignup']);
        $data['email_onsale'] = preg_replace('/[^0-9]/', '', $_POST['email_onsale']);
        $data['email_dailyreport'] = preg_replace('/[^0-9]/', '', $_POST['email_dailyreport']);
        $data['email_recurringtrangenerated'] = preg_replace('/[^0-9]/', '', $_POST['email_recurringtrangenerated']);
        $data['notifications_email'] = preg_replace('/[\"\']/', '', $_POST['notifications_email']);
        $data['forcecommfromproductid'] = preg_replace('/[\"\']/', '', $_POST['forcecommfromproductid']);
        $data['maxcommissionlevels'] = preg_replace('/[^0-9]/', '', $_POST['maxcommissionlevels']);
        $data['affiliateapproval'] = preg_replace('/[^0-9]/', '', $_POST['affiliateapproval']);
        $data['afflogouturl'] = preg_replace('/[\"\']/', '', $_POST['afflogouturl']);
        $data['affpostsignupurl'] = preg_replace('/[\"\']/', '', $_POST['affpostsignupurl']);
        $data['debug_trans'] = preg_replace('/[\"\']/', '', $_POST['debug_trans']);
        $data['p3p_xml'] = preg_replace('/[\"\']/', '', $_POST['p3p_xml']);
        $data['p3p_compact'] = preg_replace('/[\"\']/', '', $_POST['p3p_compact']);
        $data['track_by_ip'] = preg_replace('/[^0-1]/', '', $_POST['track_by_ip']);
        $data['ip_validity'] = preg_replace('/[^0-9]/', '', $_POST['ip_validity']);
        $data['ip_validity_type'] = preg_replace('/[\"\']/', '', $_POST['ip_validity_type']);
        $data['track_by_session'] = preg_replace('/[^0-1]/', '', $_POST['track_by_session']);
        $data['apply_from_banner'] = preg_replace('/[^0-1]/', '', $_POST['apply_from_banner']);
        $data['fixed_cost'] = preg_replace('/[\'\"]/', '', $_POST['fixed_cost']);
        $data['log_level_element'] = preg_replace('/[\'\"]/', '', $_POST['log_level_element']);
        $data['join_campaign'] = preg_replace('/[^0-1]/', '', $_POST['join_campaign']);
        $data['display_news'] = preg_replace('/[^0-1]/', '', $_POST['display_news']);
        $data['display_resources'] = preg_replace('/[^0-1]/', '', $_POST['display_resources']);
        $data['display_banner_stats_all'] = preg_replace('/[^0-1]/', '', $_POST['display_banner_stats_all']);
        $data['matrix_height'] = preg_replace('/[^0-9]/', '', $_POST['matrix_height']);
        $data['matrix_width'] = preg_replace('/[^0-9]/', '', $_POST['matrix_width']);
        $data['matrix_width'] = preg_replace('/[^0-9]/', '', $_POST['matrix_width']);
        $data['use_forced_matrix'] = preg_replace('/[^0-1]/', '', $_POST['use_forced_matrix']);
        $data['matrix_forced_user'] = preg_replace('/[\'\"]/', '', $_POST['matrix_forced_user']);
        $data['round_numbers'] = preg_replace('/[^0-9]/', '', $_POST['round_numbers']);
        $data['currency_left_position'] = preg_replace('/[^0-9]/', '', $_POST['currency_left_position']);
        $data['program_signup_bonus'] = preg_replace('/[\'\"]/', '', $_POST['program_signup_bonus']);
        $data['program_referral_commission'] = preg_replace('/[\'\"]/', '', $_POST['program_referral_commission']);
        $data['recurringrealcommissions'] = preg_replace('/[\'\"]/', '', $_POST['recurringrealcommissions']);
        $data['psheet'] = preg_replace('/[\'\"]/', '', $_POST['sheet']);
        $data['overwrite_cookie'] = preg_replace('/[^0-1]/', '', $_POST['overwrite_cookie']);
        $data['delete_cookie'] = preg_replace('/[^0-1]/', '', $_POST['delete_cookie']);
        $data['referred_affiliate_allow'] = preg_replace('/[^0-1]/', '', $_POST['referred_affiliate_allow']);
        $data['referred_affiliate'] = preg_replace('/[\'\"]/', '', $_POST['referred_affiliate']);
        $data['dont_display_click_transaction'] = preg_replace('/[^0-9]/', '', $_POST['dont_display_click_transaction']);
        $data['dont_save_click_transaction'] = preg_replace('/[^0-9]/', '', $_POST['dont_save_click_transaction']);
        $data['permanent_redirect'] = preg_replace('/[\'\"]/', '', $_POST['permanent_redirect']);
        $data['st2userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st2userbonuscommission']);
        $data['st3userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st3userbonuscommission']);
        $data['st4userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st4userbonuscommission']);
        $data['st5userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st5userbonuscommission']);
        $data['st6userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st6userbonuscommission']);
        $data['st7userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st7userbonuscommission']);
        $data['st8userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st8userbonuscommission']);
        $data['st9userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st9userbonuscommission']);
        $data['st10userbonuscommission'] = preg_replace('/[\'\"]/', '', $_POST['st10userbonuscommission']);
        $data['mail_send_type'] = preg_replace('/[^0-9]/', '', $_POST['mail_send_type']);
        $data['smtp_server'] = preg_replace('/[\'\"]/', '', $_POST['smtp_server']);
        $data['smtp_username'] = preg_replace('/[\'\"]/', '', $_POST['smtp_username']);
        $data['smtp_password'] = preg_replace('/[\'\"]/', '', $_POST['smtp_password']);
        $data['signup_terms_conditions'] = preg_replace('/[\'\"]/', '', $_POST['signup_terms_conditions']);
        $data['signup_display_terms'] = preg_replace('/[^0-1]/', '', $_POST['signup_display_terms']);
        $data['signup_force_acceptance'] = preg_replace('/[^0-1]/', '', $_POST['signup_force_acceptance']);
        $data['signup_affect_editing'] = preg_replace('/[^0-1]/', '', $_POST['signup_affect_editing']);
        $data['signup_username'] = preg_replace('/[^0-1]/', '', $_POST['signup_username']);
        $data['signup_name'] = preg_replace('/[^0-1]/', '', $_POST['signup_name']);
        $data['signup_surname'] = preg_replace('/[^0-1]/', '', $_POST['signup_surname']);
        $data['signup_street'] = preg_replace('/[^0-1]/', '', $_POST['signup_street']);
        $data['signup_street_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_street_mandatory']);
        $data['signup_city'] = preg_replace('/[^0-1]/', '', $_POST['signup_city']);
        $data['signup_city_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_city_mandatory']);
        $data['signup_country'] = preg_replace('/[^0-1]/', '', $_POST['signup_country']);
        $data['signup_company_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_company_name']);
        $data['signup_company_name_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_company_name_mandatory']);
        $data['signup_state'] = preg_replace('/[^0-1]/', '', $_POST['signup_state']);
        $data['signup_state_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_state_mandatory']);
        $data['signup_zipcode'] = preg_replace('/[^0-1]/', '', $_POST['signup_zipcode']);
        $data['signup_zipcode_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_zipcode_mandatory']);
        $data['signup_weburl'] = preg_replace('/[^0-1]/', '', $_POST['signup_weburl']);
        $data['signup_weburl_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_weburl_mandatory']);
        $data['signup_phone'] = preg_replace('/[^0-1]/', '', $_POST['signup_phone']);
        $data['signup_phone_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_phone_mandatory']);
        $data['signup_fax'] = preg_replace('/[^0-1]/', '', $_POST['signup_fax']);
        $data['signup_fax_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_fax_mandatory']);
        $data['signup_tax_ssn'] = preg_replace('/[^0-1]/', '', $_POST['signup_tax_ssn']);
        $data['signup_tax_ssn_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_tax_ssn_mandatory']);
        $data['signup_data1'] = preg_replace('/[^0-1]/', '', $_POST['signup_data1']);
        $data['signup_data1_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data1_mandatory']);
        $data['signup_data1_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data1_name']);
        $data['signup_data2'] = preg_replace('/[^0-1]/', '', $_POST['signup_data2']);
        $data['signup_data2_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data2_mandatory']);
        $data['signup_data2_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data2_name']);
        $data['signup_data3'] = preg_replace('/[^0-1]/', '', $_POST['signup_data3']);
        $data['signup_data3_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data3_mandatory']);
        $data['signup_data3_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data3_name']);
        $data['signup_data4'] = preg_replace('/[^0-1]/', '', $_POST['signup_data4']);
        $data['signup_data4_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data4_mandatory']);
        $data['signup_data4_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data4_name']);
        $data['signup_data5'] = preg_replace('/[^0-1]/', '', $_POST['signup_data5']);
        $data['signup_data5_mandatory'] = preg_replace('/[\'\"]/', '', $_POST['signup_data5_mandatory']);
        $data['signup_data5_name'] = preg_replace('/[\'\"]/', '', $_POST['signup_data5_name']);
        $data['bannerformat_textformat'] = preg_replace('/[\'\"]/', '', $_POST['bannerformat_textformat']);
        $data['csCookie'] = preg_replace('/[\'\"]/', '', $_POST['csCookie']);
        $data['reporting_url'] = preg_replace('/[\'\"]/', '', $_POST['reporting_url']);
        return $data;
    }
    
    //------------------------------------------------------------------------
}
?>
