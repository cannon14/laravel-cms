<?php $this->rootPath = '../' . $this->rootPath; ?>
<?='<?PHP
include_once(\''.$this->rootPath.'actions/pageInit.php\');
$_SESSION[\'fid\'] = "'.($this->page->get('fid')?$this->page->get('fid'):'35').'";
include_once(\''.$this->rootPath.'actions/trackers.php\');
';
if($this->page->get(CHAMELEON_SQL)){
    print 'include_once(\''.$this->rootPath.'actions/chameleon.php\');';
}
if ($this->useGeoIp && false) { /* This is turned off */
    echo ('include_once(\''.$this->rootPath.'actions/geoip.php\');');
}
print '?>';?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?$components = $this->page->getComponents();?>
<html>

<head>
<title><?=$this->page->getTitle()?></title>
<?=$this->page->getPageMeta()?>

<meta http-equiv="imagetoolbar" content="no">
<meta name="MSSmartTagsPreventParsing" content="true">
<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta http-equiv="Pragma" content="no-cache">
<meta name="author" content="CreditCards.com">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
<meta name="Robots" content="ALL">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="/css/credit-cards.css" type="text/css">
<link rel="stylesheet" href="/css/credit-cards-print.css" type="text/css" media="print">
<script src="/javascript/application.js"></script>
<script src="/javascript/thickbox/jquery.js" type="text/javascript"></script>
<?= '<?php require_once($_SERVER[\'DOCUMENT_ROOT\'].\'/affiliate/settings/settings.php\'); ?>
	<?php if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER[\'DOCUMENT_ROOT\'].\'/inc/analyticsHeaderScript.php\'); } ?>'?>

<link rel="stylesheet" href="profile-styles.css" type="text/css">

<style>
.slidemenuTitle {
	font-family: Lucida, Arial, Helvetica, Sans-Serif;
	font-size: 7pt;
	color: black;
	text-align: center;
	text-decoration: none;
	padding: 1px;
}
.slidemenuTitle a:link {
	text-decoration: none;
	color: black;	
}
.slidemenuTitle a:visited {
	text-decoration: none;
	color: black;	
}
.slidemenuTitle a:hover{
	text-decoration: none;
	color: black;	
}
.slidemenuMiniPic {
	border: 1px solid white;
}
.slidemenuSlideDiv {
	border-top:2px solid white;
	cursor:pointer;
	height:130px;
}
.slidemenu {
	list-style:none;
	width:220px;
	display:block;
	overflow:hidden;
	padding:0px;
	margin:0px;
}
.slidemenu li {
	float:left;
	display:inline;
	overflow:hidden;
	height:130px;
	width:22px;
}
</style>

</head>
<body>

<div id="skeleton">

<?php echo '<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>'; ?>
