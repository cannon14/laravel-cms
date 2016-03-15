<?php
    require 'global.php';

    session_start();

    QUnit_Global::includeClass('Affiliate_Scripts_Services_ContentService');

    $contentService = new Affiliate_Scripts_Services_ContentService();
    $out = $contentService->processRequest($_GET);

    echo $out;
?>
