<?php

namespace Modules\KinerjaKeuangan\Entities;
use Illuminate\Support\Facades\DB;
use Modules\KinerjaKeuangan\Entities\RealisasiRBBDetail;

class Temp100 extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_100_txt';

    /**
     * @var array
     */
    protected $fillable = [
        'id_realisasi_detail',
        'flag_detail',
        'sandi_kantor',
        'sandi_pos',
        'jumlah',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    // protected $hidden = [
    //     'id',
    // ];

    /**
     * @param mixed $value
     * @return void
     */
    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['title'] = is_null($value) ? '-' : $value;
    // }

    /**
     * @param mixed $value
     * @return void
     */
    // public function setDescriptionAttribute($value)
    // {
    //     $this->attributes['description'] = is_null($value) ? '-' : $value;
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function fungsi()
    // {
    //     return $this->hasMany(Fungsi::class, 'reg_aplikasi_id');
    // }

    // /**
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @return int
    //  */
    // public function scopeSequenceIdAplikasi($query)
    // {
    //     return ($query->select('idaplikasi')->latest('idaplikasi')->first())->idaplikasi + 1;
    // }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */

    // public function targetrbb()
    // {
    //     return $this->hasMany('TargetRBBDetail', 'id_targetrbb');
    // }

    public function scopeFetch($query, $request, $export = false)
    {
        // if ($request->tahun) {
        //     $query->where('tahun', 'like', '%' . $request->tahun . '%');
        // }

        // if ($request->id_comprof) {
        //     $query->where('id_comprof', 'like', '%' . $request->id_comprof . '%');
        // }

        $q = $query
        ->select('app_100_txt.*', 'app_realisasirbb_detail.*')
        ->join('app_realisasirbb_detail', 'app_100_txt.id_realisasi_detail', '=', 'app_realisasirbb_detail.id')
        ->orderBy('sandi_kantor');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function scopeAmbil($query, $request, $export = false)
    {
        $q = $query
        ->select('app_100_txt.*', 'app_realisasirbb_detail.*')
        ->join('app_realisasirbb_detail', 'app_100_txt.id_realisasi_detail', '=', 'app_realisasirbb_detail.id')
        ->orderBy('sandi_kantor');
        
        return $q->get();
    }
}
                // if ($request['kategori_keuangan'] === '6') { // kolekpersektor (npl)
                //     // if ($value[24] === '000001' || $value[24] === '000002' || $value[24] === '011110' || $value[24] === '011121' || $value[24] === '011122' || $value[24] === '011123' || $value[24] === '011124' || $value[24] === '011125' || $value[24] === '011126' || $value[24] === '011129' || $value[24] === '011130' || $value[24] === '011140' || $value[24] === '011150' || $value[24] === '011160' || $value[24] === '011170' || $value[24] === '011180' || $value[24] === '011190' || $value[24] === '011211' || $value[24] === '011219' || $value[24] === '011220' || $value[24] === '011231' || $value[24] === '011239' || $value[24] === '011240' || $value[24] === '011250' || $value[24] === '011311' || $value[24] === '011319' || $value[24] === '011321' || $value[24] === '011329' || $value[24] === '011330' || $value[24] === '011340' || $value[24] === '011351' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0' || $value[24] === '0') {
                //     //     $produktif[] = $value[36];
                //     // }
                //     if($value[16] === '1'){
                //         if ($value[24] === '001100' || $value[24] === '001110' || $value[24] === '001120' || $value[24] === '001130' || $value[24] === '001210' || $value[24] === '001220' || $value[24] === '001230' || $value[24] === '001300' || $value[24] === '002100' || $value[24] === '002200' || $value[24] === '002300' || $value[24] === '002900' || $value[24] === '003100' || $value[24] === '003200' || $value[24] === '003300' || $value[24] === '003900' || $value[24] === '004120' || $value[24] === '004130' || $value[24] === '004140' || $value[24] === '004150' || $value[24] === '004160' || $value[24] === '004170' || $value[24] === '004180' || $value[24] === '004190' || $value[24] === '004900' || $value[24] === '009000') {
                //             $konsumtif[] = $value[36]; 
                //         }
                //         else {
                //             $produktif[] = $value[36];
                //         }
                //     }
                // }    
