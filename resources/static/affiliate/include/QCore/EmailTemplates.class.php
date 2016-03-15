<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class QCore_EmailTemplates
{
    function getFilledEmailMessage($id, $emailcategory, $lang, $params)
    {
        $templateLang = $lang;
        if($templateLang == '')
            $templateLang = $GLOBALS['Auth']->getSetting('Aff_default_lang');
            
        // check if template in this language exists in templates
        $sql = 'select * from wd_g_emailtemplates where deleted=0 and lang='.myquotes(substr($templateLang, 0, 10)).' and categorycode='.myquotes($emailcategory);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }
        
        if($rs->EOF)
        {
            if($lang != $templateLang)
                return false;
                
            $templateLang = $GLOBALS['Auth']->getSetting('Aff_default_lang');
            
            // check if template in default language exists in templates
            $sql = 'select * from wd_g_emailtemplates where deleted=0 and lang='.myquotes(substr($templateLang, 0, 10)).' and categorycode='.myquotes($emailcategory);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if($rs->EOF)
                return false;
        }
        
        $subject = $rs->fields['emailsubject'];
        $text = $rs->fields['emailtext'];
        
        //--------------------------------------
        // replace constants depending on type of email template
        if(in_array($emailcategory, array('AFF_EMAIL_SIGNUP', 'AFF_EMAIL_FORGOTPAS1', 'AFF_EMAIL_FORGOTPAS2', 'AFF_EMAIL_NTF_SIGNUP', 'AFF_EMAIL_AF_NTF_SGN')))
        {
            // get affiliate info
            $sql = 'select * from wd_g_users where deleted=0 and userid='._q($id);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if($rs->EOF)
                return false;
            
            $Affiliate_id = $rs->fields['userid'];
            $Affiliate_name = $rs->fields['name'].' '.$rs->fields['surname'];
            $Affiliate_username = $rs->fields['username'];
            $Affiliate_password = $params['pwd'];
            if($rs->fields['rstatus'] == AFFSTATUS_APPROVED) $Affiliate_status = L_G_APPROVED;
            else if($rs->fields['rstatus'] == AFFSTATUS_NOTAPPROVED) $Affiliate_status = L_G_WAITINGAPPROVAL;
            else if($rs->fields['rstatus'] == AFFSTATUS_SUPPRESSED) $Affiliate_status = L_G_SUPPRESSED;
            
            $Affiliate_website = $rs->fields['weburl'];
            $Affiliate_country = $rs->fields['country'];

            $subject = str_replace('$Date', date("Y-m-d"), $subject);
            $subject = str_replace('$Time', date("h:j:s"), $subject);
            $subject = str_replace('$Affiliate_id', $Affiliate_id, $subject);
            $subject = str_replace('$Affiliate_name', $Affiliate_name, $subject);
            $subject = str_replace('$Affiliate_username', $Affiliate_username, $subject);
            if($emailcategory == 'AFF_EMAIL_FORGOTPAS1') {
                $subject = str_replace('$Affiliate_verification_code', $Affiliate_password, $subject);
            } else {
                $subject = str_replace('$Affiliate_password', $Affiliate_password, $subject);
            }
            
            $text = str_replace('$Date', date("Y-m-d"), $text);
            $text = str_replace('$Time', date("h:j:s"), $text);
            $text = str_replace('$Affiliate_id', $Affiliate_id, $text);
            $text = str_replace('$Affiliate_name', $Affiliate_name, $text);
            $text = str_replace('$Affiliate_username', $Affiliate_username, $text);
            if($emailcategory == 'AFF_EMAIL_FORGOTPAS1') {
                $text = str_replace('$Affiliate_verification_code', $Affiliate_password, $text);
            } else {
                $text = str_replace('$Affiliate_password', $Affiliate_password, $text);
            }
        
            if(in_array($emailcategory, array('AFF_EMAIL_NTF_SIGNUP', 'AFF_EMAIL_AF_NTF_SGN')))
            {
                $subject = str_replace('$Affiliate_status', $Affiliate_status, $subject);
                $subject = str_replace('$Affiliate_website', $Affiliate_website, $subject);
                $subject = str_replace('$Affiliate_country', $Affiliate_country, $subject);
                $text = str_replace('$Affiliate_status', $Affiliate_status, $text);
                $text = str_replace('$Affiliate_website', $Affiliate_website, $text);
                $text = str_replace('$Affiliate_country', $Affiliate_country, $text);
            }
        }
        else if($emailcategory == AFF_EMAIL_NTF_SALE || $emailcategory == AFF_EMAIL_AF_NTF_SLE)
        {
            // SALE NOTIFICATION
            // get affiliate info
            $sql = 'select * from wd_g_users where deleted=0 and userid='._q($params['userid']);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if($rs->EOF)
                return false;
            
            $Affiliate_name = $rs->fields['name'].' '.$rs->fields['surname'];
            if($params['status'] == AFFSTATUS_APPROVED) $status = L_G_APPROVED;
            else if($params['status'] == AFFSTATUS_NOTAPPROVED) $status = L_G_WAITINGAPPROVAL;
            else if($params['status'] == AFFSTATUS_SUPPRESSED) $status = L_G_SUPPRESSED;
            
            $subject = str_replace('$Date', date("Y-m-d"), $subject);
            $subject = str_replace('$Time', date("h:j:s"), $subject);
            $subject = str_replace('$Sale_id', $params['id'], $subject);
            $subject = str_replace('$Sale_commission', _rnd($params['commission']), $subject);
            $subject = str_replace('$Sale_totalcost', _rnd($params['totalcost']), $subject);
            $subject = str_replace('$Sale_orderid', $params['orderid'], $subject);
            $subject = str_replace('$Sale_productid', $params['productid'], $subject);
            $subject = str_replace('$Sale_date', $params['date'], $subject);
            $subject = str_replace('$Sale_affiliate', $params['userid'].' - '.$Affiliate_name, $subject);
            $subject = str_replace('$Sale_status', $status, $subject);
            $subject = str_replace('$Sale_ip', $params['ip'], $subject);
            $subject = str_replace('$Sale_referrer', $params['referrer'], $subject);

            $text = str_replace('$Date', date("Y-m-d"), $text);
            $text = str_replace('$Time', date("h:j:s"), $text);
            $text = str_replace('$Sale_id', $params['id'], $text);
            $text = str_replace('$Sale_commission', _rnd($params['commission']), $text);
            $text = str_replace('$Sale_totalcost', _rnd($params['totalcost']), $text);
            $text = str_replace('$Sale_orderid', $params['orderid'], $text);
            $text = str_replace('$Sale_productid', $params['productid'], $text);
            $text = str_replace('$Sale_date', $params['date'], $text);
            $text = str_replace('$Sale_affiliate', $params['userid'].' - '.$Affiliate_name, $text);
            $text = str_replace('$Sale_status', $status, $text);
            $text = str_replace('$Sale_ip', $params['ip'], $text);
            $text = str_replace('$Sale_referrer', $params['referrer'], $text);
        }
        else if($emailcategory == AFF_EMAIL_DAILY_REP || $emailcategory == AFF_EMAIL_AF_DL_REP)
        {
            $subject = str_replace('$Date', date("Y-m-d"), $subject);
            $subject = str_replace('$Time', date("h:j:s"), $subject);
            $subject = str_replace('$Impressions', $params['impressions'], $subject);
            $subject = str_replace('$Clicks', $params['clicks'], $subject);
            $subject = str_replace('$Sales_approved_2ndtier', $params['st_sales_approved'], $subject);
            $subject = str_replace('$Sales_approved', $params['sales_approved'], $subject);
            $subject = str_replace('$Sales_waitingapproval_2ndtier', $params['st_sales_waitingapproval'], $subject);
            $subject = str_replace('$Sales_waitingapproval', $params['sales_waitingapproval'], $subject);
            $subject = str_replace('$Sales_declined_2ndtier', $params['st_sales_declined'], $subject);
            $subject = str_replace('$Sales_declined', $params['sales_declined'], $subject);
            $subject = str_replace('$Commissions_approved_2ndtier', $params['st_revenue_approved'], $subject);
            $subject = str_replace('$Commissions_approved', $params['revenue_approved'], $subject);
            $subject = str_replace('$Commissions_waitingapproval_2ndtier', $params['st_revenue_waitingapproval'], $subject);
            $subject = str_replace('$Commissions_waitingapproval', $params['revenue_waitingapproval'], $subject);
            $subject = str_replace('$Commissions_declined_2ndtier', $params['st_revenue_declined'], $subject);
            $subject = str_replace('$Commissions_declined', $params['revenue_declined'], $subject);

            $text = str_replace('$Date', date("Y-m-d"), $text);
            $text = str_replace('$Time', date("h:j:s"), $text);
            $text = str_replace('$Impressions', $params['impressions'], $text);
            $text = str_replace('$Clicks', $params['clicks'], $text);
            $text = str_replace('$Sales_approved_2ndtier', $params['st_sales_approved'], $text);
            $text = str_replace('$Sales_approved', $params['sales_approved'], $text);
            $text = str_replace('$Sales_waitingapproval_2ndtier', $params['st_sales_waitingapproval'], $text);
            $text = str_replace('$Sales_waitingapproval', $params['sales_waitingapproval'], $text);
            $text = str_replace('$Sales_declined_2ndtier', $params['st_sales_declined'], $text);
            $text = str_replace('$Sales_declined', $params['sales_declined'], $text);
            $text = str_replace('$Commissions_approved_2ndtier', $params['st_revenue_approved'], $text);
            $text = str_replace('$Commissions_approved', $params['revenue_approved'], $text);
            $text = str_replace('$Commissions_waitingapproval_2ndtier', $params['st_revenue_waitingapproval'], $text);
            $text = str_replace('$Commissions_waitingapproval', $params['revenue_waitingapproval'], $text);
            $text = str_replace('$Commissions_declined_2ndtier', $params['st_revenue_declined'], $text);
            $text = str_replace('$Commissions_declined', $params['revenue_declined'], $text);
        }
        else if($emailcategory == AFF_EMAIL_NOTIFY_RC)
        {
            // get affiliate info
            $sql = 'select * from wd_g_users where deleted=0 and userid='._q($params['userid']);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if($rs->EOF)
                return false;
            
            $Affiliate_name = $rs->fields['name'].' '.$rs->fields['surname'];
            if($params['status'] == AFFSTATUS_APPROVED) $status = L_G_APPROVED;
            else if($params['status'] == AFFSTATUS_NOTAPPROVED) $status = L_G_WAITINGAPPROVAL;
            else if($params['status'] == AFFSTATUS_SUPPRESSED) $status = L_G_SUPPRESSED;
            
            $subject = str_replace('$Date', date("Y-m-d"), $subject);
            $subject = str_replace('$Time', date("h:j:s"), $subject);
            $subject = str_replace('$Rc_id', $params['id'], $subject);
            $subject = str_replace('$Rc_commission', $params['commission'], $subject);
            $subject = str_replace('$Rc_orderid', $params['orderid'], $subject);
            $subject = str_replace('$Rc_affiliate', $Affiliate_name, $subject);
            $subject = str_replace('$Rc_status', $status, $subject);
            $subject = str_replace('$Rc_recurringcommissionid', $params['recurringcommid'], $subject);

            $text = str_replace('$Date', date("Y-m-d"), $text);
            $text = str_replace('$Time', date("h:j:s"), $text);
            $text = str_replace('$Rc_id', $params['id'], $text);
            $text = str_replace('$Rc_commission', $params['commission'], $text);
            $text = str_replace('$Rc_orderid', $params['orderid'], $text);
            $text = str_replace('$Rc_affiliate', $Affiliate_name, $text);
            $text = str_replace('$Rc_status', $status, $text);
            $text = str_replace('$Rc_recurringcommissionid', $params['recurringcommid'], $text);
        }
        else if($emailcategory == AFF_EMAIL_AFF_CAMP_A)
        {
            // get affiliate info
            $sql = 'select * from wd_g_users where deleted=0 and userid='._q($id);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if (!$rs)
            {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if($rs->EOF)
                return false;
            
            $Affiliate_name = $rs->fields['name'].' '.$rs->fields['surname'];
            
            $subject = str_replace('$Date', date("Y-m-d"), $subject);
            $subject = str_replace('$Time', date("h:j:s"), $subject);
            $subject = str_replace('$camp_name', $params['camp_name'], $subject);
            $subject = str_replace('$Affiliate_name', $Affiliate_name, $subject);

            $text = str_replace('$Date', date("Y-m-d"), $text);
            $text = str_replace('$Time', date("h:j:s"), $text);
            $text = str_replace('$camp_name', $params['camp_name'], $text);
            $text = str_replace('$Affiliate_name', $Affiliate_name, $text);
        }
        else if($emailcategory == AFF_EMAIL_CONTACT_US)
        {
            // get affiliate info
            $sql = 'select * from wd_g_users where deleted=0 and userid='._q($params['UserID']);
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return;
            }
            
            if($rs->EOF)
                return false;
            
            $Affiliate_name = $rs->fields['name'].' '.$rs->fields['surname'];
            
            $subject = str_replace('$Date', date("Y-m-d"), $subject);
            $subject = str_replace('$Time', date("h:j:s"), $subject);
            $subject = str_replace('$Affiliate_name', $Affiliate_name, $subject);
            $subject = str_replace('$Affiliate_emailsubject', $params['title'], $subject);
            $subject = str_replace('$Affiliate_emailtext', $params['body'], $subject);

            $text = str_replace('$Date', date("Y-m-d"), $text);
            $text = str_replace('$Time', date("h:j:s"), $text);
            $text = str_replace('$Affiliate_name', $Affiliate_name, $text);
            $text = str_replace('$Affiliate_emailsubject', $params['title'], $text);
            $text = str_replace('$Affiliate_emailtext', $params['body'], $text);
        }
        
        $data = array();
        $data['subject'] = $subject;
        $data['text'] = $text;
        
        return $data;
    }
}
?>
