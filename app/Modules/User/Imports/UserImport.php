<?php

namespace Modules\User\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\HakAkses\Entities\Role;
use Modules\User\Entities\User;

class UserImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $now = now();

        foreach ($collection as $collect) {
            \Illuminate\Support\Facades\DB::table('app_user')->insert([
                'id' => \Illuminate\Support\Str::uuid(),
                'username' => $collect['username'],
                'password' => bcrypt('a'),
                'email' => $collect['email'],
            ]);

            $user = User::findByUsername($collect['username']);
            $user->profile()->insert([
                'user_id' => $user->id,
                'nama' => $collect['nama'],
                'nip' => $collect['nip'],
                'hp' => $collect['hp'],
                'unit_kerja_kode' => $collect['unit_kerja_kode'],
                'unit_kerja_parent' => $collect['unit_kerja_parent'],
            ]);
            $role = Role::findById($collect['role_id']);
            $user->assignRole($role->name);
            $user->syncPermissions($role->permissions->pluck('name')->toArray());
        }
    }
}
