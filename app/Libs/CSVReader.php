<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 1/7/15
 * Time: 10:31 AM
 */

namespace cccomus\Libs;


class CSVReader extends Reader {

	private $columns;
	private $lineCount;

	function __construct($filePath) {
		parent::__construct($filePath);
		$this->columns = array();
		$this->lineCount = 0;
	}

	/**
	 * Read file into an array.
	 * @param string
	 */
	public function readFile() {

		//Get the path to the file to be read.
		$filePath = $this->getFilePath();

		//Check if file exists and is readable, if it is, then continue with read.
		if ($this->fileExists($filePath) && $this->isReadable($filePath)) {
			//Open file for read only.
			$handle = fopen($filePath, "r");
			//Start counting the number of lines in file.  -1 accounts for the column header.
			$lines = -1;
			//While rows exits, push to content array and increment line count.
			while ($row = fgetcsv($handle)) {
				array_push($this->content, $row);
				$lines++;
			}
			$this->lineCount = $lines;
			//Close the file.
			fclose($handle);

			//Call this method to pull the column headers out and format them.
			$this->setColumns();

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the content of the file.
	 * @return array
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param $start
	 * @param $chunk_size
	 * @return Array $chunked_array
	 */
	public function getContentChunk($index, $chunk_size) {
		//Break the array down into a 3D array of chunks based on chunk size.
		$chunked_array = array_chunk($this->content, $chunk_size);

		return $chunked_array[$index];
	}

	/**
	 * @return array
	 */
	public function getColumns() {
		return $this->columns;
	}

	/**
	 * //Get the first row of content which should be the column titles.
	 * @return array
	 */
	public function setColumns() {
		//Remove the first row, which should be column names.
		$columns = array_shift($this->content);
		$prepared_columns = array();

		//Loop through columns, lowercase them, and replace spaces and other search values with an _.
		foreach ($columns as $c) {
			//Values we need to find and replace.
			$search_values = array(' ', "\n");
			//Replace search values with underscores.
			$columnReady = str_replace($search_values, '_', strtolower($c));
			//Put prepared value on columns array.
			array_push($prepared_columns, $columnReady);
		}

		$this->columns = $prepared_columns;
	}

	/**
	 * Gets the number of lines in a CSV file.
	 * @param $file_path
	 * @return int
	 */
	public function getNumLines() {
		return $this->lineCount;
	}

	/**
	 * Test if file is readable.
	 * @param $filePath
	 * @return bool
	 */
	public function isReadable($filePath) {
		return is_readable($filePath);
	}

	/**
	 * Test if file exists.
	 * @param $filePath
	 * @return bool
	 */
	public function fileExists($filePath) {
		return file_exists($filePath);
	}
}