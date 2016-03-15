<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\Category
 *
 * @property integer $category_id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $slug
 * @property boolean $active
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Page[] $page
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Category whereUpdatedAt($value)
 */
class Category extends Model
{
    protected $table = 'categories';

	protected $primaryKey = 'category_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}

	public function cards() {
		return $this->belongsToMany('cccomus\Models\Card', 'card_category_map')->withPivot('rank', 'position_link');
	}

}
