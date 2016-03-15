<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use cccomus\Services\Admin\CardService;

/**
 * Class CardController
 * @package cccomus\Http\Controllers\Admin
 */
class CardController extends Controller
{
	private $cardService;

	function __construct(CardService $cardService) {
		$this->cardService = $cardService;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('Getting Cards');
        return view('cccomus-admin.cards.index');
    }

    /**
     * Get cards and return to view.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCards(Request $request) {
        $attributes = $request->all();

        return response()->json($this->cardService->getCards($attributes));
    }

	/**
	 * Get a list of cards
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getCardsList() {

		return response()->json($this->cardService->getCardsList());
	}

    /**
     * Get a card
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCard($id) {
        return response()->json($this->cardService->getCard($id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
		return view('cccomus-admin.cards.edit');
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
        return response()->json(['message'=>$this->cardService->update($id, $request->all())]);
    }

	/**
	 * Update a cards status
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updateStatus($id, Request $request) {
		return response()->json(['message'=>$this->cardService->updateStatus($id, $request->all())]);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->cardService->delete($id);

        return response()->json(['message'=>$message]);
    }
}
