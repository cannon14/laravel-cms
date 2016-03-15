<?= '<?PHP
include_once(\'' . $this->rootPath . 'actions/pageInit.php\');
$_SESSION[\'fid\'] = "' . ($this->page->get('fid') ? $this->page->get('fid') : '35') . '";
include_once(\'' . $this->rootPath . 'actions/trackers.php\');

if (isset($_GET["catid"]) && !empty($_GET["catid"])) {
	$catid = $_GET["catid"];
}
';

include_once('reviews/review_stats.php');
include_once('reviews/staff_review.php');
include_once('reviews/user_reviews.php');

$isCardlist = TRUE;
if ($this->page->get(CHAMELEON_SQL)) {
    print 'include_once(\'' . $this->rootPath . 'actions/chameleon.php\');';
}
if ($this->useGeoIp) { /* This is turned off */
    echo('include_once(\'' . $this->rootPath . 'actions/geoip.php\');');
}
print '$cardId = \'' . $this->page->get('cardId') . '\';';
print '?>'; ?>
    <!DOCTYPE HTML>
    <? $components = $this->page->getComponents(); ?>
<html>
    <head>
        <title>
            <?
            if ($this->page->get('contentType') != 'card')
                echo $this->page->getTitle() . ' - Apply Online'; else {
                //echo $this->page->getType();
                if ($this->page->get('pageType') != 'BANK')
                    echo $this->page->getTitle() . ' - CreditCards.com'; else
                    echo $this->page->getTitle();
            }
            ?>
        </title>

        <?php if ($this->page->get('contentType') == 'card' || $this->page->get('contentType') == 'specials') { ?>
            <meta name="page-type" content="category" />
        <?php } ?>

        <?php if ($this->page->get('card_categories') != '') { ?>
            <meta name="category" content="<?php echo $this->page->get('card_categories') ?>" />
        <?php } ?>

        <?= $this->page->getPageMeta() ?>
        <meta name="credit-card" content="Credit card offers: low interest, balance transfer, cash back, reward, prepaid, college students, business, bad credit, airline and instant approval credit cards.">
        <meta name="google-site-verification" content="0wsuI3yWASFsqPO19ZPLkjaYkV0gFhtK30gwdeKe_ho"/>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Pragma" content="no-cache">
        <meta name="revisit-after" content="10 days">
        <meta name="resource-type" content="document">
        <meta name="distribution" content="global">
        <meta name="author" content="CreditCards.com">
        <meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
        <meta name="author" content="CreditCards.com">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'/>
        <link href="/css/bootstrap.css" rel="stylesheet"/>
        <link href="/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="/css/cc-override.css" rel="stylesheet"/>
        <link href="/css/cc-global.css" rel="stylesheet"/>
        <link href="/css/cc-card-category.css" rel="stylesheet">
        <link href="/css/jquery-ui-1.11.2.css" rel="stylesheet" type="text/css">
	    <link href="/search/css/search.css" rel="stylesheet" type="text/css">
        <!--check-->

	    <?php
	    //CCCOM-980 - Add the canonical tag below to the newly created SEM landing page (603)
	    if ($this->page->get('cardpageId') == 603) {
		    echo '<link rel="canonical" href="http://www.creditcards.com/top-credit-cards.php" />';
	    }
	    ?>

        <?php
            $injectedPage = $this->page->get('pageLearnMore');

            if($injectedPage != '') {
                ?>
            <style>
                .show-more-results {
                    display: none !important;
                }
            </style>
        <?php
            }
        ?>

        <?= '<?php include_once $_SERVER["DOCUMENT_ROOT"] . "/inc/footerScripts.php"; ?>'?>
	    <?= '<?php require_once($_SERVER[\'DOCUMENT_ROOT\'].\'/affiliate/settings/settings.php\'); ?>
		<?php if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER[\'DOCUMENT_ROOT\'].\'/inc/analyticsHeaderScript.php\'); } ?>'?>

        <?= (!empty($this->prevNextLinks)) ? $this->prevNextLinks : '' //link rel="prev/next"  ?>
	    <?php
	        $relPrevPattern = '/rel="prev"/';
	        $notOnPageOne = preg_match($relPrevPattern, $this->prevNextLinks) && !empty($this->prevNextLinks);
	    ?>
	    <?= (!empty($this->canonicalTag) && $notOnPageOne) ? $this->canonicalTag : '' //link rel="canonical" ?>
        <!--pagination_links-->

    </head>

    <body>

    <!--NAVIGATION BAR-->
<?= '<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>' ?>
