<?php
/**
 * Created by PhpStorm.
 * User: davidcannon
 * Date: 11/30/14
 * Time: 9:56 AM
 */

namespace cccomus\Libs;

/**
 * Class CacheHelper
 * @package cccomus\Libs
 */
class CacheHelper {

	/**
	 * Create a unique cache key.
	 *
	 * @param $input
	 * @param $id
	 * @return string
	 */
	public static function createCacheKey($input, $id) {

		//Start the key off with an ID.
		$key = $id;

		//Add the input values
		foreach ($input as $data) {
			$key .= $data;
		}

		return $key;

	}
} 