<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\CategoryService;
use cccomus\Services\Admin\MediaService;

/**
 * Class CategoryController
 * @package cccomus\Http\Controllers\Admin
 */
class CategoryController extends Controller
{

    private $categoryService;
	private $mediaService;

	/**
	 * @param CategoryService $categoryService
	 * @param MediaService $mediaService
	 */
    function __construct(CategoryService $categoryService, MediaService $mediaService) {
        $this->categoryService = $categoryService;
		$this->mediaService = $mediaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.categories.index');
    }

    /**
     * Get categories and return to view.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request) {
        $attributes = $request->all();

        return response()->json($this->categoryService->getCategories($attributes));
    }

	/**
	 * Get a category.
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCategory($id) {

		$categories = $this->categoryService->getCategory($id);
		$imageList = $this->mediaService->getImageList();


		return response()->json(['category'=>$categories, 'images'=>$imageList]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cccomus-admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
	{

        $this->validate($request, $this->getRules(), $this->getMessages());

        return response()->json(['message'=>$this->categoryService->updateOrCreate($request->all())]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cccomus-admin.categories.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

		$this->validate($request, $this->getRules(), $this->getMessages());

		return response()->json(['message'=>$this->categoryService->updateOrCreate($request->all(), $id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message'=>$this->categoryService->delete($id)]);
    }

	/**
	 * Update a category's status
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateStatus($id, Request $request) {
		return response()->json(['message'=>$this->categoryService->updateStatus($id, $request->all())]);
	}

	/**
	 * Get validation rules
	 */
	private function getRules() {
		return [
			'active' => 'required',
			'name' => 'required',
			//'logo' => 'mimes:jpeg,jpg,bmp,png,gif',
			'description' => 'required',
			'slug' => 'required'
		];
	}

	/**
	 * Get validation messages
	 */
	private function getMessages() {
		return [
			'active.required' => 'Category Status must be Active or Inactive',
			'name.required' => 'Category Name is Required',
			//'logo.mimes' => 'Logo must be of type jpg, jpeg, bmp, gif, or png',
			'description.required' => 'Description is Required',
			'slug.required' => 'Path Slug is Required'
		];
	}
}
