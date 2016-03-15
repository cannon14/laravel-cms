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
        array('header', 'Revenue'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_RevenueParser">Revenue Overview</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_UploadManager">Revenue Upload Manager</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_UploadErrorManager">Revenue Upload Errors Manager</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_NFExportManager">Netfiniti Export Manager</a>'),
    ),
    
    array(
        array('header', 'Rates'),
    	array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_RateManager">Product Rates Manager</a>'),
    	array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CampaignRateGroupsManager">Tier Group Rates Manager</a>'),
    ),
    
    array(
    	array('header', L_G_BONUS),
        array('item', '', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ApplyBonus">Apply Bonus</a>'),
    ),
    
    array(
        array('item', '', '<a class="aLeftMenuItem" href="../logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>
