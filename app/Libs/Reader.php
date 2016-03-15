<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 1/12/15
 * Time: 9:36 AM
 */

namespace Cannon;

abstract class Reader {

	protected $filePath;
	protected $content;

	/**
	 * @param String $file_path
	 */
	public function __construct($filePath) {
		$this->filePath = $filePath;
		$this->content = array();
	}

	/**
	 * @return String $file_path
	 */
	public function getFilePath() {
		return $this->filePath;
	}

	/**
	 * @return mixed
	 */
	protected abstract function readFile();

	/**
	 * @return Array $content
	 */
	protected abstract function getContent();

}