<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductIdToAltProductIdMap
 * @package cccomus\Models
 */
class ProductIdToAltProductIdMap extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'product_id_to_alt_product_id_map';

	/**
	 * The primary key for the model.
	 * @var string
	 */
	protected $primaryKey = 'map_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}

}
