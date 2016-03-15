<?='<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>' ?>

<?php

$cardPageId = $this->page->get('cardpageId');
switch ($cardPageId) {
    case 105:           // balance transfer page
        echo '<?php include $_SERVER["DOCUMENT_ROOT"] . "/calculators/modal/balanceTransfer.php"; ?>';
        echo '<script type="text/javascript">';
        echo '<?php include $_SERVER["DOCUMENT_ROOT"] . "/javascript/calculators/validations.js"; ?>';
        echo '<?php include $_SERVER["DOCUMENT_ROOT"] . "/javascript/calculators/balanceTransfer.js"; ?>';
        echo '</script>';
        break;
}
?>
<?php
/*if ($this->page->get('cardpageId') == 105) {
    echo '<?php include $_SERVER["DOCUMENT_ROOT"]."/calculators/bt.php" ?>';
}*/
?>

<?php
$adobeSegment = '';
$xPlusOneT = '';
switch($this->page->get('fid')) {
    // bank of america
    case 23:
        $adobeSegment = '34609';
        break;
    // balance transfer
    case 12:
        $adobeSegment = '20889';
        $xPlusOneT = '62339525ct';
        break;
    // no foreign transaction fee
    case 2022:
        $adobeSegment = '21089';
        $xPlusOneT = '62339527ct';
        break;
    // top credit cards
    case 37:
        $adobeSegment = '21065';
        $xPlusOneT = '62339517ct';
        break;
    // reward
    case 14:
        $adobeSegment = '21129';
        $xPlusOneT = '62339529ct';
        break;
    // cash back
    case 15:
        $adobeSegment = '20913';
        $xPlusOneT = '62339521ct';
        break;
    // 0 apr credit cards
    case 1477:
        $adobeSegment = '20825';
        $xPlusOneT = '62339523ct';
        break;
    // airline miles
    case 16:
        $adobeSegment = '20841';
        $xPlusOneT = '62339519ct';
        break;
}
?>

<?php if ($adobeSegment) { ?>
    <!-- Adobe Media Optimizer Tracking -->
    <script type='text/javascript'>
        (function() {
            var f = function() {
                EF.init({ eventType: "pageview",
                    pageviewProperties : "",
                    segment : "<?php echo $adobeSegment ?>",
                    searchSegment : "",
                    sku : "",
                    userid : "4397",
                    pixelHost : "pixel.everesttech.net"

                    , allow3rdPartyPixels: 1});
                EF.main();
            };
            window.EF = window.EF || {};
            if (window.EF.main) {
                f();
                return;
            }
            window.EF.onloadCallbacks = window.EF.onloadCallbacks || [];
            window.EF.onloadCallbacks[window.EF.onloadCallbacks.length] = f;
            if (!window.EF.jsTagAdded) {
                var efjs = document.createElement('script'); efjs.type = 'text/javascript'; efjs.async = true;
                efjs.src = 'https://www.everestjs.net/static/st.v3.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(efjs, s);
                window.EF.jsTagAdded=1;
            }
        })();
    </script>
    <noscript><img src="https://pixel.everesttech.net/4397/v?" width="1" height="1"/></noscript>
<?php }

if (!empty($xPlusOneT)) { ?>
    <!-- X+1 Tracking -->
    <script language="javascript" type="text/javascript">
        <!--
        var _dropTag=function() {
            var _qS='';
            var _rand=Math.random()+'';
            var _rs=document.location.protocol+'//';
            var xp1_qs =
            {
                '_t': '<?php echo $xPlusOneT ?>',


                '_random': _rand*100000000000
            };
            for(var qsKey in xp1_qs){_qS += '&'+qsKey+'='+xp1_qs[qsKey];}
            document.write('<iframe src="'+_rs+'d.xp1.ru4.com/meta?_o=62298178'+_qS+'" width="0" height="0" frameborder="0" scrolling="no" style="position: absolute; left: -5000px"></iframe>');}
        _dropTag();
        //-->
    </script>

<?php
}

echo '<?= "<IMG SRC=\'".$GLOBALS[\'RootPath\']."sb.php?a_aid=".$_SESSION[\'aid\']."&a_bid=".$_SESSION[\'hid\']."\' border=0 width=1 height=1>"; ?>';
echo '<?= "<IMG SRC=\'".$GLOBALS[\'RootPath\']."xtrack.php?".$_SERVER[\'QUERY_STRING\']."\' border=0 width=1 height=1>"; ?>';

if(isset($this->siteCatalystData)) {
    echo '<?php
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

    ?>';
}
?>

<?php
//Beacon Tags for BofA and Discover
echo '<?php
if(isset($BofaCookieForBeacon) && $BofaCookieForBeacon) {
	echo "<img src=\'http://www.likedcards.com/init.php?mid=CCCOM121&cid=5\' width=\'1\' height=\'1\' border=\'0\' alt=\'initiator\'>";
}

if(isset($DiscoverCookieForBeacon) && $DiscoverCookieForBeacon){
	echo "<img src=\'http://www.likedcards.com/init.php?mid=CCCOM121&cid=7\' width=\'1\' height=\'1\' border=\'0\' alt=\'initiator\'>";
}
?>';
?>

<script>
$(document).ready(function() {
		if (jQuery(location).attr('hash') !== '') {
			try {
				var headerHeight = jQuery('div#header-block').height() + 20;
				var hash = jQuery(location).attr('hash').substring(1);
				var selector = "a[id='" + hash + "']";
				var anchor = jQuery(selector);

				if (anchor.length > 0) {
					$('html,body').animate({scrollTop: anchor.offset().top  - headerHeight},'slow');
				}
			} catch(err) {
			}
		}
	});
</script>
</body>
</html>
