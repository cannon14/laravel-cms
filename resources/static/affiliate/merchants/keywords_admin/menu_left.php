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
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_KeywordsManager">Keywords Overview</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_KeywordsManager" onclick="javascript:keywordsBatchAdd();">Batch Add</a>'),
        //array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_KeywordsManager" onclick="javascript:keywordsBatchDelete();">Batch Delete</a>')
    ),
    
    array(
        array('item', '', '<a class="aLeftMenuItem" href="../logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>
