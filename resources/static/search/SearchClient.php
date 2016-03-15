<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

class SearchClient {

	protected $client;
    protected $config;

	public function __construct($config) {
		// get elasticsearch configuration
		$this->config = $config;
		$esParams = ['hosts' => $this->config['hosts']];
		$this->client = new Elasticsearch\Client($esParams);
	}

	public function search($queryString, $filterCode, $offset) {

		$searchParams = $this->getSearchParams($queryString, $filterCode, $this->config, $offset);
		$results = $this->client->search($searchParams);

		return $results;
	}

	protected function getSearchParams($queryString, $filterCode, $config) {

		$searchParams['index'] = $config['search_index'];
		$searchParams['type'] = $config['search_type'];
		$searchParams['from'] = $config['search_from'];
		$searchParams['size'] = $config['search_size'];

		$searchParams['body']['query']['filtered']['query']['bool']['must'][] = [
			'match' => [
				'content' => [
					'query' => $queryString,
					'operator' => 'and'
				]
			]
		];

		// boost metatag title and keyword fields
		$searchParams['body']['query']['filtered']['query']['bool']['should'] = [
			[
				'match' => [
					'title.ngram' => [
						'query' => $queryString,
						'boost' => '3.5'
					]
				]
			],
			[
				'match' => [
					'metatag.keywords.ngram' => [
						'query' => $queryString,
						'boost' => '2'
					]
				]
			],
            [
                'match' => [
                    'metatag.page-type' => [
                        'query' => 'category',
                        'boost' => '4'
                    ]
                ]
            ],
            [
                'match' => [
                    'metatag.category.raw' => [
                        'query' => $queryString,
                        'boost' => '5'
                    ]
                ]
            ]
		];

		if($filterCode == "card") {
            $filter = [
                'or' => [
                    [
                        'regexp' => ['url' => ".*/credit-cards/.*"]
                    ],
                    [
                        'term' => ['metatag.page-type' => 'category']
                    ]
                ]
            ];

			$searchParams['body']['query']['filtered']['filter'] = $filter;
		}

		if($filterCode == "editorial") {
			$searchParams['body']['query']['filtered']['filter'] = array('regexp' => array('url' => ".*/credit-card-news/.*"));
            $searchParams['body']['sort'] = array('metatag.date-published' => array('order' => 'desc'));
		}

		if($filterCode == "blog") {
			$searchParams['body']['query']['filtered']['filter'] = array('regexp' => array('url' => ".*blogs.creditcards.com/.*php"));
		}

		if ($filterCode == "review") {
			$filter = [
				'or' => [
					[
						'regexp' => ['url' => "*/reviews/*"]
					],
					[
						'term' => ['metatag.page-type' => 'review']
					]
				]
			];
			$searchParams['body']['query']['filtered']['filter'] = $filter;
			$searchParams['body']['sort'] = array(
				'metatag.date-published' => array('order' => 'desc')
			);
		}

        $searchFilters[] = array('regexp' => array('url' => '.*xml'));
        $searchFilters[] = array('regexp' => array('url' => '.*rss'));
        $searchFilters[] = array('regexp' => array('url' => '.*/assets/.*'));

        if(!in_array($queryString, array("site-map","site map","Site Map", "Site map", "site Map", "Site-Map"))) {
            $searchFilters[] = array('regexp' => array('url' => '.*site-map.*'));
        }

		$searchParams['body']['query']['filtered']['query']['bool']['must_not'] = $searchFilters;

		return $searchParams;
	}

} 
