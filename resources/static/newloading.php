<!DOCTYPE HTML>
<html>
<head>
    <title>Just a Moment While We Direct You to Your Offer</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="robots" content="NOFOLLOW,NOINDEX">
    <meta name="revisit-after" content="10 days">
    <meta name="resource-type" content="document">
    <meta name="distribution" content="global">
    <meta name="author" content="CreditCards.com">
    <meta name="copyright" content="Copyright <?= date('Y') ?> CreditCards.com">
    <meta name="author" content="CreditCards.com">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-override.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-global.css" rel="stylesheet" type="text/css">
    <link href="/css/cc-card-category.css" rel="stylesheet" type="text/css">
    <?php

    include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
    if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
    ?>
</head>

<body class="newloading-bg">

<?php //Facebook Pixel - FA:43678 ?>
<!-- Facebook Conversion Code for Offer Clicks -->
<script>(function() {
        var _fbq = window._fbq || (window._fbq = []);
        if (!_fbq.loaded) {
            var fbds = document.createElement('script');
            fbds.async = true;
            fbds.src = '//connect.facebook.net/en_US/fbds.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(fbds, s);
            _fbq.loaded = true;
        }
    })();
    window._fbq = window._fbq || [];
    window._fbq.push(['track', '6024511525486', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6024511525486&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" style="display: none;"/></noscript>

<?php // Adswerve ?>
<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: Offer Click Conversion Page
URL of the webpage where the tag is expected to be placed: http://www.creditcards.com/oc
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 09/09/2014
-->
<script type="text/javascript">
    var axel = Math.random() + "";
    var a = axel * 10000000000000;
    document.write('<iframe src="https://4508143.fls.doubleclick.net/activityi;src=4508143;type=Conve0;cat=Offer0;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
</script>
<noscript>
    <iframe src="https://4508143.fls.doubleclick.net/activityi;src=4508143;type=Conve0;cat=Offer0;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
</noscript>
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->

<div class="t-page-block">
    <div class="container">
        <div class="row">
            <?= $tPageText ?>
            <div class="lock"></div>
            <div class="load-hldr">
                <div class="figure">
                    <img src="/images/cclogo_219x90.png">
                </div>
                <div class="figure">
                    <img src="/images/arrow-time.gif">
                </div>
                <div class="figure">
                    <img src="http://www.imgsynergy.com/191x120/<?= $tPageImage ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<img src="/actions/clickBack.php?t=<?= md5(time()); ?>" width="1px" height="1px" style="display: none;">
<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1  style=\"display: none;\">\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1 style=\"display: none;\">";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');
$channel = '';
$pageName = 'lead confirmation';
$analyticsServer = '';
$pageType = '';
$prop1 = '';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = '';
$prop16 = $_SESSION['page_pos'];
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = 'purchase';
$analyticsProducts = $_SESSION['fid'].';'.$_SESSION['bid'].';1;0';
$purchaseId = isset($purchaseId) ? $purchaseId : '';
$eVar1 = isset($_GET['catid']) ? $_GET['catid'] : '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar9 = '';
$eVar10 = '';
$eVar11 = '';
$eVar25 = $_SESSION['fid'];
$eVar26 = $_SESSION['page_pos'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }

$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
$url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>



<?php
/* Show drtv banner impression pixel when banner is shown on homepage.
 * Logic to load up session var is only on homepage.
 */
if(isset($_SESSION['drtv_banner'])) {
    ?>
    <span id="trackingCode"><img src="https://tracker.revshare.com/trk.php?rsid=<?= $_SESSION['drtv_offer_id'] ?>&uid=<?= $_SESSION['external_visit_id'] ?>" width="1" height="1" border="0"></span>
<?php
} //close drtv banner
?>

<?php if($_SESSION['aid'] == 'df209399') { ?>
    <!-- Begin ZEDO -->
    <script language="JavaScript" type="text/javascript">
        var zzp=new Image();
        if (location.protocol == "https:") {
            zzp.src="https://ss1.zedo.com/ads2/t?o=332223;h=1123594;z="+Math.random();
        } else {
            zzp.src="http://xads.zedo.com/ads2/t?o=332223;h=1123594;z="+Math.random();
        }
    </script><?php if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); } ?>
    <!-- End ZEDO -->
<?php } ?>

<?php if($_SESSION['aid'] == '66a119d5') { ?>
    <img src="https://www.emjcd.com/u?AMOUNT=0&CID=1512560&OID=<?=$purchaseId?>&TYPE=327018&CURRENCY=USD&METHOD=IMG" height="1" width="20">
<?php } ?>

<?php
//FA: 28321 - AID = efa46163 - SmileyMedia
if($_SESSION['aid'] == 'efa46163') { ?>
    <IMG SRC="http://ian.smileymedia.com/r2/AdTag.php?SID=coreg2-<?=$_SESSION['tid'] ?>&oetagid=619&partnerID=CreditCardsdotcom&response=text" border="0" width="1" height="1">
<?php } ?>

<?php
//FA: 36095 - AID = f3feb8a7 - Email Marketing Campaign
if($_SESSION['aid'] == 'f3feb8a7') { ?>
    <img src="https://jump.tvitrack.com/aff_l?offer_id=1163" width="1" height="1" style="display: none;"/>
<?php } ?>

<?php //Yahoo/Bing/YSA - show for all traffic - FA:43911 and CCCOM-69 ?>
<script type="application/javascript" src="https://s.yimg.com/wi/ytc.js"></script>
<script type="application/javascript">YAHOO.ywa.I13N.fireBeacon([{"projectId" : "1000376035072","coloId" : "SP","properties" : {/*"documentName" : "",*/"pixelId" : "23924","qstrings" : {}}}]);</script>

<?php //Marin Software Tracking Script - show for all traffic - FA:43173 ?>
<script type='text/javascript'>
    var _mTrack = _mTrack || [];
    _mTrack.push(['addTrans', {
        currency :'USD',
        items : [{
            convType : 'TRACKER'
        }]
    }]);
    _mTrack.push(['processOrders']);
    (function() {
        var mClientId = '17ih1lm660';
        var mProto = (('https:' == document.location.protocol) ? 'https://' : 'http://');
        var mHost = 'tracker.marinsm.com';
        var mt = document.createElement('script'); mt.type = 'text/javascript'; mt.async = true; mt.src = mProto + mHost + '/tracker/async/' + mClientId + '.js';
        var fscr = document.getElementsByTagName('script')[0]; fscr.parentNode.insertBefore(mt, fscr);
    })();
</script>
<noscript>
    <img width="1" height="1" src="https://tracker.marinsm.com/tp?act=2&cid=17ih1lm660&script=no" />
</noscript>

<?php // X+1 ?>
<script language="javascript" type="text/javascript">
    <!--
    var _dropTag=function() {
        var _qS='';
        var _rand=Math.random()+'';
        var _rs=document.location.protocol+'//';
        var xp1_qs =
        {
            '_t': '62298230ct',


            '_random': _rand*100000000000
        };
        for(var qsKey in xp1_qs){_qS += '&'+qsKey+'='+xp1_qs[qsKey];}
        document.write('<iframe src="'+_rs+'d.xp1.ru4.com/meta?_o=62298178'+_qS+'" width="0" height="0" frameborder="0" scrolling="no"></iframe>');};
    _dropTag();
    //-->
</script>

<?php // Adode Media Optimizer ?>
<script type='text/javascript'>
    (function() {
        var f = function() {
            EF.init({ eventType: "transaction",
                transactionProperties : "ev_cc_offerclick=1&ev_transid=<?=$purchaseId?>_<?=$_GET['pg'];?>-<?=$_GET['pid'];?>",
                segment : "20753",
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
<noscript><img src="https://pixel.everesttech.net/4397/t?ev_cc_offerclick=1&ev_transid=<?=$purchaseId?>_<?=$_GET['pg'];?>-<?=$_GET['pid'];?>" width="1" height="1" style="display: none;"/></noscript>
<!-- Code for Action: Creditcards.com - Parameterized Conversion -->
<!-- Begin Rocket Fuel Conversion Action Tracking Code Version 9 -->
<script type='text/javascript'>
    (function() {
        var w = window, d = document;
        var s = d.createElement('script');
        s.setAttribute('async', 'true');
        s.setAttribute('type', 'text/javascript');
        s.setAttribute('src', '//c1.rfihub.net/js/tc.min.js');
        var f = d.getElementsByTagName('script')[0];
        f.parentNode.insertBefore(s, f);
        if (typeof w['_rfi'] !== 'function') {
            w['_rfi']=function() {
                w['_rfi'].commands = w['_rfi'].commands || [];
                w['_rfi'].commands.push(arguments);
            };
        }
        _rfi('setArgs', 'ver', '9');
        _rfi('setArgs', 'rb', '12533');
        _rfi('setArgs', 'ca', '20673285');
        _rfi('setArgs', 'revenue', 'INSERT_REVENUE_HERE');
        _rfi('setArgs', 'ptype', '<?=$CardNameAndCategory;?>');
        _rfi('track');
    })();

</script>
<noscript>
    <iframe src='//20673285p.rfihub.com/ca.html?rb=12533&ca=20673285&ra=INSERT_CACHEBUSTER_HERE&ptype=<?=$CardNameAndCategory;?>&revenue=INSERT_REVENUE_HERE' style='display:none;padding:0;margin:0' width='0' height='0'>
    </iframe>
</noscript>
<!-- End Rocket Fuel Conversion Action Tracking Code Version 9 -->

<!-- Google Code for www.creditcards.com/oc Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1065174423;
    var google_conversion_language = "en";
    var google_conversion_format = "3";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "mM3bCLK46V4Ql4v1-wM";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1065174423/?label=mM3bCLK46V4Ql4v1-wM&guid=ON&script=0"/>
    </div>
</noscript>

<!-- Yieldmo Conversion Script -->
<script>
    (function(){
        var __yms, __p;
        __p = document.body || document.head;
        __yms = document.createElement('script');
        __yms.setAttribute('type','text/javascript');
        __yms.setAttribute('async', '');
        __yms.setAttribute('src', '//static.yieldmo.com/ym.adv.min.js');
        __yms.setAttribute('class', 'ym');
        __yms.setAttribute('data-ymadvid', '1230362814768855398');
        __yms.setAttribute('data-conversion-type', 'lead');
        if(__p) __p.appendChild(__yms);
    })();
</script>

<!-- Google Code for Content Account Pixel Conversion Page -->
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1066278488;
    var google_conversion_language = "en";
    var google_conversion_format = "3";
    var google_conversion_color = "ffffff";
    var google_conversion_label = "2DHdCLrlhmAQ2Ly4_AM";
    var google_remarketing_only = false;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1066278488/?label=2DHdCLrlhmAQ2Ly4_AM&guid=ON&script=0"/>
    </div>
</noscript>
</body>
</html>
