<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/search/templates/Template.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/search/SearchClient.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/search/SearchCache.php');

$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/search/config/elasticsearch.ini');

// check for link filter (options: all, card, editorial, blog)
$filterCode = (isset($_REQUEST['filter_code']) ? $_REQUEST['filter_code'] : $config['default_filter_code']);

// check for page number
$page = (isset($_REQUEST['page']) ? $_REQUEST['page'] : $config['default_page']);

// calculate results offset
$resultsPerPage = $config['default_num_results_per_page'];
$resultsOffset = ($page - 1) * $resultsPerPage;

// if search box left empty, set query to default
$queryString = str_replace(['"', "'", "(", ")", "="], '', trim(strip_tags($_REQUEST['query'])));
if ($queryString == '') {
	$queryString = $config['default_query'];
}

// instantiate results template
$tplPath = $_SERVER['DOCUMENT_ROOT'] . '/search/templates/searchResults.tpl.php';
$tpl = new Search_Util_Template($tplPath);


$searchClient = new SearchClient($config);
$searchCache = new SearchCache($searchClient, $resultsPerPage);

try {
	$results = $searchCache->search($queryString, $filterCode, $resultsOffset);
} catch (\Exception $e) {
	$tpl->assign('serverDown', true);
	$tpl->render();
	return;
}

$numTotalResults = $results['total'];

// render results template
$tpl->assign('currentQuery', $queryString);
$tpl->assign('filterCode', $filterCode);
$tpl->assign('resultsOffset', $resultsOffset);
$tpl->assign('numTotalResults', $numTotalResults);
$tpl->assign('numResultsPerPage', $resultsPerPage);
$tpl->assign('encodedCurrentQuery', urlencode($queryString));
$tpl->assign('searchResults', $results['hits']);
$tpl->assign('pagination_start_page', $page);
$tpl->assign('numPaginationPages', $config['default_num_pagination_pages']);
$tpl->assign('pagination_end_page', ceil($numTotalResults / $resultsPerPage));

$tpl->render();

