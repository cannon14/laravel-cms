<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
	protected $table = 'parsers';

	protected $primaryKey = 'parser_id';

	/**
	 * Related issuer.
	 * @return mixed
	 */
	public function issuer()
	{
		return $this->hasOne('cccomus\Models\Issuer', 'issuer_id', 'issuer_id');
	}
}
