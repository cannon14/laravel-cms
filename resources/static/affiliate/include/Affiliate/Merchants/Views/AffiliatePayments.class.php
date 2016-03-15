<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_PayoutOptions');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Accounting');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_SaleStatistics');

class Affiliate_Merchants_Views_AffiliatePayments extends QUnit_UI_TemplatePage
{
    function initPermissions()
    {
        $this->modulePermissions['generateexport'] = 'aff_aff_pay_affiliates_modify';
        $this->modulePermissions['approvepayment'] = 'aff_aff_pay_affiliates_modify';
        $this->modulePermissions['denypayment'] = 'aff_aff_pay_affiliates_modify';
        $this->modulePermissions['view'] = 'aff_aff_pay_affiliates_view';
    }
    
    //--------------------------------------------------------------------------
    
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {
                case 'generateexport':
                if($this->processGenerateExport())
                return;
                break;
                
                case 'approvepayment':
                if($this->processApprovePayments())
                return;
                break;
                
                case 'denypayment':
                if($this->processDeclinePayments())
                return;
                break;
            }
        }
        
       if(!empty($_REQUEST['action'])) 
        {
            switch($_REQUEST['action'])
            {
                case 'manualpay':
                    if($this->drawFormManualPayment())
                        return;
                    break;
            }
        }
        
        $this->showPayments();
    }
    
    //--------------------------------------------------------------------------
    
    function processDeclinePayments()
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;
        
        $params = array();
        $params['userids'] = $userIDs;
        $params['date1'] = preg_replace('/[^0-9-]/', '', $_POST['date1']);
        $params['date2'] = preg_replace('/[^0-9-]/', '', $_POST['date2']);

        Affiliate_Merchants_Bl_Accounting::decline($params);
        
        return false;
    }
    
    //--------------------------------------------------------------------------
    
    function processApprovePayments()
    {
        if(($userIDs = $this->returnUIDs()) == false)
            return false;

        $params = array();
        $params['userids'] = $userIDs;
        $params['accounting_note'] = $_REQUEST['accounting_note'];
        $params['y1'] = $_REQUEST['ap_year1'];
        $params['m1'] = $_REQUEST['ap_month1'];
        $params['d1'] = $_REQUEST['ap_day1'];
        $params['y2'] = $_REQUEST['ap_year2'];
        $params['m2'] = $_REQUEST['ap_month2'];
        $params['d2'] = $_REQUEST['ap_day2'];
        
        if($_REQUEST['mp_date1'] != '')
        {
            // parameters from manual payment form
            $params['date1'] = $_REQUEST['mp_date1'];
            $params['date2'] = $_REQUEST['mp_date2'];
        }
        else
        {
            $params['date1'] = $_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1'];
            $params['date2'] = $_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2'];
        }

        Affiliate_Merchants_Bl_Accounting::markAsPaid($params);
        
        return false;
    }

    //--------------------------------------------------------------------------
    
    function processGenerateExport()
    {
        if(($userIDs = $this->returnUIDs()) == false)
        {
            QUnit_Messager::setErrorMessage(L_G_YOUHAVETOCHOOSESOMEUSER);
            return false;
        }
        
        $params = array();
        $params['userids'] = $userIDs;
        $params['accounting_note'] = $_REQUEST['accounting_note'];
        $params['y1'] = $_REQUEST['ap_year1'];
        $params['m1'] = $_REQUEST['ap_month1'];
        $params['d1'] = $_REQUEST['ap_day1'];
        $params['y2'] = $_REQUEST['ap_year2'];
        $params['m2'] = $_REQUEST['ap_month2'];
        $params['d2'] = $_REQUEST['ap_day2'];
        $params['date1'] = $_REQUEST['ap_year1'].'-'.$_REQUEST['ap_month1'].'-'.$_REQUEST['ap_day1'];
        $params['date2'] = $_REQUEST['ap_year2'].'-'.$_REQUEST['ap_month2'].'-'.$_REQUEST['ap_day2'];

        // check if all users do have the same payout option
        if(!Affiliate_Merchants_Bl_Accounting::checkSamePayoutOption($params))
        {
            QUnit_Messager::setErrorMessage(L_G_USERSMUSTHAVETHESAMEPAYOUTOPTION);
            return false;
        }

        $exportFileName = Affiliate_Merchants_Bl_Accounting::generateExportFile($params);

        if($exportFileName != false)
        {
            $_REQUEST['exportFileName'] = $exportFileName;
        }
        return false;
    }
    
    //--------------------------------------------------------------------------

    function returnUIDs()
    {
        $userIDs = $_POST['itemschecked'];
        
        return $userIDs;
    }
    
    //--------------------------------------------------------------------------

    function drawFormManualPayment()
    {
        $userID = $_REQUEST['aid'];

        // check payout option for this user
        $payoutData = Affiliate_Merchants_Bl_Accounting::getPayoutOptionForUser($userID);
        if($payoutData == false)
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTGETPAYOUTOPTIONFORUSER);
            return false;
        }

        // check if this payout option has defined paybutton
        $payButton = $payoutData['paybuttonformat'];
        if($payButton == '')
        {
            QUnit_Messager::setErrorMessage(L_G_NOMANUALPAYOUTOPTIONDEFINED);
            return false;
        }
        
        // draw paybutton
        $this->assign('a_payoutData', $payoutData);

        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $list_data1 = QUnit_Global::newobj('QCore_RecordSet');
        $list_data1->setTemplateRS($payout_methods);
        $this->assign('a_list_data1', $list_data1);

        $payout_fields = Affiliate_Merchants_Bl_PayoutOptions::getPayoutFieldsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_list_data2', $payout_fields);

        
        $this->addContent('manual_payout');
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function showPayments()
    {
        $payout_methods = Affiliate_Merchants_Bl_PayoutOptions::getPayoutMethodsAsArray($GLOBALS['Auth']->getAccountID(), STATUS_ENABLED);
        $this->assign('a_payout_methods', $payout_methods);
        
        //--------------------------------------
        // try to load settings from session
        foreach($_SESSION as $k => $v)
        {
            if(strpos($k, 'ap_') === 0 && !isset($_REQUEST[$k]))
            $_REQUEST[$k] = $v;
        }
        
        //--------------------------------------
        // get default settings for unset variables
        if($_REQUEST['ap_showtype'] == '') $_REQUEST['ap_showtype'] = 'allunpaid';
        if($_REQUEST['ap_day1'] == '') $_REQUEST['ap_day1'] = date("j");
        if($_REQUEST['ap_month1'] == '') $_REQUEST['ap_month1'] = date("n");
        if($_REQUEST['ap_year1'] == '') $_REQUEST['ap_year1'] = date("Y");
        if($_REQUEST['ap_day2'] == '') $_REQUEST['ap_day2'] = date("j");
        if($_REQUEST['ap_month2'] == '') $_REQUEST['ap_month2'] = date("n");
        if($_REQUEST['ap_year2'] == '') $_REQUEST['ap_year2'] = date("Y");
        
        $minyear = getMinYear(array('wd_pa_transactions' => 'dateinserted'));
        $maxyear = getMaxYear(array('wd_pa_transactions' => 'dateinserted'));
        $this->assign('a_minyear', $minyear);
        $this->assign('a_maxyear', $maxyear);

        if($_REQUEST['ap_showtype'] == 'allunpaid')
        {
            $_REQUEST['ap_day1'] = 1;
            $_REQUEST['ap_month1'] = 1;
            $_REQUEST['ap_year1'] = $minyear;
        }
        
        //--------------------------------------
        // put settings into session
        $_SESSION['ap_payout_type'] = $_REQUEST['ap_payout_type'];
        $_SESSION['ap_showtype'] = $_REQUEST['ap_showtype'];
        $_SESSION['ap_note'] = $_REQUEST['ap_note'];
        $_SESSION['ap_day1'] = $_REQUEST['ap_day1'];
        $_SESSION['ap_month1'] = $_REQUEST['ap_month1'];
        $_SESSION['ap_year1'] = $_REQUEST['ap_year1'];
        $_SESSION['ap_day2'] = $_REQUEST['ap_day2'];
        $_SESSION['ap_month2'] = $_REQUEST['ap_month2'];
        $_SESSION['ap_year2'] = $_REQUEST['ap_year2'];
        
        $this->addContent('ap_filter');
        
        $conditions = array(
            'CampaignID' => '',
            'UserID' => '',
            'TransactionType' => '',
            'Status' => '',
            'page' => '',
            'rowsPerPage' => '',
            'day1' => $_REQUEST['ap_day1'],
            'month1' => $_REQUEST['ap_month1'],
            'year1' => $_REQUEST['ap_year1'],
            'day2' => $_REQUEST['ap_day2'],
            'month2' => $_REQUEST['ap_month2'],
            'year2' => $_REQUEST['ap_year2']
        );
		if ($_REQUEST['filtered']){
        	$transdata = Affiliate_Scripts_Bl_SaleStatistics::getTransactionsSummaries($conditions);
		}
        $newTransdata = array();
        foreach($transdata as $data)
        {
            if($data['approved'] <= 0)
                continue;
            
            if($_REQUEST['ap_reachedminpayout'] == 'yes' && ($data['approved'] < $data['minpayout'] || $data['minpayout'] == ''))
                continue;
            
            if($_REQUEST['ap_payout_type'] != '' && $_REQUEST['ap_payout_type'] != '_' 
                && $_REQUEST['ap_payout_type'] != $data['payout_type'])
                continue;

            $temp = $data;
            
            $temp['payment_data'] = '';
            
            if(is_array($data['payout_fields']) && count($data['payout_fields']) > 0 ) 
            {
                foreach($data['payout_fields'] as $field)
                {
                    $temp['payment_data'] .= ($temp['payment_data'] != '' ? ',' : '').$field['name'].': '.$field['value'].' ';
                }
            }
            else 
            {
                $temp['payment_data'] = '<font color=#ff0000>'.L_G_UNDEFINED.'</font>';
            }
            
            if($data['payout_method_name'] != '')
            {
                $temp['payment_type'] = $data['payout_method_name'];
            }
            else
            {
                $temp['payment_type'] = '<font color=#ff0000>'.L_G_UNDEFINED.'</font>';
            }
            
            $temp['address'] = $data['address'];
            $temp['db_payout_type'] = $data['payout_type'];
            
            $newTransdata[] = $temp;
        }
        
        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($newTransdata);
        $this->assign('a_list_data', $list_data);
        
        $this->assign('a_transdata', count($newTransdata));
        
        $this->addContent('ap_list');
    }
    
    //--------------------------------------------------------------------------
    
}
?>
