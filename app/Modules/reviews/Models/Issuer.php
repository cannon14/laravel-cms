<?php
namespace Modules\ProductReviewsModule\Models;

use Illuminate\Database\Eloquent\Model;

class Issuer extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'issuers';

    protected $primaryKey = 'issuer_id';

    public function jobs() {
        return $this->hasMany('Job');
    }

    public function products() {
        return $this->hasMany('Modules\ProductReviewsModule\Models\Product', 'card_id');
    }

}
