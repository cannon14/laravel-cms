<?
//header("Location: /enter/index.php");

include_once('../actions/pageInit.php');
$_SESSION['fid'] = "990";
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Credit Card Finder - CreditCards.com</title>
<meta name="keywords" content="Advanta, American Express, Bank of America, BankOne, Chase Manhattan Bank, Citibank, Discover Bank, First Premier Bank, Featured Partners">
<meta name="description" content="Specify credit card attributes including type of card, rewards, credit quality, and get a list of cards that match your criteria.">
<meta http-equiv="imagetoolbar" content="no">
<meta name="MSSmartTagsPreventParsing" content="true">
<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
<link rel="stylesheet" href="/css/credit-cards.css" type="text/css">
<script src="/javascript/application.js"></script>

<script language="javascript" src="http://www.imgsynergy.com/16a772df/flash_active_content.js"></script>
<script language="javascript" src="http://www.imgsynergy.com/16a772df/flash_tween.js"></script>
<script language="javascript" src="http://www.imgsynergy.com/16a772df/flash_sequence.js"></script>
<script src="/javascript/thickbox/jquery.js" type="text/javascript"></script>
    <script language="JavaScript" src="/javascript/mvt/tooltip.js" type="text/javascript"></script>

<script type="text/javascript">
// <![CDATA[
function setHeight(start,end) { 
    t1 = new Sequence();
    t1.addChild(new Tween(document.getElementById('flashPulse').style, 'height', Tween.strongEaseOut, start, end, 0.5, 'px'));
    t1.start();
} 
// ]]>

</script>
<script type="text/javascript">
    jQuery(document).ready(function($){
		$(".advertising_disclosure_link>a").click(function(e){
			e.preventDefault();
			$(this).parent().siblings('.advertising_disclosure_text').show();
		});
		$(".advertising_disclosure_text>div>a.close_adtext").click(function(e){
			e.preventDefault();
			$(this).parent().parent().hide();
		});
    });


</script>

</head>
<body>

