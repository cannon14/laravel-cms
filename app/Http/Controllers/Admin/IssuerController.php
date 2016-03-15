<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\IssuerService;
use cccomus\Services\Admin\MediaService;

class IssuerController extends Controller
{

	private $issuerService;
	private $mediaService;

	/**
	 * @param IssuerService $issuerService
	 * @param MediaService $mediaService
	 */
	function __construct(IssuerService $issuerService, MediaService $mediaService) {
		$this->issuerService = $issuerService;
		$this->mediaService = $mediaService;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.issuers.index');
    }

	/**
	 * Get all issuers.
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getIssuers(Request $request) {
		$attributes = $request->all();

		return response()->json($this->issuerService->getIssuers($attributes));
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cccomus-admin.issuers.create');
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

		$message = $this->issuerService->create($request->all());

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
        return view('cccomus-admin.issuers.edit');
    }

	/**
	 * Get an issuer.
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getIssuer($id) {
		$issuer = $this->issuerService->getIssuer($id);
		$imageList = $this->mediaService->getImageList();

		return response()->json(['issuer'=>$issuer, 'images'=>$imageList]);
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

        $message = $this->issuerService->update($id, $request->all());

        return response()->json(['message'=>$message]);
    }

	/**
	 * Update an issuer's status
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateStatus($id, Request $request) {
		return response()->json(['message'=>$this->issuerService->updateStatus($id, $request->all())]);
	}


	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message'=>$this->issuerService->delete($id)]);
    }

	/**
	 * Get validation rules
	 * @return array
	 */
	private function getRules() {
		return [
			'name' => 'required',
			'active' => 'required',
			//'logo' => 'mimes:jpeg,jpg,bmp,png,gif',
			'slug' => 'required'
		];
	}

	/**
	 * Get validation messages
	 * @return array
	 */
	private function getMessages() {
		return [
			'name.required' => 'Issuer Name is Required',
			'active.required' => 'Issuer State must be active or inactive',
			//'logo.mimes' => 'Logo must be of type jpg, jpeg, bmp, gif, or png',
			'slug.required' => 'Slug is required'
		];
	}
}
