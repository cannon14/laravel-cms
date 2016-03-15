<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use Illuminate\Support\Facades\Hash;

use cccomus\Models\User;

/**
 * Class UserRepository
 * @package cccomus\Repositories
 */
class UserRepository extends Repository {

	/**
	 * Create a new instance of User
	 * @return User
	 */
	public function createObject() {
		return new User();
	}

	public function getTablesToJoin() {
		return ['acl'=>'acl_id'];
	}

	/**
	 * Update or Create a user
	 * @param $id
	 * @param $attributes
	 * @return static
	 */
	public function updateOrCreate($attributes, $id = null) {

		if(!is_null($id)) {
			$user = User::find($id);
		}
		else {
			$user = new User();
		}

		$user->acl_id = array_pull($attributes, 'acl_id');
		$user->first_name = array_pull($attributes, 'first_name');
		$user->last_name = array_pull($attributes, 'last_name');
		$user->email = array_pull($attributes, 'email');
		$user->username = array_pull($attributes, 'username');
		$user->password = Hash::make(array_pull($attributes, 'password'));
		$user->active = array_pull($attributes, 'active');

		return $user->save();
	}
}