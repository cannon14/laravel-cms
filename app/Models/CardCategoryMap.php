<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

class CardCategoryMap extends Model
{
    protected $table = 'card_category_map';

	protected $primaryKey = 'map_id';

	public function categories() {
		return $this->hasMany('cccomus\Models\Category', 'category_id', 'category_id');
	}

	public function cards() {
		return $this->hasMany('cccomus\Models\Card', 'card_id', 'card_id');
	}
}
