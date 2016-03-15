<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs';

    protected $primaryKey = 'job_id';

    public function issuer() {
        return $this->hasOne('Issuer', 'issuer_id', 'issuer_id');
    }

}
