<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PermissionsTablesSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $userTable = 'app_user';

    /**
     * @var string
     */
    protected $moduleTable = 'mst_module';

    /**
     * @var string
     */
    protected $roleTable = 'mst_role';

    /**
     * @var string
     */
    protected $permissionTable = 'mst_permission';

    /**
     * @var string
     */
    protected $roleHasModuleTable = 'mst_role_has_module';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->userTable)->delete();
        DB::table($this->moduleTable)->delete();
        DB::table($this->roleTable)->delete();
        DB::table($this->permissionTable)->delete();
        DB::statement('alter sequence ' . $this->permissionTable . '_id_seq restart with 1');

        $now = now();
        $modules = [
            [
                'label' => 'Hak Akses', 'uri' => 'hak-akses', 'icon' => 'fa fa-key', 'parent_module' => null,
                'visible' => 1, 'sequence' => '1', 'childs' => []
            ],
            [
                'label' => 'Opsi', 'uri' => 'opsi', 'icon' => 'fas fa-sliders-h', 'parent_module' => null,
                'visible' => 1, 'sequence' => '2', 'childs' => []
            ],
            [
                'label' => 'Log', 'uri' => '#', 'icon' => 'fa fa-rss-square', 'parent_module' => null,
                'visible' => 1, 'sequence' => '3', 'childs' => [
                    [
                        'label' => 'Log Aktifitas', 'uri' => 'log-aktifitas', 'icon' => 'fa fa-paw', 'visible' => 1,
                        'sequence' => '3.1',
                    ],
                    [
                        'label' => 'Log Aplikasi', 'uri' => 'log-aplikasi', 'icon' => 'fa fa-laptop', 'visible' => 1,
                        'sequence' => '3.2',
                    ],
                ],
            ],
            [
                'label' => 'Setting', 'uri' => 'setting', 'icon' => 'fa fa-cogs', 'parent_module' => null,
                'visible' => 1, 'sequence' => '4', 'childs' => []
            ],
            // [
            //     'label' => 'Management API', 'uri' => '#', 'icon' => 'fas fa-tram', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '5', 'childs' => [
            //         [
            //             'label' => 'Datasource', 'uri' => 'datasource', 'icon' => 'fas fa-database', 'visible' => 1,
            //             'sequence' => '5.1',
            //         ],
            //         [
            //             'label' => 'Log Transaksi', 'uri' => 'log-transaksi', 'icon' => 'fas fa-clipboard-list', 'visible' => 1,
            //             'sequence' => '5.2',
            //         ],
            //     ],
            // ],
            // [
            //     'label' => 'Data HCS', 'uri' => '#', 'icon' => 'fab fa-sourcetree', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '6', 'childs' => [
            //         [
            //             'label' => 'Unit Kerja (HCS)', 'uri' => 'unit-kerja-hcs', 'icon' => 'fas fa-building', 'visible' => 1,
            //             'sequence' => '6.1',
            //         ],
            //         [
            //             'label' => 'Grade (HCS)', 'uri' => 'grade-hcs', 'icon' => 'fab fa-google', 'visible' => 1,
            //             'sequence' => '6.2',
            //         ],
            //         [
            //             'label' => 'Jabatan (HCS)', 'uri' => 'jabatan-hcs', 'icon' => 'fab fa-hackerrank', 'visible' => 1,
            //             'sequence' => '6.3',
            //         ],
            //         [
            //             'label' => 'Pegawai (HCS)', 'uri' => 'pegawai-hcs', 'icon' => 'fa fa-address-card', 'visible' => 1,
            //             'sequence' => '6.4',
            //         ],
            //     ],
            // ],
            // [
            //     'label' => 'Data UIM', 'uri' => '#', 'icon' => 'fas fa-id-badge', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '7', 'childs' => [
            //         [
            //             'label' => 'Unit Kerja (UIM)', 'uri' => 'unit-kerja-uim', 'icon' => 'fas fa-building', 'visible' => 1,
            //             'sequence' => '7.1',
            //         ],
            //         [
            //             'label' => 'Pegawai (UIM)', 'uri' => 'pegawai-uim', 'icon' => 'fa fa-address-card', 'visible' => 1,
            //             'sequence' => '7.4',
            //         ],
            //     ],
            // ],
            // [
            //     'label' => 'Rule Hak Akses', 'uri' => 'rule-hak-akses', 'icon' => 'fas fa-universal-access', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '8', 'childs' => []
            // ],
            // [
            //     'label' => 'Limit Otorisasi', 'uri' => 'limit-otorisasi', 'icon' => 'fas fa-money-check', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '9', 'childs' => []
            // ],
            // [
            //     'label' => 'Registrasi', 'uri' => '#', 'icon' => 'far fa-registered', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '10', 'childs' => [
            //         [
            //             'label' => 'Aplikasi', 'uri' => 'registrasi-aplikasi', 'icon' => 'fas fa-desktop', 'visible' => 1,
            //             'sequence' => '10.1',
            //         ],
            //         [
            //             'label' => 'Fungsi', 'uri' => 'registrasi-aplikasi-fungsi', 'icon' => 'fas fa-user-shield', 'visible' => 1,
            //             'sequence' => '10.2',
            //         ],
            //         [
            //             'label' => 'Server', 'uri' => 'registrasi-server', 'icon' => 'fas fa-server', 'visible' => 1,
            //             'sequence' => '10.3',
            //         ],
            //     ],
            // ],
            // [
            //     'label' => 'Sinkronisasi', 'uri' => '#', 'icon' => 'fas fa-sync', 'parent_module' => null,
            //     'visible' => 1, 'sequence' => '11', 'childs' => [
            //         [
            //             'label' => 'Pegawai', 'uri' => 'sinkronisasi-pegawai', 'icon' => 'fas fa-id-card', 'visible' => 1,
            //             'sequence' => '11.1',
            //         ],
            //         [
            //             'label' => 'Limit', 'uri' => 'sinkronisasi-limit', 'icon' => 'fas fa-exchange-alt', 'visible' => 1,
            //             'sequence' => '11.2',
            //         ],
            //     ],
            // ],
            [
                'label' => 'Kelola Landing Page', 'uri' => '#', 'icon' => 'fas fa-pencil-alt ', 'parent_module' => null,
                'visible' => 1, 'sequence' => '5', 'childs' => [
                    [
                        'label' => 'Banner', 'uri' => 'kelola-banner', 'icon' => 'fas fa-object-group', 'visible' => 1,
                        'sequence' => '5.1',
                    ],
                    [
                        'label' => 'Deskripsi Menu', 'uri' => 'kelola-profilkonglomerasi', 'icon' => 'fas fa-sitemap', 'visible' => 1,
                        'sequence' => '5.2',
                    ],
                    [
                        'label' => 'Profil Perusahaan', 'uri' => 'kelola-comprof', 'icon' => 'fas fa-id-card', 'visible' => 1,
                        'sequence' => '5.3',
                    ],
                    [
                        'label' => 'Tugas dan Wewenang', 'uri' => 'kelola-tugaswewenang', 'icon' => 'fas fa-tasks', 'visible' => 1,
                        'sequence' => '5.4',
                    ],
                    [
                        'label' => 'Regulasi', 'uri' => 'kelola-regulasi', 'icon' => 'fas fa-gavel', 'visible' => 1,
                        'sequence' => '5.5',
                    ],
                    [
                        'label' => 'Artikel', 'uri' => 'kelola-artikel', 'icon' => 'fas fa-book', 'visible' => 1,
                        'sequence' => '5.6',
                    ],
                    [
                        'label' => 'Laporan', 'uri' => 'kelola-laporan', 'icon' => 'fas fa-file', 'visible' => 1,
                        'sequence' => '5.7',
                    ],
                ],
            ],
            [
                'label' => 'Kelola Kuisioner', 'uri' => '#', 'icon' => 'fas fa-list-ol ', 'parent_module' => null,
                'visible' => 1, 'sequence' => '6', 'childs' => [
                    [
                        'label' => 'Pertanyaan', 'uri' => 'kuisioner-pertanyaan', 'icon' => 'fas fa-question-circle', 'visible' => 1,
                        'sequence' => '6.1',
                    ],
                    [
                        'label' => 'Hasil Penilaian', 'uri' => 'kuisioner-penilaian', 'icon' => 'fas fa-check-circle', 'visible' => 1,
                        'sequence' => '6.2',
                    ],
                ],
            ],
            [
                'label' => 'Isi Kuisioner', 'uri' => '#', 'icon' => 'fa fa-list-alt', 'parent_module' => null,
                'visible' => 1, 'sequence' => '7', 'childs' => [
                    [
                        'label' => 'Manrisk', 'uri' => 'isikuisioner-manrisk', 'icon' => 'fas fa-file-archive', 'visible' => 1,
                        'sequence' => '7.1',
                    ],
                    [
                        'label' => 'Kepatuhan', 'uri' => 'isikuisioner-kepatuhan', 'icon' => 'fas fa-file-archive', 'visible' => 1,
                        'sequence' => '7.2',
                    ],
                ],
            ],
            [
                'label' => 'Pengawasan Audit', 'uri' => '#', 'icon' => 'fa fa-copy', 'parent_module' => null,
                'visible' => 1, 'sequence' => '8', 'childs' => [
                    [
                        'label' => 'RKAT', 'uri' => 'rkat-audit', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '8.1',
                    ],
                    [
                        'label' => 'DMTL', 'uri' => 'dmtl-audit', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '8.2',
                    ],
                ],
            ],
            [
                'label' => 'Kinerja Keuangan', 'uri' => '#', 'icon' => 'fas fa-money-check-alt', 'parent_module' => null,
                'visible' => 1, 'sequence' => '9', 'childs' => [
                    [
                        'label' => 'Target RBB', 'uri' => 'target-rbb', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '9.1',
                    ],
                    [
                        'label' => 'Realisasi RBB', 'uri' => 'realisasi-rbb', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '9.2',
                    ],
                    [
                        'label' => 'Kajian Kinerja Keuangan', 'uri' => 'kajian-kinerja', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '9.3',
                    ],
                ],
            ],
        ];

        foreach ($modules as $module) {
            $childs = $module['childs'];
            unset($module['childs']);
            \App\Entities\Module::create($module);

            if (!empty($childs)) {
                $moduleId = \App\Entities\Module::findByLabel($module['label']);

                foreach ($childs as $child) {
                    $child['parent_module'] = $moduleId->id;
                    \App\Entities\Module::create($child);
                }
            }
        }

        (new \Modules\HakAkses\Imports\RoleImport)->import('imports/Role.xlsx');

        foreach (map_action_uri() as $permission) {
            if (!in_array($permission, ['verify verification', 'login', 'request password', 'reset password', 'register', 'profile'])) {
                DB::table($this->permissionTable)->insert([
                    'name' => $permission, 'guard_name' => 'web',
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }

        DB::table($this->permissionTable)->insert([
            [
                'name' => 'matriks registrasi-aplikasi', 'guard_name' => 'web',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'sinkronisasi registrasi-aplikasi', 'guard_name' => 'web',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'name' => 'sinkronisasi registrasi-aplikasi-fungsi', 'guard_name' => 'web',
                'created_at' => $now, 'updated_at' => $now,
            ],
        ]);

        $modules = \App\Entities\Module::orderBy('sequence')->get();
        $roles = \Modules\HakAkses\Entities\Role::all();
        $permissions = \Modules\HakAkses\Entities\Permission::all();

        (new \Modules\User\Imports\UserImport)->import('imports/User.xlsx');
        foreach ($roles as $role) {
            if ($role->name == 'SUPER ADMIN') {
                $modules->each(function ($module, $key) use ($role, $permissions) {
                    DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                    $role->givePermissionTo($permissions->pluck('name')->toArray());
                });
<<<<<<< HEAD
=======
            } elseif ($role->name == 'DATA CENTER') {
                $modules->whereIn('label', ['Log', 'Log Aplikasi', 'Setting', 'Management API', 'Datasource', 'Log Transaksi', 'Sinkronisasi', 'Pegawai', 'Limit', 'Server'])
                    ->each(function ($module, $key) use ($role, $permissions) {
                        DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                        $permissions = $permissions->map(function ($permission, $key) use ($module) {
                            if (Str::contains($permission['name'], $module['uri']) && $permission['name'] !== 'clean log-aktifitas') {
                                return $permission;
                            }
                        });
                        $role->givePermissionTo($permissions->pluck('name')->toArray());
                    });
            } elseif ($role->name === 'RSM') {
                $modules->whereIn('label', ['Log', 'Log Aktifitas', 'Data HCS', 'Pegawai (HCS)', 'Data UIM', 'Pegawai (UIM)', 'Limit Otorisasi', 'Registrasi', 'Aplikasi', 'Fungsi', 'Sinkronisasi', 'Pegawai', 'Limit'])
                    ->each(function ($module, $key) use ($role, $permissions) {
                        DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
                        $permissions = $permissions->map(function ($permission, $key) use ($module) {
                            if (Str::contains($permission['name'], $module['uri']) && $permission['name'] !== 'clean log-aktifitas') {
                                return $permission;
                            }
                        });
                        $role->givePermissionTo($permissions->pluck('name')->toArray());
                    });
>>>>>>> fd5dc0e4db9b93532ba0401ad6d01417eb00dc28
            }
            //  elseif ($role->name == 'DATA CENTER') {
            //     $modules->whereIn('label', ['Log', 'Log Aplikasi', 'Setting', 'Management API', 'Datasource', 'Log Transaksi', 'Sinkronisasi', 'Pegawai', 'Limit', 'Server'])
            //         ->each(function ($module, $key) use ($role, $permissions) {
            //             DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
            //             $permissions = $permissions->map(function ($permission, $key) use ($module) {
            //                 if (Str::contains($permission['name'], $module['uri'])) {
            //                     return $permission;
            //                 }
            //             });
            //             $role->givePermissionTo($permissions->pluck('name')->toArray());
            //         });
            // } elseif ($role->name === 'RSM') {
            //     $modules->whereIn('label', ['Log', 'Log Aktifitas', 'Data HCS', 'Pegawai (HCS)', 'Data UIM', 'Pegawai (UIM)', 'Limit Otorisasi', 'Registrasi', 'Aplikasi', 'Fungsi', 'Sinkronisasi', 'Pegawai', 'Limit'])
            //         ->each(function ($module, $key) use ($role, $permissions) {
            //             DB::table($this->roleHasModuleTable)->insert(['role_id' => $role->id, 'module_id' => $module['id']]);
            //             $permissions = $permissions->map(function ($permission, $key) use ($module) {
            //                 if (Str::contains($permission['name'], $module['uri'])) {
            //                     return $permission;
            //                 }
            //             });
            //             $role->givePermissionTo($permissions->pluck('name')->toArray());
            //         });
            // }
        }
    }
}
