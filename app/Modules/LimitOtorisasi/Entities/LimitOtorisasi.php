<?php

namespace Modules\LimitOtorisasi\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class LimitOtorisasi extends \App\Entities\Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'app_limit_oto';

    /**
     * @var array
     */
    protected $fillable = [
        'kode', 'jabatan', 'limit_kredit', 'limit_debit',
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
    public function setJabatanAttribute($value)
    {
        $this->attributes['jabatan'] = json_encode($value);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setLimitKreditAttribute($value)
    {
        $this->attributes['limit_kredit'] = str_replace(',', '', $value);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setLimitDebitAttribute($value)
    {
        $this->attributes['limit_debit'] = str_replace(',', '', $value);
    }

    /**
     * @param mixed $value
     * @return array
     */
    public function getJabatanAttribute($value)
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
        if ($request->kode) {
            $query->where('kode', $request->kode);
        }

        if ($request->jabatan) {
            $query->whereJsonContains('jabatan', $request->jabatan);
        }

        $q = $query->select(array_merge($this->fillable, ['id']))
            ->orderByDesc('limit_kredit')
            ->orderByDesc('limit_debit');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }
}