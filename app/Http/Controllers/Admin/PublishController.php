<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\PublishService;

class PublishController extends Controller
{
	private $publishService;

	/**
	 * @param PublishService $publishService
	 */
	function __construct(PublishService $publishService) {
		$this->publishService = $publishService;
	}

	public function publishToStaging() {
		return response()->json(['errors' => $this->publishService->publishToStaging()]);
	}

	public function publishToProductions() {

	}

	public function syncDatabase() {

	}
}
