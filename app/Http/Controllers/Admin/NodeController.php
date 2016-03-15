<?php

namespace cccomus\Http\Controllers\Admin;

use Illuminate\Http\Request;

use cccomus\Http\Requests;
use cccomus\Http\Controllers\Controller;

use cccomus\Services\Admin\NodeService;

class NodeController extends Controller
{
    protected $nodeService;

	/**
	 * @param NodeService $nodeService
	 */
    function __construct(NodeService $nodeService) {
        $this->nodeService = $nodeService;
    }

    /**
     * Get all nodes.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNodes() {

        return response()->json(['nodes'=>$this->nodeService->getNodes()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $node = $this->nodeService->create($request->all());

        return response()->json(['node'=>$node]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->nodeService->delete($id);

        return response()->json(['message'=>$message]);
    }
}
