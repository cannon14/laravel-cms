<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\StaticPageService;

/**
 * Class StaticPageController
 * @package cccomus\Http\Controllers\Admin
 */
class StaticPageController extends Controller
{

	private $pageService;

	/**
	 * @param StaticPageService $pageService
	 */
	function __construct(StaticPageService $pageService) {
		$this->pageService = $pageService;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('cccomus-admin.pages.static.index');
    }

	/**
	 * Get pages
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPages(Request $request) {
		return response()->json($this->pageService->getPages($request->all()));
	}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('cccomus-admin.pages.static.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request, $this->getRules(),$this->getMessages());

		$message = $this->pageService->create($request->all());

		return response()->json(['message'=>$message]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('cccomus-admin.pages.static.edit');
    }

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPage($id) {

		$page = $this->pageService->getPage($id);

		return response()->json(['pg'=>$page]);
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

		$this->validate($request, $this->getRules(), $this->getMessages());

		$message = $this->pageService->update($id, $request->all());

		return response()->json(['message'=>$message]);
    }

	/**
	 * Update a page's status
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateStatus($id, Request $request) {
		return response()->json(['message'=>$this->pageService->updateStatus($id, $request->all())]);
	}


	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message'=>$this->pageService->delete($id)]);
    }

	private function getRules() {
		return [
			'active' => 'required',
			'title' => 'required',
			'slug' => 'required'
		];

	}

	private function getMessages() {
		return [
			'active.required' => 'Page Status must be Active or Inactive',
			'title.required' => 'Title is Required',
			'slug.required' => 'Slug is Required'
		];
	}
}
