<?php

namespace Modules\HCS\Imports;

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
     * @return void
     */
    public function model(array $row)
    {
        if (!is_null($row['userid'])) {
            \Illuminate\Support\Facades\DB::table('hcs_pegawai')->insert([
                'userid' => $row['userid'],
                'nama' => $row['nama'],
                'nip' => $row['nip'],
                'email' => $row['email_bjb'],
                'hp' => $row['hp'],
                'kode_unit_kerja' => $row['kode_unit_kerja'],
                'kode_jabatan' => $row['kode_jabatan'],
                'kode_penempatan' => $row['kode_penempatan'],
                'kode_grade' => $row['grade'],
                'status_karyawan' => $row['status_karyawan'],
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
