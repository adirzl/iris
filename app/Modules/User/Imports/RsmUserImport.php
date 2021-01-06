<?php

namespace Modules\User\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\HakAkses\Entities\Role;
use Modules\User\Entities\User;

class RsmUserImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $now = now();

        foreach ($collection as $collect) {
            if ($collect['username'] != 'I816') {
                \Illuminate\Support\Facades\DB::table('app_user')->insert([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'username' => $collect['username'],
                    'password' => bcrypt('p@ssw0rd'),
                    'email' => $collect['email'],
                ]);

                $user = User::findByUsername($collect['username']);
                $user->profile()->insert([
                    'user_id' => $user->id,
                    'nama' => $collect['nama'],
                    'nip' => $collect['nip'],
                    'hp' => $collect['hp'],
                ]);
                $role = Role::findById($collect['role_id']);
                $user->assignRole($role->name);
                $user->syncPermissions($role->permissions->pluck('name')->toArray());
            }
        }
    }
}
