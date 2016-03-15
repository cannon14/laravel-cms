<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\Feed
 *
 * @property integer $feed_id
 * @property string $name
 * @property string $url
 * @property string $key
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereFeedId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Feed whereUpdatedAt($value)
 */
class Feed extends Model
{
    protected $table = 'feeds';

    protected $primaryKey = 'feed_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}


}
