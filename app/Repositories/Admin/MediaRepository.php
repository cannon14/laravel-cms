<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\Media;

/**
 * Class MediaRepository
 * @package cccomus\Repositories\Admin
 */
class MediaRepository extends Repository {


	public function createObject() {
		return new Media();
	}

	public function getTablesToJoin() {
		return ['media_types'=>'media_type_id'];
	}

	/**
	 * Create media
	 * @param array $attributes
	 * @return bool
	 */
	public function create(array $attributes) {

		$exists = Media::where('filename', array_get($attributes, 'filename'))->first();

		if(!$exists) {
			$media = new Media();

			$media->name = array_get($attributes, 'name');
			$media->filename = array_get($attributes, 'filename');
			$media->media_type_id = array_get($attributes, 'media_type_id', 1);

			return $media->save();
		}
		return false;
	}

	/**
	 * Get a list of media by type.
	 * @return mixed
	 */
	public function getMediaList($mediaTypeId) {
		return Media::where('media_type_id', $mediaTypeId)->lists('name', 'media_id');
	}

}