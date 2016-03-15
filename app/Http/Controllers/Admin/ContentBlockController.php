<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\ContentBlockService;

class ContentBlockController extends Controller
{
	private $contentBlockService;

	/**
	 * @param ContentBlockService $contentBlockService
	 */
	function __construct(ContentBlockService $contentBlockService) {
		$this->contentBlockService = $contentBlockService;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.content-blocks.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function getContentBlocksAjax(Request $request) {
		$attributes = $request->all();
		return response()->json($this->contentBlockService->getContentBlocks($attributes));
	}

    /**
     * Get a list of content blocks
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContentBlocksList() {

        return response()->json($this->contentBlockService->getContentBlocksList());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cccomus-admin.content-blocks.create');
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

		$message = $this->contentBlockService->updateOrCreate($request->all());

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('cccomus-admin.content-blocks.edit');
    }

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getContentBlock($id) {

		$contentBlock = $this->contentBlockService->getContentBlock($id);

		return response()->json(['content_block' => $contentBlock]);
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

		$message = $this->contentBlockService->updateOrCreate($request->all(), $id);

		return response()->json(['message'=>$message]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message'=>$this->contentBlockService->delete($id)]);
    }

	private function getRules() {
		return [
			'name' => 'required',
		];
	}

	private function getMessages() {
		return [
			'name.required' => 'Content Block Name is Required',
		];
	}
}
