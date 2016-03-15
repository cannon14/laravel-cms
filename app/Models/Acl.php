<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * cccomus\Models\Acl
 *
 * @property integer $acl_id
 * @property string $role
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Acl whereAclId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Acl whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Acl whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\Acl whereUpdatedAt($value)
 */
class Acl extends Model
{
    protected $table = 'acl';

	protected $primaryKey = 'acl_id';

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}


	public function users() {
		return $this->belongsToMany('cccomus\Models\User', 'user_id', 'user_id');
	}
}
