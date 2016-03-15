<?
// disabled post click pages
//if ( $this->page->get('cardpageId') == 83 ||
//	 //$this->page->get('cardpageId') == 81 ||
//	 $this->page->get('cardpageId') == 103
//    ) {
//	echo '<input type="hidden" id="showPostClick" value="1" />';
//}
?>



<?='<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>' ?>


<div id="toolTipLayer" style="position:absolute; z-index:5; visibility:hidden; border: 2px solid #990000; background-color: #fff; padding: 7px;" onmouseover="javascript:hideToolTip=false;" onmouseout="javascript:hideToolTip=true; setTimeout('toolTip()', 1500);"></div>
<iframe id="DivShim" src="javascript:false;" scrolling="no" frameborder="0" style="position:absolute; top:0px; left:0px; display:none;"></iframe>
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
<script language="JavaScript" src="/javascript/mvt/tooltip.js" type="text/javascript"></script>
<script type="text/javascript">
	initToolTips();
</script>

<?='<?echo "<IMG SRC=\'".$GLOBALS[\'RootPath\']."sb.php?a_aid=".$_SESSION[\'aid\']."&a_bid=".$_SESSION[\'hid\']."\' border=0 width=1 height=1>\n";
echo "<IMG SRC=\'".$GLOBALS[\'RootPath\']."xtrack.php?".$_SERVER[\'QUERY_STRING\']."\' border=0 width=1 height=1>";?>'?>
<?
if(isset($this->siteCatalystData))
{
   ?>
<?= '<?php

    $channel = \''.$this->siteCatalystData["channel"].'\';
    $pageName = \''.$this->siteCatalystData["pageName"].'\';
    $purchaseId = \''.$this->siteCatalystData["purchaseID"].'\';
    $analyticsServer = \''.$this->siteCatalystData["server"].'\';
    $pageType = \''.$this->siteCatalystData["pageType"].'\';
    $prop1 = \''.$this->siteCatalystData["prop1"].'\';
    $prop2 = \''.$this->siteCatalystData["prop2"].'\';
    $prop3 = \''.$this->siteCatalystData["prop3"].'\';
    $prop4 = \''.$this->siteCatalystData["prop4"].'\';
    $prop5 = \''.$this->siteCatalystData["prop5"].'\';
    $prop6 = \''.$this->siteCatalystData["prop6"].'\';
    $prop7 = \''.$this->siteCatalystData["prop7"].'\';
    $prop8 = \''.$this->siteCatalystData["prop8"].'\';
    $prop14 = \''.(isset($this->siteCatalystData['prop14']) ? $this->siteCatalystData['prop14'] : '').'\';
    $campaign = (isset($_SESSION[\'aid\']) ? $_SESSION[\'aid\'] : 0).\'-\'.(isset($_SESSION[\'banner_id\']) ? $_SESSION[\'banner_id\'] : 0).\'-\'.(isset($_SESSION[\'cid\']) ? $_SESSION[\'cid\'] : 0).\'-\'.(isset($_SESSION[\'did\']) ? $_SESSION[\'did\'] : 0);
    $analyticsState = \''.$this->siteCatalystData["state"].'\';
    $analyticsZip = \''.$this->siteCatalystData["zip"].'\';
    $analyticsEvent = \''.$this->siteCatalystData["event"].'\';
    $analyticsProducts = \''.$this->siteCatalystData["products"].'\';
    $eVar1 = \''.$this->siteCatalystData["evar1"].'\';
    $eVar2 = \''.$this->siteCatalystData["evar2"].'\';
    $eVar3 = \''.$this->siteCatalystData["evar3"].'\';
    $eVar4 = \''.$this->siteCatalystData["evar4"].'\';
    $eVar5 = \''.$this->siteCatalystData["evar5"].'\';
    $eVar6 = \''.$this->siteCatalystData["evar6"].'\';
    $eVar7 = \''.$this->siteCatalystData["evar7"].'\';
    $eVar8 = \''.$this->siteCatalystData["evar8"].'\';
    $eVar9 = \'\';
    $eVar10 = \'\';
    $eVar11 = \'\';
    $eVar20 = isset($_SESSION[\'NUM_GEO_BANNER_IMPRESSIONS\']) ? $_SESSION[\'NUM_GEO_BANNER_IMPRESSIONS\'] : \'\';
    $eVar27 = $_REQUEST[\'adsrc\'];
    if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER[\'DOCUMENT_ROOT\'].\'/inc/analyticsFooterScript.php\'); }
	if (SITE_CATALYST_ENABLED) { include_once($_SERVER[\'DOCUMENT_ROOT\'].\'/inc/legacyAnalyticsScript.php\'); }

?>' ?>
<?
}
?>

</div><!-- skeleton -->
</body>
</html>
