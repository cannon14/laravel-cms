<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'First PREMIER - Terms & Conditions';
$metaKeywords = '';
$metaDescription = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/affiliate/settings/settings.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link href="/css/cc-misc.css" rel="stylesheet">
</head>

<body>

<!-- Main Content -->
<div class="other-block">
	<div class="container">
		<div class="row">

			<img src="/images/carddetails.gif" ALT="Fees, Costs and Limitations" BORDER=0>

			<p>Below are the account fees, rates, costs, limitations, available credit and other terms for the MasterCard offer.</p>

			<p><strong>Please print these disclosures and keep them with your records.</strong> If you are unable to print these, write to First PREMIER Bank, C/O Correspondence, P.O. Box 5524, Sioux Falls, SD 57117-5524 and request a copy. By submitting this application you understand that your initial credit limit will be at least $250.00 and the following fees will be billed to your first statement: Annual Fee of $48, Account Set-Up Fee of $29, Program Fee of $95, monthly service Fee of $7, and an Additional Card Fee of $20 per card (if applicable). These fees will reduce your available credit until they are paid. You will be eligible for consideration of a credit limit increase in as little as 6 months. In addition, by submitting this application you certify that you have read, meet, understand, and agree to the account fees, rates, costs, limitations, available credit and other terms listed below.</p>

			<?php

			$cardDetails = array(
				'annualRate' => '9.9',
				'cashAdvanceAPR' => '19.9',
				'purchasPenaltyAPR' => '19.9',

				'issuanceLiabityA' => array(
					'setupFee' => '29.00',
					'programFee' => '95.00',
					'annualFee' => '48.00 ',
					'serviceFee' => '84.00',
					'additionalCardFee' => '20.00'
				),

				'gracePeriod' => '25',
				'computationMethod' => 'Average Daily Balance (Including new purchases)',

				'minFinanceCharge' => '0.50',

				'cashAdvanceFee' => '5.00',
				'cashAdvancePercentage' => '3',
				'latePaymentFee' => '29',
				'overLimitFee' => '29',
				'maintainaceFee' => '3',
				'outstandingBalance' => '20',
				'foreignTransactionFee' => '1.0',

				'serviceOrParticipationText' => '++The Service Fee of $84.00 will be billed at $7.00 per month.'
			);
			include_once('inc/termsOfService.php');
			?>

		</div>
	</div>
</div><!-- End of #other-block -->
<!-- End of Main Content -->

<?php
echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

$channel = 'terms-and-conditions';
$pageName = $channel.':premier-mastercard';
$analyticsServer = '';
$pageType = '';
$prop1 = 'BANK:first premier';
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
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>
</body>
</html>
