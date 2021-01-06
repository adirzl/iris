<?php

namespace Modules\UIM\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UbahLimitImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        if (!is_null($row['tglpengajuan']) && !is_null($row['limitoto_kbaru']) && !is_null($row['limitoto_dbaru'])) {
            \Illuminate\Support\Facades\DB::table('uim_ubah_limit')->insert([
                'tgl_pengajuan' => $row['tglpengajuan'],
                'userid' => trim($row['userid']),
                'nama' => trim($row['nama']),
                'idaplikasi' => trim($row['idaplikasi']),
                'aplikasi' => trim($row['aplikasi']),
                'kode_cabang' => trim($row['kodecabang']),
                'limit_oto_kredit' => $row['limitoto_kbaru'],
                'limit_oto_debit' => $row['limitoto_dbaru'],
                'waktu_proses' => $row['waktuproses'],
                'user_admin_ti' => trim($row['useradminti']),
                'tgl_berlaku_awal' => $row['tgl_berlaku_baru'],
                'tgl_berlaku_akhir' => $row['tgl_selesai_baru'],
                'sementara' => trim($row['sementara']),
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
