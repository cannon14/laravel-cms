<?php

/*include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');*/
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = '';
$metaKeywords = '';
$metaDescription = '';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>
<link href="/css/cc-misc.css" rel="stylesheet">
</head>

<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<!-- breadcrumbs -->
			<div class="other-subnav-hldr">
				<ol class="breadcrumb-other">
					<li><a href="/">Credit Cards</a> <i class="fa fa-angle-right"></i></li>
					<li><a href="#">Trail 1</a> <i class="fa fa-angle-right"></i></li>
					<li>Trail 2</li>
				</ol>
			</div><!-- End of breadcrumbs -->

			<h1></h1>

			<p></p>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
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
$analyticsEvents = 'purchase,event2';
$analyticsProducts = $_SESSION['fid'].';'.$_SESSION['bid'].';1;0';
$purchaseId = isset($purchaseId) ? $purchaseId : '';
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar25 = $_SESSION['fid'];
$eVar26 = $_SESSION['page_pos'];
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>

</body>
</html>
