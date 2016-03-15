<?php
/**
 * Created by PhpStorm.
 * User: davidc
 * Date: 11/16/15
 * Time: 3:07 PM
 */

namespace cccomus\Repositories\Admin;

/**
 * Class MongoDbRepository
 * @package cccomus\Repositories\Admin
 */
abstract class MongoDbRepository {

	/**
	 * Create an object
	 * @return mixed
	 */
	abstract public function createObject();


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
		//Select
		$query = $object::select($objectTable.'.*');

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
		//Select
		$query = $object::select($objectTable.'.*');

		return $query->count();
	}

}