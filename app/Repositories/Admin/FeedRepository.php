<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:14 PM
 */

namespace cccomus\Repositories\Admin;

use Exception;
use DB;
use cccomus\Models\Feed;

class FeedRepository extends Repository {

	public function createObject() {
		return new Feed();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Update or Create a Feed
	 * @param $id
	 * @param $attributes
	 * @return static
	 */
	public function updateOrCreate($attributes, $id = null) {

		if(!is_null($id)) {
			$feed = Feed::find($id);
		}
		else {
			$feed = new Feed();
		}

		$feed->name = array_get($attributes, 'name');
		$feed->url = array_get($attributes, 'url');
		$feed->key = array_get($attributes, 'key');
		$feed->active = array_get($attributes, 'active', 1);

		return $feed->save();
	}

}