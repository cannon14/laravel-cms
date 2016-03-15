<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\MediaType;

/**
 * Class MediaRepository
 * @package cccomus\Repositories\Admin
 */
class MediaTypeRepository  {


	/**
	 * Get a list of media types.
	 * @return mixed
	 */
	public function getMediaTypeList() {
		return MediaType::lists('name', 'media_type_id');
	}

}