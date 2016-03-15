<?php
namespace cccomus\Models;

use Jenssegers\Mongodb\Model as Meloquent;

/**
 * Class Review
 * @package cccomus\Models
 */

class Review extends Meloquent {

	protected $connection = 'mongodb';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $collection = 'reviews';

    protected $primaryKey = 'review_id';

	protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function product()
	{
		return $this->belongsTo('cccomus\Models\Card', 'card_id', 'product_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function issuer()
	{
		return $this->belongsTo('cccomus\Models\Issuer', 'issuer_id', 'issuer_id');
	}
}
