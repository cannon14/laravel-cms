<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\NodeRepository;

/**
 * Class NodeService
 * @package cccomus\Services
 */
class NodeService {

	private $nodeRepo;

	/**
	 * @param NodeRepository $nodeRepo
	 */
	function __construct(NodeRepository $nodeRepo) {
		$this->nodeRepo = $nodeRepo;
	}

	/**
	 * Get all nodes.
	 * @return mixed
	 */
	public function getNodes() {

		return $this->buildNodeTree();
	}


	/**
	 * Build the node tree.
	 * @return array
	 */
	private function buildNodeTree() {

		//Get the initial root node.
		$root = $this->nodeRepo->getRootNode();
		$data = new \stdClass();
		$data->id = $root->node_id;
		$data->title = $root->title;
		$data->type = $root->type;
		$data->nodes = [];

		//Tree array to hold the node structure.
		$tree = [];
		$tree[] = $this->buildNode($data, $root->node_id);

		return $tree;
	}

	/**
	 * Build file and directory nodes recursively
	 * @param $data
	 * @param $parentId
	 * @return mixed
	 */
	private function buildNode($data, $parentId) {

		$nodes = $this->nodeRepo->getNodesByParent($parentId);

		foreach($nodes as $node) {
			$nodeData = new \stdClass();
			$nodeData->id = $node->node_id;
			$nodeData->title = $node->title;
			$nodeData->type = $node->type;
			$nodeData->nodes = [];

			if($node->type == 'directory') {
				$data->nodes[] = $this->buildNode($nodeData, $node->node_id);
			}
			else {
				$data->nodes[] = $nodeData;
			}
		}

		return $data;
	}

	/**
	 * Create a node
	 * @param $attributes
	 * @return static
	 */
	public function create($attributes) {

		$parentNodeId = array_get($attributes, 'node_id');
		$pageTitle = array_get($attributes, 'title');
		$type = array_get($attributes, 'type');

		return $this->nodeRepo->createOrUpdate($parentNodeId, $pageTitle, $type);

	}

	/**
	 * Delete a node.
	 * @param $id
	 * @return int
	 */
	public function delete($id) {
		return $this->nodeRepo->delete($id);
	}

}