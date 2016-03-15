<?php
namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

class StaffReview extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'staff_reviews';

    protected $primaryKey = 'review_id';

}
