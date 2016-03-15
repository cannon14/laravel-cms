<?php
require_once('global.php');
require_once ($GLOBALS['IncludesPath'].'/jpgraph/src/jpgraph.php');
require_once ($GLOBALS['IncludesPath'].'/jpgraph/src/jpgraph_gantt.php');

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Rate');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Campaign');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_RateGantt');

	$camp = Affiliate_Merchants_Bl_Campaign::load(array('campaignid' => $_REQUEST['campaignid']));
	$name = $camp['name'];
	$rates = Affiliate_Merchants_Bl_Rate::getRatesByProductId($_REQUEST['campaignid']);
	Affiliate_Merchants_Bl_RateGantt::drawGantt($name, $rates)

?>
