<?php
namespace Modules\ProductReviewsModule\Controllers;

use App\Models\Job;

use App\Http\Controllers\Controller;

class JobController extends Controller {

	/**
	 * Show all jobs.
	 * @return mixed
	 */
	public function index() {
		$jobs = Job::all();

		return response()->json($jobs);

	}

	/**
	 * Delete a job.
	 * @param $job_id
	 * @return mixed
	 */
	public function destroy($job_id) {
		//Retrieve the job to delete.
		$job = Job::find($job_id);
		//Delete it.
		$job->delete();

		return response()->json('Deleted');
	}

}


