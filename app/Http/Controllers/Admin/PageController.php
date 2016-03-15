<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\PageService;
use cccomus\Services\Admin\CardService;

/**
 * Class PageController
 * @package cccomus\Http\Controllers\Admin
 */
class PageController extends Controller
{

	private $pageService;
	private $cardService;

	/**
	 * @param PageService $pageService
	 * @param CardService $cardService
	 */
	function __construct(PageService $pageService, CardService $cardService) {
		$this->pageService = $pageService;
		$this->cardService = $cardService;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.pages.index');
    }

	/**
	 * Display a listing of static resources
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function staticIndex() {
		return view('cccomus-admin.pages.static-index');
	}


	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPagesAjax(Request $request) {
		$attributes = $request->all();

		return response()->json($this->pageService->getPages($attributes));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
		$categories = $this->pageService->getCategoriesList();
		$templates = $this->pageService->getPageTemplatesList();
		$pageTypes = $this->pageService->getPageTypesList();
		$schumerTypes = $this->pageService->getSchumerTemplatesList();

        return view('cccomus-admin.pages.create', ['templates'=>$templates, 'categories'=>$categories, 'pageTypes'=>$pageTypes, 'schumerTypes'=>$schumerTypes]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('cccomus-admin.pages.show', ['page'=>null]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		return view('cccomus-admin.pages.edit');
    }

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getPage($id) {

		$categories = $this->pageService->getCategoriesList();
		$templates = $this->pageService->getPageTemplatesList();
		$pageTypes = $this->pageService->getPageTypesList();
		$schumerTypes = $this->pageService->getSchumerTemplatesList();
		$page = $this->pageService->getPage($id);

		return response()->json(['pg'=>$page, 'templates'=>$templates, 'categories'=>$categories, 'pageTypes'=>$pageTypes, 'schumerTypes'=>$schumerTypes]);
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
	 * Show the card assignment page.
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showCardAssignments($id) {

		$page = $this->pageService->getPage($id);

		return view('cccomus-admin.pages.assign-cards', ['page'=>$page]);
	}

	/**
	 * Get cards assigned to page.
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function assignedCards($id) {

		$cards = $this->pageService->getAssignedCards($id);

		return response()->json($cards);
	}

	/**
	 * Assign a card to a page.
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function assignCards($id, Request $request) {

		$attributes = $request->all();

		$message = $this->pageService->createMapping($id, $attributes);

		return response()->json(['message'=>$message]);
	}

	/**
	 * Unassign a card from a page.
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function unAssignCard($id, Request $request) {
		$attributes = $request->all();

		$message = $this->pageService->deleteMapping($id, $attributes);

		return response()->json(['message'=>$message]);
	}

	/**
	 * Show the content assignment page.
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showContentAssignments($id) {

		$page = $this->pageService->getPage($id);

		return view('cccomus-admin.pages.assign-content', ['page'=>$page]);
	}

	/**
	 * Get content blocks assigned to page.
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function assignedContent($id) {

		$contentBlocks = $this->pageService->getAssignedContent($id);

		return response()->json(['content_blocks'=>$contentBlocks]);
	}

	/**
	 * Assign a content block to a page.
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function assignContent($id, Request $request) {

		$attributes = $request->all();

		$message = $this->pageService->createContentMapping($id, $attributes);

		return response()->json(['message'=>$message]);
	}

	/**
	 * Unassign a content block from a page.
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function unAssignContent($id, Request $request) {
		$attributes = $request->all();

		$message = $this->pageService->deleteContentMapping($id, $attributes);

		return response()->json(['message'=>$message]);
	}

	/**
	 * Order cards
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function order($id, Request $request) {

		$attributes = $request->all();

		$message = $this->pageService->order($id, $attributes);

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
			'template_id' => 'required',
			'page_type_id' => 'required',
			'title' => 'required',
			'image' => 'mimes:gif,jpg,jpeg,bmp,png',
			'slug' => 'required'
		];

	}

	private function getMessages() {
		return [
			'active.required' => 'Page Status must be Active or Inactive',
			'template_id.required' => 'Template Name is Required',
			'page_type_id.required' => 'Page Type is Required',
			'title.required' => 'Title is Required',
			'slug.required' => 'Slug is Required'
		];
	}
}
