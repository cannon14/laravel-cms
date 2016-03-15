<?php
require_once('global.php');

csCore_Import::importClass("csCore_UI_uiEngine");

$uiEngine = new csCore_UI_uiEngine();
$uiEngine->setDefaultModule("CMS_view_preview");


$uiEngine->processModule('CMS_view_preview');

?>
