<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/13/15
 * Time: 11:15 PM
 */

namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\CodeRepository;
use cccomus\Repositories\Admin\TemplateRepository;

/**
 * Class CodeService
 * @package cccomus\Services\Admin
 */
class CodeService {

	private $codeRepo;
	private $templateRepo;

	/**
	 * @param CodeRepository $codeRepo
	 * @param TemplateRepository $templateRepo
	 */
	function __construct(CodeRepository $codeRepo, TemplateRepository $templateRepo) {
		$this->codeRepo = $codeRepo;
		$this->templateRepo = $templateRepo;
	}

	/**
	 * Write a file based on page.
	 * @param $templateId
	 * @param $attributes
	 * @return bool
	 */
	public function writeFile($templateId, $attributes) {
		$content = array_get($attributes, 'content');

		$file = $this->getFilePath($templateId);

		return $this->codeRepo->writeFile($file, $content);
	}

	/**
	 * Get code by node id.
	 * @param $templateId
	 * @return null|string
	 */
	public function getCodeByTemplateId($templateId) {

		$filePath = $this->getFilePath($templateId);

		if(!$this->codeRepo->exists($filePath)) {
			$this->codeRepo->writeFile($filePath, '');
		}

		$contents = $this->codeRepo->readFile($filePath);

		return $contents;
	}

	/**
	 * Get the asset file.
	 * @param $templateId
	 * @return string
	 */
	private function getFilePath($templateId) {

		$template = $this->templateRepo->getObject($templateId);

		return $template->path;
	}
}