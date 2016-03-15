<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

// get elasticsearch configuration
$config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/search/config/elasticsearch.ini');
$esParams = ['hosts' => $config['hosts']];

$queryTerm = trim(strip_tags($_GET['term']));

// set up search
$params['index'] = $config['autocomplete_index'];

$params['body'] = [
	'keyword-suggest' => [
		'text' => $queryTerm,
		'completion' => [
			'field' => 'keyword_suggest',
            'fuzzy' => true
		]
	]
];

$esClient = new Elasticsearch\Client($esParams);

try {
	$results = $esClient->suggest($params);
} catch (\Exception $e) {
	return;
}

$data = $results['keyword-suggest']['0']['options'];

foreach($data as $result) {
	$suggestions[] = ['label' => $result['text'], 'value' => $result['text']];
}

echo json_encode($suggestions);
