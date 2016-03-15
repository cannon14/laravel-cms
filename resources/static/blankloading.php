<html>
<head>
<meta name="robots" content="NOFOLLOW,NOINDEX">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<script src="/javascript/application.js"></script>
</head>
<body>
<img src="/actions/clickBack.php?t=<?=md5(time()); ?>" width="1px" height="1px" />
<? 
echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

$channel = '';
$pageName = 'lead confirmation';
$analyticsServer = '';
$pageType = '';
$prop1 = 'best credit cards';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = 'purchase,event2';
$analyticsProducts = $_SESSION['fid'].';'.$_SESSION['bid'].';1;0';
$purchaseId = $purchaseId;
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }

if($_SESSION['aid'] == '1047') { ?>
<!-- Google Code for offer click Conversion Page -->

<script language="JavaScript" type="text/javascript">

<!--

var google_conversion_id = 1066278488;

var google_conversion_language = "en_US";

var google_conversion_format = "3";

var google_conversion_color = "ffffff";

var google_conversion_label = "gJ8CCOjodxDYvLj8Aw";

if (2.5) {
  var google_conversion_value = 2.5;

}

//-->

</script>

<script language="JavaScript" src="http://www.googleadservices.com/pagead/conversion.js"> 

</script>

<noscript>

<img height="1" width="1" border="0" src="http://www.googleadservices.com/pagead/conversion/1066278488/?value=2.5&amp;label=gJ8CCOjodxDYvLj8Aw&amp;guid=ON&amp;script=0"/> 

</noscript>
<?php } ?>

<script>
showPostClickField = opener.document.getElementById('showPostClick');
if (showPostClickField && showPostClickField.value == "1") {
	if (opener.location.href.indexOf('/postclick') > -1) {
		opener.location.replace( "/postclick?c=<?=$_SESSION['bid']?>" );
	} else {
		opener.location.href = "/postclick?c=<?=$_SESSION['bid']?>";
	}
}
</script>

<!-- Conversion Pixel -->

<img src="//pixel.quantserve.com/pixel/p-KL7thL9yP4QPZ.gif?labels=_fp.event.Conversion" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>

</body>
</html>
