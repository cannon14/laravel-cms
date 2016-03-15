<?php

class SearchCache {

	/**
	 * @param SearchClient $esClient
	 * @param int $resultsPerPage
	 */
	public function __construct($esClient, $resultsPerPage) {
		$this->client = $esClient;
		$this->resultsPerPage = $resultsPerPage;
	}

	public function search($query, $filterCode, $offset) {

		$key = md5($query.$filterCode);

		if(!$this->exists($key)) {
			$results = $this->client->search($query, $filterCode, $offset);
			$hits = $this->getUnique($results['hits']['hits']);
			$this->add($key, $hits);
		}

		$hits = $this->get($key);

		$results['hits'] = array_slice($hits, $offset, $this->resultsPerPage);
		$results['total'] = count($hits);

		return $results;
	}

	protected function add($key, $results) {
		$_SESSION['search'][$key] = $results;
	}

	protected function get($key) {
		return $_SESSION['search'][$key];
	}

	protected function getUnique($hits) {

		$titles = [];

		foreach($hits as $key => $hit) {
            if (stripos($hit['_source']['url'], 'page') === false && !(in_array($hit['_source']['title'], $titles))) {
                $titles[$key] = $hit['_source']['title'];
            }
		}

		$uniqueHits = array_intersect_key($hits, $titles);

		return $uniqueHits;
	}

    protected function exists($key) {
        if (array_key_exists($key, $_SESSION['search'])) {
            return true;
        }

        return false;
    }
}
