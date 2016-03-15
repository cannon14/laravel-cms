<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 7/25/15
 * Time: 2:48 PM
 */
namespace App\Services\Admin;

use App\Repositories\UserRepository;
use App\Repositories\AclRepository;
use App\Models\User;

class UserService {

	private $user;
	private $acl;

	/**
	 * Constructor
	 * @param UserRepository $user
	 * @param AclRepository $acl
	 */
	public function __construct(UserRepository $user, AclRepository $acl) {

		$this->user = $user;
		$this->acl = $acl;
	}

	/**
	 * Get all users
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function getAllUsers() {
		return $this->user->getAll();
	}

	/**
	 * Get a user by its ID.
	 * @param $id
	 * @return mixed
	 */
	public function getUserById($id) {
		return $this->user->getById($id);
	}

	public function getAclList() {
		return $this->acl->getList();
	}

	/**
	 * Create a user.
	 * @param array $attributes
	 * @return bool
	 */
	public function create(array $attributes) {
		$user = $this->user->create($attributes);

		return $user instanceof User;
	}

	/**
	 * Update a user
	 * @param $id
	 * @param array $attributes
	 * @return mixed
	 */
	public function update($id, array $attributes) {
		return $this->user->update($id, $attributes);
	}

	/**
	 * Delete a user
	 * @param $id
	 * @return mixed
	 */
	public function delete($id) {
		return $this->user->delete($id);
	}
}