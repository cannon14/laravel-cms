<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

class PageType extends Model
{
    protected $table = 'page_types';

	protected $primaryKey = 'page_type_id';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function page()
	{
		return $this->belongsToMany('cccomus\Models\PageType', 'page_type_id', 'page_type_id');
	}

}
