<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\MediaService;

class MediaController extends Controller
{

	private $mediaService;

	/**
	 * @param MediaService $mediaService
	 */
	function __construct(MediaService $mediaService) {
		$this->mediaService = $mediaService;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.media.index');
    }

	/**
	 * Get all media.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getMedia(Request $request) {
		$attributes = $request->all();

		return response()->json($this->mediaService->getMedia($attributes));
	}

    /**
     * Show the form for uploading a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('cccomus-admin.media.upload');
    }

	public function processUploads(Request $request) {
		$attributes = $request->all();

		return response()->json(['message' => $this->mediaService->upload($attributes)]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    }


	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message'=>$this->$mediaService->delete($id)]);
    }
}
