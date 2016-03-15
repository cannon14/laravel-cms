<?php
require_once('global.php');

QUnit_Global::includeClass('Affiliate_Scripts_Bl_JSON');
QUnit_Global::includeClass('Affiliate_Scripts_Bl_EntityInfoService');

$jsonParser = new Affiliate_Scripts_Bl_JSON();
$infoService = new Affiliate_Scripts_Bl_EntityInfoService();

$entity = $_REQUEST['entity'];
$id	= $_REQUEST['id'];

$out = $infoService->processRequest($entity, $key);

//header('Content-type:/json');
echo $jsonParser->encode($out);

?>
