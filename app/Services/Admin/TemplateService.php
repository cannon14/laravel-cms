<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\TemplateRepository;
use cccomus\Repositories\Admin\TemplateTypeRepository;

use Illuminate\Support\Facades\File;

/**
 * Class TemplateService
 * @package cccomus\Services
 */
class TemplateService {

	private $templateTypeRepo;
	private $templateRepo;

	/**
	 * @param TemplateRepository $templateRepo
	 * @param TemplateTypeRepository $templateTypeRepo
	 */
	function __construct(TemplateRepository $templateRepo, TemplateTypeRepository $templateTypeRepo) {
		$this->templateRepo = $templateRepo;
		$this->templateTypeRepo = $templateTypeRepo;
	}

	/**
	 * Read all templates
	 */
	public function readAllTemplates() {

		//Flag all as orphaned so we can see the ones that are not after reading templates.
		$this->templateRepo->setOrphaned();

		$files = File::allFiles(base_path('/resources/views/cccomus/templates'));

		foreach ($files as $file) {
			$this->readTemplate($file);
		}

		//Delete orphaned file rows.
		$this->templateRepo->deleteOrphaned();
	}

	/**
	 * Read template
	 * @param $file
	 */
	public function readTemplate($file) {

		$filename = $file->getFileName();
		$filePath = $file->getPathname();

		$contents = \File::get($filePath);

		$docComments = array_filter(
			token_get_all($contents), function ($entry) {
			return $entry[0] == T_DOC_COMMENT;
		}
		);
		$fileDocComment = array_shift($docComments);

		$search = ['/**', '*', '*/'];
		$commentBlock = str_replace($search, '', $fileDocComment[1]);

		$lines = explode(PHP_EOL, $commentBlock);

		$data = [];
		$data['filename'] = $filename;
		$data['path'] = $filePath;
		foreach ($lines as $key => $value) {
			$values = explode(':', $value);
			if (count($values) > 1) {
				$data[trim(strtolower($values[0]))] = trim($values[1]);
			}
		}
		$this->templateRepo->createOrUpdate($data);
	}

	/**
	 * Get all templates
	 * @param $attributes
	 * @return \stdClass
	 */
	public function getTemplates($attributes) {

		$count = array_get($attributes, 'count');
		$page = array_get($attributes, 'page');
		$sorting = array_get($attributes, 'sorting');
		$sortBy = key($sorting);
		$dir = $sorting[$sortBy];
		$filters = array_get($attributes, 'filter', []);

		$data = new \stdClass();
		$data->totalRecords = $this->templateRepo->count($filters);
		$data->templates = $this->templateRepo->getObjects($count, $page, $sortBy, $dir, $filters);

		return $data;
	}

	/**
	 * Get a template by id.
	 * @param $id
	 * @return mixed
	 */
	public function getTemplate($id) {
		return $this->templateRepo->getObject($id);
	}

}