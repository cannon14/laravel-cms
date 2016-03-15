<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\MediaRepository;

/**
 * Class MediaService
 * @package cccomus\Services\Admin
 */
class MediaService {

	private $mediaRepo;

	/**
	 * @param MediaRepository $mediaRepo
	 */
	function __construct(MediaRepository $mediaRepo) {
		$this->mediaRepo = $mediaRepo;
	}

	/**
	 * Get all media
	 * @param array $attributes
	 * @return \stdClass
	 */
	public function getMedia(array $attributes) {

		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->mediaRepo->count($filters);
		$data->issuers = $this->mediaRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		return $data;
	}


	/**
	 * Get a list of images (media_type_id is 1 for images)
	 * @return mixed
	 */
	public function getImageList() {
		return $this->mediaRepo->getMediaList(1);
	}

	/**
	 * Upload media
	 * @param array $attributes
	 * @return bool
	 */
	public function upload(array $attributes) {
		//Get the file to upload
		$file = array_pull($attributes, 'file');
		//Get the filename
		$attributes['filename'] = $attributes['name'] = $filename = $file->getClientOriginalName();
		//Get the tmp path where file was uploaded
		$tmpPath = $file->getPathName();
		//Get the destination to move file.
		$destination = public_path('/cccomus-assets/images/'.$filename);
		//Move the file.
		move_uploaded_file($tmpPath, $destination);

		return $this->mediaRepo->create($attributes);


	}


	/**
	 * Delete an issuer.
	 * @param $mediaId
	 * @return int
	 */
	public function delete($mediaId) {
		return $this->mediaRepo->deleteObject($mediaId);
	}

}