<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Issuer
 *
 * @package cccomus\Models
 * @property integer $issuer_id
 * @property string $issuer_name
 * @property string $url
 * @property mixed $description
 * @property string $date_created
 * @property string $date_updated
 * @property integer $active
 * @property integer $deleted
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereIssuerId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereIssuerName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereDateUpdated($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereDeleted($value)
 * @property string $name
 * @property string $logo
 * @property string $slug
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Issuer whereDeletedAt($value)
 */
class Issuer extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'issuers';

	/**
	 * The primary key for the model.
	 * @var string
	 */
	protected $primaryKey = 'issuer_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}

	public function reviews() {
		return $this->hasMany('cccomus\Models\Review', 'issuer_id', 'issuer_id');
	}

}
