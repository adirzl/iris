<?php

namespace Modules\Opsi\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OptionsTablesSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $optionGroupTable = 'mst_option_group';

    /**
     * @var string
     */
    protected $optionValueTable = 'mst_option_value';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->optionGroupTable)->delete();

        $now = now();
        $options = [
            [
                'id' => Str::uuid(), 'name' => 'display_per_page', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '5', 'value' => '5', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '10', 'value' => '10', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '15', 'value' => '15', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '25', 'value' => '25', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '50', 'value' => '50', 'sequence' => 5,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '100', 'value' => '100', 'sequence' => 6,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'All', 'value' => 'All', 'sequence' => 7,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'bool_decision', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => __('label.no'), 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => __('label.yes'), 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'char_decision', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'N', 'value' => __('label.no'), 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'Y', 'value' => __('label.yes'), 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'visibility', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => 'Hidden', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Visible', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 0, 'value' => 'Tidak Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'level_hakakses', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'USER', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 2, 'value' => 'ADMIN', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 3, 'value' => 'SUPERVISOR', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 4, 'value' => 'SUPERVISOR TI', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 5, 'value' => 'ADMIN TI', 'sequence' => 5,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'jadwal', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'hourly', 'value' => 'per Jam', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'daily', 'value' => 'per Hari', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'weekly', 'value' => 'per Minggu', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'monthly', 'value' => 'per Bulan', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'yearly', 'value' => 'per Tahun', 'sequence' => 5,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'jadwal', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Belum diimplentasikan', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Masih Dalam Perencanaan Internal', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '3', 'value' => 'Masih Dalam Pembahasan Komisaris', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '4', 'value' => 'Telah Diimplemantsikan', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'environment', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'development', 'value' => 'Development', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'testing', 'value' => 'Testing', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'production', 'value' => 'Production', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'dialect', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'pgsql', 'value' => 'PostgreSQL', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'mssql', 'value' => 'MS SQL Server', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'akses_aplikasi', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 'CAB', 'value' => 'Cabang', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'DIV', 'value' => 'Kantor Pusat', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'ALL', 'value' => 'Seluruh Pegawai', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 'UKER', 'value' => 'Unit Kerja', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'otentikasi_user', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Manajemen User sendiri', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'UIM bandung10', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '3', 'value' => 'LDAP+UIM', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '4', 'value' => 'UIM API', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_artikel', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_banner', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_profil', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Profil Konglomerasi Keuangan', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Profil Perusahaan/LJK', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '3', 'value' => 'Tugas dan Wewenang', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '4', 'value' => 'Struktur Organisasi', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_regulasi', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_laporan', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_dokumen', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],

            [
                'id' => Str::uuid(), 'name' => 'status_dokumen', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_data', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Tugas', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Wewenang', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_pertanyaan', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'periode', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Triwulan I', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Triwulan II', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '3', 'value' => 'Triwulan III', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '3', 'value' => 'Triwulan IV', 'sequence' => 4,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_user', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Manrisk', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Kepatuhan', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'ljk', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'BJB Syariah', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Bank Intan Jabar', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '3', 'value' => 'Bank Karya Utama', 'sequence' => 3,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'status_perusahaan', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => '1', 'value' => 'Aktif', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => '2', 'value' => 'Tidak Aktif', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'approval', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => __('label.approve'), 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 2, 'value' => __('label.Reject'), 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
            [
                'id' => Str::uuid(), 'name' => 'risetquality', 'created_at' => $now, 'updated_at' => $now,
                'values' => [
                    [
                        'id' => Str::uuid(), 'key' => 1, 'value' => 'Sangat tidak puas', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 2, 'value' => 'Tidak puas', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 3, 'value' => 'Cukup puas', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 4, 'value' => 'Puas', 'sequence' => 2,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                    [
                        'id' => Str::uuid(), 'key' => 5, 'value' => 'Sangat puas', 'sequence' => 1,
                        'created_at' => $now, 'updated_at' => $now
                    ],
                ]
            ],
        ];

        foreach ($options as $option) {
            $values = $option['values'];
            \Illuminate\Support\Arr::forget($option, 'values');

            DB::table($this->optionGroupTable)->insert($option);

            foreach ($values as $value) {
                $value['option_group_id'] = $option['id'];
                DB::table($this->optionValueTable)->insert($value);
            }
        }
    }
}
