<?php
namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\FeedService;

/**
 * Class FeedController
 * @package cccomus\Http\Controllers\Admin
 */
class FeedController extends Controller
{
	private $feedService;

	function __construct(FeedService $feedService) {
		$this->feedService = $feedService;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cccomus-admin.feeds.index');
    }

    /**
     * Get the feeds
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFeeds(Request $request) {
        $attributes = $request->all();

        return response()->json($this->feedService->getFeeds($attributes));
    }

	public function getFeed($id) {
		return response()->json($this->feedService->getFeed($id));
	}
    /**
     * Update product from feeds
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
	public function pullCardsFromFeed($id) {

		$errors = $this->feedService->updateCards($id);

        return response()->json(['errors'=>$errors]);

	}

	/**
	 * Update issuers from feeds
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pullIssuersFromFeed($id) {
		$errors = $this->feedService->updateIssuers($id);

		return response()->json(['errors'=>$errors]);
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function pullCategoriesFromFeed($id) {

		$errors = $this->feedService->updateCategories($id);

		return response()->json(['errors'=>$errors]);
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cccomus-admin.feeds.create');
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

        $message = $this->feedService->updateOrCreate($request->all());

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
        return view('cccomus-admin.feeds.edit');
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

        $message = $this->feedService->updateOrCreate($request->all(), $id);

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
        $message = $this->feedService->delete($id);

        return response()->json(['message'=>$message]);
    }

	private function getRules() {
		return [
			'name' => 'required',
			'url' => 'required',
			'key' => 'required',
		];
	}

	private function getMessages() {
		return [
			'name.required' => 'Name is Required',
			'url.required' => 'URL is Required',
			'key.required' => 'Key is Required',
		];
	}
}
