<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\Issuer;
use cccomus\Traits\SlugGenerator;

/**
 * Class IssuerRepository
 * @package cccomus\Repositories\Admin
 */
class IssuerRepository extends Repository {

	use SlugGenerator;

	public function createObject() {
		return new Issuer();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Create an issuer
	 * @param $attributes
	 * @return bool
	 */
	public function create($attributes) {
		$issuer = new Issuer();

		$issuer->name = array_get($attributes, 'name');
		$issuer->slug = array_get($attributes, 'slug');
		$issuer->active = array_get($attributes, 'active', 1);
		$issuer->logo = array_get($attributes, 'logo');

		return $issuer->save();
	}

	/**
	 * Update an issuer.
	 * @param $issuerId
	 * @param $attributes
	 * @return mixed
	 */
	public function update($issuerId, $attributes) {
		$issuer = Issuer::find($issuerId);

		$issuer->name = array_get($attributes, 'name');
		$issuer->slug = array_get($attributes, 'slug');
		$issuer->active = array_get($attributes, 'active');
		$issuer->logo = array_get($attributes, 'logo');

		return $issuer->save();
	}

	/**
	 * @param $attributes
	 * @return mixed
	 */
	public function updateOrCreateFromFeed($attributes) {

		$attributes = array_dot($attributes);

		$issuer = Issuer::find($attributes['issuer_id.id']);

		if(is_null($issuer)) {
			$issuer = new Issuer();
		}

		$issuer->issuer_id = array_get($attributes, 'issuer_id.id');
		$issuer->name = array_get($attributes, 'issuer_id.name');
		$issuer->slug = $this->createSlug(array_get($attributes, 'issuer_id.name'));
		$issuer->active = array_get($attributes, 'active', (isset($issuer->active) ? $issuer->active : 1));

		return $issuer->save();
	}

	/**
	 * Set a issuer's status to active or inactive.
	 * @param $id
	 * @param array $attributes
	 * @return mixed
	 */
	public function setStatus($id, array $attributes) {
		$issuer = Issuer::find($id);
		$issuer->active = array_get($attributes, 'active');
		return $issuer->save();
	}

	/**
	 * Get a list of issuers.
	 * @return mixed
	 */
	public function getIssuersList() {
		return Issuer::lists('name', 'issuer_id');
	}

}