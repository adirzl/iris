<?php

namespace Modules\RuleHakAkses\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class RuleHakAkses extends \App\Entities\Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'app_hak_akses';

    /**
     * @var array
     */
    protected $fillable = [
        'grade', 'pegawai_ti', 'as_admin_spv', 'as_admin', 'primary_level', 'secondary_level', 'sequence',
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
    public function setGradeAttribute($value)
    {
        $data = null;
        
        foreach ($value as $val) {
            if (!is_null($val)) {
                $data[] = $val;
            }
        }

        $this->attributes['grade'] = !is_null($data) ? json_encode($value) : null;
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function getGradeAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->level) {
            $query->where('primary_level', $request->level);
        }

        $q = $query->select(array_merge($this->fillable, ['id']))
            ->orderBy('sequence');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }
}