<?php
/**
 * Created by PhpStorm.
 * User: davidc
 * Date: 11/16/15
 * Time: 3:07 PM
 */

namespace cccomus\Repositories\Admin;

/**
 * Class Repository
 * @package cccomus\Repositories\Admin
 */
abstract class Repository {

	/**
	 * Create an object
	 * @return mixed
	 */
	abstract public function createObject();

	/**
	 * Get the tables that need to be joined with the object
	 * @return mixed
	 */
	abstract public function getTablesToJoin();

	/**
	 * Get all objects.
	 * @param null $count
	 * @param null $page
	 * @param null $sortBy
	 * @param null $dir
	 * @param $filters
	 * @return mixed
	 */
	public function getObjects($count = null, $page = null, $sortBy = null, $dir = null, $filters=[]) {

		//Get the Object Class
		$object = $this->createObject();
		//Get the table associated with the object
		$objectTable = $object->getTable();
		//Get any tables that need to be joined with the objectTable
		$joins = $this->getTablesToJoin();
		//Select
		$query = $object::select($objectTable.'.*');

		//Create any joins
		foreach($joins as $joiningTable=>$primaryKey) {
			$query->join($joiningTable, $objectTable.'.'.$primaryKey, '=', $joiningTable.'.'.$primaryKey);
		}

		//Apply any filters
		foreach($filters as $table=>$columns) {
			$columns = json_decode(str_replace('\\', '', $columns));
			foreach($columns as $column=>$value) {
				if($value != '') {
					$query->where($table . '.' . $column, 'like', '%'.$value.'%');
				}
			}
		}

		//Sort By
		if(!is_null($sortBy)) {
			$query->orderBy($sortBy, $dir);
		}

		//Page Number
		if(!is_null($page)) {
			$query->skip(($page-1)*$count);
		}

		//Get specified number of records
		if(!is_null($count)) {
			$query->take($count);
		}

		//Execute and return query
		return $query->get();

	}

	/**
	 * Find an object by ID
	 * @param $id
	 * @return mixed
	 */
	public function getObject($id) {
		$object = $this->createObject();

		return $object::find($id);
	}

	/**
	 * Delete an object by ID
	 * @param $id
	 * @return mixed
	 */
	public function deleteObject($id) {
		$object = $this->createObject();

		return $object::destroy($id);
	}

	/**
	 * Get a count of objects
	 * @param array $filters
	 * @return mixed
	 */
	public function count($filters=[]) {
		//Get the Object Class
		$object = $this->createObject();
		//Get the table associated with the object
		$objectTable = $object->getTable();
		//Get any tables that need to be joined with the objectTable
		$joins = $this->getTablesToJoin();
		//Select
		$query = $object::select($objectTable.'.*');

		//Create any joins
		foreach($joins as $joiningTable=>$primaryKey) {
			$query->join($joiningTable, $objectTable.'.'.$primaryKey, '=', $joiningTable.'.'.$primaryKey);
		}

		//Apply any filters
		foreach($filters as $table=>$columns) {
			$columns = json_decode(str_replace('\\', '', $columns));
			foreach($columns as $column=>$value) {
				if($value != '') {
					$query->where($table . '.' . $column, 'like', '%'.$value.'%');
				}
			}
		}

		return $query->count();
	}

}