<?php

namespace cccomus\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'static_pages';

    /**
     * The primary key for the model.
     * @var string
     */
    protected $primaryKey = 'page_id';

    /**
     * Get the table name
     * @return string
     */
    public function getTable() {
        return $this->table;
    }
}
