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
		array('header', "Sites"),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_SiteManager">Manage Sites</a>'),
           ),
    
    array( 
    	array('header', "Card Listings"),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CategoryManager">Manage Page Categories</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_PageManager">Manage Card Pages</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CardSubCategoryManager">Manage Card Sub Headings</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CardManager">Manage Cards</a>'),
        ),
        
    array( 
    	array('header', "Articles"),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_CategoryManager&type=1">Manage Article Categories</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_PageManager&type=1">Manage Article Pages</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ArticleSubCategoryManager">Manage Article Sub Headings</a>'),
        array('item', 'aff_camp_product_categories_view', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Merchants_Views_ArticleManager">Manage Articles</a>'),
    ),
    
    array(
        array('item', '', '<a class="aLeftMenuItem" href="../logout.php">'.L_G_LOGOUT.'</a>'),
    ),
); 

?>