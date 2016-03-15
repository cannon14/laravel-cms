<?php

namespace cccomus\Http\Controllers\Admin;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\PublishService;

class DashboardController extends Controller
{

	private $publishService;

	/**
	 * @param PublishService $publishService
	 */
	function __construct(PublishService $publishService) {
		$this->publishService = $publishService;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.dashboard.index');
    }

	public function publishToStaging() {

		$errors = $this->publishService->publishToStaging();

		return response()->json(['errors'=>$errors]);
	}

	public function publishToProduction() {
		return response()->json(['errors' => $this->publishService->publishToProduction()]);

	}

	public function syncDatabase() {

	}

}
