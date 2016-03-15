<script type="text/javascript" language="javascript">
<!--

var collapsedMenuItems = new Array('id_full_reports','id_transactions','id_tools','id_communication');

-->
</script>

<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

$transactionsArray = array(
        array('header', L_G_TRANSACTIONS, 'id_transactions'),
        array('item', 'aff_trans_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all">'.L_G_CTRSALES.'</a>'),
    );

if($GLOBALS['Auth']->getSetting('Aff_support_recurring_commissions') == 1) 
{
    $transactionsArray[] = array ('item', 'aff_trans_recurr_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_RecurringManager&type=all">'.L_G_RECURRINGCOMMS.'</a>');
}


$affiliatesArray = array(
        array('header', L_G_AFFILIATES, 'id_traffic_sources'),
        array('item', 'aff_aff_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AffiliateManager">'.L_G_AFFILIATES.'</a>')
    );

if($GLOBALS['Auth']->getSetting('Aff_join_campaign') == 1)
{
    $affiliatesArray = array_merge($affiliatesArray,
            array(array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AppliedAffiliate">'.L_G_APPLIED.'</a>'))
        );
}

$affiliatesArray = array_merge($affiliatesArray,
        array(
            array('item', 'aff_aff_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AffiliateGroupsManager">'.L_G_AGROUPS.'</a>'),
            array('item', 'aff_aff_pay_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AffiliatePayments">'.L_G_PAYOUT.'</a>'),
            array('item', 'aff_aff_accounting_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_Accounting">'.L_G_ACCOUNTING.'</a>')
             )
    );

$GLOBALS['leftMenu'] = array(
    // menu table
    array(
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantProfile">'.L_G_PROFILE.'</a>'),
    ),

    array(
        array('header', L_G_MERCHANTS),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantManager">'.L_G_MERCHANTS.'</a>'),
    ),
    
    array(
        array('header', L_G_CAMPAIGNS),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ProductManager">'.L_G_CAMPAIGNS.'</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CampaignCategoryGroupsManager">'.L_G_CTYPES.'</a>'),
        //array('item', 'aff_camp_banner_links_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_BannerManager">'.L_G_BANNERS.'</a>'),

    ),
    
    array(
        array('header', L_G_ADS),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AdvertisementManager">'.L_G_ADS.'</a>'),
        array('item', 'aff_camp_banner_links_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_BannerManager">'.L_G_BANNERS.'</a>'),

    ),    
    
    $affiliatesArray,
    
    $transactionsArray,
    
    /**array(
        array('header', L_G_EXPENSES), 
        array('item', 'aff_trans_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpensesManager&type=view">'.L_G_EXPENSES.'</a>'),           
    ),*/
    
    array(
        array('header', L_G_REPORTS, 'id_reports'),
        array('item', 'aff_rep_quick_report_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=quick">'.L_G_QUICK.'</a>'),
        array('item', 'aff_rep_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=transactions">'.L_G_TRANSACTIONS.'</a>'),
        array('item', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic">'.L_G_TRAFFIC.'</a>'),
        
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_imps=1&commited=yes">'.L_G_IMPRESSIONS.'</a>'),
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_clicks=1&commited=yes">'.L_G_CLICKS.'</a>'),
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_sales=1&commited=yes">'.L_G_SALES.'</a>'),
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_commission=1&commited=yes">'.L_G_REVENUE.'</a>'),
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_revenue=1&commited=yes">'.L_G_TOTALCOSTS.'</a>'),
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_expenses=1&commited=yes">'.L_G_EXPENSES.'</a>'),
        //array('child', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic&rt_profits=1&commited=yes">'.L_G_PROFITS.'</a>'),
        
        array('item', 'aff_rep_top_20_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=top20affiliates">'.L_G_TOPAFFILIATES.'</a>'),
        array('item', 'aff_rep_number_of_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=affiliatecounts">'.L_G_AFFILIATECOUNTS.'</a>'),
    ),
    
    array(
        array('header', L_G_ALLREPORTS, 'id_full_reports'),
        //array('item', 'aff_rep_quick_report_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=aquick">'.L_G_QUICK.'</a>'),
        array('item', 'aff_rep_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=atransactions">'.L_G_TRANSACTIONS.'</a>'),
        array('item', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=atraffic">'.L_G_TRAFFIC.'</a>'),        
        //array('item', 'aff_rep_top_20_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=atop20affiliates">'.L_G_TOPAFFILIATES.'</a>'),
        //array('item', 'aff_rep_number_of_affiliates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=aaffiliatecounts">'.L_G_AFFILIATECOUNTS.'</a>'),
    ),

    array(
        array('header', L_G_COMMUNICATION, 'id_communication'),
        array('item', 'aff_comm_email_templates_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AffEmailTemplates">'.L_G_EMAILTEMPLATES.'</a>'),
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_Communications">'.L_G_COMMUNICATION.'</a>'),
        array('item', 'aff_comm_broadcast_email_use', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_BroadcastMessage">'.L_G_BROADCAST_MESSAGE.'</a>'),
    ),
    
    array(
        array('header', L_G_RT_TRACKING_TOOLS, 'id_tracking_tools'),
        array('item', '', '<a class="aLeftMenuItem" href="/affiliate/merchants/keywords_admin/index.php">'.L_G_RT_KEYWORDS.'</a>'),
//        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=merchants">'.L_G_RT_MERCHANTS.'</a>'),
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=pages">'.L_G_RT_PAGES.'</a>'),
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=timeslots">'.L_G_RT_TIMESLOTS.'</a>'),
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=trackers">'.L_G_RT_TRACKERS.'</a>'),
        // added link to epc edit pg.  - mz 12/12/07
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TrackingManager&mode=epcedit">'.L_G_RT_MANAGEEPC.'</a>'),
    ),    
    
    array(
        array('header', L_G_TOOLS, 'id_tools'),
        array('item', 'aff_tool_admins_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AdminsManager">'.L_G_ADMINS.'</a>'),
        array('item', 'aff_tool_user_profiles_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_UserProfiles">'.L_G_USER_PROFILES_MANAGER.'</a>'),
        array('item', 'aff_tool_settings_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_Settings">'.L_G_SETTINGS.'</a>'),
        array('item', 'aff_tool_integration_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantProfile&action=showcodes">'.L_G_INTEGRATIONCODE.'</a>'),
        array('item', 'aff_tool_history_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_History">'.L_G_HISTORY.'</a>'),
        //array('item', 'aff_tool_db_maintenance_backup', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_Maintenance">'.L_G_MAINTENANCE.'</a>'),
    ),   


    array(
        array('item', '', '<a class="aLeftMenuItem" href="logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>
