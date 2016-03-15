<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\ContentBlock
 *
 * @property integer $content_block_id
 * @property string $name
 * @property string $description
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\ContentBlock whereContentBlockId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\ContentBlock whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\ContentBlock whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\ContentBlock whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\ContentBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\ContentBlock whereUpdatedAt($value)
 */
class ContentBlock extends Model
{
	protected $table = 'content_blocks';

	protected $primaryKey = 'content_block_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}


}
