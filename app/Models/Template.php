<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * cccomus\Models\Template
 *
 * @property integer $template_id
 * @property string $template_name
 * @property string $description
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereTemplateName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereUpdatedAt($value)
 * @property string $deleted_at
 * @property string $active
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereActive($value)
 * @property string $name
 * @property string $filename
 * @property string $path
 * @property string $version
 * @property string $date
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereDate($value)
 * @property integer $template_type_id
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Template whereTemplateTypeId($value)
 */
class Template extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'templates';

	/**
	 * The primary key for the model.
	 * @var string
	 */
	protected $primaryKey = 'template_id';

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
	public function templateType()
	{
		return $this->hasOne('cccomus\Models\TemplateType', 'template_type_id', 'template_type_id');
	}


}
