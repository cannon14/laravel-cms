<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'media_types';

	/**
	 * The primary key for the model.
	 * @var string
	 */
	protected $primaryKey = 'media_type_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}
}
