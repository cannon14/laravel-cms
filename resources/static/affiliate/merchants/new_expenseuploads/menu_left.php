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
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpenseParser">Expenses Overview</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpensesUploadManager">Expense Uploads Manager</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpensesUploadErrorsManager">Expense Upload Errors Manager</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ExpensesUploadManager" onclick="javascript:createNewExpense();">Create New Expense</a>')
		),
    
  
    array(
        array('item', '', '<a class="aLeftMenuItem" href="../logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>
