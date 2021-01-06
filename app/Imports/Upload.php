<?php

namespace App\Imports;

use Modules\KinerjaKeuangan\Entities\TargetRBB;
use Modules\KinerjaKeuangan\Entities\TargetRBBDetail1;
use Modules\KinerjaKeuangan\Entities\TargetRBBDetail2;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class Upload implements ToCollection, WithStartRow
{
    protected $tahun, $kategori, $comprof, $status_progres;

    public function __construct($tahun, $kategori, $comprof, $status_progres)
    {
        $this->tahun = $tahun;
        $this->kategori = $kategori;
        $this->comprof = $comprof;
        $this->status_progres = $status_progres;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        if ($this->kategori == 1) {
            return 4;
        } else {
            return 6;
        }
    }

    public function collection(Collection $rows)
    {
        $targetid = TargetRBB::create([
            'tahun' => $this->tahun,
            'id_comprof' => $this->comprof,
            'kategori_keuangan' => $this->kategori,
            'status_progres' => $this->status_progres,
        ]);
        if ($this->kategori == 1) {
            foreach ($rows as $row) {
                TargetRBBDetail1::create([
                    'periode' => $row[1],
                    'total_aset' => $row[2],
                    'total_aba' => $row[3],
                    'total_kredit' => $row[4],
                    'dana_pihak_ketiga' => $row[5],
                    'simpanan_bank_lain' => $row[6],
                    'pinjaman_yang_diterima' => $row[7],
                    'modal' => $row[8],
                    'laba_rugi' => $row[9],
                    'id_targetrbb' => $targetid->id,
                ]);
            }
        } else {
            foreach ($rows as $row) {
                TargetRBBDetail2::create([
                    'periode' => $row[1],
                    'bunga_kredit' => $row[2],
                    'bunga_ppbl' => $row[3],
                    'pendapatan_provinsi' => $row[4],
                    'pendapatan_lainnya' => $row[5],
                    'tabungan' => $row[6],
                    'deposito' => $row[7],
                    'pinjaman_diterima' => $row[8],
                    'penyisihan_kerugian' => $row[9],
                    'penyusutan_ati' => $row[10],
                    'beban_restrukturisasi' => $row[11],
                    'beban_pemasaran' => $row[12],
                    'tenaga_kerja' => $row[13],
                    'pendidikan' => $row[14],
                    'premi_asuransi' => $row[15],
                    'sewa' => $row[16],
                    'barang_dan_jasa' => $row[17],
                    'pemeliharaan_perbaikan' => $row[18],
                    'pajak' => $row[19],
                    'beban_lainnya' => $row[20],
                    'laba_rugi' => $row[21],
                    'id_targetrbb' => $targetid->id,
                ]);
            }
        }
    }
}
