<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 1/5/16
 * Time: 5:36 PM
 */

namespace cccomus\Libs\Maps;

/**
 * Interface Maps
 * @package cccomus\Modules\Libs\maps
 */
interface Map {

	/**
	 * Required Columns
	 * @return array
	 */
	public function columns();
}