<?
//start session for external visit ID
include_once('../actions/pageInit.php');

//global connection file
require_once('../global.php');

$cardName       = $_REQUEST['user_card_name'];
$cardImage      = $_REQUEST['card_image'];
$apr            = $_REQUEST['user_apr'];
$annualFee      = $_REQUEST['user_annual_fee'];
$principle      = $_REQUEST['user_principle'];
$monthlyCharges = $_REQUEST['user_monthly_charges'];
$monthlyPayment = $_REQUEST['user_payment'];
$creditQuality  = $_REQUEST['user_quality'];
$marketable     = $_REQUEST['marketable'];


QUnit_Global::includeClass('Affiliate_Scripts_Bl_CreditCardCheckup');

$checkupReg = QUnit_Global::newObj('Affiliate_Scripts_Bl_CreditCardCheckup');

$checkupReg->saveCheckupData(
        $cardName,
        $apr, 
        $annualFee,
        $principle,
        $monthlyCharges,
        $monthlyPayment,
        $creditQuality
    );

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Compare your credit cards and their benefits � CreditCards.com</title>

<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta http-equiv="Pragma" content="no-cache">
<meta name="author" content="CreditCards.com">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
<link rel="stylesheet" href="/css/credit-cards.css" type="text/css">

<script src="/javascript/application.js"></script>
<script src="/javascript/AC_RunActiveContent.js" language="javascript"></script>

<meta http-equiv="refresh" content="2;url=/checkup/results.php?&user_card_name=<?=$_REQUEST["user_card_name"] ?>&user_apr=<?=$_REQUEST["user_apr"] ?>&user_annual_fee=<?=$_REQUEST["user_annual_fee"] ?>&user_principle=<?=$_REQUEST["user_principle"] ?>&user_monthly_charges=<?=$_REQUEST["user_monthly_charges"] ?>&user_payment=<?=$_REQUEST["user_payment"]?>&user_quality=<?=$_REQUEST["user_quality"]?>&card_image=<?=$cardImage?>&marketable=<?=$marketable?>" />

</head>
<body>

<div id="skeleton">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr> 
        <td class="mainLeftNav"><?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/left-nav.php"; ?></td>
        <td class="mainContentColumn">
            
            <div id="pageContentArea">
	            
	    
	                        <table cellpadding="10" style="position: relative; left: 30px; top: 30px;">
	                           <tr>
	                               <td rowspan="2" valign="top"><img src="/images/credit-card-checkup-tool.gif" /></td>
	                               <td align="center"><h2>Please wait while we run the Credit Card CheckUp...</h2></td>
	                           </tr>
	                           <tr>
	                               <td align="center">
	                                   <script type="text/javascript">
		                                AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','300','height','100','src','/images/loading-bar.swf','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','/checkup/heartrate_monitor_loading_bar.swf' );
		                              </script>
		                              
		                              <noscript>
		                              <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="300" height="100">
		                                <param name="quality" value="high">
		                                <embed src="/checkup/heartrate_monitor_loading_bar.swf" width="300" height="100" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash"></embed>
		                              </object>
		                              </noscript>
	                               </td>
	                           </tr>
	                        </table>
	                        
                <div class="credit-card-details" style="padding: 30px 0; margin-top: 200px;">
                    Interactive tools are made available to you as self-help tools for your independent use, and are not intended to provide financial advice. We cannot and do not guarantee their accuracy in regard to your individual circumstances. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty.
                </div>
                
            </div> <!-- pageContentArea -->
        
        </td>
    </tr>
</table>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>

</div> <!-- skeleton -->
</body>
</html>