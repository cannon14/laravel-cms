<?php

include_once('../actions/pageInit.php');
if (empty($pagefid)) $pagefid = "1581";
$_SESSION['fid'] = $pagefid;
include_once('../actions/trackers.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<?php

$htmlTitle = empty($this->title) ? 'CardMatch - CreditCards.com' : $this->title;
$metaDescription = empty($this->keywords) ? '' : $this->keywords;
$metaKeywords = empty($this->description) ? '' : $this->description;
include_once('templates/partials/htmlHead.php');
include_once($_SERVER['DOCUMENT_ROOT'].'inc/analyticsHeaderScript.php');
?>
</head>

<body>

<?php include_once('templates/partials/header.php'); ?>

<!-- Main Content -->

<?php

include_once('templates/partials/footer.php');
include_once('templates/partials/footerScripts.php');

$channel = 'tools';
$pageName = 'tools:cardmatch';
include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php');
?>
</body>
</html>
