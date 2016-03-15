<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CardPageMap
 *
 * @package cccomus\Models
 * @property integer $map_id
 * @property integer $page_id
 * @property integer $card_id
 * @property integer $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap whereMapId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap whereCardId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap whereUpdatedAt($value)
 * @property integer $node_id
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\CardPageMap whereNodeId($value)
 */
class CardPageMap extends Model
{
    protected $table = 'card_page_map';

	protected $primaryKey = 'map_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function pages() {
		return $this->hasMany('cccomus\Models\Page', 'page_id', 'page_id');
	}
}
