<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


$GLOBALS['leftMenu'] = array(
    // menu table
    
    
    array(
        array('header', L_G_TOOLS),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CsvParser2">UPLOAD Statement</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CustomMappings"> Manage Custom Mappings</a>'),
    	array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_QueryTool&runQuery=false"> Query Transactions</a>'),
    ),
    
    
    array(
        array('header', L_G_REPORTS),
        array('item', 'aff_rep_quick_report_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TransactionErrors">Error / Variance Log</a>'),
        array('item', 'aff_rep_quick_report_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_AdjustmentsLog&runQuery=false">Adjustments Log</a>'),
        //array('item', 'aff_rep_quick_report_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ParserLogs&reporttype=error log">Error Log [DEBUG]</a>'),
        //array('item', 'aff_rep_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ParserLogs&reporttype=parser log">SQL Log [DEBUG]</a>'),
        array('item', 'aff_rep_traffic_and_sales_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_MerchantReports&reporttype=traffic">'.L_G_TRAFFIC.'</a>'),

		),

    array(
        array('header', L_G_TRANSACTIONS),
        array('item', 'aff_trans_transactions_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all">'.L_G_CTRSALES.'</a>'),
    ),
    
    array(
        array('item', '', '<a class="aLeftMenuItem" href="../logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>
