<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\Page
 *
 * @property integer $page_id
 * @property string $title
 * @property integer $page_type_id
 * @property integer $schumer_type_id
 * @property integer $category_id
 * @property string $image
 * @property string $description
 * @property string $slug
 * @property integer $card_count
 * @property boolean $active
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Category $category
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page wherePageId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page wherePageTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereSchumerTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereCardCount($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereUpdatedAt($value)
 * @property integer $template_id
 * @property string $meta_description
 * @property string $meta_tags
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereMetaDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereMetaTags($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Page whereNodeId($value)
 */
class Page extends Model
{
	/**
	 * The collection associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	protected $primaryKey = 'page_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function category()
	{
		return $this->hasOne('cccomus\Models\Category', 'category_id', 'category_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function template() {
		return $this->hasOne('cccomus\Models\Template', 'template_id', 'template_id');
	}

	public function schumer() {
		return $this->hasOne('cccomus\Models\Template', 'template_id', 'schumer_template_id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function pageType() {
		return $this->hasOne('cccomus\Models\PageType', 'page_type_id', 'page_type_id');
	}
}
