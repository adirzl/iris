<?php

namespace Modules\Opsi\Entities;

class OptionGroup extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'mst_option_group';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionValues()
    {
        return $this->hasMany(OptionValue::class)->orderBy('key');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $q = $query->select(array_merge($this->fillable, ['id']))
            ->orderBy('name');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }
}