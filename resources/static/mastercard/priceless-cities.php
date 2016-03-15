<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = "2043";
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>MasterCard &mdash; Priceless Cities</title>
	<meta name="keywords" content="creditcards.com, credit cards, credit card, Visa, Mastercard, Discover, American Express, offers, apply online, credit card application, articles">
	<meta name="description" content="CreditCards.com provides the greatest variety of credit card offers online, bringing consumers and card issuers together.">
	<meta name="Robots" content="ALL">
	<meta name="revisit-after" content="10 days">
	<meta name="resource-type" content="document">
	<meta name="distribution" content="global">
	<meta http-equiv="Pragma" content="no-cache">
	<meta name="author" content="CreditCards.com">
	<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
	<link rel="stylesheet" type="text/css" href="/css/credit-cards.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="/mastercard/slider.css" type="text/css">
	<script src="/javascript/application.js"></script>
	<script src="/javascript/jquery/jquery-1.10.1.min.js"></script>
	<script src="/javascript/jquery/unslider.min.js"></script>
</head>
<body>
<div id="container">
  <div id="skeleton">
	  <?php include $_SERVER["DOCUMENT_ROOT"] . "/mastercard/header.php"; ?>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr>
			  <td class="mainLeftNav"><?php include $_SERVER["DOCUMENT_ROOT"] . "/mastercard/inc/left-nav.php"; ?></td>
			  <td class="mainContentColumn">
				  <div id="pageContentArea" style="padding: 20px 20px;">
					  <div class="mc-header"><img
								  src="/images/mastercard-logo.png" alt="MasterCard" width="100" height="60" align="absmiddle"><h1>World MasterCard<sup>&reg;</sup></h1></div>
					  <div id="sub-nav">
						  <div class="slider-container">  
			  		<?php include $_SERVER["DOCUMENT_ROOT"] . "/mastercard/slider.php"; ?>
              	</div>


						  <table align="center" cellpadding="0" cellspacing="0">
							  <tr>
								  <td width="25%" align="center" valign="middle"><a href="/mastercard/index.php">World MasterCard&reg; Overview</a>
								  </td>
								  							 
								  <td class="compare" width="25%" align="center" valign="middle"><a href="/mastercard/featured-cards.php">Compare<br>MasterCard Cards</a>
								  </td>
							  </tr>
						  </table>
					  </div><!-- sub-nav -->
					  <div id="priceless-cities">
						<h2>PRICELESS CITIES OFFER EXCLUSIVE EXPERIENCES</h2>
                        <p>Your MasterCard gives you access to premier, handpicked experiences and offers in cities you love around the world.</p>
                        <p>When you are thinking about your home town or next holiday destination, <a href="http://www.priceless.com" target="_blank">Priceless Cities</a> is a great place to find inspiration for dining, shopping, sports, travel or music.</p>
                        <p>Listed below are some sample offers from Priceless Cities in the United States - New York, Los Angeles, Chicago and Miami. More cities are being added to the list. </p>
<div style="text-align:center"><a href="/mastercard/featured-cards.php">Get a World MasterCard now! <img src="/images/mastercard-arrow.png" width="20" height="20" align="absmiddle"></a></div>
                        	                        
			    		</div><!-- prime-features -->
                         <div id="sample-offers">
                         <h2>SAMPLE OFFERS IN PRICELESS CITIES</h2>
                           <table>
                          <tr>
    <td><img src="images/city-ny.jpg" width="260" height="130"></td>
    <td valign="top"><p>Check out your favorite celebrity chefs from the best seats in the house. VIP ticket includes expedited entry and reserved seating at the culinary demos at the Grand Tasting.</p><p>Pier 94, New York
<br>Oct 20, 2013</p>
      <img src="images/dining.gif" width="143" height="41"></td>
  </tr>
  <tr>
    <td><img src="images/city-chicago.jpg" width="260" height="130"></td>
    <td valign="top"><p>Have your photo taken on Wrigley Field, enjoy batting practice from the bleachers and then head to the game!</p><p>Wrigley Field, Chicago<br>
Sep 20, 2013</p>
      <img src="images/sports.gif" width="143" height="41"></td>
  </tr>
  <tr>
    <td><img src="images/city-la.jpg" width="260" height="130"></td>
    <td valign="top"><p>Enter the Priceless Cities #LoveThisCity Sweepstakes for your chance to win!</p><p>56th GRAMMY Awards&reg;, Los Angeles<br>
Feb 04 - Dec 31, 2013</p>
      <img src="images/music.gif" width="143" height="41"></td>
  </tr>
  <tr>
    <td><img src="images/city-miami.jpg" width="260" height="130"></td>
    <td valign="top"><p>Receive a $50 hotel credit for 2 night stay or $100 hotel credit for 4 night stay.</p>
      <p>W South Beach, Miami Beach<br>
        Jan 01 - Dec 31, 2013</p>
      <img src="images/travel.gif" width="143" height="41"></td>
  </tr>
                           </table>
                    </div><!--services --></div><!-- pageContentArea -->
			  </td>
		  </tr>
	  </table>
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>
    <?php
	echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
	echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";
	?>
    <!-- Adobe Marketing Cloud Tag Loader Code
Copyright 1996-2013 Adobe, Inc. All Rights Reserved
More info available at http://www.adobe.com/solutions/digital-marketing.html --> 
    <script type="text/javascript">//<![CDATA[
var amc=amc||{};if(!amc.on){amc.on=amc.call=function(){}};
document.write("<scr"+"ipt type=\"text/javascript\" src=\"//www.adobetag.com/d1/v2/ZDEtY3JlZGl0Y2FyZHNjb20tNTY5NS0yMTg0/amc.js\"></sc"+"ript>");
//]]></script> 
    <!-- End Adobe Marketing Cloud Tag Loader Code --> 
    <script language="JavaScript" type="text/javascript">
/* You may give each page an identifying name, server, and channel on
the next lines. */
s.pageName="microsite:mastercard-priceless-cities";
s.server="";
s.channel="microsite";
s.pageType="";
s.prop1="microsite";
s.prop2="";
s.prop3="";
s.prop4="";
s.prop5="";
s.prop6="";
s.prop7="";
s.prop8="";
/* Conversion Variables */
s.campaign="<?= isset($_SESSION['aid']) ? $_SESSION['aid'] : 0;?>-<?= isset($_SESSION['banner_id']) ? $_SESSION['banner_id'] : 0;?>-<?= isset($_SESSION['cid']) ? $_SESSION['cid'] : 0;?>-<?= isset($_SESSION['did']) ? $_SESSION['did'] : 0;?>"
s.state="";
s.zip="";
s.events="";
s.products="";
s.purchaseID="";
s.eVar1="";
s.eVar2="";
s.eVar3="";
s.eVar4="";
s.eVar5="";
s.eVar6="";
s.eVar7="";
s.eVar8="";
s.eVar9="";
s.eVar10="";
s.eVar11="";
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code);</script>
    <script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script>
    <noscript>
    <img src="http://creditcardscom.112.2o7.net/b/ss/ccardsccdc-us/1/H.25--NS/0"
height="1" width="1" border="0" alt="" />
    </noscript>
    <!--/DO NOT REMOVE/--> 
    <!-- End SiteCatalyst code version: H.25. --> 
    
  </div>
  <!-- skeleton --> 
</div>
<!-- container -->
</body>
</html>
