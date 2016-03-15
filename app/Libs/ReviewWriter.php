<?php
namespace Cannon;

/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 11/21/14
 * Time: 12:04 PM
 */
use Cannon\CSVReader;
use App\Models\Job;
use App\Models\Review;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReviewWriter {

	/**
	 * Queue Method
	 * @param $job - Job Number
	 * @param $data - Data for the Job
	 */
	public function fire($job, $data) {

		//If the jobs has been attempted and failed more than 2 times...delete it.
		if ($job->attempts() > 1) {
			$job->delete();
		} else {
			$this->runJob($job, $data);
		}
	}

	/**
	 * Function Method that actually executes the job.
	 * @param $job
	 * @param $data
	 */
	private function runJob($job, $data) {

		//Passed in variables needed to complete the job.
		$file_path = $data['file_path'];
		$job_id = $data['job_id'];
		$job_number = $data['job_number'];
		$chunk_size = $data['chunk_size'];
		$issuer_id = $data['issuer_id'];

		//Create a CSVReader with the given file.
		$reader = new CSVReader($file_path);
		//Process the passed in CSV file.
		$reader->readFile();
		//Break the array down into manageable sections.
		$reviews = $reader->getContentChunk($job_number, $chunk_size);
		//Get the column titles.
		$columns = $reader->getColumns();
		//Get the total number of lines in the job.
		$numberOfLines = $reader->getNumLines();

		//Create the job
		$j = Job::find($job_id);;

		//Get all the indexes. We have to do it like this because the column headers are in different locations depending
		//on the issuer.
		$review_index = $this->getIndex('review_id', $columns);
		$submission_date_index = $this->getIndex('submission_date', $columns);
		$product_id_index = $this->getIndex('product_id', $columns);
		$product_name_index = $this->getIndex('product_name', $columns);
		$user_nickname_index = $this->getIndex('user_nickname', $columns);
		$age_index = $this->getIndex('age', $columns);
		$member_since_index = $this->getIndex('member_since', $columns);
		$recommend_to_a_friend_index = $this->getIndex('recommend_to_a_friend', $columns);
		$user_location_index = $this->getIndex('user_location', $columns);
		$review_title_index = $this->getIndex('review_title', $columns);
		$review_text_index = $this->getIndex('review_text', $columns);
		$overall_rating_index = $this->getIndex('overall_rating', $columns);
		$account_benefits_index = $this->getIndex('account_benefits', $columns);
		$online_experience_index = $this->getIndex('online_experience', $columns);
		$customer_service_index = $this->getIndex('customer_service', $columns);
		$rewards_program_index = $this->getIndex('rewards_program', $columns);

		//Jobs processed.
		$processed = $j->processed;
		//Jobs successful
		$successful = $j->successful;
		//Job errors
		$errors = $j->errors;

		//Disable logging to save memory for large jobs.
		DB::connection()->disableQueryLog();

		//Loop through $reader and upload each row to the database.
		foreach ($reviews as $row) {

			$review = new Review();
			$review->review_id = $row[$review_index];
			$review->issuer_id = $issuer_id;
			$review->submission_date = Carbon::parse($row[$submission_date_index]);
			$review->product_id = $product_id_index ? $row[$product_id_index] : '';
			$review->product_name = $product_name_index ? $row[$product_name_index] : '';
			$review->user_nickname = $user_nickname_index ? $row[$user_nickname_index] : '';
			$review->age = $age_index ? $row[$age_index] : '';
			$review->member_since = $member_since_index ? $row[$member_since_index] : '';
			$review->recommend_to_a_friend = $recommend_to_a_friend_index ? $row[$recommend_to_a_friend_index] : '';
			$review->user_location = $user_location_index ? $row[$user_location_index] : '';
			$review->review_title = $review_title_index ? $row[$review_title_index] : '';
			$review->review_text = $review_text_index ? $row[$review_text_index] : '';
			$review->overall_rating = $overall_rating_index ? $row[$overall_rating_index] : '';
			$review->account_benefits = $account_benefits_index ? $row[$account_benefits_index] : '';
			$review->online_experience = $online_experience_index ? $row[$online_experience_index] : '';
			$review->customer_service = $customer_service_index ? $row[$customer_service_index] : '';
			$review->rewards_program = $rewards_program_index ? $row[$rewards_program_index] : '';

			//Try to save, if successful, iterate success.
			try {
				$review->save();
				$successful++;
			} //If job fails for whatever reason, iterate errors.
			catch (\Exception $e) {
				$errors++;
			}
			//Always iterate the number of processed jobs.
			$processed++;

			//Increment the job table so we can track progress on the frontend.
			if ($processed % 20 == 0 || $processed == $numberOfLines) {
				$j->processed = $processed;
				$j->successful = $successful;
				$j->errors = $errors;
				$j->save();
			}
		}

		//Flag the job as complete.
		if ($processed == $numberOfLines) {
			$j->isComplete = 1; //1 = true
			$j->save();
		}

		//Delete the Queued Job.
		$job->delete();
	}

	/**
	 * Method gets the index of the column name.
	 *
	 * @param $column_name String
	 * @param $columns_array Array
	 * @return mixed Boolean or Integer
	 */
	private function getIndex($column_name, $columns_array) {
		return array_search($column_name, $columns_array);
	}
}