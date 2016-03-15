<?php

namespace cccomus\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

/**
 * cccomus\Models\User
 *
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $username
 * @property string $password
 * @property boolean $active
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereUpdatedAt($value)
 * @property string $remember_token
 * @property integer $role
 * @property integer $acl_id
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\cccomus\Models\User whereAclId($value)
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The collection table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $primaryKey = 'user_id';

	protected $with = ['acl'];

	/**
	 * Get the table name
	 * @return string
	 */
	public function getTable() {
		return $this->table;
	}


	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'user_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

	public function acl() {
		return $this->hasOne('cccomus\Models\Acl', 'acl_id', 'acl_id');
	}
}
