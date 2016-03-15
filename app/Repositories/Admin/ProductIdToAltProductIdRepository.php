<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:14 PM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\ProductIdToAltProductIdMap;

/**
 * Class ProductIdToAltProductIdRepository
 * @package cccomus\Repositories\Admin
 */
class ProductIdToAltProductIdRepository extends Repository {


	public function createObject() {
		return new ProductIdToAltProductIdMap();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Get map by product id
	 * @param $cardId
	 * @return mixed
	 */
	public function getMapByProductId($cardId) {
		return ProductIdToAltProductIdMap::where('product_id', $cardId)
			->first();
	}

	/**
	 * Update or Create a mapping
	 * @param array $attributes
	 * @param $id
	 * @return bool
	 */
	public function updateOrCreate(array $attributes, $id=null) {

		$map = new ProductIdToAltProductIdMap();

		if(!is_null($id)) {
			$map = ProductIdToAltProductIdMap::find($id);
		}

		$map->product_name = array_get($attributes, 'product_name');
		$map->product_id = array_get($attributes, 'product_id');
		$map->alt_product_id = array_get($attributes, 'alt_product_id');

		return $map->save();
	}

}