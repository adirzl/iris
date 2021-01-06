<?php

namespace Modules\API\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Datasource extends \App\Entities\Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'api_datasource';

    /**
     * @var array
     */
    protected $fillable = [
        'nama', 'environment', 'dialect', 'properties',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        
        if ($request->environment) {
            $query->where('environment', $request->environment);
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'status']))
            ->orderBy('nama');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }
}