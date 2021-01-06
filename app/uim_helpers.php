<?php

if (!function_exists('akses_aplikasi')) {
    /**
     * @param string $akses
     * @return string
     */
    function akses_aplikasi(string $akses)
    {
        $akses_aplikasi = config('options.akses_aplikasi');

        if (\Illuminate\Support\Str::is($akses, '-')) {
            return $akses;
        }
        
        if(isset($akses_aplikasi[$akses])) {
            return $akses_aplikasi[$akses];
        }

        return (\Modules\UIM\Entities\UnitKerja::select('nama_cabang')->where('kode_cabang', $akses)->first())->nama_cabang;
    }
}
