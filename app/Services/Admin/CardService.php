<?php

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\CardRepository;
use Mockery\CountValidator\Exception;

/**
 * Class CardService
 * @package cccomus\Services
 */
class CardService {

    private $cardRepo;

    /**
     * @param CardRepository $cardRepo
     */
    function __construct(CardRepository $cardRepo) {
        $this->cardRepo = $cardRepo;
    }

	/**
	 * Get cards
	 * @param array $attributes
	 * @return \stdClass
	 */
    public function getCards(array $attributes = []) {
		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

        $data = new \stdClass();
        $data->totalRecords = $this->cardRepo->count($filters);
        $data->cards = $this->cardRepo->getObjects($count, $page, $sortBy, $dir, $filters);

        return $data;
    }

	/**
	 * Get a list of cards.
	 */
	public function getCardsList() {
		return $this->cardRepo->getCardsList();
	}

	/**
	 * Get a card by id
	 * @param $id
	 * @return mixed
	 */
    public function getCard($id) {
		return $this->cardRepo->getObject($id);
	}

	/**
	 * Create a card (based on feed)
	 * @param $attributes
	 * @return bool
	 */
	public function create($attributes) {
		return $this->cardRepo->create($attributes);
	}

	/**
	 * Update a card
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
    public function update($id, $attributes) {
        return $this->cardRepo->update($id, $attributes);
    }

	/**
	 * Update a card's status to active or inactive.
	 * @param $id
	 * @param $attributes
	 * @return mixed
	 */
	public function updateStatus($id, $attributes) {
		return $this->cardRepo->setStatus($id, $attributes);
	}

    /**
     * Delete a card by id
     * @param $id
     * @return int
     */
    public function delete($id) {
        return $this->cardRepo->deleteObject($id);
    }
}