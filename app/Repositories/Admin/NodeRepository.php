<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\Node;

/**
 * Class NodeRepository
 * @package cccomus\Repositories
 */
class NodeRepository {

	/**
	 * Get all nodes.
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getNodes() {
		return Node::all();
	}

	/**
	 * Get a node by id.
	 * @param $nodeId
	 * @return mixed
	 */
	public function getNode($nodeId) {
		return Node::find($nodeId);
	}

	/**
	 * Get the root node.
	 * @return mixed
	 */
	public function getRootNode() {
		return Node::where('parent_id', 0)
			->where('title', '/')
			->where('type', 'directory')->first();
	}

	/**
	 * Get all nodes by type.
	 * @return mixed
	 */
	public function getNodesByType($type) {
		return Node::where('type', $type)
			->get();
	}

	/**
	 * d
	 */
	public function getNodeByTemplateTypeId($id) {
		return Node::select('nodes.*')
			->join('template_types', 'template_types.type', '=', 'nodes.title')
			->where('template_types.template_type_id', $id)
			->first();
	}

	/**
	 * Get all nodes of a parent node.
	 * @param $parentId
	 * @return mixed
	 */
	public function getNodesByParent($parentId) {
		return Node::where('parent_id', $parentId)
			->get();
	}

	/**
	 * Get a parent node.
	 * @param $parentId
	 * @return mixed
	 */
	public function getParent($parentId) {
		return Node::where('parent_id', $parentId)->first();
	}

	/**
	 * Check if a node has children.
	 * @param $nodeId
	 * @return bool
	 */
	public function hasChildren($nodeId) {
		$count = Node::where('parent_id', $nodeId)->count();

		return $count > 0;
	}

	/**
	 * Create a node
	 * @param $objectId
	 * @param $title
	 * @param $type
	 * @return mixed
	 */
	public function create($objectId, $title, $type) {

		$node = Node::where('type', $type)
			->where('title', $title)
			->first();

		if(is_null($node)) {
			return false;
		}

		$newNode = new Node();
		$node->title = $title;
		$node->type = $type;
		$node->parent_id = $parentId;

		$node->save();

		return $node;

	}

	/**
	 * Delete a node.
	 * @param $id
	 * @return int
	 */
	public function delete($id) {
		return Node::destroy($id);
	}

}