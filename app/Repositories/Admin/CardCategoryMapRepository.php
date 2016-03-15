<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\CardCategoryMap;

/**
 * Class CardCategoryMapRepository
 * @package cccomus\Repositories\Admin
 */
class CardCategoryMapRepository {


	/**
	 * Get all mappings by category id
	 * @param $categoryId
	 * @return mixed
	 */
	public function getMapings($categoryId) {
		return CardCategoryMap::where('category_id', $categoryId)
			->orderBy('rank', 'asc')
			->get();
	}

	/**
	 * Create or update mapping
	 * @param $categoryId
	 * @param array $ranking
	 * @return bool
	 */
	public function createOrUpdateMapping($categoryId, array $ranking) {

		$mapping = CardCategoryMap::where('category_id', $categoryId)
			->where('card_id', $ranking['product_id'])
			->first();

		if(is_null($mapping)) {
			$mapping = new CardCategoryMap();
		}

		$mapping->category_id = $categoryId;
		$mapping->card_id = array_get($ranking, 'product_id', $mapping->card_id);
		$mapping->position_link = array_get($ranking, 'position_link', $mapping->position_link);
		$mapping->rank = array_get($ranking, 'rank', $mapping->rank);

		return $mapping->save();
	}

	/**
	 * Delete a mapping
	 * @param $categoryId
	 * @param $cardId
	 * @return bool
	 */
	public function deleteMapping($categoryId, $cardId) {

		return CardCategoryMap::where('category_id', $categoryId)
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