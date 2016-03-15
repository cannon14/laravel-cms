<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 7/25/15
 * Time: 2:48 PM
 */
namespace cccomus\Services\Admin;

use cccomus\Repositories\Admin\IssuerRepository;
use cccomus\Lib\CSVReader;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;

class FileService {

	private $issuer;

	/**
	 * File Constructor.
	 */
	public function __construct(IssuerRepository $issuer) {
		$this->issuer = $issuer;
	}

	public function getIssuerList() {
		return $this->issuer->getList();
	}

	/**
	 * Create a Job
	 * @param $file_name
	 * @param $issuer_id
	 * @param $numberOfLines
	 * @return mixed
	 */
	public function createJob($file_name, $issuer_id, $numberOfLines) {
		//Create a job so we can track job status.
		$job = new Job();
		//Add the filename for reference on the front-end during status updates.
		$job->file_name = $file_name;
		//Add the issuer_id for reference on the front-end during status updates
		$job->issuer_id = $issuer_id;
		//Get total number of lines which indicates the number of records.
		$job->total_records = $numberOfLines;
		//Save the job.
		$job->save();

		return $job->job_id;
	}

	public function process($attributes) {

		//Get the issuer id.
		$issuer_id = array_get($attributes, 'issuer_id');
		//The file to be stored.
		$file_name = array_get($attributes, 'csv_file')->getClientOriginalName();
		//File plus storage directory.
		$target_file = "data/" . $file_name;
		//File type for validation
		$fileType = pathinfo($target_file, PATHINFO_EXTENSION);

		// At this time only allow CSV
		if ($fileType != "csv") {
			return ['error', "Sorry, Only CSV Files are Allowed!"];
		}

		//Move the uploaded file to the target directory.
		if (!move_uploaded_file($_FILES["csv_file"]["tmp_name"], $target_file)) {
			return ['error', 'Sorry, there was an error uploading your file.'];
		}

		//Path where uploaded file can be found.
		$file_path = public_path() . '/data/' . $_FILES['csv_file']['name'];

		//Create a CSVReader
		$reader = new CSVReader($file_path);
		//Read the CSV File.
		$reader->readFile();
		//Get the number of lines.
		$numberOfLines = $reader->getNumLines();
		//Get the chunksize from the settings file.
		$chunk_size = Config::get('settings.chunksize');
		//Calculate the number of jobs needed to process this file.
		$jobs = ceil($numberOfLines / $chunk_size);
		//Create a job and get the id to track the progress of the job.
		$job_id = $this->createJob($file_name, $issuer_id, $numberOfLines);

		//Push each job onto the queue.
		for ($i = 0; $i < $jobs; $i++) {
			Queue::push('Cannon\\ReviewWriter', array(//Path to the file to be uploaded.
				'file_path' => $file_path, //Path of the file to be read.
				'job_id' => $job_id, //Id assigned to job in the database.
				'job_number' => $i, //This represents one of the total number of jobs to complete the file upload.
				'chunk_size' => $chunk_size, //Size array will be broken down into.
				'issuer_id' => $issuer_id //Issuer ID used for reviews.
			));
		}

		return ['success', 'The file has been uploaded'];
	}

}