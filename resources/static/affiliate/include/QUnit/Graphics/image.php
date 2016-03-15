<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================
// include files
session_start();
require_once(dirname(dirname(realpath(dirname(realpath(__FILE__))))) . '/QUnit/Global.class.php');

$GLOBALS['RootPath'] = './';
include_once('../globalFuncs.php'); 
include_once('./postgraph.class.php'); 

$graph_data = $_SESSION[$_GET['img']];


$graph = QUnit_Global::newObj('QUnit_Graphics_POSTGraph', 550,330);

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