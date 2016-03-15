<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 7/25/15
 * Time: 2:48 PM
 */
namespace Modules\ProductReviewsModule\Services;

use Modules\ProductReviewsModule\Repositories\ProductRepository;

/**
 * Class ProductService
 * @package App\Services\Admin
 */
class ProductService {

	private $productRepo;

	/**
	 * @param ProductRepository $productRepo
	 */
	public function __construct(ProductRepository $productRepo) {
		$this->productRepo = $productRepo;
	}

	/**
	 * Get all products.
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getProducts() {
		return $this->productRepo->getProducts();
	}

	/**
	 * Get a product by id.
	 * @param $id
	 * @return mixed
	 */
	public function getProduct($id) {
		return $this->productRepo->getProduct($id);
	}
}