<?php
namespace Modules\ProductReviewsModule\Controllers;

use Cache, Issuer, Review, Product, View, Redirect, Input, User, Validator, Hash, Job;

use App\Http\Controllers\Controller;

/**
 * Class AdminController
 * @author David Cannon
 * @date 20 Oct 14
 */
class AdminController extends Controller {

	public function index() {

		$issuers = array('' => 'Select an Issuer', '-1' => 'ALL ISSUERS') + Issuer::lists('issuer_name', 'issuer_id');
		$products = array('' => 'Select a Product', '-1' => 'ALL PRODUCTS') + Product::lists('product_name', 'alternate_product_id');

		return view('admin.index', array('issuers' => $issuers, 'products' => $products));
	}

	/**
	 * Flush all cached data.
	 * @return mixed
	 */
	public function flushCache() {
		Cache::flush();

		return Redirect::back()->with('success', 'Cached has been flushed!');
	}

	/**
	 * Sometimes an error might occur that won't allow the job to get to 100%, so it must be deleted.  This only deletes
	 * the job from the database, not the daemon.  You must let that run its course.
	 * @return mixed
	 */
	public function clearJobStatuses() {
		$jobs = Job::all();

		foreach ($jobs as $job) {
			$job->delete();
		}

		return Redirect::back()->with('success', 'All Jobs Have Been Deleted!');
	}

	/**
	 * Disable all reviews.
	 */
	public function disableAll() {
		$issuers = Issuer::all();

		foreach ($issuers as $issuer) {
			$issuer->disabled = 1;
			$issuer->save();
		}
	}

	/**
	 * Enable all reviews.
	 */
	public function enableAll() {
		$issuers = Issuer::all();

		foreach ($issuers as $issuer) {
			$issuer->disabled = 0;
			$issuer->save();
		}
	}

	public function createApiUser() {
		$username = Input::get('username');
		$password = Input::get('password');

		$exists = User::where('username', '=', $username)->count();

		if ($exists > 0) {
			return Redirect::back()->withInput()->with('error', 'Username Already Exists!');
		}

		// validate the info, create rules for the inputs
		$rules = array('username' => 'required|min:5|unique:users', 'password' => 'required|min:5|same:confirm_password', 'confirm_password' => 'required|alphaNum|min:5',);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);// send back all errors to the login form
		} else {
			$user = new User();
			$user->username = $username;
			$user->password = Hash::make($password);
			$user->acl_id = 1; //Make everyone a standard user for now.  That is all that is required for an API call.

			if ($user->save()) {
				return Redirect::back()->with('success', 'User Successfully Created!');
			} else {
				return Redirect::back()->with('error', 'Error Creating User!');
			}
		}
	}

	public function deleteReviews() {

		$attributes = Input::all();

		//Initially, only the issuer id is required.
		$rules = array('issuer_id' => 'required');
		// run the validation rules on the inputs from the form
		$validator = Validator::make($attributes, $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);// send back all errors to the login form
		} else {
			$success = Review::deleteReviews($attributes);
			if ($success) {
				return Redirect::back()->with('success', 'Review Range Successfully Deleted!');
			} else {
				return Redirect::back()->with('error', 'Error Deleting Reviews!');
			}
		}

	}
}
