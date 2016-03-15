<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

$resourcesArray = array();
if($GLOBALS['Auth']->getSetting('Aff_display_resources') == 1)
{
    //$resourcesArray[] = array('item', '<a class="aLeftRedMenuItem" href="index_res.php">'.L_G_RESOURCES.'</a>');
}

$campaignsArray = array(
        array('header', L_G_PROGRAMS),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffCampaignManager">'.L_G_AVAILABLEPROGRAMS.'</a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffBannerManager">'.L_G_BANNERSANDLINKS.'</a>'),
    );

if($GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels') > 1) 
{
    //$campaignsArray[] = array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=subaffsignup">'.L_G_LINKTOSUBAFFSIGNUP.'</a>');
}

//$campaignsArray[] = array('item', '<a class="aLeftMenuItem" href="javascript:customDynamicLink();">'.L_G_BUILDCUSTOMDYNAMICLINK.'</a>');

$reportsArray = array(
        array('header', L_G_REPORTS),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=traffic">'.L_G_TRAFFICBYCLICKDATE.'</a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=trafficprocess">'.L_G_TRAFFICBYPROCESSDATE.'</a>'),
		array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=pending"> Pending Commissions </a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=paid"> Paid Commissions </a>'),
        
        //array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=quick">'.L_G_QUICK.'</a>'),
        //array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=transactions">'.L_G_TRANSACTIONS.'</a>'),
);
    
if($GLOBALS['Auth']->getSetting('Aff_maxcommissionlevels') > 1) 
{
    //$reportsArray[] = array ('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffReports&reporttype=subaffiliates">'.L_G_SUBAFFILIATES.'</a>');
}

$GLOBALS['leftMenu'] = array(
    // menu table
    $resourcesArray,
    
    //array(
        //array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_MainPage">'.L_G_MAINPAGE.'</a>'),
        //array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffiliateProfile">'.L_G_PROFILE.'</a>'),
    //),
    
    $campaignsArray,
    
    $reportsArray,
    
    array(
        array('header', L_G_TOOLSANDRESOURCES),
        //array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_Settings">'.L_G_NOTIFICATIONS.'</a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_StaticPage">'.L_G_MAINPAGE.'</a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_StaticPage&page=newsandarticles">'.L_G_NEWSANDARTICLES.'</a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_AffiliateProfile">'.L_G_PROFILE.'</a>'),
        array('item', '<a class="aLeftMenuItem" href="index.php?md=Affiliate_Affiliates_Views_ContactUs">'.L_G_CONTACTUS.'</a>'),
    ),
    
    array(
        array('item', '<a class="aLeftMenuItem" href="logout.php">'.L_G_LOGOUT.'</a>'),
    ),    
);


?>
