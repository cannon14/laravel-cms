<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\UserRepository;

/**
 * Class UserService
 * @package cccomus\Services
 */
class UserService {

	private $userRepo;

	/**
	 * @param UserRepository $userRepo
	 */
	function __construct(UserRepository $userRepo) {
		$this->userRepo = $userRepo;
	}

	/**
	 * Get all users
	 * @param $attributes
	 * @return \stdClass
	 */
	public function getUsers($attributes) {

		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->userRepo->count($filters);
		$data->users = $this->userRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		return $data;
	}

	/**
	 * Get a user by id.
	 * @param $id
	 * @return mixed
	 */
	public function getUser($id) {
		return $this->userRepo->getObject($id);
	}

	/**
	 * Create a user
	 * @param int $id
	 * @param $attributes
	 * @return static
	 */
	public function updateOrCreate($attributes, $id = null) {

		$status = $this->userRepo->updateOrCreate($attributes, $id);

		return $status;
	}

	/**
	 * Delete a user.
	 * @param $id
	 * @return mixed
	 */
	public function delete($id) {
		return $this->userRepo->deleteObject($id);
	}

}