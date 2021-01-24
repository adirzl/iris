<?php

namespace App\Concerns;

use Modules\User\Entities\User;

trait AuthenticatesFrom
{
    /**
     * @var int
     */
    protected $level;

    /**
     * @var string
     */
    protected $role;

    /**
     * @param array $credentials
     * @return bool
     */
    public function local(array $credentials): bool
    {
        if ($is_authenticated = $this->guard()->attempt($credentials)) {
            $r = User::findByUsername($credentials[$this->username()])->roles->first();

            $this->level = $r->id;
            $this->role = $r->name;
        }

        return $is_authenticated;
    }

    /**
     * @param array $credentials
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uim(array $credentials)
    {
        $secretKey = config('app.https') ? config('auth.domain_secret_key') : config('auth.client_secret');
        $username = $this->username();
        $client = new \GuzzleHttp\Client();
        $encrypter = new \Illuminate\Encryption\Encrypter($secretKey, config('app.cipher'));
        $response = $client->request('POST', config('auth.api_host'), [
            'form_params' => [
                'userId' => $credentials[$username],
                'password' => $encrypter->encrypt($credentials['password']),
                'appId' => config('app.id'),
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $res = json_decode($response->getBody()->getContents())->response;
            $this->level = $res->idFungsi;
            $this->role = trim($res->namaFungsi);
            $user = User::findByUsername($credentials[$username]);

            if (!is_null($user)) {
                $user->update(['password' => $credentials['password']]);
            } else {
                User::create([
                    $username => $credentials[$username],
                    'password' => $credentials['password'],
                    'email' => $res->email,
                ]);
                $user = User::findByUsername($credentials[$username]);
                $user->profile()->create([
                    'nama' => $res->nama,
                    'nip' => $res->nip,
                    'hp' => trim($res->hp),
                ]);
            }

            $user->syncRoles($res->namaFungsi);
            $user->syncPermissions((\Modules\HakAkses\Entities\Role::where('id', $this->level)->first())->permissions()->pluck('name')->toArray());

            return true;
        }

        return false;
    }
}
