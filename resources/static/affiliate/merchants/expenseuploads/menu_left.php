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
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpenseCsvParser2">UPLOAD Expenses</a>'),
		array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpensesManager&type=view&runQuery=false">Query Expenses</a>'),
		),
    
    
    array(
        array('header', L_G_REPORTS),
        array('item', 'aff_rep_quick_report_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpensesErrorsManager&type=view&runQuery=false">Error Log</a>'),
		),
  
    array(
        array('item', '', '<a class="aLeftMenuItem" href="../logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>
