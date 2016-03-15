<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\PageContentBlockMap
 *
 * @property integer $map_id
 * @property integer $page_id
 * @property integer $content_block_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\PageContentBlockMap whereMapId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\PageContentBlockMap wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\PageContentBlockMap whereContentBlockId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\PageContentBlockMap whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\PageContentBlockMap whereUpdatedAt($value)
 */
class PageContentBlockMap extends Model
{
	protected $table = 'page_content_block_map';

	protected $primaryKey = 'map_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}

}
