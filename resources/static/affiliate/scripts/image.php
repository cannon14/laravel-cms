<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
// include files
error_reporting(E_ALL ^ E_NOTICE);

session_start();

require_once('../../../QUnit/Global.class.php');
QUnit_Global::includeClass('QUnit_GlobalFuncs');
QUnit_Global::includeClass('QUnit_Graphics_POSTGraph');

$graph_data = $_SESSION[$_GET['img']];

// check if all data are integers
$allInt = true;
foreach($graph_data['data'] as $k => $v)
{
    if(strpos($v, '.') !== false)
    {
        $allInt = false;
        break;
    }
}

$graph = new QUnit_Graphics_POSTGraph(550,330);

if($allInt)
    $graph->setYNumberFormat('integer');

$graph->setGraphTitles($graph_data['title'], $graph_data['xtitle'], $graph_data['ytitle']);

$graph->setYTicks(10);

$graph->setData($graph_data['data']);

if($graph_data['orientation'])
    $graph->setXTextOrientation($graph_data['orientation']);
    
$graph->drawImage();

$graph->printImage();

$_SESSION[$_GET['img']] = '';
unset($_SESSION[$_GET['img']]);
?>