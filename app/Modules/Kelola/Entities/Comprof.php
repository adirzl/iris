<?php

namespace Modules\Kelola\Entities;

class Comprof extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_company_prof';

    /**
     * @var array
     */
    protected $fillable = [
        'company_name', 'description', 'image', 'created_at', 'updated_at', 'status',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @param mixed $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['company_name'] = is_null($value) ? '-' : $value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = is_null($value) ? '-' : $value;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->company_name) {
            $query->where('company_name', 'ilike', '%' . $request->company_name . '%');
        }

        if (in_array($request->status, ['1', '2'])) {
            $query->where('status', $request->status);
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'company_name', 'description', 'image', 'created_at', 'updated_at', 'status']))
            ->orderBy('company_name');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}
