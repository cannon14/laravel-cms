<?php
/**
 * Created by PhpStorm.
 * User: cannon14
 * Date: 1/5/16
 * Time: 5:47 PM
 */

namespace cccomus\Libs\Maps;


class CapitalOne implements Map {

	/**
	 * Required Columns
	 * @return array
	 */
	public function columns() {
		return [
			'Review ID' => 'review_id',
			'Submission Date' => 'submission_date',
			'Product ID' => 'product_id',
			'Product Name' => 'product_name',
			'User Nickname' => 'user_nickname',
			'Age' => 'age',
			'Member Since' => 'member_since',
			'Location' => 'user_location',
			'Review Title' => 'review_title',
			'Review Text' => 'review_text',
			'Overall Rating' => 'overall_rating',
			'Online Experience' => 'online_experience',
			'Account Benefits' => 'account_benefits',
			'Customer Service' => 'customer_service',
		];
	}

}