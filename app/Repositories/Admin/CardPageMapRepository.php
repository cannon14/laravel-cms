<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use Illuminate\Support\Facades\DB;

use cccomus\Models\CardPageMap;

/**
 * Class CardPageMapRepository
 * @package cccomus\Repositories
 */
class CardPageMapRepository {


	/**
	 * Get all mappings by page id
	 * @param $page_id
	 * @return mixed
	 */
	public function getMapings($page_id) {
		return CardPageMap::where('page_id', $page_id)
			->orderBy('order', 'asc')
			->get();
	}

	/**
	 * Create a mapping
	 * @param $page_id
	 * @param $card_id
	 * @return bool
	 */
	public function createMapping($page_id, $card_id) {
		$mapping = new CardPageMap();

		$mapping->page_id = $page_id;
		$mapping->card_id = $card_id;

		return $mapping->save();
	}

	/**
	 * Delete a mapping
	 * @param $pageId
	 * @param $cardId
	 * @return bool
	 */
	public function deleteMapping($pageId, $cardId) {

		return CardPageMap::where('page_id', $pageId)
			->where('card_id', $cardId)
			->delete();
	}

	/**
	 * Update card order
	 * @param $page_id
	 * @param $card_id
	 * @param $order
	 * @return mixed
	 */
	public function order($page_id, $card_id, $order) {

		$mapping = CardPageMap::where('page_id', $page_id)
			->where('card_id', $card_id)
			->first();

		$mapping->order = $order;

		return $mapping->save();
	}

}