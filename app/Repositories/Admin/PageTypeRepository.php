<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use Illuminate\Support\Facades\DB;

use cccomus\Models\PageType;

/**
 * Class PageTypeRepository
 * @package cccomus\Repositories
 */
class PageTypeRepository extends Repository {


	public function createObject() {
		return new PageType();
	}

	public function getTablesToJoin() {
		return [];
	}

	/**
	 * Page types list
	 * @return mixed
	 */
	public function getPageTypesList() {
		return PageType::lists('name', 'page_type_id');
	}

}