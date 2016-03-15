<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

/**
 * Class SiteController
 * @package cccomus\Http\Controllers\Admin
 */
class SiteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function help() {
		return view('cccomus-admin.help.index');
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
        return view('cccomus-admin.cards.index');
    }

}
