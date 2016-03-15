<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 1/5/16
 * Time: 6:14 PM
 */

namespace cccomus\Libs\Maps;

/**
 * Class ClassMap
 * @package cccomus\Libs\Maps
 */
class ClassMap {

	private static $classMap = [
		'7'	=> 'cccomus\Libs\Maps\Discover',
		'4' => 'cccomus\Libs\Maps\CapitalOne'
	];

	/**
	 * Get the classname base on issuer id
	 * @param $issuerId
	 * @return mixed
	 */
	public static function getClass($issuerId) {
		return self::$classMap[$issuerId];
	}

	/**
	 * Get the classmap
	 */
	public function getClassMap() {

	}

}