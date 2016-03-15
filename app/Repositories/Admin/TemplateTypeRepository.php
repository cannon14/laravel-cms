<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\TemplateType;

/**
 * Class TemplateTypeRepository
 * @package cccomus\Repositories\Admin
 */
class TemplateTypeRepository extends Repository {


	public function createObject() {
		return new TemplateType();
	}

	public function getTablesToJoin() {
		return [];
	}

}