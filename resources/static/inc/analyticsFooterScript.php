<?php
$path = $_SERVER['PHP_SELF'];
$path_info = pathinfo($path);

/*** variable descriptions ***
 *
 * channel - a grouping of pages on the website, consisting of one or more pages
 * affiliateId (aid) - the ID of the affiliate
 * productId (pid) - the ID of the credit card
 * pageId (cid) - the ID of the page
 * keywordId (did) - the ID of the keyword
 * bannerId (bid) - the ID of the banner
 * purchaseId (oid) - the ID of the transaction
 * exitPageId (fid) - the ID of the exit page
 * cardPosition - the order number of the card on the page, top to bottom
 * authorName - the name of the author on an editorial page
 * categoryId - the ID of the category
 *
 */
$channel = isset($channel) ? $channel : substr($path_info['dirname'], 1);
$pageName = isset($pageName) ? $pageName : $channel.':'.$path_info['filename'];
$affiliateId = isset($_SESSION['aid']) ? $_SESSION['aid'] : '';
$productId = isset($_SESSION['pid']) ? $_SESSION['pid'] : '';
$pageId = isset($_SESSION['cid']) ? $_SESSION['cid'] : '';
$keywordId = isset($_SESSION['did']) ? $_SESSION['did'] : '';
$bannerId = isset($_SESSION['bid']) ? $_SESSION['bid'] : '';
$exitPageId = isset($_SESSION['fid']) ? $_SESSION['fid'] : '';
$purchaseId = isset($purchaseId) ? $purchaseId : '';
$cardPosition = isset($_GET['pgpos']) ? $_GET['pgpos'] : '';
$categoryId = isset($_GET['catid']) ? $_GET['catid'] : '';

?>

<!-- Adobe DTM data layer -->
<script>
    var dtmAnalyticsData = {
        pageName: "<?= $pageName ?>",
        channel: "<?= $channel ?>",
        affiliateId: "<?= $affiliateId ?>",
        productId: "<?= $productId ?>",
        pageId: "<?= $pageId ?>",
        keywordId: "<?= $keywordId ?>",
        bannerId: "<?= $bannerId ?>",
        exitPageId: "<?= $exitPageId ?>",
        purchaseId: "<?= $purchaseId ?>",
        cardPosition: "<?= $cardPosition ?>",
        authorName: $('a[rel=author]').text(),
        categoryId: "<?= $categoryId ?>",
        testCampaignName: null,
        testVariationId: null,
        testVariationName: null
    };
</script>
<!-- Adobe DTM footer script -->
<script>_satellite.pageBottom();</script>

<?php if ($_SERVER['REQUEST_URI'] == '/business.php') : ?>
<!--
BEGIN HEADER
Segment name: business_seg
Type: Javascript
END HEADER
-->
<script type='text/javascript'>
    (function() {
        var f = function() {
            EF.init({ eventType: "pageview",
                pageviewProperties : "",
                segment : "20897",
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
            efjs.src = '//www.everestjs.net/static/st.v3.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(efjs, s);
            window.EF.jsTagAdded=1;
        }
    })();
</script>
<noscript><img src="//pixel.everesttech.net/4397/v?" width="1" height="1"/></noscript>
<?php endif; ?>

<?php
//CCCOM-1238 - LiveRamp
if (isset($_COOKIE['CCCID'])) {
    echo '<img src=\'//idsync.rlcdn.com/403166.gif?partner_uid=' .$_COOKIE['CCCID']. '\'/>';
} else {
    echo '<img src=\'//idsync.rlcdn.com/403166.gif?partner_uid=nocookie\'/>';
}
?>

<?php
// CCCOM-1254
require_once('yieldmoTargetingScript.php');
switch ($_SERVER['REQUEST_URI']) {
	case '/cash-back.php':
		echo printYieldmoScript('cashback');
		break;

	case '/airline-miles.php':
		echo printYieldmoScript('travel');
		break;

	case '/balance-transfer.php':
		echo printYieldmoScript('balancetransfer');
		break;

	case '/top-credit-cards.php':
		echo printYieldmoScript('topoffers');
		break;

	default:
		break;
}
?>