<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 12/7/15
 * Time: 6:25 PM
 */

namespace cccomus\Factories;


class AssetFactory {

	/**
	 * Return a class
	 * @param $classname
	 * @return mixed
	 */
	public static function create($classname)
	{
		return new $classname;
	}
}