<div id="skeleton">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="mainLeftNav"><?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/left-nav.php"; ?></td>
        <td class="mainContentColumn">
    
			<div id="breadcrumb">
			    <a href="http://www.creditcards.com">Credit Cards</a> &gt; <a href="/credit-card-tools/">Tools</a> &gt; Credit Card Finder
			</div>
            
            <div id="pageContentArea">
            
                <h1>Credit Card Finder</h1>
				<p>Use the Credit Card Finder to define what type of credit card offers you are looking for, and let us give you a list of cards that match your criteria. We've partnered with leading banks and issuers to bring you these offers.</p>
				<div class="advertising_disclosure_container">
					<div class="advertising_disclosure_link">                      
						<a href="#advertising_disclosure_footer">                  
							<img src="/images/advertising-disclosure/advertiserDisclosure.png">
						</a>
					</div>
					<div class="advertising_disclosure_text">                      
						<div>                                                      
						<a class="close_adtext" href="#">                          
							<img src="/images/advertising-disclosure/disclosure_top.png">
						</a>
						</div>
						<div>
							<img src="/images/advertising-disclosure/disclosure.png">
						</div>                                                     
					</div>
					<div class="clear"></div>                                      
				</div>
		        <br />
				<!-- <div id="flashPulse" style="width: 100%; height: 745px;"> -->

			    <div id="flashPulse" style="height: 745px;">
			
			        <script language="JavaScript" type="text/javascript">
			        <!--
			        var hasProductInstall = DetectFlashVer(6, 0, 65);
			        var hasRequestedVersion = DetectFlashVer(9, 0, 0);
			        
			        if ( hasProductInstall && !hasRequestedVersion ) {
			            var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
			            var MMredirectURL = window.location;
			            document.title = document.title.slice(0, 47) + " - Flash Player Installation";
			            var MMdoctitle = document.title;
			        
			            AC_FL_RunContent(
			                "src", "http://www.imgsynergy.com/16a772df/flash_player_install.swf",
			                "FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
			                "width", "100%",
			                "height", "100%",
			                "align", "middle",
			                "id", "cardfinder",
			                "quality", "high",
			                "bgcolor", "#ffffff",
			                "name", "cardfinder",
			                "allowScriptAccess","always",
			                "type", "application/x-shockwave-flash",
			                "pluginspage", "http://www.adobe.com/go/getflashplayer"
			            );
			        } else if (hasRequestedVersion) {
			            AC_FL_RunContent(
			                    "src", "http://www.imgsynergy.com/16a772df/cardfinder.swf",
			                    "width", "100%",
			                    "height", "100%",
			                    "FlashVars", "ctid=1&gpid=3&cs=<?=$_GET['cs'] ?>&qs=<?=$_GET['qs'] ?>&ts=<?=$_GET['ts'] ?>&ns=<?=$_GET['ns'] ?>",
			                    "align", "middle",
			                    "id", "cardfinder",
			                    "quality", "high",
			                    "bgcolor", "#ffffff",
			                    "name", "cardfinder",
			                    "scale","noscale",
			                    "allowScriptAccess","always",
			                    "type", "application/x-shockwave-flash",
			                    "pluginspage", "http://www.adobe.com/go/getflashplayer"
			            );
			          } else {  // flash is too old or we can't detect the plugin
			            var alternateContent = 'Alternate HTML content should be placed here. '
			            + 'This content requires the Adobe Flash Player. '
			            + '<a href=http://www.adobe.com/go/getflash/>Get Flash</a>';
			            document.write(alternateContent);  // insert non-flash content
			          }
			        // -->
			        </script>
			        <noscript>
			            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="cardfinder" width="100%" height="100%" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			                <param name="movie" value="http://www.imgsynergy.com/16a772df/cardfinder.swf" />
			                <param name="quality" value="high" />
			                <param name="FlashVars" value="ctid=1&gpid=3&cs=<?=$_GET['cs'] ?>&qs=<?=$_GET['qs'] ?>&ts=<?=$_GET['ts'] ?>&ns=<?=$_GET['ns'] ?>" />
			                <param name="bgcolor" value="#ffffff" />
			                <param name="allowScriptAccess" value="always" />
			                <embed src="http://www.imgsynergy.com/16a772df/cardfinder.swf" flashvars="ctid=1&gpid=3&cs=<?=$_GET['cs'] ?>&qs=<?=$_GET['qs'] ?>&ts=<?=$_GET['ts'] ?>&ns=<?=$_GET['ns'] ?>" quality="high" bgcolor="#ffffff" width="100%" height="100%" name="cardfinder" align="middle" play="true" loop="false" quality="high" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer"></embed>
			            </object>
			        </noscript>
			    </div> <!-- end resizable flash div -->

                <div class="aboutcalcs"><p>Use one or more selection criteria listed above to find the credit card of your choice. Click on "More Details" for additional information on the offer.</p></div>
                
                <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcredit-card-finder%2F&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
                <br/><br/>
                Comments or suggestions about this tool? <a href="/site-feedback.php">Send us feedback</a>

            </div> <!-- pageContentArea -->
        
        </td>
    </tr>
</table>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>

<? 
echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
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
s.pageName="tools:finder"
s.server=""
s.channel="tools"
s.pageType=""
s.prop1="tools"
s.prop2=""
s.prop3=""
s.prop4=""
s.prop5=""
s.prop6=""
s.prop7=""
s.prop8=""
/* Conversion Variables */
s.campaign="<?= isset($_SESSION['aid']) ? $_SESSION['aid'] : 0;?>-<?= isset($_SESSION['banner_id']) ? $_SESSION['banner_id'] : 0;?>-<?= isset($_SESSION['cid']) ? $_SESSION['cid'] : 0;?>-<?= isset($_SESSION['did']) ? $_SESSION['did'] : 0;?>"
s.state=""
s.zip=""
s.events=""
s.products=""
s.purchaseID=""
s.eVar1=""
s.eVar2=""
s.eVar3=""
s.eVar4=""
s.eVar5=""
s.eVar6=""
s.eVar7=""
s.eVar8=""
s.eVar9=""
s.eVar10=""
s.eVar11=""
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><img src="http://creditcardscom.112.2o7.net/b/ss/ccardsccdc-us/1/H.25--NS/0"
height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.25. -->

</div> <!-- skeleton -->
</body>
</html>