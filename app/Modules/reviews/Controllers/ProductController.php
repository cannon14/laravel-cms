<?php
/**
 * Class SiteController
 * @author David Cannon
 * @date 20 Oct 14
 */
namespace Modules\ProductReviewsModule\Controllers;

use Modules\ProductReviewsModule\Services\ProductService;

use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package Modules\ProductReviewsModule\Controllers
 */
class ProductController extends Controller {

	private $productService;

	/**
	 * @param ProductService $productService
	 */
	public function __construct(ProductService $productService) {

		$this->productService= $productService;
	}

	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$products = $this->productService->getProducts();

		return view('cccomus-admin.modules.reviews.products.index', ['products' => $products]);
	}


	/**
	 * Display the specified product.
	 * @param $id
	 * @return mixed
	 */
	public function show($id) {

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return mixed
	 */
	public function edit($id) {
		$product = $this->productService->getProduct($id);

		return view('products.edit', array('product' => $product));
	}
}
