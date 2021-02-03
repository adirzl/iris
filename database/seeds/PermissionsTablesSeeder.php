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

            [
                'label' => 'Kelola Landing Page', 'uri' => '#', 'icon' => 'fas fa-pencil-alt ', 'parent_module' => null,
                'visible' => 1, 'sequence' => '5', 'childs' => [
                    [
                        'label' => 'Banner', 'uri' => 'kelola-banner', 'icon' => 'fas fa-object-group', 'visible' => 1,
                        'sequence' => '5.1',
                    ],
                    [
                        'label' => 'Konten', 'uri' => 'kelola-konten', 'icon' => 'fas fa-sitemap', 'visible' => 1,
                        'sequence' => '5.2',
                    ],
                ],
            ],

            [
                'label' => 'Dokumen', 'uri' => '#', 'icon' => 'fas fa-money-check-alt', 'parent_module' => null,
                'visible' => 1, 'sequence' => '10', 'childs' => [
                    [
                        'label' => 'Tipe Dan Nama', 'uri' => 'dokumen-filetype', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '10.1',
                    ],
                    [
                        'label' => 'Upload', 'uri' => 'dokumen-filearchive', 'icon' => 'fas fa-file-alt', 'visible' => 1,
                        'sequence' => '10.2',
                    ],
                ],
            ],
            [
                'label' => 'Request', 'uri' => 'requestfile', 'icon' => 'fas fa-tasks', 'parent_module' => null,
                'visible' => 1, 'sequence' => '11', 'childs' => []
            ],
            [
                'label' => 'Evaluasi', 'uri' => 'evaluasi', 'icon' => 'fa fa-pencil-alt', 'parent_module' => null,
                'visible' => 1, 'sequence' => '12', 'childs' => []
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
            }
        }
    }
}
