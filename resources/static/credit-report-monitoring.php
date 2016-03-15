<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = '919';
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'Monitoring Your Credit - CreditCards.com';
$metaKeywords = 'credit, credit report, credit bureaus, annual credit report, annualcreditreport.com, credit scores, free report, Experian, Equifax, TransUnion';
$metaDescription = 'Monitoring Your Credit the importance of keeping track of your credit history through an annual credit report from annualcreditreport.com and other premium credit bureau services including credit scores from Experian, Equifax and TransUnion; link to What is a Credit Report? article';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
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
				
			<div id="pageContentArea">
				<h1>Monitoring your Credit with a Free Credit Report</h1>

				<img src="/images/free-credit-report-monitoring-online.gif" alt="Monitor your credit online" width="98" height="119" border="0" >

				<p>It's important to monitor your credit on a regular basis to ensure all the information reported by the three major credit bureaus is accurate and to provide peace of mind against identity theft.  Credit reports are used by banks and other lenders when deciding whether to grant new credit and determine interest rates so it's good to stay on top of your financial history.  To learn more about this subject click on our article link "<a href="/what-is-a-credit-report.php">What is a Credit Report?</a>"	We've made it easy to get a free basic annual credit report or more detailed information with a simple click of the mouse  the choice is yours.</p>

				<br>

				<h2>Annual Credit Report - Free</h2>

				<p>Recently the Federal Trade Commission mandated that the three major credit reporting agencies provide all American citizens access to a basic credit report at no cost once per year. This report, offered through AnnualCreditReport.com, will show all credit relationships, payment history and the status of each revolving or installment credit account that you have ever opened. Credit scores are not provided with this free report.</p>

				<div style="text-align: right; padding-right: 26px;">
					<strong>Click to Order: &nbsp;</strong> <a href="/free-credit-report.php"><img src="/images/Free-Annual-Credit-Report.gif" alt="Click here for a free annual credit report" width="207" height="28" border="0" align="absmiddle"></a>
				</div><br><br>
			</div> <!-- pageContentArea -->

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:credit-monitoring';
$analyticsServer = '';
$pageType = '';
$prop1 = 'tools';
$prop2 = '';
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
	$pageName = 'tools:credit monitoring';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}
?>

</body>
</html>
