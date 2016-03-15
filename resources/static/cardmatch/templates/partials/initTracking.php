<?php
include_once('../actions/pageInit.php');
if (empty($pagefid)) $pagefid = "1581";
$_SESSION['fid'] = $pagefid;
include_once('../actions/trackers.php');
