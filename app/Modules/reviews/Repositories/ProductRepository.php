<?php
/**
 * Created by PhpStorm.
 * User: cannon
 * Date: 3/2/2015
 * Time: 4:47 PM
 */
namespace Modules\ProductReviewsModule\Repositories;

use Modules\ProductReviewsModule\Models\Product;

class ProductRepository {

	/**
	 * Get all products
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getProducts() {
		return Product::all();
	}

	/**
	 * Get a product by ID
	 * @param $id
	 * @return mixed
	 */
	public function getProduct($id) {
		return Product::find($id);
	}
}