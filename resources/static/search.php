<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '292';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');

?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Search - CreditCards.com';
$metaKeywords = '';
$metaDescription = '';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link rel="stylesheet" href="/css/cc-misc.css">

	<script>
	<!--
	function clickit(cn,clink,val) {
		if (document.images) {
			(new Image()).src="/actions/searchClick.php?num="+cn+"&url="+clink+"&val="+val;
		}
		return true;
	}
	//-->
	</script>
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/search/searchElastic.php'); ?>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:search';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = str_replace('"', '\"', $GLOBALS['search_query']);
$prop7 = $GLOBALS['search_num_results'];
$prop8 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = '';
$analyticsProducts = '';
$purchaseId = '';
$eVar1 = '';
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
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

</body>
</html>
