<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;
use ReflectionClass;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\TemplateService;

/**
 * Class TemplateController
 * @package cccomus\Http\Controllers\Admin
 */
class TemplateController extends Controller
{

	private $templateService;

	/**
	 * @param TemplateService $templateService
	 */
	function __construct(TemplateService $templateService) {
		$this->templateService = $templateService;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$this->templateService->readAllTemplates();

		return view('cccomus-admin.templates.index');
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getTemplatesAjax(Request $request) {

		$attributes = $request->all();


		return response()->json($this->templateService->getTemplates($attributes));
	}
}
