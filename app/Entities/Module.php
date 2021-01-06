<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class Module extends Model
{
    /**
     * @var string
     */
    protected $table = 'mst_module';

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindByLabel($query, string $value)
    {
        return $query->where('label', $value)->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopePermissions($query)
    {
        return $query->select([
            'id', 'label', 'uri',
            DB::raw("case when parent_module is null then '' else (select x.label from " . $this->table . " x where x.id = " . $this->table . ".parent_module) end as parent_module")
        ])->where('uri', '<>', '#')->get();
    }
}
