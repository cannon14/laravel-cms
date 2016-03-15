<?php

include_once(dirname(realpath(__FILE__)).'/../actions/pageInit.php');
$_SESSION['fid'] = '1428';
include_once(dirname(realpath(__FILE__)).'/../actions/trackers.php');
?>

<?php
	/* esm_common.php - editorial site map common file */
	/* FA0020452 - Editorial Site Map Rollup Project */
	/* Expects $esm_common_content to be set to the content to be displayed */
	/* Expects $esm_category and $esm_category_fn to be set to category and filename */
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Site Map for \''.$esm_category.'\' Articles -- CreditCards.com';
$metaKeywords = $esm_category.' site map, credit card news, article site map';
$metaDescription = 'Use the following site map to search the archive of all \''.$esm_category.'\' from the CreditCards.com editorial team.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">
			<br>
			<h1>Site Map for '<?=$esm_category ?>' Articles</h1>
			<br>
			<p>Use the following site map to search the archive of all related '<?= $esm_category ?>' articles from the CreditCards.com editorial team.</p>
			<br>
			
			<div class="row">
				<div class="col-md-24">
					<?php /* include from cardpress that generates sitemap sub-tree, manager/includes/templates/defaults/rolled_up_cat_sitemap.tpl.php */ ?>
					<?= $esm_common_content ?>
			
				</div>
			</div>
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
$pageName = $channel.':site-map:<?= $esm_category_fn ?>';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
$prop2 = '<?= $esm_category_fn ?>';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
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
if (SITE_CATALYST_ENABLED) {
	$channel = 'tools';
	$pageName = $channel.':site map:<?= $esm_category_fn ?>';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
