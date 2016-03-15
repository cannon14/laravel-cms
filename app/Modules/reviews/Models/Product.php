<?php
namespace Modules\ProductReviewsModule\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cards';

    protected $primaryKey = 'card_id';


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function issuer() {
        return $this->hasOne('Modules\ProductReviewsModule\Models\Issuer', 'issuer_id', 'issuer_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews() {
        return $this->hasMany('Modules\ProductReviewsModule\Models\Review', 'review_id', 'review_id');
    }

}
