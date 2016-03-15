<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/15/15
 * Time: 10:28 AM
 */

namespace cccomus\Repositories\Admin;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

/**
 * Class CodeRepository
 * @package cccomus\Repositories\Admin
 */
class CodeRepository {

	/**
	 * Write/Create a file.
	 * @param $file
	 * @param $contents
	 * @return bool
	 */
	public function writeFile($file, $contents) {

		$bytes_written = File::put($file, $contents);

		if ($bytes_written === false) {
			return false;
		}

		return true;
	}

	/**
	 * Read a file.
	 * @param $file
	 * @return null|string
	 */
	public function readFile($file) {

		$contents = null;

		try {
			$contents = File::get($file);
		}
		catch (FileNotFoundException $exception) {
			return null;
		}

		return $contents;
	}

	/**
	 * Check if file exists.
	 * @param $file
	 * @return mixed
	 */
	public function exists($file) {
		return File::exists($file);
	}
}