<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use cccomus\Models\Template;

/**
 * Class TemplateRepository
 * @package cccomus\Repositories\Admin
 */
class TemplateRepository extends Repository {


	public function createObject() {
		return new Template();
	}

	public function getTablesToJoin() {
		return [
		];
	}

	/**
	 * Create a new template entry from file
	 * @param $attributes
	 * @return bool
	 */
	public function createOrUpdate($attributes) {

		//First check for the existence of the template for update.
		$template = Template::where('name', $attributes['name'])
				->where('version', $attributes['version'])
				->where('date', $attributes['date'])
				->first();

		//If no template is found...create one.
		if(is_null($template)) {
			$template = new Template();
		}

		$template->name = array_get($attributes, 'name');
		$template->type = array_get($attributes, 'type');
		$template->filename = array_get($attributes, 'filename');
		$template->path = array_get($attributes, 'path');
		$template->description = array_get($attributes, 'description');
		$template->version = array_get($attributes, 'version');
		$template->slug = str_replace('.blade.php', '', array_get($attributes, 'filename'));
		$template->date = array_get($attributes, 'date');
		$template->orphaned_file = 0;

		return $template->save();
	}

	/**
	 * Set all files to orphaned status
	 * @return mixed
	 */
	public function setOrphaned() {
		return Template::where('orphaned_file', 0)->update(['orphaned_file' => 1]);
	}

	/**
	 * Delete orphaned files
	 * @return mixed'
	 */
	public function deleteOrphaned() {
		return Template::where('orphaned_file', 1)->delete();
	}

	/**
	 * Get a list of templates.
	 * @param $type
	 * @return static
	 */
	public function getTemplateList($type) {
		return Template::lists('name', 'template_id');
	}

}