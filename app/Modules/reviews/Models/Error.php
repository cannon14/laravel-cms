<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'errors';

    protected $primaryKey = 'error_id';

}
