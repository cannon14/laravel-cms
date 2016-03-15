<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/pageInit.php');
$_SESSION['fid'] = "875";
include_once($_SERVER['DOCUMENT_ROOT'].'/actions/trackers.php');
?>

<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = 'CreditCards.com Site Security policy';
$metaKeywords = '';
$metaDescription = 'View the CreditCards.com site security policy.';

include_once($_SERVER['DOCUMENT_ROOT'].'/inc/htmlHead.php');
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

<link href="/css/cc-misc.css" rel="stylesheet">
</head>
<body>

<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/header.php'); ?>

<!-- Other Block -->
<div class="other-block">
    <div class="container">
        <div class="row">
                <div class="category-subnav">
                    <ol class="breadcrumb-other">
                        <li><a href="/">Credit Cards </a> <i class="fa fa-angle-right"></i></li>
                        <li>Credit Cards Site Security </li>
                    </ol>
                </div>
                <h1>Site Security</h1>
                <p>Ensuring the security and protection of your personal  information is important to us. When you
                    choose to apply for any credit card offer  shown on our website, you will be taken directly to the
                    card issuer's secure  website to complete the application.&nbsp; </p>
                <p>We only partner with card issuers whose online credit application  forms are secured by 128-bit SSL
                    encryption. SSL technology encodes information  as it is being sent over the Internet, helping to
                    ensure that the information  transmitted remains confidential. </p>
                <p>You will know the card issuer's application form is secure  when you see:</p>
                <ul>
                    <li>A secure symbol (for example, closed padlock or key)<br>
                        <img width="162" height="34" src="/images/SSL-Security_clip_image002.jpg"><br>
                        <br>
                    </li>
                    <li>http<strong>s</strong>:// in the address bar, instead of http://<br>
                        <img width="141" height="25" src="/images/SSL-Security_clip_image004.jpg"></li>
                </ul>
                <p>SSL technology requires the use of compatible browsers which  allow you to communicate with our
                    website in a protected session by encrypting  information that flows between you and the site.
                    Internet Explorer browser  versions prior to 3.02 and Netscape browser versions prior to 4.02 are not
                    capable of 128-bit encryption. We recommend you use  the latest browser versions available. </p>
                <p>For more information on how we  protect&nbsp;information about you online and our approach to privacy,
                    please  see our&nbsp;<a href="/privacy.php">Privacy Policy.</a>
                    <br>
                    <br>
                </p>
        </div>
    </div>
</div><!-- End of Other Block -->
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'].'/inc/footerScripts.php'); ?>

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

$channel = 'about-us';
$pageName = $channel.':security';
$analyticsServer = '';
$pageType = '';
$prop1 = 'about us';
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
	$channel = 'about us';
	$pageName = $channel.':security';
	include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php');
}

?>

</body>
</html>
