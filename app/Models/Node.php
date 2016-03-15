<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Node
 *
 * @package cccomus\Models
 * @property integer $node_id
 * @property integer $parent_id
 * @property string $title
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Node whereNodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Node whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Node whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Node whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Node whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Node whereUpdatedAt($value)
 */
class Node extends Model
{
    protected $table = 'nodes';

	protected $primaryKey = 'node_id';

	protected $guarded = [];

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}


}
