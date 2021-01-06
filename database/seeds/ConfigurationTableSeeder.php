<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * @var string
     */
    protected $table = 'mst_configuration';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->truncate();

        $https = request()->isSecure() ? 'true' : 'false';
        $appDebug = config('app.debug') ? 'true' : 'false';
        $sessionExpireOnClose = config('session.expire_on_close') ? 'true' : 'false';
        $sessionSecureCookie = config('session.secure_cookie') ? 'true' : 'false';

        $configurations = [
            ['key' => 'id', 'value' => '100', 'shortdesc' => 'ID Aplikasi di UIM', 'user_config' => 0, 'component' => 'app'],
            ['key' => 'url', 'value' => request()->getSchemeAndHttpHost(), 'shortdesc' => null, 'user_config' => 0, 'component' => 'app'],
            ['key' => 'https', 'value' => $https, 'shortdesc' => null, 'user_config' => 0, 'component' => 'app'],
            ['key' => 'domain_url', 'value' => request()->getSchemeAndHttpHost(), 'shortdesc' => null, 'user_config' => 0, 'component' => 'app'],
            ['key' => 'env', 'value' => config('app.env'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'app'],
            ['key' => 'debug', 'value' => $appDebug, 'shortdesc' => null, 'user_config' => 0, 'component' => 'app'],
            ['key' => 'secret_key', 'value' => \Illuminate\Support\Str::random(32), 'shortdesc' => null, 'user_config' => 0, 'component' => 'app'],

            ['key' => 'method', 'value' => 'local', 'shortdesc' => null, 'user_config' => 0, 'component' => 'auth'],
            ['key' => 'api_host', 'value' => 'http://10.6.226.199:3000/login', 'shortdesc' => null, 'user_config' => 0, 'component' => 'auth'],
            ['key' => 'client_secret', 'value' => null, 'shortdesc' => null, 'user_config' => 0, 'component' => 'auth'],
            ['key' => 'domain_client_secret', 'value' => null, 'shortdesc' => null, 'user_config' => 0, 'component' => 'auth'],
            ['key' => 'force_local', 'value' => 'true', 'shortdesc' => null, 'user_config' => 0, 'component' => 'auth'],

            ['key' => 'default', 'value' => env('LOG_CHANNEL'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'logging'],

            ['key' => 'driver', 'value' => env('MAIL_DRIVER'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'host', 'value' => env('MAIL_HOST'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'port', 'value' => env('MAIL_PORT'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'username', 'value' => env('MAIL_USERNAME'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'password', 'value' => env('MAIL_PASSWORD'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'encryption', 'value' => env('MAIL_ENCRYPTION'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'from_address', 'value' => env('MAIL_FROM_ADDRESS'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],
            ['key' => 'from_name', 'value' => env('MAIL_FROM_NAME'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'mail'],

            ['key' => 'default', 'value' => env('CACHE_DRIVER'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'cache'],

            ['key' => 'driver', 'value' => env('SESSION_DRIVER'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'session'],
            ['key' => 'lifetime', 'value' => env('SESSION_LIFETIME'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'session'],
            ['key' => 'expire_on_close', 'value' => $sessionExpireOnClose, 'shortdesc' => null, 'user_config' => 0, 'component' => 'session'],
            ['key' => 'domain', 'value' => request()->server('SERVER_NAME'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'session'],
            ['key' => 'secure_cookie', 'value' => $sessionSecureCookie, 'shortdesc' => null, 'user_config' => 0, 'component' => 'session'],
            ['key' => 'same_site', 'value' => config('session.same_site'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'session'],

            ['key' => 'default', 'value' => env('BROADCAST_DRIVER'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'broadcasting'],

            ['key' => 'default', 'value' => env('QUEUE_DRIVER'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'queue'],

            [
                'key' => 'connections', 'value' => str_ireplace(' ', '', '
                [
                    {
                        "name": "default",
                        "default": true,
                        "driver": "' . env('DB_CONNECTION') . '",
                        "host": "' . env('DB_HOST') . '",
                        "port": ' . env('DB_PORT') . ',
                        "database": "' . env('DB_DATABASE') . '",
                        "username": "' . env('DB_USERNAME') . '",
                        "password": "' . env('DB_PASSWORD') . '"
                    }
                ]'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'database'
            ],

            ['key' => 'wkhtmltopdf', 'value' => (config('app.env') === 'local' ? '"D:\Server\wkhtmltopdf\bin\wkhtmltopdf.exe"' : '/usr/local/bin/wkhtmltopdf-amd64'), 'shortdesc' => null, 'user_config' => 0, 'component' => 'misc'],

            ['key' => 'name', 'value' => 'UIM', 'shortdesc' => 'Nama Aplikasi', 'user_config' => 1, 'component' => 'app'],
            ['key' => 'display_name', 'value' => 'Tools UIM', 'shortdesc' => 'Nama Aplikasi yang ditampilkan', 'user_config' => 1, 'component' => 'app'],
            ['key' => 'logo', 'value' => 'logo.png', 'shortdesc' => 'Logo Aplikasi', 'user_config' => 1, 'component' => 'app'],
            ['key' => 'display_per_page', 'value' => '10', 'shortdesc' => 'Default data yang ditampilkan dalam tabel', 'user_config' => 1, 'component' => 'app'],
            ['key' => 'copyright', 'value' => 'Copyright &copy; 2020. bankbjb.', 'shortdesc' => null, 'user_config' => 1, 'component' => 'app'],
            ['key' => 'auto_logout', 'value' => '10', 'shortdesc' => 'Auto Logout User jika idle (dalam menit)', 'user_config' => 1, 'component' => 'parameter'],
            ['key' => 'app_server', 'value' => '192.168.226.159', 'shortdesc' => 'IP App Server', 'user_config' => 1, 'component' => 'parameter'],
            ['key' => 'uim_api_user', 'value' => 'I816', 'shortdesc' => 'User Otentikasi UIM API', 'user_config' => 1, 'component' => 'parameter'],
            ['key' => 'uim_api_pass', 'value' => 'bandung10', 'shortdesc' => 'Password Otentikasi UIM API', 'user_config' => 1, 'component' => 'parameter'],
            ['key' => 'uim_api_dev', 'value' => '10.6.226.199:3000/api', 'shortdesc' => 'IP UIM API Development', 'user_config' => 1, 'component' => 'parameter'],
            ['key' => 'uim_api_prod', 'value' => '10.6.232.134/v1/api', 'shortdesc' => 'IP UIM API Production', 'user_config' => 1, 'component' => 'parameter'],

        ];

        DB::table($this->table)->insert($configurations);
    }
}
