<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 12/29/15
 * Time: 8:39 PM
 */

namespace cccomus\Traits;

/**
<<<<<<< Updated upstream
 * Trait FileTrait
 * @package cccomus\Traits
 */
trait FileTrait {

	/**
	 * @param string $filename
	 * @param string $delimiter
	 * @return array|bool
	 */
	public function readCsvFileToArray($filename = '', $delimiter = ',') {

		if (!file_exists($filename) || !is_readable($filename)) {
			return false;
		}

		$header = NULL;

		$data = array();

		if (($handle = fopen($filename, 'r')) !== FALSE) {
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
				if (!$header) {
					$header = $row;
				}
				else {
					if(count($header) === count($row)) {
						$data[] = array_combine($header, $row);
					}
				}
			}
			fclose($handle);
		}
		return $data;
	}
}