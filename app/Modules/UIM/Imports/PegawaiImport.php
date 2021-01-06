<?php

namespace Modules\UIM\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        if ((!in_array(trim($row['userid']), ['-', 'NULL']) && !empty(trim($row['userid']))) && (!is_null($row['hakakses']) && in_array(trim($row['hakakses']), ['1', '2', '3'])) && trim($row['status_karyawan']) !== 'NULL') {
            \Illuminate\Support\Facades\DB::table('uim_pegawai')->insert([
                'userid' => trim($row['userid']),
                'nama' => trim($row['nama']),
                'nip' => trim($row['nip']),
                'email' => trim($row['email']),
                'hp' => trim($row['hp']),
                'kode_induk' => trim($row['kodecabang']),
                'kode_cabang' => trim($row['kodecabang']),
                'kode_jabatan' => trim($row['jabatan']),
                'nama_jabatan' => trim($row['nama_posisi_penempatan']),
                'kode_penempatan' => trim($row['kode_penempatan_hris']),
                'nama_penempatan' => trim($row['penempatan_hris']),
                'kode_grade' => trim($row['kode_grade']),
                'nama_grade' => trim($row['nama_grade']),
                'admin_spv_ti' => trim($row['ditunjuk_as_admin_spvti']),
                'hakakses' => trim($row['hakakses']),
                'status_karyawan' => trim($row['status_karyawan']),
            ]);
        }
    }

    /**
     * @return integer
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return integer
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
